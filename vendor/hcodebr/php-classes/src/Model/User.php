<?php 

	namespace Hcode\Model;

	//Importando a class
	use \Hcode\DB\Sql; 
	use \Hcode\Model; 
	use \Hcode\Mailer; 

	class User extends Model
	{
		const SESSION = "User";
		const SECRET = "HcodePhp7_Secret"; // <- 16 caracteres
		const ERROR = "UserError";
		const ERROR_REGISTER = "UserErrorRegister";
		const SUCCESS = "UserSuccess";

		public static function getFromSession()
		{
			$user = new User();

			if(isset($_SESSION[User::SESSION]) && (int) $_SESSION[User::SESSION]['iduser'] > 0)
			{
				$user->setData($_SESSION[User::SESSION]);
			}

			return $user;
		}

		public static function checkLogin($inadmin = true)
		{
			/*
				Verifica se a seção não está definida
				Verifica se a seção está vazia
				Verifica se está definido porém o id não é maior que 0
			*/
			if(!isset($_SESSION[User::SESSION]) || !$_SESSION[User::SESSION] || !(int) $_SESSION[User::SESSION]["iduser"] > 0)
			{
				return false;//Não está logado
			}
			else
			{
				//Esse if só será acionado quando for acessar o painel administrativo
				if($inadmin === true && (bool) $_SESSION[User::SESSION]["inadmin"] === true)
				{
					return true;
				}
				else if($inadmin === false) //É um clinente da loja
				{
					return true;
				}
				else
				{
					return false;
				}
			}
		}

		public static function login($login, $password)//Executa o login no site
		{
			$sql = new Sql();

			$results = $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b ON a.idperson = b.idperson WHERE a.deslogin = :LOGIN", array(':LOGIN' => $login));//Retorna se o usuário existe

			if (count($results) === 0)
			{
				var_dump('aqui');
				throw new \Exception("Usuário inexistente ou senha inválida");
			}

			$data = $results[0];

			if(password_verify($password, $data['despassword']) === true) //Compara os hash de senha
			{ 
				$user = new User();//Cria um objeto de usuário

				$data['desperson'] = utf8_encode($data['desperson']);

				$user->setData($data);//Atribui as suas informações

				$_SESSION[User::SESSION] = $user->getValues();//Insere as suas informações a seção

				return $user;//Retorna o objeto do usuário instanciado 

			} else {//Caso o hash não seja igual
				throw new \Exception("Usuário inexistente ou senha inválida");
			}
		}

		public static function verifyLogin($inadmin = true)//Verifica se o usuário é um administrador
		{
			if(!User::checkLogin($inadmin))
			{
				if($inadmin)
				{
					header("Location: /admin/login");
				}
				else
				{
					header("Location: /login");
				}
				exit;
			}
			//Caso nenhuma das circunstâncias acima seja verdadeira o usuário permance na seção
		}

		public static function logout()//Encerra o login
		{
			$_SESSION[User::SESSION] = NULL;
		}

		public static function listAll()//Lista todos os usuários
		{
			$sql = new Sql();

			return $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) ORDER BY b.idperson DESC");
		}

		public function save()//Insere os dados no banco
		{
			$sql = new Sql();

			$results = $sql->select("CALL sp_users_save(:desperson, :deslogin, :despassword, :desemail, :nrphone, :inadmin)", array(
				":desperson" => utf8_decode($this->getdesperson()),
				":deslogin" => $this->getdeslogin(),
				":despassword" => User::getPasswordHash($this->getdespassword()),
				":desemail" => $this->getdesemail(),
				":nrphone" => $this->getnrphone(),
				":inadmin" => $this->getinadmin()
			));

			$this->setData($results[0]);
		}

		public function get($iduser)//Retorna um usuário
		{
			$sql = new Sql();

			$data = array(":iduser" => $iduser);

			$results = $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING (idperson) WHERE a.iduser = :iduser", $data);

			if(isset($results[0]))
			{
				$result = $results[0];

				$result['desperson'] = utf8_encode($result['desperson']);

				$this->setData($result);
			}
		}

		public function update()//Atualiza as informações do usuário
		{
			$sql = new Sql();

			$data = array(
				":iduser" => $this->getiduser(),
				":desperson" => utf8_decode($this->getdesperson()),
				":deslogin" => $this->getdeslogin(),
				":despassword" => User::getPasswordHash($this->getdespassword()),
				":desemail" => $this->getdesemail(),
				":nrphone" => $this->getnrphone(),
				":inadmin" => $this->getinadmin()
			);

			$results = $sql->select("CALL sp_usersupdate_save(:iduser, :desperson, :deslogin, :despassword, :desemail, :nrphone, :inadmin)", $data);

			$this->setData($results[0]);
		}

		public function delete()//Remove um usuário
		{
			$sql = new Sql();

			$sql->query("CALL sp_users_delete(:iduser)", array(
				":iduser" => $this->getiduser()
			));
		}

		public static function getForgot($email, $inadmin = true)//Inicia o processo de recuperar a senha
		{
			$sql = new Sql();

			//Identifica se o usuário existe
			$results = $sql->select("SELECT * FROM tb_persons a INNER JOIN tb_users b USING(idperson) WHERE a.desemail = :email;", array(':email' => $email));

			if(count($results) === 0)//Caso não exista
			{
				throw new \Exception('Não foi possível recuperar a senha.');
			}
			else
			{
				$data = $results[0];

				//Insere uma solicitação de troca de senha
				$results2 = $sql->select("CALL sp_userspasswordsrecoveries_create (:iduser, :desip)", array(
					':iduser' => $data['iduser'],
					':desip' => $_SERVER['REMOTE_ADDR']
				));

				if(count($results2) === 0)//Caso não seja possível
				{
					throw new \Exception('Não foi possível recuperar a senha.');
				}
				else
				{
					$dataRecovery = $results2[0];

					$code = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, User::SECRET, $dataRecovery["idrecovery"], MCRYPT_MODE_ECB));//Cria um hash

					if($inadmin)
					{
						$link = "http://www.hcodecommerce.com.br/admin/forgot/reset?code=".$code;//Cria o link para a troca de senha
					}
					else
					{
						$link = "http://www.hcodecommerce.com.br/forgot/reset?code=".$code;//Cria o link para a troca de senha
					}

					$mailer = new Mailer($data["desemail"], $data["desperson"], "Redefinir Senha da Hcode Store", "forgot", array(
						'name' => $data["desperson"],
						'link' => $link
					));//Cria a estrutura do e-mail a ser enviada
					
					$mailer->send();//Envia o e-mail

					return $data;
				}
			}
		}

		public static function validForgotDecrypt($code)//Verifica se o hash é válido
		{
			$idrecovery = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, User::SECRET, base64_decode($code), MCRYPT_MODE_ECB);//Descriptografa o hash
			
			$sql = new Sql();

			$results = $sql->select("SELECT * FROM tb_userspasswordsrecoveries a INNER JOIN tb_users b USING(iduser) INNER JOIN tb_persons c USING(idperson) WHERE a.idrecovery = :idrecovery AND a.dtrecovery IS NULL AND DATE_ADD(a.dtregister, INTERVAL 1 HOUR) >= NOW()", array(
				":idrecovery" => $idrecovery
			));

			if(count($results) === 0)
			{
				throw new \Exception('Não foi possível recuperar a senha.');
			}
			else
			{
				return $results[0];
			}
		}

		public static function setForgotUsed($idrecovery)//Determina o intervalo foi usado e concluído
		{
			$sql = new Sql();

			$sql->query("UPDATE tb_userspasswordsrecoveries SET dtrecovery = NOW() WHERE idrecovery = :idrecovery", array(
				":idrecovery" => $idrecovery
			));
		}

		public function setPassword($password)//Atualiza a senha do usuário
		{
			$sql = new Sql();

			$sql->query("UPDATE tb_users SET despassword = :password WHERE iduser = :iduser", array(
				":password" => $password,
				":iduser" => $this->getiduser()
			));
		}

		public static function setSuccess($msg)
		{
			$_SESSION[User::SUCCESS] = $msg;
		}

		public static function getSuccess()
		{
			$msg = isset($_SESSION[User::SUCCESS]) && $_SESSION[User::SUCCESS] ? $_SESSION[User::SUCCESS] : '';
			User::clearSuccess();
			return $msg;
		}

		public static function clearSuccess()
		{
			$_SESSION[User::SUCCESS] = NULL;
		}

		public static function setError($msg)
		{
			$_SESSION[User::ERROR] = $msg;
		}

		public static function getError()
		{
			$msg = isset($_SESSION[User::ERROR]) && $_SESSION[User::ERROR] ? $_SESSION[User::ERROR] : '';
			User::clearError();
			return $msg;
		}

		public static function clearError()
		{
			$_SESSION[User::ERROR] = NULL;
		}

		public static function setErrorRegister($msg)
		{
			$_SESSION[User::ERROR_REGISTER] = $msg;
		}

		public static function getErrorRegister()
		{
			$msg = isset($_SESSION[User::ERROR_REGISTER]) && $_SESSION[User::ERROR_REGISTER] ? $_SESSION[User::ERROR_REGISTER] : '';
			User::clearErrorRegister();
			return $msg;
		}

		public static function clearErrorRegister()
		{
			$_SESSION[User::ERROR_REGISTER] = NULL;
		}

		public static function checkLoginExist($login)
		{
			$sql = new Sql();
			$data = array(':deslogin' => $login);
			$results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :deslogin",$data);
			return (count($results) > 0);
		}

		public static function getPasswordHash($password)
		{
			return password_hash($password, PASSWORD_DEFAULT, array('cost' => 12));
		}

		public function getOrders()
		{
			$sql = new Sql();

			$results = $sql->select("
				SELECT *
				FROM tb_orders a
				INNER JOIN tb_ordersstatus b USING(idstatus)
				INNER JOIN tb_carts c USING(idcart)
				INNER JOIN tb_users d ON d.iduser = a.iduser
				INNER JOIN tb_addresses e USING(idaddress)
				INNER JOIN tb_persons f ON f.idperson = d.idperson
				WHERE a.iduser = :iduser
			", array(':iduser' => $this->getiduser()));

			if(count($results) > 0)
			{
				return $results;
			}
		}

		public static function getPage($page = 1, $search = false, $itemsPerPage = 10)//Função de paginação
		{
			$start = ($page - 1) * $itemsPerPage;//Identifica em qual posição a query será iniciada

			$sql = new Sql ();
			$results = '';

			$query = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_users a INNER JOIN tb_persons b USING(idperson)";

			if($search)
			{
				$query .= " WHERE LCASE(b.desperson) LIKE search OR LCASE(b.desemail) = :search OR LCASE(a.deslogin) LIKE search ORDER BY b.desperson LIMIT ".$start.", ".$itemsPerPage.";";
				$results = $sql->select($query, array(":search" => '%'.strtolower($search).'%'));
			}
			else
			{
				$query .= " ORDER BY b.desperson LIMIT ".$start.", ".$itemsPerPage.";";
				$results = $sql->select($query);
			}

			$resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");

			return array(
				'data' => $results,
				'total' => (int) $resultTotal[0]["nrtotal"],
				'pages' => ceil($resultTotal[0]["nrtotal"] / $itemsPerPage)
			);
		}
	}
?>
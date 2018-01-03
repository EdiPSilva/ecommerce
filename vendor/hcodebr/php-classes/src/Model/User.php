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

			$results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", array(
				':LOGIN' => $login
			));//Retorna se o usuário existe

			if (count($results) === 0)
			{
				throw new \Exception("Usuário inexistente ou senha inválida");
			}

			$data = $results[0];

			if(password_verify($password, $data['despassword'])) //Compara os hash de senha
			{ 
				$user = new User();//Cria um objeto de usuário

				$user->setData($data);//Atribui as suas informações

				$_SESSION[User::SESSION] = $user->getValues();//Insere as suas informações a seção

				return $user;//Retorna o objeto do usuário instanciado 

			} else {//Caso o hash não seja igual
				throw new \Exception("Usuário inexistente ou senha inválida " . $data['despassword']);
			}
		}

		public static function verifyLogin($inadmin = true)//Verifica se o usuário é um administrador
		{
			if(!User::checkLogin($inadmin))
			{
				header("Location: /admin/login");
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
				":desperson" => $this->getdesperson(),
				":deslogin" => $this->getdeslogin(),
				":despassword" => password_hash($this->getdespassword(), PASSWORD_DEFAULT, ["cost" => 12]),
				":desemail" => $this->getdesemail(),
				":nrphone" => $this->getnrphone(),
				":inadmin" => $this->getinadmin()
			));

			$this->setData($results[0]);

		}

		public function get($iduser)//Retorna um usuário
		{
			$sql = new Sql();

			$results = $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING (idperson) WHERE a.iduser = :iduser", array(
				":iduser" => $iduser
			));

			$this->setData($results[0]);
		}

		public function update()//Atualiza as informações do usuário
		{
			$sql = new Sql();

			$results = $sql->select("CALL sp_usersupdate_save(:iduser, :desperson, :deslogin, :despassword, :desemail, :nrphone, :inadmin)", array(
				":iduser" => $this->getiduser(),
				":desperson" => $this->getdesperson(),
				":deslogin" => $this->getdeslogin(),
				":despassword" => $this->getdespassword(),
				":desemail" => $this->getdesemail(),
				":nrphone" => $this->getnrphone(),
				":inadmin" => $this->getinadmin()
			));

			$this->setData($results[0]);
		}

		public function delete()//Remove um usuário
		{
			$sql = new Sql();

			$sql->query("CALL sp_users_delete(:iduser)", array(
				":iduser" => $this->getiduser()
			));
		}

		public static function getForgot($email)//Inicia o processo de recuperar a senha
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

					$link = "http://www.hcodecommerce.com.br/admin/forgot/reset?code=".$code;//Cria o link para a troca de senha

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
	}
?>
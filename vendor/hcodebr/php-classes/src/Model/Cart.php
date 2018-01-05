<?php 

	namespace Hcode\Model;

	//Importando a class
	use \Hcode\DB\Sql; 
	use \Hcode\Model; 
	use \Hcode\Model\User; 

	class Cart extends Model
	{
		const SESSION = "Cart";
		const SESSION_ERROR = "CartError";

		public static function getFromSession()
		{
			$cart = new Cart();

			if(isset($_SESSION[Cart::SESSION]) && isset($_SESSION[Cart::SESSION]['idcart']) && (int) $_SESSION[Cart::SESSION]['idcart'] > 0)
			{
				$cart->get((int) $_SESSION[Cart::SESSION]['idcart']);
			}
			else
			{
				$cart->getFromSessionID();

				if(!(int) $cart->getidcart() > 0)
				{
					$data = array('dessessionid' => session_id());

					if(User::checkLogin(false))
					{
						$user = User::getFromSession();
						$data['iduser'] = $user->getiduser();
					}
						
					$cart->setData($data);
					$cart->seve();
					$cart->setToSerrion();
				}
			}

			return $cart;
		}

		public function setToSerrion()
		{
			$_SESSION[Cart::SESSION] = $this->getValues();
		}

		public function getFromSessionID()
		{
			$sql = new Sql();

			$results = $sql->select("SELECT * FROM tb_carts WHERE dessessionid = :dessessionid",
				array(':dessessionid' => session_id())
			);

			if(count($results) > 0)
			{
				$this->setData($results[0]);
			}
		}

		public function get(int $idcart)
		{
			$sql = new Sql();

			$results = $sql->select("SELECT * FROM tb_carts WHERE idcart = :idcart",
				array(':idcart' => $idcart)
			);

			if(count($results) > 0)
			{
				$this->setData($results[0]);
			}
		}

		public function seve()
		{
			$sql = new Sql();

			$data = array(
				':idcart' => $this->getidcart(),
				':dessessionid' => $this->getdessessionid(),
				':iduser' => $this->getiduser(),
				':deszipcode' => $this->getdeszipcode(),
				':vlfreight' => $this->getvlfreight(),
				':nrdays' => $this->getnrdays()
			);

			$results = $sql->select("CALL sp_carts_save(:idcart, :dessessionid, :iduser, :deszipcode, :vlfreight, :nrdays)", $data);

			$this->setData($results[0]);
		}

		public function addProduct(Product $product)
		{
			$sql = new Sql();

			$query = "INSERT INTO tb_cartsproducts (idcart, idproduct) VALUES (:idcart, :idproduct)";

			$data = array(
				':idcart' => $this->getidcart(),
				':idproduct' => $product->getidproduct()
			);

			$sql->query($query, $data);

			$this->getCalculateTotal();
		}

		public function removeProduct(Product $product, $all = false)
		{
			$sql = new Sql();

			$query = "UPDATE tb_cartsproducts SET dtremoved = NOW() WHERE idcart = :idcart AND idproduct = :idproduct AND dtremoved IS NULL";

			if($all === false)
			{
				$query .= " LIMIT 1;";
			}

			$data = array(
				':idcart' => $this->getidcart(),
				'idproduct' => $product->getidproduct()
			);

			$sql->query($query, $data);

			$this->getCalculateTotal();
		}

		public function getProducts()//Retorna todos os protus do carrinho
		{
			$sql = new Sql();

			$query = "SELECT b.idproduct, b.desproduct, b.vlprice, b.vlwidth, b.vlheight, b.vllength, b.vlweight, b.desurl, COUNT(*) as nrqtd, SUM(b.vlprice) as vltotal FROM tb_cartsproducts a INNER JOIN tb_products b ON (a.idproduct = b.idproduct) WHERE a.idcart = :idcart AND a.dtremoved IS NULL GROUP BY b.idproduct, b.desproduct, b.vlprice, b.vlwidth, b.vlheight, b.vllength, b.vlweight, b.desurl ORDER BY b.desproduct;";

			$data =  array(':idcart' => $this->getidcart());

			$rows = $sql->select($query, $data);

			return $rows ? Product::checkList($rows) : false;
		}

		public function getProductsTotals()//Retorna o somatório da cubagem do produto e seus respectivos valores
		{
			$sql = new Sql();

			$data = array(':idcart' => $this->getidcart());

			$results = $sql->select("
				SELECT SUM(vlprice) AS vlprice,
						SUM(vlwidth) AS vlwidth,
						SUM(vlheight) AS vlheight,
						SUM(vllength) AS vllength,
						SUM(vlweight) AS vlweight,
						COUNT(*) AS nrqtd
				FROM tb_products a
				INNER JOIN tb_cartsproducts b ON a.idproduct = b.idproduct
				WHERE b.idcart = :idcart AND dtremoved IS NULL;
			", $data);

			return count($results) > 0 ? $results[0] : array();
		}

		public function setFreight($nrzipcode)//Conecta na api dos correios e calcula o frete
		{
			$nrzipcode = str_replace("-", "", $nrzipcode);

			$totals = $this->getProductsTotals();

			if($totals['nrqtd'] > 0)
			{
				if($totals['vlheight'] < 2) $totals['vlheight'] = 2;
				if($totals['vllength'] < 16) $totals['vllength'] = 16;

				$data = array(
					'nCdEmpresa' => '',//Não necessidade de informar valor nesse campo
					'sDsSenha' => '',//Não necessidade de informar valor nesse campo
					'nCdServico' => '40010',//Sedex Varejo
					'sCepOrigem' => '09853120',
					'sCepDestino' => $nrzipcode,
					'nVlPeso' => $totals['vlweight'],
					'nCdFormato' => 1,
					'nVlComprimento' => $totals['vllength'],
					'nVlAltura' => $totals['vlheight'],
					'nVlLargura' => $totals['vlwidth'],
					'nVlDiametro' => 0,
					'sCdMaoPropria' => 'S',
					'nVlValorDeclarado' => $totals['vlprice'],
					'sCdAvisoRecebimento' => 'S'
				);

				$qs = http_build_query($data);//Monta query string

				$xml = simplexml_load_file("http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx/CalcPrecoPrazo?".$qs);//Lê formato xml

				$result = $xml->Servicos->cServico;

				if($result->MsgErro != '')
				{
					Cart::setMsgError($result->MsgErro);
				}
				else
				{
					Cart::clearMsgError();
				}

				$this->setnrdays($result->PrazoEntrega);
				$this->setvlfreight(Cart::formatValueToDecimal($result->Valor));
				$this->setdeszipcode($nrzipcode);

				$this->seve();
				return $result;
			}
		}

		public static function formatValueToDecimal($value):float
		{
			$value = str_replace('.', '', $value);
			return (float) str_replace(',', '.', $value);;
		}

		public static function setMsgError($msg)
		{
			$_SESSION[Cart::SESSION_ERROR] = $msg;
		}

		public static function getMsgError()
		{
			$msg = isset($_SESSION[Cart::SESSION_ERROR]) ? $_SESSION[Cart::SESSION_ERROR] : '';

			Cart::clearMsgError();

			return $msg;
		}

		public static function clearMsgError()
		{
			$_SESSION[Cart::SESSION_ERROR] = NULL;
		}

		public function updateFreight()
		{
			if($this->getdeszipcode() != '')
			{
				$this->setFreight($this->getdeszipcode());
			}
		}

		public function getValues()
		{
			$this->getCalculateTotal();

			return parent::getValues();
		}

		public function getCalculateTotal()
		{
			$this->updateFreight();

			$totals = $this->getProductsTotals();

			$this->setvlsubtotal($totals['vlprice']);
			$this->setvltotal($totals['vlprice'] + $this->getvlfreight());
		}
	}
?>
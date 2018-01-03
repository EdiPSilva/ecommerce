<?php 

	namespace Hcode\Model;

	//Importando a class
	use \Hcode\DB\Sql; 
	use \Hcode\Model; 
	use \Hcode\Model\User; 

	class Cart extends Model
	{
		const SESSION = "Cart";

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

			$results = $sql->select("CALL sp_carts_save(:idcart, :dessessionid, :iduser, :deszipcode, :vlfreight, :nrdays)", array(
				':idcart' => $this->getidcart(),
				':dessessionid' => $this->getdessessionid(),
				':iduser' => $this->getiduser(),
				':deszipcode' => $this->getdeszipcode(),
				':vlfreight' => $this->getvlfreight(),
				':nrdays' => $this->getnrdays()
			));

			$this->setData($results[0]);
		}

		public function addProduct(Product $product)
		{
			$sql = new Sql();

			$query = "INSERT INTO tb_cartsproducts (idcart, idproduct) VALUES (:idcart, :idproduct)";

			$sql->query($query, array(
				':idcart' => $this->getidcart(),
				':idproduct' => $product->getidproduct()
			));
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
		}

		public function getProducts()
		{
			$sql = new Sql();

			$query = "SELECT b.idproduct, b.desproduct, b.vlprice, b.vlwidth, b.vlheight, b.vllength, b.vlweight, b.desurl, COUNT(*) as nrqtd, SUM(b.vlprice) as vltotal FROM tb_cartsproducts a INNER JOIN tb_products b ON (a.idproduct = b.idproduct) WHERE a.idcart = :idcart AND a.dtremoved IS NULL GROUP BY b.idproduct, b.desproduct, b.vlprice, b.vlwidth, b.vlheight, b.vllength, b.vlweight, b.desurl ORDER BY b.desproduct;";

			$data =  array(':idcart' => $this->getidcart());

			$rows = $sql->select($query, $data);

			return $rows ? Product::checkList($rows) : false;
		}
	}
?>
<?php 

	namespace Hcode\Model;

	//Importando a class
	use \Hcode\DB\Sql; 
	use \Hcode\Model; 

	class Category extends Model
	{
		public static function listAll()//Retorna todas as categorias
		{
			$sql = new Sql();

			return $sql->select("SELECT * FROM tb_categories ORDER BY idcategory");
		}

		public function save()//Salva as informações no banco
		{
			$sql = new Sql();

			$results = $sql->select("CALL sp_categories_save(:idcategory, :descategory)", array(
				":idcategory" => $this->getidcategory(),
				":descategory" => $this->getdescategory()
			));

			$this->setData($results[0]);

			Category::updateFile();
		}

		public function get($idcategory)//Retorna somente uma categoria
		{
			$sql = new Sql();

			$results = $sql->select("SELECT * FROM tb_categories WHERE idcategory = :idcategory", [
				':idcategory' => $idcategory
			]);

			$this->setData($results[0]);
		}

		public function delete()//Remove a categoria do banco
		{
			$sql = new Sql();

			$sql->query("DELETE FROM tb_categories WHERE idcategory = :idcategory", [
				':idcategory' => $this->getidcategory()
			]);

			Category::updateFile();
		}

		public static function updateFile()//Cria o arquivo com o html list das categorias
		{
			$categories = Category::listAll();
			
			$html = [];

			foreach ($categories as $row) {
				array_push($html, '<li><a href="/categories/'.$row['idcategory'].'">'.$row['descategory'].'</a></li>');
				//array_push($html, '<li><a href="/'.strtolower($row['descategory']).'">'.$row['descategory'].'</a></li>');
			}

			file_put_contents(str_replace('/', DIRECTORY_SEPARATOR, $_SERVER['DOCUMENT_ROOT']) . DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."categories-menu.html", implode('',$html));
		}

		public function getProducts($related = true)//Retorna os produtos associados e não associados das categorias
		{
			$sql = new Sql();

			$termo = "";

			if($related === true)
			{
				$termo = " IN";
			}
			else
			{
				$termo = " NOT IN";
			}

			return $sql->select("SELECT * FROM tb_products WHERE idproduct ".$termo."(SELECT a.idproduct FROM tb_products a INNER JOIN tb_productscategories b ON (a.idproduct = b.idproduct) WHERE b.idcategory = :idcategory);", [':idcategory' => $this->getidcategory()]);
		}

		public function getProductsPage($page = 1, $itemsPerPage = 8)//Função de paginação
		{
			$start = ($page - 1) * $itemsPerPage;//Identifica em qual posição a query será iniciada

			$sql = new Sql ();

			$results = $sql->select("
				SELECT SQL_CALC_FOUND_ROWS *
				FROM tb_products a
				INNER JOIN tb_productscategories b ON (a.idproduct = b.idproduct)
				INNER JOIN tb_categories c ON (c.idcategory = b.idcategory)
				WHERE c.idcategory = :idcategory
				LIMIT ".$start.", ".$itemsPerPage.";",
				array(
					':idcategory' => $this->getidcategory()
				)
			);

			$resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");

			return array(
				'data' => Product::checkList($results),
				'total' => (int) $resultTotal[0]["nrtotal"],
				'pages' => ceil($resultTotal[0]["nrtotal"] / $itemsPerPage)
			);
		}

		public function addProduct(Product $product)//Associa o produto a categoria
		{
			$sql = new Sql();

			$sql->query("INSERT INTO tb_productscategories (idcategory, idproduct) VALUES (:idcategory, :idproduct)", [
				':idcategory' => $this->getidcategory(),
				':idproduct' => $product->getidproduct()
			]);
		}

		public function removeProduct(Product $product)//Remove associação do produto a categoria
		{
			$sql = new Sql();

			$sql->query("DELETE FROM tb_productscategories WHERE idcategory = :idcategory AND idproduct = :idproduct", [
				':idcategory' => $this->getidcategory(),
				':idproduct' => $product->getidproduct()
			]);
		}
	}
?>
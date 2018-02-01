<?php 

	namespace Hcode\Model;

	//Importando a class
	use \Hcode\DB\Sql; 
	use \Hcode\Model; 
	use \Hcode\Mailer; 

	class Product extends Model
	{
		public static function listAll()//Retorna todos os produtos
		{
			$sql = new Sql();

			return $sql->select("SELECT * FROM tb_products ORDER BY desproduct");
		}

		/*
		O método abaixo recebe uma lista de produtos, a variável $row serve para abrir o foreach e também recebe a nova estrutura do objeto de produtos, após a execução do loop o métogo getValues é acionado na linha 89 e com isso o método checkPhoto também é chamado, e com isso independente da estrutura da tabela é inserido mais uma posição no objeto que detém a foto do mesmo.
		*/
		public static function checkList($list)
		{
			foreach ($list as &$row)
			{
				$p = new Product();
				$p->setData($row);
				$row = $p->getValues();
			}

			return $list;
		}

		public function save()//Salva as informações no banco
		{
			$sql = new Sql();

			$results = $sql->select("CALL sp_products_save(:idproduct, :desproduct, :vlprice, :vlwidth, :vlheight, :vllength, :vlweight, :desurl)", array(
				":idproduct" => $this->getidproduct(),
				":desproduct" => $this->getdesproduct(),
				":vlprice" => $this->getvlprice(),
				":vlwidth" => $this->getvlwidth(),
				":vlheight" => $this->getvlheight(),
				":vllength" => $this->getvllength(),
				":vlweight" => $this->getvlweight(),
				":desurl" => $this->getdesurl()				
			));

			$this->setData($results[0]);
		}

		public function get($idproduct)//Retorna um produto
		{
			$sql = new Sql();

			$results = $sql->select("SELECT * FROM tb_products WHERE idproduct = :idproduct", [
				':idproduct' => $idproduct
			]);

			$this->setData($results[0]);
		}

		public function delete()//Remove um produto
		{
			$sql = new Sql();

			$sql->query("DELETE FROM tb_products WHERE idproduct = :idproduct", [
				':idproduct' => $this->getidproduct()
			]);

		}

		public function checkPhoto()//Verifica se o produto detém foto
		{
			$file = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."res".DIRECTORY_SEPARATOR."site".DIRECTORY_SEPARATOR."img".DIRECTORY_SEPARATOR."products".DIRECTORY_SEPARATOR.$this->getidproduct().".jpg";

			if(file_exists($file))
			{
				$url = "/res/site/img/products/".$this->getidproduct().".jpg";//Retorna a imagem do produto
			}
			else
			{
				$url = "/res/site/img/product.jpg";//Retorna uma imagem padrão
			}

			return $this->setdesphoto($url);//Insere na memória do objeto a foto do produto
		}

		public function getValues()//Reescrita método class Model
		{
			$this->checkPhoto();

			$values = parent::getValues();

			return $values;	
		}

		public function setPhoto($file)//Faz o upload do arquivo
		{
			$extension = explode('.', $file['name']);
			$extension = end($extension);//recupera a ultima posição do array

			switch ($extension)
			{
				case "jpg":
				case "jpeg":
					$image = imagecreatefromjpeg($file["tmp_name"]);//Cria uma imagem temporária com o formato jpeg
					break;

				case "gif":
					$image = imagecreatefromgif($file["tmp_name"]);//Cria uma imagem temporária com o formato gif
					break;

				case "png":
					$image = imagecreatefrompng($file["tmp_name"]);//Cria uma imagem temporária com o formato png
					break;
			}

			$dist = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."res".DIRECTORY_SEPARATOR."site".DIRECTORY_SEPARATOR."img".DIRECTORY_SEPARATOR."products".DIRECTORY_SEPARATOR.$this->getidproduct().".jpg";//Diretório de imagens

			imagejpeg($image, $dist);//Move a imagem para o diretorio equivalente e troca a extensão para jpg

			imagedestroy($image);//Destroi o arquivo temporário

			$this->checkPhoto();
		}

		public function getFromUrl($desurl)
		{
			$sql = new Sql();

			$rows = $sql->select("SELECT * FROM tb_products WHERE desurl = :desurl LIMIT 1",
				array(':desurl' => $desurl)
			);//Retorna um produto pertinente a url enviada por parâmetro

			$this->setData($rows[0]);
		}

		public function getCategories()//Retorna as categoria que o produto esta associado
		{
			$sql = new Sql();

			return $sql->select("SELECT * FROM tb_categories a INNER JOIN tb_productscategories b ON (a.idcategory = b.idcategory) WHERE b.idproduct = :idproduct", array(':idproduct' => $this->getidproduct()));
		}

		public static function getPage($page = 1, $search = false, $itemsPerPage = 10)//Função de paginação
		{
			$start = ($page - 1) * $itemsPerPage;//Identifica em qual posição a query será iniciada

			$sql = new Sql ();
			$results = '';

			$query = "SELECT SQL_CALC_FOUND_ROWS * FROM tb_products";

			if($search)
			{
				$query .= " WHERE LCASE(desproduct) LIKE :search ORDER BY desproduct LIMIT ".$start.", ".$itemsPerPage.";";
				$results = $sql->select($query, array(":search" => '%'.strtolower($search).'%'));
			}
			else
			{
				$query .= " ORDER BY desproduct LIMIT ".$start.", ".$itemsPerPage.";";
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
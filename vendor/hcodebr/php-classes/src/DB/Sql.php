<?php 

namespace Hcode\DB;

//class Sql {
class Sql extends \PDO {

	const HOSTNAME = "127.0.0.1";
	const USERNAME = "root";
	const PASSWORD = "";
	const DBNAME = "db_ecommerce";

	private $conn;

	public function __construct() //Cria a conexão
	{
		$this->conn = new \PDO("mysql:dbname=".Sql::DBNAME.";host=".Sql::HOSTNAME, Sql::USERNAME, Sql::PASSWORD);
	}

	private function setParams($statement, $parameters = array())//Abre o array de parêmetros
	{
		foreach ($parameters as $key => $value) {
			$this->setParam($statement, $key, $value);
		}
	}

	private function setParam($statement, $key, $value)//Faz o link do valor do array com o parâmetro na query
	{
		$statement->bindParam($key, $value);
	}

	public function query($rawQuery, $params = array())
	{
		$stmt = $this->conn->prepare($rawQuery);//Prepara a query a partir da conexão
		$this->setParams($stmt, $params);
		$stmt->execute();
		return $stmt;
	}

	public function select($rawQuery, $params = array()):array//Retorna um array
	{
		$stmt = $this->query($rawQuery, $params);
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

}

 ?>
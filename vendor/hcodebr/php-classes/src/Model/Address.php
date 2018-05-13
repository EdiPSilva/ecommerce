<?php 

	namespace Hcode\Model;

	//Importando a class
	use \Hcode\DB\Sql; 
	use \Hcode\Model; 

	class Address extends Model
	{
		const SESSION_ERROR = "AddressError";

		public static function getCEP($nrcep)
		{
			$nrcep = str_replace("-", "", $nrcep);

			$url = 'https://viacep.com.br/ws/'.$nrcep.'/json/';

			$ch = curl_init();//Iniciar o restreamento de uma url
			curl_setopt($ch, CURLOPT_URL, $url);//Qual url será consumida
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//Parametro true identifica a necessidade de um retorno
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//Não exige altenticação SSL

			$data = json_decode(curl_exec($ch), true);//O true serve para transformar em array

			curl_close($ch);

			return $data;
		}

		public function loadFromCEP($nrcep)
		{
			$data = Address::getCEP($nrcep);
		
			if(isset($data['logradouro']) && $data['logradouro'])
			{
				$this->setdesaddress($data['logradouro']);
				$this->setdescomplement($data['complemento']);
				$this->setdesdistrict($data['bairro']);
				$this->setdescity($data['localidade']);
				$this->setdesstate($data['uf']);
				$this->setdescountry('Brasil');
				$this->setdeszipcode($nrcep);
			}
		}

		public function save()
		{
			$sql = new Sql();

			$data = array(
				':idaddress' => $this->getidaddress(),
				':idperson' => $this->getidperson(),
				':desaddress' => utf8_decode($this->getdesaddress()),
				':desnumber' => utf8_decode($this->getdesnumber()),
				':descomplement' => utf8_decode($this->getdescomplement()),
				':descity' => utf8_decode($this->getdescity()),
				':desstate' => utf8_decode($this->getdesstate()),
				':descountry' => utf8_decode($this->getdescountry()),
				':deszipcode' => $this->getdeszipcode(),
				':desdistrict' => utf8_decode($this->getdesdistrict())
			);

			$results = $sql->select("CALL sp_addresses_save(:idaddress, :idperson, :desaddress, :desnumber, :descomplement, :descity, :desstate, :descountry, :deszipcode, :desdistrict)", $data);

			if(count($results) > 0)
			{
				$this->setData($results[0]);
			}
		}

		public static function formatValueToDecimal($value):float
		{
			$value = str_replace('.', '', $value);
			return (float) str_replace(',', '.', $value);;
		}

		public static function setMsgError($msg)
		{
			$_SESSION[Address::SESSION_ERROR] = $msg;
		}

		public static function getMsgError()
		{
			$msg = isset($_SESSION[Address::SESSION_ERROR]) ? $_SESSION[Address::SESSION_ERROR] : '';

			Address::clearMsgError();

			return $msg;
		}

		public static function clearMsgError()
		{
			$_SESSION[Address::SESSION_ERROR] = NULL;
		}
	}
?>
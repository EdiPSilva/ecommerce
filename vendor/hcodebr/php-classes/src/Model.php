<?php 

	namespace Hcode;

	class Model
	{

		private $values = [];

		public function __call($name, $args)// (__call) -> Identifica qual método foi chamado no momento
		{
			//Identifica se o método é um get ou set
			$method = substr($name, 0, 3); //Inicia no indice 0, com isso retorna os caracteres das posições 0, 1 e 2.
			//Identifica o restante do nome do método
			$fieldName = substr($name, 3, strlen($name));

			switch ($method)
			{
				case 'get':
					return (isset($this->values[$fieldName])) ? $this->values[$fieldName] : NULL;
					break;
				
				case 'set':
					$this->values[$fieldName] = $args[0];
					break;
			}
		}

		public function setData($data = array())
		{
			if($data)
			{
				foreach ($data as $key => $value)
				{
					$this->{"set".$key}($value);//Chama um método declarado apartir do valor do $key
				}
			}
		}

		public function getValues()
		{
			return $this->values;
		}

	}

?>
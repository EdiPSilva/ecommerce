<?php 	

	namespace Hcode;

	use Rain\Tpl;

	class Page
	{
	    
		private $tpl;
		private $options = [];
		private $defaults = [
			"header"	=> true,
			"footer"	=> true,
			"data"		=> []
		];

	    public function __construct($opts = array(), $tpl_dir = "/views/")
	    {
	        $this->options = array_merge($this->defaults, $opts); //Une os dois arrays sobrepondo as posições

	        $config = array(
	        	"tpl_dir"	=> $_SERVER["DOCUMENT_ROOT"].$tpl_dir,//Identifica onde está o layout
	        	"cache_dir"	=> $_SERVER["DOCUMENT_ROOT"]."/views-cache/",//Identifica onde salvar o cache
	        	"debug"		=> false
	        );

	        Tpl::configure($config);//Inicia as configurações da view

	        $this->tpl = new Tpl;

	        $this->setData($this->options["data"]);

	        if($this->options['header'] === true) $this->tpl->draw("header");//Caso o header seja true o mesmo será desenhado

	    }

	    private function setData($data = array())//Insere as informações na instancia do objeto
	    {
	    	foreach ($data as $key => $value)
	    	{
	    		$this->tpl->assign($key, $value);
	    	}
	    }

	    public function setTpl($name, $data = array(), $returnHTML = false)//Desenha o layout
	    {
	    	$this->setData($data);

	    	return $this->tpl->draw($name, $returnHTML);
	    }

	    public function __destruct()
	    {
	    	if($this->options['footer'] === true) $this->tpl->draw("footer");//Caso o footer seja true o mesmo será desenhado
	    }
	}
	

?>
<?php 	

	namespace Hcode;
	//Class PageAdmin é uma herança da class Page
	class PageAdmin extends Page
	{
	    public function __construct($opts = array(), $tpl_dir = "/views/admin/")
	    {
	    	parent::__construct($opts, $tpl_dir);//Chama o método construtor da classe pai
	    }
		
	}
	
?>
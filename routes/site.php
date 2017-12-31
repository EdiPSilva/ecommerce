<?php 

use \Hcode\Page;
use \Hcode\Model\Product;
use \Hcode\Model\Category;

$app->get('/', function() {//Abre a tela principal do site

	$products = Product::listAll();//Lista todos os produtos
    
	$page = new Page(array("sidebar" => false));

	$page->setTpl("index", array('products' => Product::checkList($products)));//Renderiza a tela
});

$app->get("/categories/:idcategory", function($idcategory){//Abre a categoria do site

	$category = new Category();

	$category->get((int) $idcategory);//Verifica se é uma categoria válida

	$page = new Page(array("sidebar" => false));

	$page->setTpl("category", array(
		'category' => $category->getValues(),
		'products' => Product::checkList($category->getProducts())
	));//Renderiza a tela
});

?>
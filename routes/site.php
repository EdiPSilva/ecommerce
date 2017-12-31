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

	$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;

	$category = new Category();

	$category->get((int) $idcategory);//Verifica se é uma categoria válida

	$pagination = $category->getProductsPage($page);//Chama a função para criar a paginação

	$pages = array();//Array de números de páginas com seus respectivos links

	for($i = 1; $i <= $pagination['pages']; $i++)
	{
		array_push($pages,
			array(
				'link' => '/categories/'.$category->getidcategory().'?page='.$i,//Cria o link
				'page' => $i//Cria o número da página
			));
	}

	$page = new Page(array("sidebar" => false));

	$page->setTpl("category", array(
		'category' => $category->getValues(),
		'products' => $pagination["data"],
		'pages' => $pages
	));//Renderiza a tela
});

?>
<?php 

use \Hcode\Page;
use \Hcode\Model\Product;
use \Hcode\Model\Category;
use \Hcode\Model\Cart;

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

$app->get("/products/:desurl", function($desurl){

	$product = new Product();

	$product->getFromUrl($desurl);

	$page = new Page(array("sidebar" => false));//Não exibe o menu do painel administrativo

	$page->setTpl("product-detail", 
		array(
			'product' => $product->getValues(),
			'categories' => $product->getCategories()
		)
	);
});

$app->get("/cart", function(){//Abre a tela do carrinho

	$cart = Cart::getFromSession();//Cria uma seção e um carrinho

	$page = new Page(array("sidebar" => false));//Não exibe o menu do painel administrativo

	$data = array(
		'cart' => $cart->getValues(),
		'products' => $cart->getProducts()
	);
	
	$page->setTpl("cart", $data);
});

$app->get("/cart/:idproduct/add", function($idproduct){//Adiciona um produto no carrinho

	$product = new Product();//Cria um objeto do produto para associar o mesmo ao carrinho

	$product->get((int) $idproduct);//Carrega as informações do produto

	$cart = Cart::getFromSession();//Cria uma seção e um carrinho

	$qtd = isset($_GET['qtd']) ? (int) $_GET['qtd'] : 1;//Quantidade vinda da tela de detalhe do produto

	for($i = 0; $i < $qtd; $i++)
	{
		$cart->addProduct($product);//Adiciona o produto ao carrinho
	}

	header("Location: /cart");
	exit;
});

$app->get("/cart/:idproduct/minus", function($idproduct){//Remove uma unidade do produto no carrinho

	$product = new Product();//Cria um objeto do produto para associar o mesmo ao carrinho

	$product->get((int) $idproduct);//Carrega as informações do produto

	$cart = Cart::getFromSession();//Cria uma seção e um carrinho

	$cart->removeProduct($product);//Remove uma unidade do produto no carrinho

	header("Location: /cart");
	exit;
});

$app->get("/cart/:idproduct/remove", function($idproduct){//Remove todas as ocorrências do mesmo produto no carrinho

	$product = new Product();//Cria um objeto do produto para associar o mesmo ao carrinho

	$product->get((int) $idproduct);//Carrega as informações do produto

	$cart = Cart::getFromSession();//Cria uma seção e um carrinho

	$cart->removeProduct($product, true);//Remove todas as ocorrências do mesmo produto no carrinho

	header("Location: /cart");
	exit;
});

?>
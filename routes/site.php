<?php 

use \Hcode\Page;
use \Hcode\Model\Product;
use \Hcode\Model\Category;
use \Hcode\Model\Cart;
use \Hcode\Model\Address;
use \Hcode\Model\User;

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
		'products' => $cart->getProducts(),
		'error' => Cart::getMsgError()
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

$app->post("/cart/freight", function(){

	$cart = Cart::getFromSession();

	$cart->setFreight($_POST['zipcode']);

	header("Location: /cart");
	exit;
});

$app->get("/checkout", function(){

	User::verifyLogin(false);//Verifica se o usuário é administrador e pode estar logado

	$cart = Cart::getFromSession();

	$address = new Address();

	$page = new Page(array("sidebar" => false));//Não exibe o menu do painel administrativo

	$data = array(
		'cart' => $cart->getValues(),
		'address' => $address->getValues()
	);

	$page->setTpl("checkout", $data);
});

$app->get("/login", function(){//Abre a tela de login

	$page = new Page(array("sidebar" => false));//Não exibe o menu do painel administrativo

	$dataInputs = array('name' => '', 'email' => '', 'phone' => '');

	$data = array(
		'error' => User::getError(),
		'errorRegister' => User::getErrorRegister(),
		'registerValues' => isset($_SESSION['registerValues']) ? $_SESSION['registerValues'] : $dataInputs
	);

	$page->setTpl("login", $data);
});

$app->post("/login", function(){//Executa o login do cliente na loja

	try
	{
		User::login($_POST['login'], $_POST['password']);
	}
	catch(Exception $e)
	{
		User::setError($e->getMessage());
	}

	header("Location: /checkout");
	exit;
});

$app->get("/logout", function(){//Encerra a seção do usuário da loja

	User::logout();

	header("Location: /login");
	exit;
});

$app->post("/register", function(){//Faz o cadastro do cliente na loja

	$_SESSION['registerValues'] = $_POST;

	if(!isset($_POST['name']) || $_POST['name'] == '')
	{
		$msg = 'Preencha o campo nome.';
		User::setErrorRegister($msg);
		header("Location: /login");
		exit;
	}

	if(!isset($_POST['email']) || $_POST['email'] == '')
	{
		$msg = 'Preencha o campo email.';
		User::setErrorRegister($msg);
		header("Location: /login");
		exit;
	}

	if(User::checkLoginExist($_POST['email']) === true)
	{
		$msg = 'Este email já está em uso, por favor use um endereço diferente.';
		User::setErrorRegister($msg);
		header("Location: /login");
		exit;
	}

	if(!isset($_POST['password']) || $_POST['password'] == '')
	{
		$msg = 'Preencha o campo senha.';
		User::setErrorRegister($msg);
		header("Location: /login");
		exit;
	}

	$user = new User();

	$setData = array(
		'inadmin' => 0,
		'deslogin' => $_POST['email'],
		'desperson' => $_POST['name'],
		'desemail' => $_POST['email'],
		'despassword' => $_POST['password'],
		'nrphone' => $_POST['phone']
	);

	$user->setData($setData);

	$user->save();

	User::login($_POST['email'], $_POST['password']);

	header('Location: /checkout');
	exit;
});

?>
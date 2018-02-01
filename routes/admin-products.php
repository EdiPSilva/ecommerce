<?php 

use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Product;

$app->get("/admin/products",function(){//Abre a tela para listar todos os produtos

	User::verifyLogin();//Verifica se o usuário é administrador e pode estar logado
	
	$data['data'] = loadLanguage('admin-products');//Carrega as languages

	if(isset($data['data']) && !empty($data['data']))
	{
		$search = isset($_GET['search']) ? $_GET['search'] : "";
		$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

		if($search != '')
		{
			$pagination = Product::getPage($page, $search);//Lista todos os usuários
		}
		else
		{
			$pagination = Product::getPage($page);//Lista todos os usuários
		}

		$pages = array();

		for ($i = 0; $i < $pagination['pages']; $i++)
		{
			if(!empty($search))
			{
				array_push($pages, array(
					"href" => "/admin/products?".http_build_query(array(
						"page" => $i + 1,
						"search" => $search
					)),
					"text" => $i + 1
				));
			}
			else
			{
				array_push($pages, array(
					"href" => "/admin/products?".http_build_query(array(
						"page" => $i + 1
					)),
					"text" => $i + 1
				));
			}
		}

		$page = new PageAdmin($data);
		
		$page->setTpl("products",
			array(
				"products" => $pagination['data'],
				"search" => $search,
				"pages" => $pages
			)
		);//Renderiza a tela
	}
});

$app->get("/admin/products/create", function(){//Abre a tela para criar um produto

	User::verifyLogin();//Verifica se o usuário é administrador e pode estar logado

	$data['data'] = loadLanguage('admin-products');

	if(isset($data) && !empty($data))
	{
		$page = new PageAdmin($data);

		$page->setTpl("products-create");//Renderiza a tela
	}
});

$app->post("/admin/products/create", function(){//Cria um produto

	User::verifyLogin();//Verifica se o usuário é administrador e pode estar logado

	$product = new Product();

	$product->setData($_POST);//Insere as informações na memória do objeto

	$product->save();//Salva as informações

	header("Location: /admin/products");
	exit;
});

$app->get("/admin/products/:idproduct", function($idproduct){//Abre a tela para atualização do produto

	User::verifyLogin();//Verifica se o usuário é administrador e pode estar logado

	$product = new Product();

	$product->get((int) $idproduct);//Verifica se é um produto válido

	$data['data'] = loadLanguage('admin-products');

	if(isset($data) && !empty($data))
	{
		$page = new PageAdmin($data);

		$page->setTpl("products-update", array('product' => $product->getValues()));//Renderiza a tela
	}
});

$app->post("/admin/products/:idproduct", function($idproduct){//Salva as informações da atualização do produto 

	User::verifyLogin();//Verifica se o usuário é administrador e pode estar logado

	$product = new Product();

	$product->get((int) $idproduct);//Verifica se é um produto válido

	$product->setData($_POST);//Insere as informações na memória do objeto

	$product->save();//Salva as informações

	$product->setPhoto($_FILES["file"]);//Upload da foto do produto

	header("Location: /admin/products");
	exit;
});

$app->get("/admin/products/:idproduct/delete", function($idproduct){//Remove um produto

	User::verifyLogin();//Verifica se o usuário é administrador e pode estar logado

	$product = new Product();

	$product->get((int) $idproduct);//Verifica se é um produto válido

	$product->delete();//Remove o produto

	header("Location: /admin/products");
	exit;
})

?>
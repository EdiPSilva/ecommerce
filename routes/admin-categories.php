<?php 

use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Category;
use \Hcode\Model\Product;

$app->get("/admin/categories", function(){//Abre a tela para listar todas as categorias

	User::verifyLogin();//Verifica se o usuário é administrador e pode estar logado

	$categories = Category::listAll();//Traz todas as categorias

	$data['data'] = loadLanguage("admin-category");

	if(isset($data['data']) && !empty($data['data']))
	{
		$page = new PageAdmin($data);

		$page->setTpl("categories", array('categories' => $categories) );//Renderiza a tela
	}

});

$app->get("/admin/categories/create", function(){//Chama a tela de cadastro de categorias

	User::verifyLogin();//Verifica se o usuário é administrador e pode estar logado

	$data['data'] = loadLanguage("admin-category");

	if(isset($data['data']) && !empty($data['data']));
	{
		$page = new PageAdmin($data);
	
		$page->setTpl("categories-create");//Renderiza a tela
	}
});

$app->post("/admin/categories/create", function(){//Cria uma categoria

	User::verifyLogin();//Verifica se o usuário é administrador e pode estar logado

	$category = new Category();

	$category->setData($_POST);//Insere as informações na memória do objeto

	$category->save();//Salva as informações

	header('Location: /admin/categories');
	exit;
});

$app->get('/admin/categories/:idcategory/delete', function($idcategory){//Chama a tela para remover uma categoria

	User::verifyLogin();//Verifica se o usuário é administrador e pode estar logado

	$category = new Category();

	$category->get((int) $idcategory);//Verifica se é uma categoria válida

	$category->delete();//Remove uma categoria a partir do id contido no objeto

	header('Location: /admin/categories');
	exit;
});

$app->get('/admin/categories/:idcategory', function($idcategory){//Chama a tela para editar uma categoria

	User::verifyLogin();//Verifica se o usuário é administrador e pode estar logado

	$category = new Category();

	$category->get((int) $idcategory);//Verifica se é uma categoria válida

	$data['data'] = loadLanguage("admin-category");

	if(isset($data['data']) && !empty($data['data']))
	{
		$page = new PageAdmin($data);

		$page->setTpl("categories-update", array('category' => $category->getValues()));//Renderiza a tela
	}
});

$app->post('/admin/categories/:idcategory', function($idcategory){//Salva a atualização da categoria

	User::verifyLogin();//Verifica se o usuário é administrador e pode estar logado

	$category = new Category();

	$category->get((int) $idcategory);//Verifica se é uma categoria válida

	$category->setData($_POST);//Insere as informações na memória do objeto

	$category->save();//Salva as informações

	header('Location: /admin/categories');
	exit;
	
});

$app->get("/admin/categories/:idcategory/products", function($idcategory){//Abre a tela para associar um produto a categoria

	User::verifyLogin();//Verifica se o usuário é administrador e pode estar logado

	$category = new Category();

	$category->get((int) $idcategory);//Verifica se é uma categoria válida

	$data['data'] = loadLanguage("admin-category");

	if(isset($data['data']) && !empty($data['data']))
	{
		$page = new PageAdmin($data);

		$page->setTpl("categories-products", array(
			'category' => $category->getValues(),//Envia as informações da categoria
			'productsRelated' => $category->getProducts(),//Envia as informações dos produtos relacionados
			'productsNotRelated' => $category->getProducts(false)//Envia as informações dos produtos não relacionados
		));//Renderiza a tela
	}
});

$app->get("/admin/categories/:idcategory/products/:idproduct/add", function($idcategory, $idproduct){//Associa o produto a categoria

	User::verifyLogin();//Verifica se o usuário é administrador e pode estar logado

	$category = new Category();

	$category->get((int) $idcategory);//Verifica se é uma categoria válida

	$product = new Product();

	$product->get((int) $idproduct);//Verifica se é um produto válido

	$category->addProduct($product);//Envia a instancia o objeto produto a categoria para ser adicionado

	header("Location: /admin/categories/".$idcategory."/products");
	exit;
});

$app->get("/admin/categories/:idcategory/products/:idproduct/remove", function($idcategory, $idproduct){

	User::verifyLogin();//Verifica se o usuário é administrador e pode estar logado

	$category = new Category();

	$category->get((int) $idcategory);//Verifica se é uma categoria válida

	$product = new Product();

	$product->get((int) $idproduct);//Verifica se é um produto válido

	$category->removeProduct($product);//Envia a instancia o objeto produto a categoria para ser removido

	header("Location: /admin/categories/".$idcategory."/products");
	exit;
});
?>
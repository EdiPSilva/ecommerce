<?php 

use \Hcode\PageAdmin;
use \Hcode\Model\User;

$app->get('/admin/users/:iduser/password', function($iduser){

	User::verifyLogin();//Verifica se o usuário é administrador e pode estar logado

	$data["data"] = loadLanguage('admin-user');

	if(isset($data["data"]) && !empty($data["data"]))
	{
		$user = new User();

		$user->get((int) $iduser);

		$page = new PageAdmin($data);
		
		$page->setTpl("users-password",
			array(
				"user" => $user->getValues(),
				"msgError" => User::getError(),
				"msgSuccess" => User::getSuccess()
			)
		);//Renderiza a tela
	}

});

$app->post('/admin/users/:iduser/password', function($iduser){

	User::verifyLogin();//Verifica se o usuário é administrador e pode estar logado

	if(!isset($_POST['despassword']) || empty($_POST['despassword']))
	{
		User::setError("Preencha a nova senha.");
		header("Location: /admin/users/".$iduser."/password");
		exit;
	}

	if(!isset($_POST['despassword-confirm']) || empty($_POST['despassword-confirm']))
	{
		User::setError("Preencha a confirmação da nova senha.");
		header("Location: /admin/users/".$iduser."/password");
		exit;
	}

	if($_POST['despassword'] !== $_POST['despassword-confirm'])
	{
		User::setError("Confirme corretamente as senhas.");
		header("Location: /admin/users/".$iduser."/password");
		exit;
	}

	$user = new User();

	$user->get((int) $iduser);

	$user->setPassword(User::getPasswordHash($_POST['despassword']));

	User::setSuccess("A senha foi alterada com sucesso.");
	header("Location: /admin/users/".$iduser."/password");
	exit;
});

$app->get('/admin/users', function(){//Abre a tela para listar todos os usuários

	User::verifyLogin();//Verifica se o usuário é administrador e pode estar logado

	$data["data"] = loadLanguage('admin-user');

	if(isset($data["data"]) && !empty($data["data"]))
	{
		$search = isset($_GET['search']) ? $_GET['search'] : "";
		$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

		if($search != '')
		{
			$pagination = User::getPage($page, $search);//Lista todos os usuários
		}
		else
		{
			$pagination = User::getPage($page, false);//Lista todos os usuários
		}


		$pages = array();

		for ($i = 0; $i < $pagination['pages']; $i++)
		{
			array_push($pages, array(
				"href" => "/admin/users?".http_build_query(array(
					"page" => $i + 1,
					"search" => $search
				)),
				"text" => $i + 1
			));
		}


		$page = new PageAdmin($data);
		
		$page->setTpl("users",
			array(
				"users" => $pagination['data'],
				"search" => $search,
				"pages" => $pages
			)
		);//Renderiza a tela
	}
	else
	{
		header("Location: /admin/");
		exit;
	}
});

$app->get('/admin/users/create', function(){//Abre a tala para criar um usuário

	User::verifyLogin();//Verifica se o usuário é administrador e pode estar logado

	$data["data"] = loadLanguage('admin-user');

	if(isset($data["data"]) && !empty($data["data"]))
	{
		$page = new PageAdmin($data);
		
		$page->setTpl("users-create");//Renderiza a tela
	}
});

$app->post('/admin/users/create', function(){//Cria um usuário

	User::verifyLogin();//Verifica se o usuário é administrador e pode estar logado

	$user = new User();

	$_POST['inadmin'] = isset($_POST['inadmin']) ? 1 : 0;//Insere 1 (um) caso exista

	$user->setData($_POST);//Insere as informações na memória do objeto

	$user->save();//Salva as informações

	header("Location: /admin/users");
	exit;
});

$app->get('/admin/users/:iduser/delete', function($iduser){//Remove um usuário

	User::verifyLogin();//Verifica se o usuário é administrador e pode estar logado

	$user = new User();

	$user->get((int) $iduser);//Verifica se é um usuário válido

	$user->delete();//Remove um usuário

	header("Location: /admin/users");
	exit;
}); 

$app->get('/admin/users/:iduser', function($iduser){//Abre a tela para atualizar um usuário

	User::verifyLogin();//Verifica se o usuário é administrador e pode estar logado

	$user = new User();

	$user->get((int) $iduser);//Verifica se é um usuário válido

	$data["data"] = loadLanguage('admin-user');

	if(isset($data["data"]) && !empty($data["data"]))
	{
		$page = new PageAdmin($data);
		
		$page->setTpl("users-update", array("user" => $user->getValues()));//Renderiza a tela
	}

});

$app->post('/admin/users/:iduser', function($iduser){//Atualiza as informações do usuário

	User::verifyLogin();//Verifica se o usuário é administrador e pode estar logado

	$user = new User();

	$_POST['inadmin'] = isset($_POST['inadmin']) ? 1 : 0;//Insere 1 (um) caso exista

	$user->get((int) $iduser);//Verifica se é um usuário válido

	$user->setData($_POST);//Insere as informações na memória do objeto

	$user->update();

	header("Location: /admin/users");
	exit;
});
?>
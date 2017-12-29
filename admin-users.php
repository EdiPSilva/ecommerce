<?php 

use \Hcode\PageAdmin;
use \Hcode\Model\User;

$app->get('/admin/users', function(){//Abre a tela para listar todos os usuários

	User::verifyLogin();//Verifica se o usuário é administrador e pode estar logado

	$users = User::listAll();//Lista todos os usuários

	$page = new PageAdmin();

	$page->setTpl("users", array("users" => $users));//Renderiza a tela
});

$app->get('/admin/users/create', function(){//Abre a tala para criar um usuário

	User::verifyLogin();//Verifica se o usuário é administrador e pode estar logado

	$page = new PageAdmin();

	$page->setTpl("users-create");//Renderiza a tela
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

	$page = new PageAdmin();

	$page->setTpl("users-update", array("user" => $user->getValues()));//Renderiza a tela
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
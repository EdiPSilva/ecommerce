<?php 

use \Hcode\PageAdmin;
use \Hcode\Model\User;

$app->get('/admin', function() {//Abre a tela principal do painel administrativo

	User::verifyLogin();//Verifica se o usuário é administrador e pode estar logado
    
	$page = new PageAdmin();

	$page->setTpl("index");//Renderiza a tela
});

$app->get('/admin/login', function() {//Abre a tela de login do painel administrativo 
    
	$page = new PageAdmin(array("header" => false, "footer" => false));//Cria uma página sem o header e o footer

	$page->setTpl("login");//Renderiza a tela
});

$app->post('/admin/login', function(){//Executa o login do usuário

	User::login($_POST['login'], $_POST['password']);//Dao do usuário

	header("Location: /admin");//Caso de tudo certo o usuário será direcionado a tela principal
	exit;
});

$app->get('/admin/logout', function(){//Sai do painel administrativo

	User::logout();//Encerra a seção

	header("Location: /admin/login");
	exit;
});

//---Recuperar Senha---//
$app->get('/admin/forgot', function(){//Abra a tela para recuperar a senha

	$page = new PageAdmin(array("header" => false, "footer" => false));//Cria uma página sem o header e o footer

	$page->setTpl("forgot");//Renderiza a tela
});

$app->post('/admin/forgot', function(){//Envia um email ao usuário caso o mesmo exista com o código para recuperar a senha

	if(isset($_POST['email']))
	{
		$user = User::getForgot($_POST['email']);

		header("Location: /admin/forgot/sent");
		exit;
	}
});

$app->get('/admin/forgot/sent', function(){//Abre a tela para mostrar que o email foi enviado

	$page = new PageAdmin(array("header" => false, "footer" => false));//Cria uma página sem o header e o footer

	$page->setTpl("forgot-sent");//Renderiza a tela
});

$app->get('/admin/forgot/reset', function(){//Abre a tela para inserir a nova senha

	$user = User::validForgotDecrypt($_GET["code"]);
	
	$page = new PageAdmin(array("header" => false, "footer" => false));//Cria uma página sem o header e o footer

	$page->setTpl("forgot-reset", array(
		"name" => $user['desperson'],
		"code" => $_GET['code']
	));//Renderiza a tela
});

$app->post('/admin/forgot/reset', function(){//Cadastra a nova senha

	$forgot = User::validForgotDecrypt($_POST["code"]);//Verifica se o hash é válido

	User::setForgotUsed($forgot['idrecovery']);//Marca o hash para não ser usado novamente

	$user = new User();

	$user->get((int) $forgot['iduser']);//Verifica se é um usuário válido

	$password = password_hash($_POST['password'], PASSWORD_DEFAULT, ["cost" => 12]);//Cria um hash de senha

	$user->setPassword($password);//Salva a nova senha

	$page = new PageAdmin(array("header" => false, "footer" => false));//Cria uma página sem o header e o footer

	$page->setTpl("forgot-reset-success");//Renderiza a tela
});

?>
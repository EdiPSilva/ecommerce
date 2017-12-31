<?php 

use \Hcode\Model\User;
$user = new User();
$user->get((int) $_SESSION[User::SESSION]['iduser']);

/*User*/
$user_language["desperson"] = $user->getdesperson();
/*User*/

/*Text*/
$user_language["title_list"] = "Lista de Usuários";
$user_language["title_create"] = "Cadastrar Usuário";
$user_language["title_update"] = "Editar Usuário";
/*Text*/

/*Columns*/
$user_language["column_name"] = "Nome";
$user_language["column_email"] = "E-mail";
$user_language["column_login"] = "Login";
$user_language["column_admin"] = "Admin";
/*Columns*/

/*Label*/
$user_language["label_name"] = "Nome";
$user_language["label_login"] = "Login";
$user_language["label_phone"] = "Telefone";
$user_language["label_email"] = "E-mail";
$user_language["label_pass"] = "Senha";
$user_language["label_admin"] = "Acesso de Administrador";
/*Label*/

/*Input*/
$user_language["input_name"] = "Digite o nome";
$user_language["input_login"] = "Digite o login";
$user_language["input_phone"] = "Digite o telefone";
$user_language["input_email"] = "Digite o e-mail";
$user_language["input_pass"] = "Digite a senha";
/*Input*/

/*Button*/
$user_language["user_menu_button_create"] = "Cadastrar Usuário";
$user_language["user_menu_button_update"] = "Editar";
$user_language["user_menu_button_delete"] = "Excluir";
$user_language["user_menu_button_finish"] = "Finalizar";
/*Button*/
?>
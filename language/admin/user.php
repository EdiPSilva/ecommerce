<?php 

use \Hcode\Model\User;
$user = new User();
$user->get((int) $_SESSION[User::SESSION]['iduser']);

/*User*/
$user_language["desperson"] = $user->getdesperson();
/*User*/

/*Text*/
$user_language["user_title"] = "Usuários";
$user_language["user_title_list"] = "Lista de Usuários";
$user_language["user_title_create"] = "Cadastrar Usuário";
$user_language["user_title_update"] = "Editar Usuário";
/*Text*/

/*Columns*/
$user_language["user_column_name"] = "Nome";
$user_language["user_column_email"] = "E-mail";
$user_language["user_column_login"] = "Login";
$user_language["user_column_admin"] = "Admin";
$user_language["user_column_actions"] = "Ações";
/*Columns*/

/*Label*/
$user_language["user_label_name"] = "Nome";
$user_language["user_label_login"] = "Login";
$user_language["user_label_phone"] = "Telefone";
$user_language["user_label_email"] = "E-mail";
$user_language["user_label_pass"] = "Senha";
$user_language["user_label_admin"] = "Acesso de Administrador";
/*Label*/

/*Input*/
$user_language["user_input_name"] = "Digite o nome";
$user_language["user_input_login"] = "Digite o login";
$user_language["user_input_phone"] = "Digite o telefone";
$user_language["user_input_email"] = "Digite o e-mail";
$user_language["user_input_pass"] = "Digite a senha";
/*Input*/

/*Button*/
$user_language["user_menu_button_create"] = "Cadastrar Usuário";
$user_language["user_button_pass"] = "Senha";
/*Button*/
?>
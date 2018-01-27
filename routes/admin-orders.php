<?php 

use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Order;
use \Hcode\Model\OrderStatus;

$app->get("/admin/orders/:idorder/status", function($idorder){

	User::verifyLogin();//Verifica se o usuário é administrador e pode estar logado

	$order = new Order();

	$order->get((int) $idorder);

	$data['data'] = loadLanguage("admin-orders");

	if(isset($data['data']) && !empty($data['data']))
	{
		$page = new PageAdmin($data);

		$page->setTpl("order-status",
			array(
				'order' => $order->getValues(),
				'status' => OrderStatus::listAll(),
				'msgSuccess' => Order::getSuccess(),
				'msgError' => Order::getError()
			)
		);
	}
});

$app->post("/admin/orders/:idorder/status", function($idorder){

	User::verifyLogin();//Verifica se o usuário é administrador e pode estar logado

	if(!isset($_POST['idstatus']) || !(int) $_POST['idstatus'] > 0)
	{
		Order::setError("Informe o status atual");
		header("Location: /admin/orders/".$idorder."/status");
		exit;
	}

	$order = new Order();

	$order->get((int) $idorder);

	$order->setidstatus((int) $_POST['idstatus']);

	$order->save();

	Order::setSuccess("Status atualizado com sucesso.");

	header("Location: /admin/orders/".$idorder."/status");
	exit;
});

$app->get("/admin/orders/:idorder/delete", function($idorder){

	User::verifyLogin();//Verifica se o usuário é administrador e pode estar logado

	$order = new Order();

	$order->get((int) $idorder);

	$order->delete();

	header("Location: /admin/orders");
	exit;
});

$app->get("/admin/orders/:idorder", function($idorder){

	User::verifyLogin();//Verifica se o usuário é administrador e pode estar logado

	$order = new Order();

	$order->get((int) $idorder);

	$cart = $order->getCart();

	$data['data'] = loadLanguage("admin-orders");

	if(isset($data['data']) && !empty($data['data']))
	{
		$page = new PageAdmin($data);

		$page->setTpl("order",
			array(
				'order' => $order->getValues(),
				'cart' => $cart->getValues(),
				'products' => $cart->getProducts()
			)
		);
	}
});

$app->get("/admin/orders", function(){

	User::verifyLogin();//Verifica se o usuário é administrador e pode estar logado

	$data['data'] = loadLanguage("admin-orders");

	if(isset($data['data']) && !empty($data['data']))
	{
		$page = new PageAdmin($data);

		$page->setTpl("orders", array('orders' => Order::listAll()));
	}
});
?>
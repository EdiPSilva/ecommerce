	<?php

	use \Hcode\PageAdmin;
	use \Hcode\Model\User;
	use \Hcode\Model\Category;
	use \Hcode\Model\Product;
	use \Hcode\Model\Cart;

	function formatPrice($vlprice)//Função para formatar preço
	{
		if(is_null($vlprice)) $vlprice = 0;

		return number_format((float) $vlprice, 2, ",", ".");
	}

	function checkLogin($inadmin = true)
	{
		return User::checkLogin($inadmin);
	}

	function getUserName()
	{
		$user = User::getFromSession();
		$user->get((int) $user->getiduser());
		return $user->getdesperson();
	}

	function getCartNrQtd()
	{
		$cart = Cart::getFromSession();

		$totals = $cart->getProductsTotals();

		return $totals['nrqtd'];
	}

	function getCartVlSubTotal()
	{
		$cart = Cart::getFromSession();

		$totals = $cart->getProductsTotals();

		return formatPrice($totals['vlprice']);
	}

	function formateDate($date)
	{
		return date('d/m/Y', strtotime($date));
	}

	function loadLanguage($value, $dir = "admin")
	{
		$language_dir = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."language".DIRECTORY_SEPARATOR;

		if($dir == "admin")
		{
			require_once($language_dir.$dir.DIRECTORY_SEPARATOR."default.php");
			require_once($language_dir.$dir.DIRECTORY_SEPARATOR."header.php");
			require_once($language_dir.$dir.DIRECTORY_SEPARATOR."sidebar.php");
			require_once($language_dir.$dir.DIRECTORY_SEPARATOR."footer.php");
			require_once($language_dir.$dir.DIRECTORY_SEPARATOR."index.php");
			require_once($language_dir.$dir.DIRECTORY_SEPARATOR."user.php");
			require_once($language_dir.$dir.DIRECTORY_SEPARATOR."category.php");
			require_once($language_dir.$dir.DIRECTORY_SEPARATOR."product.php");

			if(isset($value))
			{
				if($value != "admin-user"){
					$user = new User();
					$user->get((int) $_SESSION[User::SESSION]['iduser']);
					$user_language["desperson"] = $user->getdesperson();
					$default = array_merge($user_language, $default_language, $sidebar_language, $header_language, $footer_language);
				} 
				else
				{
					$default = array_merge($default_language, $sidebar_language, $header_language, $footer_language);
				}

				switch ($value)
				{
					case 'admin':
						return array_merge($default, $index_language);
						break;

					case 'admin-user':
						return array_merge($default, $user_language);
						break;
					case 'admin-category':
						return array_merge($default, $category_language);
						break;
					case 'admin-products':
						return array_merge($default, $product_language);
						break;
					case 'admin-orders':
						return array_merge($default);
						break;
				}
			}
		}
	}

?>
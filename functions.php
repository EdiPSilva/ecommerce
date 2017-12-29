<?php

	function formatPrice(float $vlprice)//Função para formatar preço
	{
		return number_format($vlprice, 2, ",", ".");
	}

?>
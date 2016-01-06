<?php
/**
 * @version 1.0
 * @author QQ46231996
 * @create 2015/01/30
 * @modify 2015/01/30
 */

$tpl_shopping_cart = array(
	'count' => $_SESSION['cart']->count_contents(),
	'weight' => $_SESSION['cart']->show_weight(),
	'total' => $currencies->format($_SESSION['cart']->show_total()),
	'products' => array()
);

if ($tpl_shopping_cart['count'])
{
	$tpl_shopping_cart['products'] = $_SESSION['cart']->get_products();
}







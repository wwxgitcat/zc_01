<?php
if (!isset($no_need)) require ('includes/application_top.php');

$db->Execute('UPDATE `' . TABLE_PRODUCTS . '` SET `products_quantity`=ceil(rand()*(10000-3000) + 3000);'); // update products quantity

echo 'Products quantity done !<br>';

$db->Execute("delete from " . TABLE_FEATURED);

$products_query = "SELECT products_id FROM " . TABLE_PRODUCTS . ' ORDER BY RAND() LIMIT 500;';
$products = $db->Execute($products_query);

while(!$products->EOF)
{
	$db->Execute("INSERT INTO " . TABLE_FEATURED . " (`featured_id`, `products_id`, `status`) VALUES (NULL, '" . $products->fields['products_id'] . "', '1');");
	
	$products->MoveNext();
}

echo 'Featured products done !<br>';

?>
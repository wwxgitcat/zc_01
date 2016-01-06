<?php
/**
 * @author QQ46231996
 * @create 2015/6/1
 * @modify 2015/6/1
 */

$tpl_banner_product = array();
$banner_product_result = $db->Execute('SELECT p.`products_id`, p.`products_image`, pd.`products_name` FROM '.TABLE_PRODUCTS.' p 
	JOIN '.TABLE_PRODUCTS_DESCRIPTION.' pd ON (p.products_id=pd.products_id)
	WHERE p.`shop_id`='.(int)$_SESSION['shop_id'].' ORDER BY RAND() ', 8, true, 43200);

while (!$banner_product_result->EOF){
	$tpl_banner_product[$banner_product_result->fields['products_id']] = array(
		'id' => $banner_product_result->fields['products_id'],
		'image' => DIR_WS_IMAGES.$banner_product_result->fields['products_image'],
		'href' => zen_href_link(FILENAME_PRODUCT_INFO, 'products_id='.$banner_product_result->fields['products_id']),
		'title' => $banner_product_result->fields['products_name']
	);
	$banner_product_result->MoveNext();
}
unset($banner_product_result);

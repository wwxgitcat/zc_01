<?php
/**
 * @package modules
 * @author JunsGo@msn.com
 * @copyright Copyright 2013 SL Development Team
 * @copyright Portions Copyright 2003 osCommerce
 */

$tpl_products = array(
	'title' => '',
	'products' => array()
);
if ((int)$_GET['products_id'] > 0)
{
	
	$sql = 'SELECT p.products_image, pd.products_name, p.products_quantity, p.products_id, p.products_type, p.master_categories_id, p.manufacturers_id, p.products_price,
	 p.products_tax_class_id, pd.products_description, IF(s.status = 1, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status =1, s.specials_new_products_price, p.products_price) as final_price,
	 p.products_sort_order, p.product_is_call, p.product_is_free, p.product_is_always_free_shipping, p.products_qty_box_status
			FROM ' . TABLE_PRODUCTS_DESCRIPTION . ' pd, .' . TABLE_PRODUCTS . ' p left join ' . TABLE_MANUFACTURERS . ' m on (p.manufacturers_id = m.manufacturers_id),
				' . TABLE_PRODUCTS_TO_CATEGORIES . ' p2c left join ' . TABLE_SPECIALS . ' s on (p2c.products_id = s.products_id)
			WHERE p.products_status = 1 and (p.products_id = p2c.products_id) and (pd.products_id = p2c.products_id)
					 and p.shop_id = '.(int)$_SESSION['shop_id'].'
				and pd.language_id = \'' . (int)$_SESSION['languages_id'] . '\' and p.master_categories_id = \'' . (int)zen_get_products_category_id($_GET['products_id']) . '\'
			ORDER BY RAND()';
	$relateds = $db->Execute($sql, MAX_DISPLAY_PRODUCTS_RELATED, true, CACHE_TIMELIFT);
	
	while(!$relateds->EOF)
	{
		$tpl_products['products'][$relateds->fields['products_id']] = array(
			'name' => $relateds->fields['products_name'],
			'image' => $relateds->fields['products_image'],
			'quantity' => $relateds->fields['products_quantity'],
			'weight' => $relateds->fields['products_weight'],
			'type' => $relateds->fields['products_type'],
			'categories_id' => $relateds->fields['master_categories_id'],
			'manufacturers_id' => $relateds->fields['manufacturers_id'],
			'products_price' => $relateds->fields['products_price'],
			'tax_class_id' => $relateds->fields['products_tax_class_id'],
			'specials_price' => $relateds->fields['specials_new_products_price'],
			'final_price' => $relateds->fields['final_price'],
			'sort_order' => $relateds->fields['products_sort_order'],
			'is_call' => $relateds->fields['product_is_call'],
			'is_always_free_shipping' => $relateds->fields['product_is_always_free_shipping'],
			'qty_box_status' => $relateds->fields['products_qty_box_status'],
			'href' => zen_href_link(zen_get_info_page($relateds->fields['products_id']), 'cPath=' . (($_GET['manufacturers_id'] > 0 and $_GET['filter_id'] > 0) ? zen_get_generated_category_path_rev($_GET['filter_id']) : ($_GET['cPath'] > 0 ? zen_get_generated_category_path_rev($_GET['cPath']) : zen_get_generated_category_path_rev($relateds->fields['master_categories_id']))) . '&products_id=' . $relateds->fields['products_id']),
			'display_price' => zen_get_products_display_price($relateds->fields['products_id']),
			'is_free' => $relateds->fields['product_is_free'] == '1' ? true : false,
			/*display more price*/
			'display_normal_price' => get_normal_price($relateds->fields['products_id']),
			'display_special_price' => get_special_price($relateds->fields['products_id']),
			'display_sale_price' => get_sale_discount_price($relateds->fields['products_id']) 
		);
		$relateds->MoveNext();
	}
}
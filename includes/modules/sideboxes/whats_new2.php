<?php
/**
 * whats_new sidebox - displays a random "new" product
 *
 * @package templateSystem
 * @author JunsGo@msn.com
 * @copyright Copyright 2013 SL Development Team
 * @copyright Portions Copyright 2003 osCommerce
 */

// display limits
// $display_limit = zen_get_products_new_timelimit();
$idx = 0;
$tpl_what_new = array();
$display_limit = zen_get_new_date_range();
// var_dump($display_limit);exit;
$random_whats_new_sidebox_product_query = "select p.products_id, p.products_image, p.products_tax_class_id, p.products_price, pd.products_name,
                                              p.master_categories_id, p.product_is_free
                           from (" . TABLE_PRODUCTS . " p
                           left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id )
                           where p.products_id = pd.products_id
                           and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                           and p.shop_id = ".(int)$_SESSION['shop_id']."
                           and p.products_status = 1 " . $display_limit;
$random_whats_new_sidebox_product = $db->ExecuteRandomMulti($random_whats_new_sidebox_product_query, MAX_RANDOM_SELECT_NEW, true, CACHE_TIMELIFT);

if ($random_whats_new_sidebox_product->RecordCount() > 0)
{
	// var_dump($random_whats_new_sidebox_product);
	// exit;
	while(!$random_whats_new_sidebox_product->EOF)
	{
		$tpl_what_new[$idx] = array(
			'id' => $random_whats_new_sidebox_product->fields['products_id'],
			'name' => $random_whats_new_sidebox_product->fields['products_name'],
			'href' => zen_href_link(zen_get_info_page($random_whats_new_sidebox_product->fields['products_id']), 'cPath=' . zen_get_generated_category_path_rev($random_whats_new_sidebox_product->fields['master_categories_id']) . '&products_id=' . $random_whats_new_sidebox_product->fields['products_id']),
			'image' => $random_whats_new_sidebox_product->fields['products_image'],
			'price' => zen_get_products_display_price($random_whats_new_sidebox_product->fields['products_id']),
			'categories_id' => $random_whats_new_sidebox_product->fields['master_categories_id'],
			'tax_class_id' => $random_whats_new_sidebox_product->fields['products_tax_class_id'],
			'is_free' => $random_whats_new_sidebox_product->fields['product_is_free'] == '1' ? true : false,
				/*display more price*/
				'display_normal_price' => get_normal_price($random_whats_new_sidebox_product->fields['products_id']),
			'display_special_price' => get_special_price($random_whats_new_sidebox_product->fields['products_id']),
			'display_sale_price' => get_sale_discount_price($random_whats_new_sidebox_product->fields['products_id']) 
		);
		++$idx;
		$random_whats_new_sidebox_product->MoveNextRandom();
	}
	unset($idx);
	require ($template->get_template_dir('tpl_whats_new2.php', DIR_WS_TEMPLATE, $current_page_base, 'sideboxes') . '/tpl_whats_new2.php');
}
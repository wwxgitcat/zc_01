<?php
/**
 * featured sidebox - displays a random Featured Product
 *
 * @package templateSystem
 * @author JunsGo@msn.com
 * @copyright Copyright 2013 SL Development Team
 * @copyright Portions Copyright 2003 osCommerce
 */

// test if box should display
$show_featured = true;

if ($show_featured == true)
{
	$random_featured_products_query = "select p.products_id, p.products_image, pd.products_name,
                                       p.master_categories_id, p.product_is_free
                           from (" . TABLE_PRODUCTS . " p
                           left join " . TABLE_FEATURED . " f on p.products_id = f.products_id
                           left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id )
                           where p.products_id = f.products_id
                           and p.products_id = pd.products_id
                           and p.products_status = 1
                           and f.status = 1
                           and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'";
	
	// randomly select ONE featured product from the list retrieved:
	// $random_featured_product = zen_random_select($random_featured_products_query);
	$random_featured_product = $db->ExecuteRandomMulti($random_featured_products_query, MAX_RANDOM_SELECT_FEATURED_PRODUCTS, true, CACHE_TIMELIFT);
	
	if ($random_featured_product->RecordCount() > 0)
	{
		$tpl_feature_array = array();
		
		while(!$random_featured_product->EOF)
		{
			$tpl_feature_array[] = array(
				'id' => $random_featured_product->fields['products_id'],
				'name' => $random_featured_product->fields['products_name'],
				'href' => zen_href_link(zen_get_info_page($random_featured_product->fields["products_id"]), 'cPath=' . zen_get_generated_category_path_rev($random_featured_product->fields["master_categories_id"]) . '&products_id=' . $random_featured_product->fields["products_id"]),
				'image' => $random_featured_product->fields['products_image'],
				'price' => zen_get_products_display_price($random_featured_product->fields['products_id']),
				'categories_id' => $random_featured_product->fields['master_categories_id'],
				'is_free' => $random_featured_product->fields['product_is_free'] == 1 ? true : false,
				/*display more price*/
				'display_normal_price' => get_normal_price($random_featured_product->fields['products_id']),
				'display_special_price' => get_special_price($random_featured_product->fields['products_id']),
				'display_sale_price' => get_sale_discount_price($random_featured_product->fields['products_id']) 
			);
			$random_featured_product->MoveNextRandom();
		}
		require ($template->get_template_dir('tpl_featured.php', DIR_WS_TEMPLATE, $current_page_base, 'sideboxes') . '/tpl_featured.php');
	}
}
?>
<?php
/**
 * product_listing module
 *
 * @package modules
 * @author JunsGo@msn.com
 * @copyright Copyright 2013 SL Development Team
 * @copyright Portions Copyright 2003 osCommerce
 */
if (!defined('IS_ADMIN_FLAG'))
{
	die('Illegal Access');
}
$show_submit = zen_run_normal();
$listing_split = new splitPageResults($listing_sql, MAX_DISPLAY_PRODUCTS_LISTING, 'p.products_id', 'page');
$zco_notifier->notify('NOTIFY_MODULE_PRODUCT_LISTING_RESULTCOUNT', $listing_split->number_of_rows);
$how_many = 0;

$tpl_products = array(
	'title' => '',
	'products' => array()
);

if ($listing_split->number_of_rows > 0)
{
	
	$listing = $db->Execute($listing_split->sql_query, false, true, CACHE_TIMELIFT);
	
	while(!$listing->EOF)
	{
		$the_categories_name_query = "select categories_name from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id= '" . $listing->fields['master_categories_id'] . "' and language_id= '" . $_SESSION['languages_id'] . "'";
		
		$the_categories_name = $db->Execute($the_categories_name_query, null, true, CACHE_TIMELIFT);
		$tpl_products['products'][$listing->fields['products_id']] = array(
			'name' => $listing->fields['products_name'],
			'image' => $listing->fields['products_image'],
			'quantity' => $listing->fields['products_quantity'],
			'weight' => $listing->fields['products_weight'],
			'type' => $listing->fields['products_type'],
			'categories_id' => $listing->fields['master_categories_id'],
			'categories_name' => $the_categories_name->fields['categories_name'],
			'categories_href' => zen_href_link(FILENAME_DEFAULT, 'cPath='.$listing->fields['master_categories_id']),
			'manufacturers_id' => $listing->fields['manufacturers_id'],
			'products_price' => $listing->fields['products_price'],
			'tax_class_id' => $listing->fields['products_tax_class_id'],
			'description' => zen_trunc_string(zen_clean_html(stripslashes(zen_get_products_description($listing->fields['products_id'], $_SESSION['languages_id']))), PRODUCT_LIST_DESCRIPTION),
			'content' => $listing->fields['products_description'],
			'specials_price' => $listing->fields['specials_new_products_price'],
			'final_price' => $listing->fields['final_price'],
			'sort_order' => $listing->fields['products_sort_order'],
			'is_call' => $listing->fields['product_is_call'],
			'is_always_free_shipping' => $listing->fields['product_is_always_free_shipping'],
			'qty_box_status' => $listing->fields['products_qty_box_status'],
			'href' => zen_href_link(zen_get_info_page($listing->fields['products_id']), 'cPath=' . (($_GET['manufacturers_id'] > 0 and $_GET['filter_id'] > 0) ? zen_get_generated_category_path_rev($_GET['filter_id']) : ($_GET['cPath'] > 0 ? zen_get_generated_category_path_rev($_GET['cPath']) : zen_get_generated_category_path_rev($listing->fields['master_categories_id']))) . '&products_id=' . $listing->fields['products_id']),
			'display_price' => zen_get_products_display_price($listing->fields['products_id']),
			'is_free' => get_product_is_free($listing->fields['products_id']),
			/*display more price*/
			'display_normal_price' => get_normal_price($listing->fields['products_id']),
			'display_special_price' => get_special_price($listing->fields['products_id']),
			'display_sale_price' => get_sale_discount_price($listing->fields['products_id']) 
		);
		
		if (PRODUCT_LIST_MANUFACTURER != 0)
		{
			$tpl_products['products'][$listing->fields['products_id']]['show_manufacturer'] = true;
			$tpl_products['products'][$listing->fields['products_id']]['manufacturers_name'] = $listing->fields['manufacturers_name'];
			$tpl_products['products'][$listing->fields['products_id']]['manufacturers_href'] = zen_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $listing->fields['manufacturers_id']);
		}
		
		$listing->MoveNext();
	}
	$error_categories = false;
}
else
{
	$tpl_products = array(
		'title' => '',
		'products' => array()
	);
	$error_categories = true;
}
$multiple_buy = false;
if (($how_many > 0 and $show_submit == true and $listing_split->number_of_rows > 0) and (PRODUCT_LISTING_MULTIPLE_ADD_TO_CART == 1 or PRODUCT_LISTING_MULTIPLE_ADD_TO_CART == 3))
{
	$show_top_submit_button = true;
}
else
{
	$show_top_submit_button = false;
}
if (($how_many > 0 and $show_submit == true and $listing_split->number_of_rows > 0) and (PRODUCT_LISTING_MULTIPLE_ADD_TO_CART >= 2))
{
	$show_bottom_submit_button = true;
}
else
{
	$show_bottom_submit_button = false;
}

if ($how_many > 0 && PRODUCT_LISTING_MULTIPLE_ADD_TO_CART != 0 and $show_submit == true and $listing_split->number_of_rows > 0)
{
	// bof: multiple products
	$multiple_buy = true;
}


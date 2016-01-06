<?php
/**
 * new_products.php module
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

// initialize vars
$categories_products_id_list = '';
$list_of_products = '';
$new_products_query = '';

$display_limit = zen_get_new_date_range();

$show_select_product_id = '';
if ($this_is_home_page)
	$show_select_product_id = HOME_SHOW_PRODUCT_NEW;

if ((($manufacturers_id > 0 && $_GET['filter_id'] == 0) || $_GET['music_genre_id'] > 0 || $_GET['record_company_id'] > 0) || (!isset($new_products_category_id) || $new_products_category_id == '0'))
{
	$new_products_query = "select distinct p.products_id, p.products_image, p.products_tax_class_id, pd.products_name,
                                p.products_date_added, p.products_price, p.products_type, p.master_categories_id, p.product_is_free, p.product_is_call
                           from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
                           where p.products_id = pd.products_id
                           and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                           and   p.products_status = 1 and p.shop_id = ".(int)$_SESSION['shop_id']
                           .(!empty($show_select_product_id) ? " AND p.products_id IN (".$show_select_product_id.")" : "")."
							order by p.products_sort_order DESC, p.products_date_added desc ";
						   //order by p.products_date_added desc " . $display_limit;
}
else
{
	// get all products and cPaths in this subcat tree
	$productsInCategory = zen_get_categories_products_list((($manufacturers_id > 0 && $_GET['filter_id'] > 0) ? zen_get_generated_category_path_rev($_GET['filter_id']) : $cPath), false, true, 0, $display_limit);
	
	if (is_array($productsInCategory) && sizeof($productsInCategory) > 0)
	{
		// build products-list string to insert into SQL query
		foreach($productsInCategory as $key => $value)
		{
			$list_of_products .= $key . ', ';
		}
		$list_of_products = substr($list_of_products, 0, -2); // remove trailing comma
		
		$new_products_query = "select distinct p.products_id, p.products_image, p.products_tax_class_id, pd.products_name,pd.products_description,
                                  p.products_date_added, p.products_price, p.products_type, p.master_categories_id, p.product_is_free, p.product_is_call
                           from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
                           where p.products_id = pd.products_id
                           and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                           and p.products_status = 1 and p.shop_id = ".(int)$_SESSION['shop_id']
                           .(!empty($show_select_product_id) ? " AND p.products_id IN (".$show_select_product_id.")" : "")."
                           	order by p.products_date_added desc";
	}
	else
	{
		$new_products_query = "select distinct p.products_id, p.products_image, p.products_tax_class_id, pd.products_name,pd.products_description,
                                p.products_date_added, p.products_price, p.products_type, p.master_categories_id, p.product_is_free, p.product_is_call
                           from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
                           where p.products_id = pd.products_id
                           and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                           and   p.products_status = 1  and p.shop_id = ".(int)$_SESSION['shop_id']
                           .(!empty($show_select_product_id) ? " AND p.products_id IN (".$show_select_product_id.")" : "") . $display_limit;
	}
}

if ($new_products_query != '') $new_products = $db->Execute($new_products_query, MAX_DISPLAY_NEW_PRODUCTS, true, CACHE_TIMELIFT);

$col = 0;
$tpl_products = array(
	'title' => '',
	'products' => array()
);

$num_products_count = ($new_products_query == '') ? 0 : $new_products->RecordCount();

// show only when 1 or more
if ($num_products_count > 0)
{
	$title = '';
	if ($num_products_count < SHOW_PRODUCT_INFO_COLUMNS_NEW_PRODUCTS || SHOW_PRODUCT_INFO_COLUMNS_NEW_PRODUCTS == 0)
	{
		$col_width = floor(100 / $num_products_count);
	}
	else
	{
		$col_width = floor(100 / SHOW_PRODUCT_INFO_COLUMNS_NEW_PRODUCTS);
	}
	
	while(!$new_products->EOF)
	{
		$the_categories_name_query = "select categories_name from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id= '" . $new_products->fields['master_categories_id'] . "' and language_id= '" . $_SESSION['languages_id'] . "'";
		
		$the_categories_name = $db->Execute($the_categories_name_query, null, true, CACHE_TIMELIFT);
		
		$tpl_products['products'][$new_products->fields['products_id']] = array(
			'id' => $new_products->fields['products_id'],
			'name' => zen_get_products_name($new_products->fields['products_id']),
			'href' => zen_href_link(zen_get_info_page($new_products->fields['products_id']), 'cPath=' . $productsInCategory[$new_products->fields['products_id']] . '&products_id=' . $new_products->fields['products_id']),
			'display_price' => zen_get_products_display_price($new_products->fields['products_id']),
			'image' => ($new_products->fields['products_image'] == '' && PRODUCTS_IMAGE_NO_IMAGE_STATUS == 0) ? '' : $new_products->fields['products_image'],
			'tax_class_id' => $new_products->fields['products_tax_class_id'],
			'date_added' => $new_products->fields['products_date_added'],
			'type' => $new_products->fields['products_type'],
			'categories_id' => $new_products->fields['master_categories_id'],
			'categories_name' => $the_categories_name->fields['categories_name'],
			'categories_href' => zen_href_link(FILENAME_DEFAULT, 'cPath='.$new_products->fields['master_categories_id']),
			'is_call' => $new_products->fields['product_is_call'] ? true : false,
			'is_free' => $new_products->fields['product_is_free'] == '1' ? true : false,
			/*display more price*/
			'display_normal_price' => get_normal_price($new_products->fields['products_id']),
			'display_special_price' => get_special_price($new_products->fields['products_id']),
			'display_sale_price' => get_sale_discount_price($new_products->fields['products_id']),
			'content' => $new_products->fields['products_description']
		);
		$new_products->MoveNext();
	}
	if (!empty($show_select_product_id))
	{
		//sort
		$show_select_product_id = explode(',', $show_select_product_id);
		$tpl_tmp_product = $tpl_products['products'];
		$tpl_products['products'] = array();
		foreach ($show_select_product_id as $tmp_id)
		{
			$tpl_products['products'][$tmp_id] = $tpl_tmp_product[$tmp_id];
		}
		unset($tpl_tmp_product, $tmp_id);
	}
	
	if ($new_products->RecordCount() > 0)
	{
		if (isset($new_products_category_id) && $new_products_category_id != 0)
		{
			$tpl_products['title'] = zen_get_categories_name((int)$new_products_category_id);
		}
		else
		{
		}
		$zc_show_new_products = true;
	}
}


<?php
/**
 * featured_products module - prepares content for display
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
$featured_products_query = '';
$display_limit = '';

$show_select_product_id = '';
if ($this_is_home_page)
	$show_select_product_id = HOME_SHOW_PRODUCT_FEATURED;

if ((($manufacturers_id > 0 && $_GET['filter_id'] == 0) || $_GET['music_genre_id'] > 0 || $_GET['record_company_id'] > 0) || (!isset($new_products_category_id) || $new_products_category_id == '0'))
{
	$featured_products_query = "select distinct p.products_id, p.products_image, pd.products_name, p.master_categories_id,f.date_status_change , p.product_is_free, p.product_is_call
                           from (" . TABLE_PRODUCTS . " p
                           left join " . TABLE_FEATURED . " f on p.products_id = f.products_id
                           left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id )
                           where p.products_id = f.products_id
                           and p.products_id = pd.products_id
                           and p.products_status = 1 and f.status = 1
                           and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                           	 and p.shop_id = ".(int)$_SESSION['shop_id']
                           .(!empty($show_select_product_id) ? " AND p.products_id IN (".$show_select_product_id.")" : "")."
                           
						   order by f.featured_date_added desc";
						  // order by f.featured_date_added desc";
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
		$featured_products_query = "select distinct p.products_id, p.products_image, pd.products_name, p.master_categories_id, p.product_is_free, p.product_is_call
                                from (" . TABLE_PRODUCTS . " p
                                left join " . TABLE_FEATURED . " f on p.products_id = f.products_id
                                left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id)
                                where p.products_id = f.products_id
                                and p.products_id = pd.products_id
                                and p.products_status = 1 and f.status = 1
                                and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                                 and p.shop_id = ".(int)$_SESSION['shop_id']
                                .(!empty($show_select_product_id) ? " AND p.products_id IN (".$show_select_product_id.")" : "")."
								order by f.featured_date_added desc";
	}
}
if ($featured_products_query != '') $featured_products = $db->Execute($featured_products_query, MAX_DISPLAY_SEARCH_RESULTS_FEATURED, true, CACHE_TIMELIFT);

$row = 0;
$col = 0;
$list_box_contents = array();
$tpl_products = array(
	'title' => '',
	'products' => array()
);
$title = '';

$num_products_count = ($featured_products_query == '') ? 0 : $featured_products->RecordCount();

// show only when 1 or more
if ($num_products_count > 0)
{
	if ($num_products_count < SHOW_PRODUCT_INFO_COLUMNS_FEATURED_PRODUCTS || SHOW_PRODUCT_INFO_COLUMNS_FEATURED_PRODUCTS == 0)
	{
		$col_width = floor(100 / $num_products_count);
	}
	else
	{
		$col_width = floor(100 / SHOW_PRODUCT_INFO_COLUMNS_FEATURED_PRODUCTS);
	}
	while(!$featured_products->EOF)
	{
		$tpl_products['products'][$featured_products->fields['products_id']] = array(
			'id' => $featured_products->fields['products_id'],
			'name' => zen_get_products_name($featured_products->fields['products_id']),
			'href' => zen_href_link(zen_get_info_page($featured_products->fields['products_id']), 'cPath=' . $productsInCategory[$featured_products->fields['products_id']] . '&products_id=' . $featured_products->fields['products_id']),
			'display_price' => zen_get_products_display_price($featured_products->fields['products_id']),
			'image' => ($featured_products->fields['products_image'] == '' && PRODUCTS_IMAGE_NO_IMAGE_STATUS == 0) ? '' : $featured_products->fields['products_image'],
			'tax_class_id' => $featured_products->fields['products_tax_class_id'],
			'date_added' => $featured_products->fields['products_date_added'],
			'type' => $featured_products->fields['products_type'],
			'categories_id' => $featured_products->fields['master_categories_id'],
			'is_call' => $featured_products->fields['product_is_call'] ? true : false,
			'is_free' => $featured_products->fields['product_is_free'] == '1' ? true : false,
			/*display more price*/
			'display_normal_price' => get_normal_price($featured_products->fields['products_id']),
			'display_special_price' => get_special_price($featured_products->fields['products_id']),
			'display_sale_price' => get_sale_discount_price($featured_products->fields['products_id']) 
		);
		$featured_products->MoveNext();
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
	
	if ($featured_products->RecordCount() > 0)
	{
		if (isset($new_products_category_id) && $new_products_category_id != 0)
		{
			$category_title = zen_get_categories_name((int)$new_products_category_id);
			$tpl_products['title'] = TABLE_HEADING_FEATURED_PRODUCTS . ($category_title != '' ? ' - ' . $category_title : '');
		}
		else
		{
			$tpl_products['title'] = TABLE_HEADING_FEATURED_PRODUCTS;
		}
		$zc_show_featured = true;
	}
}


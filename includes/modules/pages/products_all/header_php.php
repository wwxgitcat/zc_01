<?php
/**
 * products_all  header_php.php
 *
 * @package page
 * @author JunsGo@msn.com
 * @copyright Copyright 2013 SL Development Team
 * @copyright Portions Copyright 2003 osCommerce
 */
require (DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

$breadcrumb->add(NAVBAR_TITLE);
// display order dropdown
$disp_order_default = PRODUCT_ALL_LIST_SORT_DEFAULT;
require (DIR_WS_MODULES . zen_get_module_directory(FILENAME_LISTING_DISPLAY_ORDER));

$tpl_products = array(
	'title' => '',
	'products' => array()
);

$products_all_query_raw = "SELECT p.products_type, p.products_id, pd.products_name, p.products_image, p.products_price, p.products_tax_class_id,
                                    p.products_date_added, m.manufacturers_name, p.products_model, p.products_quantity, p.products_weight, p.product_is_call,
                                    p.product_is_always_free_shipping, p.products_qty_box_status,
                                    p.master_categories_id, p.product_is_free
                             FROM " . TABLE_PRODUCTS . " p
                             LEFT JOIN " . TABLE_MANUFACTURERS . " m ON (p.manufacturers_id = m.manufacturers_id), " . TABLE_PRODUCTS_DESCRIPTION . " pd
                             WHERE p.products_status = 1
                             AND p.products_id = pd.products_id
                             AND p.shop_id = ".(int)$_SESSION['shop_id']."
                             AND pd.language_id = :languageID " . $order_by;

$products_all_query_raw = $db->bindVars($products_all_query_raw, ':languageID', $_SESSION['languages_id'], 'integer');
$products_all_split = new splitPageResults($products_all_query_raw, MAX_DISPLAY_PRODUCTS_ALL);

// check to see if we are in normal mode ... not showcase, not maintenance, etc
$show_submit = zen_run_normal();

// check whether to use multiple-add-to-cart, and whether top or bottom buttons are displayed
if (PRODUCT_ALL_LISTING_MULTIPLE_ADD_TO_CART > 0 and $show_submit == true and $products_all_split->number_of_rows > 0)
{
	
	// check how many rows
	$products_all = $db->Execute($products_all_split->sql_query, false, true);
	$how_many = 0;
	while(!$products_all->EOF)
	{
		
		$tpl_products['products'][$products_all->fields['products_id']] = array(
			'name' => $products_all->fields['products_name'],
			'image' => $products_all->fields['products_image'],
			'quantity' => $products_all->fields['products_quantity'],
			'weight' => $products_all->fields['products_weight'],
			'type' => $products_all->fields['products_type'],
			'categories_id' => $products_all->fields['master_categories_id'],
			'manufacturers_id' => $products_all->fields['manufacturers_id'],
			'products_price' => $products_all->fields['products_price'],
			'tax_class_id' => $products_all->fields['products_tax_class_id'],
			'description' => zen_trunc_string(zen_clean_html(stripslashes(zen_get_products_description($products_all->fields['products_id'], $_SESSION['languages_id']))), PRODUCT_LIST_DESCRIPTION),
			'specials_price' => $products_all->fields['specials_new_products_price'],
			'final_price' => $products_all->fields['final_price'],
			'sort_order' => $products_all->fields['products_sort_order'],
			'is_call' => $products_all->fields['product_is_call'],
			'is_always_free_shipping' => $products_all->fields['product_is_always_free_shipping'],
			'qty_box_status' => $products_all->fields['products_qty_box_status'],
			'href' => zen_href_link(zen_get_info_page($products_all->fields['products_id']), 'cPath=' . (($_GET['manufacturers_id'] > 0 and $_GET['filter_id'] > 0) ? zen_get_generated_category_path_rev($_GET['filter_id']) : ($_GET['cPath'] > 0 ? zen_get_generated_category_path_rev($_GET['cPath']) : zen_get_generated_category_path_rev($products_all->fields['master_categories_id']))) . '&products_id=' . $products_all->fields['products_id']),
			'display_price' => zen_get_products_display_price($products_all->fields['products_id']),
			'is_free' => $products_all->fields['product_is_free'] == '1' ? true : false,
			/*display more price*/
			'display_normal_price' => get_normal_price($products_all->fields['products_id']),
			'display_special_price' => get_special_price($products_all->fields['products_id']),
			'display_sale_price' => get_sale_discount_price($products_all->fields['products_id']) 
		);
		
		if (PRODUCT_LIST_MANUFACTURER != 0)
		{
			$tpl_products['products'][$products_all->fields['products_id']]['show_manufacturer'] = true;
			$tpl_products['products'][$products_all->fields['products_id']]['manufacturers_name'] = $products_all->fields['manufacturers_name'];
			$tpl_products['products'][$products_all->fields['products_id']]['manufacturers_href'] = zen_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $products_all->fields['manufacturers_id']);
		}
		
		if (zen_has_product_attributes($products_all->fields['products_id']))
		{
		}
		else
		{
			// needs a better check v1.3.1
			if ($products_all->fields['products_qty_box_status'] != 0)
			{
				if (zen_get_products_allow_add_to_cart($products_all->fields['products_id']) != 'N')
				{
					if ($products_all->fields['product_is_call'] == 0)
					{
						if ((SHOW_PRODUCTS_SOLD_OUT_IMAGE == 1 and $products_all->fields['products_quantity'] > 0) or SHOW_PRODUCTS_SOLD_OUT_IMAGE == 0)
						{
							if ($products_all->fields['products_type'] != 3)
							{
								if (zen_has_product_attributes($products_all->fields['products_id']) < 1)
								{
									$how_many++;
								}
							}
						}
					}
				}
			}
		}
		$products_all->MoveNext();
	}
	
	if ((($how_many > 0 and $show_submit == true and $products_all_split->number_of_rows > 0) and (PRODUCT_ALL_LISTING_MULTIPLE_ADD_TO_CART == 1 or PRODUCT_ALL_LISTING_MULTIPLE_ADD_TO_CART == 3)))
	{
		$show_top_submit_button = true;
	}
	else
	{
		$show_top_submit_button = false;
	}
	if ((($how_many > 0 and $show_submit == true and $products_all_split->number_of_rows > 0) and (PRODUCT_ALL_LISTING_MULTIPLE_ADD_TO_CART >= 2)))
	{
		$show_bottom_submit_button = true;
	}
	else
	{
		$show_bottom_submit_button = false;
	}
}
?>
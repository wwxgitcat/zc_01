<?php
/**
 * @package modules
 * @author JunsGo@msn.com
 * @copyright Copyright 2013 SL Development Team
 * @copyright Portions Copyright 2003 osCommerce
 */
function get_sale_discount_price($products_id)
{
	global $db, $currencies;
	
	switch(true)
	{
		case (CUSTOMERS_APPROVAL == '1' && $_SESSION['customer_id'] == ''):
			// customer must be logged in to browse
			return '';
			break;
		case (CUSTOMERS_APPROVAL == '2' && $_SESSION['customer_id'] == ''):
			// customer may browse but no prices
			return TEXT_LOGIN_FOR_PRICE_PRICE;
			break;
		case (CUSTOMERS_APPROVAL == '3' && TEXT_LOGIN_FOR_PRICE_PRICE_SHOWROOM != ''):
			// customer may browse but no prices
			return TEXT_LOGIN_FOR_PRICE_PRICE_SHOWROOM;
			break;
		case ((CUSTOMERS_APPROVAL_AUTHORIZATION != '0' && CUSTOMERS_APPROVAL_AUTHORIZATION != '3') && $_SESSION['customer_id'] == ''):
			// customer must be logged in to browse
			return TEXT_AUTHORIZATION_PENDING_PRICE;
			break;
		case ((CUSTOMERS_APPROVAL_AUTHORIZATION != '0' && CUSTOMERS_APPROVAL_AUTHORIZATION != '3') && $_SESSION['customers_authorization'] > '0'):
			// customer must be logged in to browse
			return TEXT_AUTHORIZATION_PENDING_PRICE;
			break;
		default:
			// proceed normally
			break;
	}
	
	// show case only
	if (STORE_STATUS != '0')
	{
		if (STORE_STATUS == '1')
		{
			return '';
		}
	}
	
	$product_check = $db->Execute("select products_tax_class_id, products_price, products_priced_by_attribute, product_is_free, product_is_call, products_type from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "'" . " limit 1");
	
	// no prices on Document General
	if ($product_check->fields['products_type'] == 3)
	{
		return '';
	}
	
	$display_normal_price = zen_get_products_base_price($products_id);
	$display_special_price = zen_get_products_special_price($products_id, true);
	$display_sale_price = zen_get_products_special_price($products_id, false);
	
	$sale_discount = '';
	if (SHOW_SALE_DISCOUNT_STATUS == '1' && ($display_special_price != 0 || $display_sale_price != 0))
	{
		if ($display_sale_price)
		{
			if (SHOW_SALE_DISCOUNT == 1)
			{
				if ($display_normal_price != 0)
				{
					$show_discount_amount = number_format(100 - (($display_sale_price / $display_normal_price) * 100), SHOW_SALE_DISCOUNT_DECIMALS);
				}
				else
				{
					$show_discount_amount = '';
				}
				$sale_discount = PRODUCT_PRICE_DISCOUNT_PREFIX . $show_discount_amount . PRODUCT_PRICE_DISCOUNT_PERCENTAGE;
			}
			else
			{
				$sale_discount = PRODUCT_PRICE_DISCOUNT_PREFIX . $currencies->display_price(($display_normal_price - $display_sale_price), zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . PRODUCT_PRICE_DISCOUNT_AMOUNT;
			}
		}
		else
		{
			if (SHOW_SALE_DISCOUNT == 1)
			{
				$sale_discount = PRODUCT_PRICE_DISCOUNT_PREFIX . number_format(100 - (($display_special_price / $display_normal_price) * 100), SHOW_SALE_DISCOUNT_DECIMALS) . PRODUCT_PRICE_DISCOUNT_PERCENTAGE;
			}
			else
			{
				$sale_discount = PRODUCT_PRICE_DISCOUNT_PREFIX . $currencies->display_price(($display_normal_price - $display_special_price), zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . PRODUCT_PRICE_DISCOUNT_AMOUNT;
			}
		}
	}
	return $sale_discount;
}
function get_special_price($products_id)
{
	global $db, $currencies;
	
	switch(true)
	{
		case (CUSTOMERS_APPROVAL == '1' && $_SESSION['customer_id'] == ''):
			// customer must be logged in to browse
			return '';
			break;
		case (CUSTOMERS_APPROVAL == '2' && $_SESSION['customer_id'] == ''):
			// customer may browse but no prices
			return TEXT_LOGIN_FOR_PRICE_PRICE;
			break;
		case (CUSTOMERS_APPROVAL == '3' && TEXT_LOGIN_FOR_PRICE_PRICE_SHOWROOM != ''):
			// customer may browse but no prices
			return TEXT_LOGIN_FOR_PRICE_PRICE_SHOWROOM;
			break;
		case ((CUSTOMERS_APPROVAL_AUTHORIZATION != '0' && CUSTOMERS_APPROVAL_AUTHORIZATION != '3') && $_SESSION['customer_id'] == ''):
			// customer must be logged in to browse
			return TEXT_AUTHORIZATION_PENDING_PRICE;
			break;
		case ((CUSTOMERS_APPROVAL_AUTHORIZATION != '0' && CUSTOMERS_APPROVAL_AUTHORIZATION != '3') && $_SESSION['customers_authorization'] > '0'):
			// customer must be logged in to browse
			return TEXT_AUTHORIZATION_PENDING_PRICE;
			break;
		default:
			// proceed normally
			break;
	}
	
	// show case only
	if (STORE_STATUS != '0')
	{
		if (STORE_STATUS == '1')
		{
			return '';
		}
	}
	
	$product_check = $db->Execute("select products_tax_class_id, products_price, products_priced_by_attribute, product_is_free, product_is_call, products_type from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "'" . " limit 1");
	
	// no prices on Document General
	if ($product_check->fields['products_type'] == 3)
	{
		return '';
	}
	
	$display_special_price = zen_get_products_special_price($products_id, true);
	$special_price = 0;
	
	if ($display_special_price) $special_price = $currencies->display_price($display_special_price, zen_get_tax_rate($product_check->fields['products_tax_class_id']));
	
	return $special_price;
}
function get_normal_price($products_id)
{
	global $db, $currencies;
	
	switch(true)
	{
		case (CUSTOMERS_APPROVAL == '1' && $_SESSION['customer_id'] == ''):
			// customer must be logged in to browse
			return '';
			break;
		case (CUSTOMERS_APPROVAL == '2' && $_SESSION['customer_id'] == ''):
			// customer may browse but no prices
			return TEXT_LOGIN_FOR_PRICE_PRICE;
			break;
		case (CUSTOMERS_APPROVAL == '3' && TEXT_LOGIN_FOR_PRICE_PRICE_SHOWROOM != ''):
			// customer may browse but no prices
			return TEXT_LOGIN_FOR_PRICE_PRICE_SHOWROOM;
			break;
		case ((CUSTOMERS_APPROVAL_AUTHORIZATION != '0' && CUSTOMERS_APPROVAL_AUTHORIZATION != '3') && $_SESSION['customer_id'] == ''):
			// customer must be logged in to browse
			return TEXT_AUTHORIZATION_PENDING_PRICE;
			break;
		case ((CUSTOMERS_APPROVAL_AUTHORIZATION != '0' && CUSTOMERS_APPROVAL_AUTHORIZATION != '3') && $_SESSION['customers_authorization'] > '0'):
			// customer must be logged in to browse
			return TEXT_AUTHORIZATION_PENDING_PRICE;
			break;
		default:
			// proceed normally
			break;
	}
	
	// show case only
	if (STORE_STATUS != '0')
	{
		if (STORE_STATUS == '1')
		{
			return '';
		}
	}
	
	$product_check = $db->Execute("select products_tax_class_id, products_price, products_priced_by_attribute, product_is_free, product_is_call, products_type from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "'" . " limit 1");
	
	// no prices on Document General
	if ($product_check->fields['products_type'] == 3)
	{
		return '';
	}
	
	$display_normal_price = zen_get_products_base_price($products_id);
	$special_price = 0;
	
	$normal_price = $currencies->display_price($display_normal_price, zen_get_tax_rate($product_check->fields['products_tax_class_id']));
	
	return $normal_price;
}
function get_product_is_free($products_id)
{
	global $db;
	
	$free = false;
	$product_check = $db->Execute("select product_is_free from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "'" . " limit 1", false, true);
	if ($product_check->fields['product_is_free'] == '1') $free = true;
	return $free;
}
function get_product_is_call($products_id)
{
	global $db;
	
	$call = false;
	$product_check = $db->Execute("select product_is_call from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "'" . " limit 1");
	if ($product_check->fields['product_is_call'] == '1') $call = true;
	return $call;
}
?>
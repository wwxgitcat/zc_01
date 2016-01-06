<?php
/**
 * Checkout Shipping Page
 *
 * @package page
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 18697 2011-05-04 14:35:20Z wilt $
 */

require (DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

// Get coupon code
if (!isset($_SESSION['J_COUPON_VALIDATE']))
	$_SESSION['J_COUPON_VALIDATE'] = null;

if (isset($_GET['get_coupon']) && (int)$_GET['get_coupon'] == 1)
{
	if ($_SESSION['J_COUPON_VALIDATE'] === null)
	{
		$db->Execute('UPDATE '.TABLE_CUSTOMERS_FOLLOW.' SET `jcoupon_get`=1, `jcoupon_start_time`='.time().' WHERE `customers_id`='.(int)$_SESSION['customer_id']);
		
	}
	
	$_SESSION['J_COUPON_VALIDATE'] = false;
	if (!isset($_SESSION['J_COUPON_CODE']) || empty($_SESSION['J_COUPON_CODE']))
		$_SESSION['J_COUPON_CODE'] = get_rand_name(8);
	
	
	
	$cus = $db->Execute('SELECT * FROM '.TABLE_CUSTOMERS.' WHERE `customers_id`='.(int)$_SESSION['customer_id']);
	$email_address = $cus->fields['customers_email_address'];
	$name = $cus->fields['customers_firstname'] . ' ' . $cus->fields['customers_lastname'];
	
	$html_msg['EMAIL_FIRST_NAME'] = $_SESSION['customer_first_name'];
	$html_msg['EMAIL_LAST_NAME'] = $_SESSION['customer_last_name'];
	
	$email_text = "\n\n".sprintf(EMAIL_J_COUPON_TEXT, $name, zen_href_link(FILENAME_DEFAULT), $_SESSION['J_COUPON_CODE'], zen_href_link(FILENAME_DEFAULT));
	$html_msg['EMAIL_J_COUPON_HTML'] = sprintf(EMAIL_J_COUPON_HTML, $name, zen_href_link(FILENAME_DEFAULT), $_SESSION['J_COUPON_CODE'], zen_href_link(FILENAME_DEFAULT));
	
	
	@zen_mail($name, $email_address, EMAIL_J_COUPON_SUBJECT, $email_text, STORE_NAME, EMAIL_FROM, $html_msg, 'jcoupon');
	
	
	$result = array(
		'status' => 1,
		'mail' => 1,
		'code' => $_SESSION['J_COUPON_CODE'],
		'msg' => (sprintf(TEXT_SHIPPING_COUPON_INFO, $_SESSION['J_COUPON_CODE']))
	);
	exit(json_encode($result));
}
if (isset($_POST['val_coupon']) && (int)$_POST['val_coupon'] == 1)
{
	$flag = true;
	if (!isset($_POST['coupon_code']) || empty($_POST['coupon_code']) || strtolower($_POST['coupon_code']) != strtolower($_SESSION['J_COUPON_CODE']))
		$flag = false;
	
	if ($flag)
		$msg = TEXT_SHIPPING_COUPON_INFO_SUCCESS;
	else
		$msg = sprintf(TEXT_SHIPPING_COUPON_INFO_ERROR, $_SESSION['J_COUPON_CODE']);
	
	
	
	$result = array(
		'status' => 1,
		'mail' => 1,
		'code' => $_SESSION['J_COUPON_CODE'],
		'msg' => $msg
	);
	exit(json_encode($result));
}


// This should be first line of the script:
$zco_notifier->notify('NOTIFY_HEADER_START_CHECKOUT_SHIPPING');

require_once (DIR_WS_CLASSES . 'http_client.php');

// if there is nothing in the customers cart, redirect them to the shopping cart page
if ($_SESSION['cart']->count_contents() <= 0)
{
	zen_redirect(zen_href_link(FILENAME_TIME_OUT));
}

// if the customer is not logged on, redirect them to the login page
if (!isset($_SESSION['customer_id']) || !$_SESSION['customer_id'])
{
	$_SESSION['navigation']->set_snapshot();
	zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
}
else
{
	// validate customer
	if (zen_get_customer_validate_session($_SESSION['customer_id']) == false)
	{
		$_SESSION['navigation']->set_snapshot(array(
			'mode' => 'SSL',
			'page' => FILENAME_CHECKOUT_SHIPPING 
		));
		zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
	}
}

// Validate Cart for checkout
$_SESSION['valid_to_checkout'] = true;
$_SESSION['cart']->get_products(true);
if ($_SESSION['valid_to_checkout'] == false)
{
	$messageStack->add('header', ERROR_CART_UPDATE, 'error');
	zen_redirect(zen_href_link(FILENAME_SHOPPING_CART));
}

// Stock Check
if ((STOCK_CHECK == 'true') && (STOCK_ALLOW_CHECKOUT != 'true'))
{
	$products = $_SESSION['cart']->get_products();
	for($i = 0, $n = sizeof($products); $i < $n; $i++)
	{
		if (zen_check_stock($products[$i]['id'], $products[$i]['quantity']))
		{
			zen_redirect(zen_href_link(FILENAME_SHOPPING_CART));
			break;
		}
	}
}
// if no shipping destination address was selected, use the customers own address as default
if (!$_SESSION['sendto'])
{
	$_SESSION['sendto'] = $_SESSION['customer_default_address_id'];
}
else
{
	// verify the selected shipping address
	$check_address_query = "SELECT count(*) AS total
                            FROM   " . TABLE_ADDRESS_BOOK . "
                            WHERE  customers_id = :customersID
                            AND    address_book_id = :addressBookID";
	
	$check_address_query = $db->bindVars($check_address_query, ':customersID', $_SESSION['customer_id'], 'integer');
	$check_address_query = $db->bindVars($check_address_query, ':addressBookID', $_SESSION['sendto'], 'integer');
	$check_address = $db->Execute($check_address_query);
	
	if ($check_address->fields['total'] != '1')
	{
		$_SESSION['sendto'] = $_SESSION['customer_default_address_id'];
		$_SESSION['shipping'] = '';
	}
}

require (DIR_WS_CLASSES . 'order.php');
$order = new order();

// register a random ID in the session to check throughout the checkout procedure
// against alterations in the shopping cart contents
if (isset($_SESSION['cart']->cartID))
{
	if (!isset($_SESSION['cartID']) || $_SESSION['cart']->cartID != $_SESSION['cartID'])
	{
		$_SESSION['cartID'] = $_SESSION['cart']->cartID;
	}
}
else
{
	zen_redirect(zen_href_link(FILENAME_TIME_OUT));
}

// if the order contains only virtual products, forward the customer to the billing page as
// a shipping address is not needed
if ($order->content_type == 'virtual')
{
	$_SESSION['shipping'] = 'free_free';
	$_SESSION['shipping']['title'] = 'free_free';
	$_SESSION['sendto'] = false;
	zen_redirect(zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
}

$total_weight = $_SESSION['cart']->show_weight();
$total_count = $_SESSION['cart']->count_contents();

// load all enabled shipping modules
require (DIR_WS_CLASSES . 'shipping.php');
$shipping_modules = new shipping();

$pass = true;
if (defined('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING') && (MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING == 'true'))
{
	$pass = false;
	
	switch(MODULE_ORDER_TOTAL_SHIPPING_DESTINATION)
	{
		case 'national':
			if ($order->delivery['country_id'] == STORE_COUNTRY)
			{
				$pass = true;
			}
			break;
		case 'international':
			if ($order->delivery['country_id'] != STORE_COUNTRY)
			{
				$pass = true;
			}
			break;
		case 'both':
			$pass = true;
			break;
	}
	
	$free_shipping = false;
	if (($pass == true) && ($_SESSION['cart']->show_total() >= MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER))
	{
		$free_shipping = true;
	}
}
else
{
	$free_shipping = false;
}



if (isset($_SESSION['comments']))
{
	$comments = $_SESSION['comments'];
}

// process the selected shipping method
if (isset($_POST['action']) && ($_POST['action'] == 'process'))
{
	
	// JCoupon
	if ($_SESSION['J_COUPON_VALIDATE'] !== null)
	{
		if (isset($_POST['jcoupon']) && !empty($_POST['jcoupon']) && trim(strtolower($_POST['jcoupon'])) == strtolower($_SESSION['J_COUPON_CODE']))
		{
			$_SESSION['J_COUPON_VALIDATE'] = true;
			$_SESSION['J_COUPON_COST'] = J_SHIPPING_COUPON_COST;
			$db->Execute('UPDATE '.TABLE_CUSTOMERS_FOLLOW.' SET `jcoupon_status`=1 WHERE `customers_id`='.(int)$_SESSION['customer_id']);
		}
		else if (!empty($_POST['jcoupon']))
		{
			$db->Execute('UPDATE '.TABLE_CUSTOMERS_FOLLOW.' SET `jcoupon_status`=2 WHERE `customers_id`='.(int)$_SESSION['customer_id']);
		}
	}
	$db->Execute('UPDATE '.TABLE_CUSTOMERS_FOLLOW.' SET `jcoupon_end_time`='.time().' WHERE `customers_id`='.(int)$_SESSION['customer_id']);
	
	if (zen_not_null($_POST['comments']))
	{
		$_SESSION['comments'] = zen_db_prepare_input($_POST['comments']);
	}
	$comments = $_SESSION['comments'];
	$quote = array();
	
	if ((zen_count_shipping_modules() > 0) || ($free_shipping == true))
	{
		if ((isset($_POST['shipping'])) && (strpos($_POST['shipping'], '_')))
		{
			/**
			 * check to be sure submitted data hasn't been tampered with
			 */
			if ($_POST['shipping'] == 'free_free' && ($order->content_type != 'virtual' && !$pass))
			{
				$quote['error'] = 'Invalid input. Please make another selection.';
			}
			else
			{
				$_SESSION['shipping'] = $_POST['shipping'];
			}
			
			list($module, $method) = explode('_', $_SESSION['shipping']);
			if (is_object($$module) || ($_SESSION['shipping'] == 'free_free'))
			{
				if ($_SESSION['shipping'] == 'free_free')
				{
					$quote[0]['methods'][0]['title'] = FREE_SHIPPING_TITLE;
					$quote[0]['methods'][0]['cost'] = '0';
				}
				else
				{
					$quote = $shipping_modules->quote($method, $module);
				}
				if (isset($quote['error']))
				{
					$_SESSION['shipping'] = '';
				}
				else
				{
					if ((isset($quote[0]['methods'][0]['title'])) && (isset($quote[0]['methods'][0]['cost'])))
					{
						$_SESSION['shipping'] = array(
							'id' => $_SESSION['shipping'],
							'title' => (($free_shipping == true) ? $quote[0]['methods'][0]['title'] : $quote[0]['module'] . ' (' . $quote[0]['methods'][0]['title'] . ')'),
							'cost' => $quote[0]['methods'][0]['cost'] 
						);
						
						zen_redirect(zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
					}
				}
			}
			else
			{
				$_SESSION['shipping'] = false;
			}
		}
	}
	else
	{
		$_SESSION['shipping'] = false;
		
		zen_redirect(zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
	}
}

// get all available shipping quotes
$quotes = $shipping_modules->quote();

$shipping_cost = false;
foreach ($quotes as $q){
	if (isset($q['methods'][0]['cost']) && (int)$q['methods'][0]['cost'] > 0){
		$shipping_cost = (int)$q['methods'][0]['cost'];
		break;
	}
}

// check that the currently selected shipping method is still valid (in case a zone restriction has disabled it, etc)
if (isset($_SESSION['shipping']) && $_SESSION['shipping'] != FALSE && $_SESSION['shipping'] != '')
{
	$checklist = array();
	foreach($quotes as $key => $val)
	{
		foreach($val['methods'] as $key2 => $method)
		{
			$checklist[] = $val['id'] . '_' . $method['id'];
		}
	}
	$checkval = (is_array($_SESSION['shipping']) ? $_SESSION['shipping']['id'] : $_SESSION['shipping']);
	if (!in_array($checkval, $checklist))
	{
		$messageStack->add('checkout_shipping', ERROR_PLEASE_RESELECT_SHIPPING_METHOD, 'error');
	}
}

// if no shipping method has been selected, automatically select the cheapest method.
// if the modules status was changed when none were available, to save on implementing
// a javascript force-selection method, also automatically select the cheapest shipping
// method if more than one module is now enabled
if (!$_SESSION['shipping'] || ($_SESSION['shipping'] && ($_SESSION['shipping'] == false) && (zen_count_shipping_modules() > 1)))
	$_SESSION['shipping'] = $shipping_modules->cheapest();

// Should address-edit button be offered?
$displayAddressEdit = (MAX_ADDRESS_BOOK_ENTRIES >= 2);

// if shipping-edit button should be overridden, do so
$editShippingButtonLink = zen_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, '', 'SSL');
if (isset($_SESSION['payment']) && method_exists($$_SESSION['payment'], 'alterShippingEditButton'))
{
	$theLink = $$_SESSION['payment']->alterShippingEditButton();
	if ($theLink)
	{
		$editShippingButtonLink = $theLink;
		$displayAddressEdit = true;
	}
}

$breadcrumb->add(NAVBAR_TITLE_1, zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2);

// This should be last line of the script:
$zco_notifier->notify('NOTIFY_HEADER_END_CHECKOUT_SHIPPING');

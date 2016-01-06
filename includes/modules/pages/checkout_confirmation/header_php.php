<?php

require (DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
require(DIR_WS_LANGUAGES.$_SESSION['language'].'/checkout_process.php');



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
			'page' => FILENAME_CHECKOUT_CONFIRMATION
		));
		zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
	}
}
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

// if no billing destination address was selected, use the customers own address as default
if (!$_SESSION['billto'])
{
	$_SESSION['billto'] = $_SESSION['customer_default_address_id'];
}
else
{
	// verify the selected billing address
	$check_address_query = "SELECT count(*) AS total FROM " . TABLE_ADDRESS_BOOK . "
                          WHERE customers_id = :customersID
                          AND address_book_id = :addressBookID";

	$check_address_query = $db->bindVars($check_address_query, ':customersID', $_SESSION['customer_id'], 'integer');
	$check_address_query = $db->bindVars($check_address_query, ':addressBookID', $_SESSION['billto'], 'integer');
	$check_address = $db->Execute($check_address_query);

	if ($check_address->fields['total'] != '1')
	{
		$_SESSION['billto'] = $_SESSION['customer_default_address_id'];
		$_SESSION['payment'] = '';
	}
}




$total_weight = $_SESSION['cart']->show_weight();
$total_count = $_SESSION['cart']->count_contents();

if (zen_not_null($_POST['comments']))
{
	$_SESSION['comments'] = zen_db_prepare_input($_POST['comments']);
}
$comments = $_SESSION['comments'];

if (!isset($credit_covers)) $credit_covers = FALSE;

// echo 'credit covers'.$credit_covers;

if ($credit_covers)
{
	unset($_SESSION['payment']);
	$_SESSION['payment'] = '';
}

require (DIR_WS_CLASSES . 'order.php');
$order = new order();



// load all enabled shipping modules
require (DIR_WS_CLASSES . 'shipping.php');
$shipping_modules = new shipping();

require (DIR_WS_CLASSES . 'payment.php');
$payment_modules = new payment();
$payment_selection = $payment_modules->selection();
if (count($payment_selection) && !$_SESSION['payment'])
	$_SESSION['payment'] = $payment_selection[0]['id'];

$payment_modules = new payment($_SESSION['payment']);

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

// process the selected shipping method
// get all available shipping quotes
$quotes = $shipping_modules->quote();
//$shipping_modules->cheapest();

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


if (!$_SESSION['shipping'] || ($_SESSION['shipping'] && ($_SESSION['shipping'] == false) ))
	$_SESSION['shipping'] = $shipping_modules->cheapest();


if (isset($_SESSION['shipping']['id']))
{
	//re-calc
	list($module, $method) = explode('_', $_SESSION['shipping']['id']);
	$quote = $shipping_modules->quote($method, $module);
	if (!isset($quote['error']))
	{
		if ((isset($quote[0]['methods'][0]['title'])) && (isset($quote[0]['methods'][0]['cost'])))
		{
			$_SESSION['shipping'] = array(
				'id' => $_SESSION['shipping']['id'],
				'title' => (($free_shipping == true) ? $quote[0]['methods'][0]['title'] : $quote[0]['module'] . ' (' . $quote[0]['methods'][0]['title'] . ')'),
				'cost' => $quote[0]['methods'][0]['cost']
			);
		
		}
		$order->info['shipping_method'] = $_SESSION['shipping']['title'];
		$order->info['shipping_cost'] = $quote[0]['methods'][0]['cost'];
	}
}


// if the order contains only virtual products, forward the customer to the billing page as
// a shipping address is not needed
if ($order->content_type == 'virtual')
{
	$_SESSION['shipping'] = 'free_free';
	$_SESSION['shipping']['title'] = 'free_free';
	$_SESSION['sendto'] = false;
	zen_redirect(zen_href_link(FILENAME_CHECKOUT_CONFIRMATION, '', 'SSL'));
}


$order = new order();


require (DIR_WS_CLASSES . 'order_total.php');
$order_total_modules = new order_total();
$order_total_modules->collect_posts();
$order_total_modules->pre_confirmation_check();





if ((isset($_GET['ajax']) || isset($_GET['amp;ajax'])) && isset($_POST['shipping']))
{

	$info = array(
		'orderTotal' => '',
		'total' => ''
	);

	if ((zen_count_shipping_modules() > 0) || ($free_shipping == true))
	{
		if ((isset($_POST['shipping'])) && (strpos($_POST['shipping'], '_')))
		{
			$_SESSION['shipping'] = $_POST['shipping'];
				
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

					}
					$order->info['shipping_method'] = $_SESSION['shipping']['title'];
					$order->info['shipping_cost'] = $quote[0]['methods'][0]['cost'];
					$info['msg'] = '';
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

	}

	$order = new order();
	
	$order_totals = $order_total_modules->process();
	ob_start();
	$order_total_modules->output();
	$output = ob_get_clean();
	ob_end_clean();
	$info['orderTotal'] = $output;
	$info['total'] = $currencies->format($order->info['total']);


	exit(json_encode($info));
}




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

					zen_redirect(zen_href_link(FILENAME_CHECKOUT_CONFIRMATION, '', 'SSL'));
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

	zen_redirect(zen_href_link(FILENAME_CHECKOUT_CONFIRMATION, '', 'SSL'));
}


// get coupon code
if ($_SESSION['cc_id'])
{
	$discount_coupon_query = "SELECT coupon_code
                            FROM " . TABLE_COUPONS . "
                            WHERE coupon_id = :couponID";

	$discount_coupon_query = $db->bindVars($discount_coupon_query, ':couponID', $_SESSION['cc_id'], 'integer');
	$discount_coupon = $db->Execute($discount_coupon_query);
}


$shipping_cost = false;
foreach ($quotes as $q){
	if (isset($q['methods'][0]['cost']) && (int)$q['methods'][0]['cost'] > 0){
		$shipping_cost = (int)$q['methods'][0]['cost'];
		break;
	}
}

// check that the currently selected shipping method is still valid (in case a zone restriction has disabled it, etc)




$flagOnSubmit = sizeof($payment_selection);

$payment_modules->update_status();
if (($_SESSION['payment'] == '' || !is_object($$_SESSION['payment'])) && $credit_covers === FALSE)
{
	$messageStack->add_session('checkout_payment', ERROR_NO_PAYMENT_MODULE_SELECTED, 'error');
}

if (is_array($payment_modules->modules))
{
	$payment_modules->pre_confirmation_check();
}

if ($messageStack->size('checkout_payment') > 0)
{
	zen_redirect(zen_href_link(FILENAME_CHECKOUT_CONFIRMATION, '', 'SSL'));
}

// update customers_referral with $_SESSION['gv_id']
if ($_SESSION['cc_id'])
{
	$discount_coupon_query = "SELECT coupon_code
                            FROM " . TABLE_COUPONS . "
                            WHERE coupon_id = :couponID";

	$discount_coupon_query = $db->bindVars($discount_coupon_query, ':couponID', $_SESSION['cc_id'], 'integer');
	$discount_coupon = $db->Execute($discount_coupon_query);

	$customers_referral_query = "SELECT customers_referral
                               FROM " . TABLE_CUSTOMERS . "
                               WHERE customers_id = :customersID";

	$customers_referral_query = $db->bindVars($customers_referral_query, ':customersID', $_SESSION['customer_id'], 'integer');
	$customers_referral = $db->Execute($customers_referral_query);

	// only use discount coupon if set by coupon
	if ($customers_referral->fields['customers_referral'] == '' and CUSTOMERS_REFERRAL_STATUS == 1)
	{
		$sql = "UPDATE " . TABLE_CUSTOMERS . "
            SET customers_referral = :customersReferral
            WHERE customers_id = :customersID";

		$sql = $db->bindVars($sql, ':customersID', $_SESSION['customer_id'], 'integer');
		$sql = $db->bindVars($sql, ':customersReferral', $discount_coupon->fields['coupon_code'], 'string');
		$db->Execute($sql);
	}
	else
	{
		// do not update referral was added before
	}
}

if (isset($$_SESSION['payment']->form_action_url))
{
	$form_action_url = $$_SESSION['payment']->form_action_url;
}
else
{
	$form_action_url = zen_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL');
}
if ($_SESSION['payment'] == 'rpsitepay')
    $form_action_url = zen_href_link('checkout_checkout', '', 'SSL');







// if shipping-edit button should be overridden, do so
$editShippingButtonLink = zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL');
if (method_exists($$_SESSION['payment'], 'alterShippingEditButton'))
{
	$theLink = $$_SESSION['payment']->alterShippingEditButton();
	if ($theLink) $editShippingButtonLink = $theLink;
}
// deal with billing address edit button
$flagDisablePaymentAddressChange = false;
if (isset($$_SESSION['payment']->flagDisablePaymentAddressChange))
{
	$flagDisablePaymentAddressChange = $$_SESSION['payment']->flagDisablePaymentAddressChange;
}

// Load the selected shipping module(needed to calculate tax correctly)









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


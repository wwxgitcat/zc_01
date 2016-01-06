<?php
if (!defined('IS_ADMIN_FLAG'))
{
	die('Illegal Access');
}
$zco_notifier->notify('NOTIFY_HEADER_START_CHECKOUT_CHECKOUT');
require(DIR_WS_LANGUAGES.$_SESSION['language'].'/checkout_process.php');
require (DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));



if ($_SESSION['customer_default_address_id'] <= 0)
{
    
    zen_redirect(zen_href_link(FILENAME_SHOPPING_CART));
}



if (!$_SESSION['customer_id'])
{
	zen_redirect(zen_href_link(FILENAME_TIME_OUT));
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


if (empty($_SESSION['payment']) || empty($_SESSION['shipping']))
{
	zen_redirect(zen_href_link(FILENAME_CHECKOUT_CONFIRMATION, '', 'SSL'));
}


if (isset($_POST['payment']) && strstr(MODULE_PAYMENT_INSTALLED, $_POST['payment']))
	$_SESSION['payment'] = $_POST['payment'];


if (!strstr(MODULE_PAYMENT_INSTALLED, $_SESSION['payment']))
{
	zen_redirect(zen_href_link(FILENAME_CHECKOUT_CONFIRMATION, '', 'SSL'));
}

if (!isset($credit_covers)) $credit_covers = FALSE;

// load selected payment module
require (DIR_WS_CLASSES . 'payment.php');
// load the selected shipping module
require (DIR_WS_CLASSES . 'shipping.php');
require (DIR_WS_CLASSES . 'order.php');

$shipping_modules = new shipping();
$order = new order();//apply to shipping

$total_weight = $_SESSION['cart']->show_weight();
$total_count = $_SESSION['cart']->count_contents();

if (isset($_POST['shipping']) && !empty($_POST['shipping']))
{
	$free_shipping = false;
	$quote = array();
	if ((zen_count_shipping_modules() > 0))
	{
		if ((isset($_POST['shipping'])) && (strpos($_POST['shipping'], '_')))
		{
			$_SESSION['shipping'] = $_POST['shipping'];
			
			list($module, $method) = explode('_', $_SESSION['shipping']);
			if (is_object($$module))
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
					//Have this shipping and not error
					$_SESSION['shipping'] = array(
						'id' => $_SESSION['shipping'],
						'title' => (($free_shipping == true) ? $quote[0]['methods'][0]['title'] : $quote[0]['module'] . ' (' . $quote[0]['methods'][0]['title'] . ')'),
						'cost' => $quote[0]['methods'][0]['cost']
					);
				}
			}
		}
	}
}


$payment_modules = new payment($_SESSION['payment']);
$shipping_modules = new shipping(is_array($_SESSION['shipping']) ? $_SESSION['shipping']['id'] : $_SESSION['shipping']);
$order = new order();

// prevent 0-entry orders from being generated/spoofed
if (sizeof($order->products) < 1)
{
	zen_redirect(zen_href_link(FILENAME_SHOPPING_CART));
}

// BEGIN CC SLAM PREVENTION
if (!isset($_SESSION['payment_attempt'])) $_SESSION['payment_attempt'] = 0;
$_SESSION['payment_attempt']++;
$zco_notifier->notify('NOTIFY_CHECKOUT_SLAMMING_ALERT');
if ($_SESSION['payment_attempt'] > 10)
{
	$zco_notifier->notify('NOTIFY_CHECKOUT_SLAMMING_LOCKOUT');
	$_SESSION['cart']->reset(TRUE);
	zen_session_destroy();
	zen_redirect(zen_href_link(FILENAME_TIME_OUT));
}
// END CC SLAM PREVENTION




require (DIR_WS_CLASSES . 'order_total.php');
$order_total_modules = new order_total();
$order_total_modules->collect_posts();
$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_BEFORE_ORDER_TOTALS_PRE_CONFIRMATION_CHECK');
if (strpos($GLOBALS[$_SESSION['payment']]->code, 'paypal') !== 0)
{
	$order_totals = $order_total_modules->pre_confirmation_check();
}
if ($credit_covers === TRUE)
{
	$order->info['payment_method'] = $order->info['payment_module_code'] = '';
}
$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_BEFORE_ORDER_TOTALS_PROCESS');
$order_totals = $order_total_modules->process();
$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_AFTER_ORDER_TOTALS_PROCESS');



//Process rpsitepay payment method
if ($_SESSION['payment'] == 'rpsitepay' && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['payment_process']) && $_POST['payment_process'] =='payment_post')
{
	$checkout_paymethod = $_POST['paymethod'];
	$checkout_card_no = $_POST['card_no'];
	$checkout_card_exp_month = $_POST['card_exp_month'];
	$checkout_card_exp_year = $_POST['card_exp_year'];
	$checkout_card_cvn = $_POST['card_cvn'];
	
	$checkout_BFirstName = $_POST['BFirstName'];
	$checkout_BLastName = $_POST['BLastName'];
	$checkout_BAddress = $_POST['BAddress'];
	$checkout_PostCode = $_POST['PostCode'];
	$checkout_BCity = $_POST['BCity'];
	$checkout_BEmail = $_POST['BEmail'];
	
	$checkout_remote_ip = zen_get_ip_address();
	$checkout_user_agent = $_SERVER['HTTP_USER_AGENT'];
	$checkout_accept_language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
	
	$checkout_hDate = $_POST['checkout_hDate'];
	$checkout_hTimeZone = $_POST['checkout_hTimeZone'];
	$checkout_vga = $_POST['checkout_vga'];
	
	$pay_error = false;
	if (empty($checkout_paymethod))
	{
		$pay_error = true;
		$messageStack->add('pay_error', TEXT_CHECKOUT_PAYMENT_ERROR_CREDIT_CARD);
	}
	if (empty($checkout_card_no))
	{
		$pay_error = true;
		$messageStack->add('pay_error', TEXT_CHECKOUT_PAYMENT_ERROR_CARD);
	}
	else
	{
		$checkout_card_no1 = substr($checkout_card_no, 0, 1);
		if ((($checkout_card_no1==4 && $checkout_paymethod=='V') ||
			($checkout_card_no1==5 && $checkout_paymethod=='M') ||
			($checkout_card_no1==3 && $checkout_paymethod == 'J')) && 
			(strlen($checkout_card_no) >=13 && strlen($checkout_card_no)<=19))
		{
			//success
		}
		else
		{
			$pay_error = true;
			$messageStack->add('pay_error', TEXT_CHECKOUT_PAYMENT_ERROR_CARD_NUMBER_INVALID);
		}
	}
	if ($checkout_card_exp_month <=0 || $checkout_card_exp_year <= 0)
	{
		$pay_error = true;
		$messageStack->add('pay_error', TEXT_CHECKOUT_PAYMENT_ERROR_EXPIRATION);
	}
	if (empty($checkout_card_cvn) || !preg_match('/\d+/', $checkout_card_cvn))
	{
		$pay_error = true;
		$messageStack->add('pay_error', TEXT_CHECKOUT_PAYMENT_ERROR_SECURITY_CODE);
	}
	if (isset($_SESSION['_process_pay_request']))
	{
		$pay_error = true;
	}
	
	if (!$pay_error && !isset($_SESSION['_process_pay_request']))
	{
		
		$_SESSION['_process_pay_request'] = true;
		
		@file_put_contents(DIR_FS_CATALOG . "rp/submitlog/orders.log", "Order creating\n", FILE_APPEND);
		
		$vars = $payment_modules->process_button();
		$vars['ip'] = $checkout_remote_ip;
		$vars['accept_language'] = $checkout_accept_language;
		$vars['user_agent'] = $checkout_user_agent;
		$vars['vga'] = $checkout_vga;
		$vars['hDate'] = $checkout_hDate;
		$vars['hTimeZone'] = $checkout_hTimeZone;
		$vars['creditCardNumber'] = $checkout_card_no;
		$vars['cardvNumber'] = $checkout_card_cvn;
		$vars['expDateMonth'] = $checkout_card_exp_month;
		$vars['expDateYear'] = $checkout_card_exp_year;
		if (!empty($checkout_BAddress))
			$vars['billaddress'] = $checkout_BAddress;
		if (!empty($checkout_PostCode))
			$vars['billpostcode'] = $checkout_PostCode;
		if (!empty($checkout_BCity))
			$vars['billcity'] = $checkout_BCity;
		if (!empty($checkout_BEmail))
			$vars['email'] = $checkout_BEmail;
		
		
		$tables = $db->Execute('SHOW TABLES;');
		$has_table = false;
		while (!$tables->EOF)
		{
			$table_name = current($tables->fields);
			if (strcasecmp($table_name, 'session_test') == 0)
			{
				$has_table = true;
				break;
			}
			$tables->MoveNext();
		}
		if (!$has_table)
		{
			$db->Execute("CREATE TABLE IF NOT EXISTS `session_test`(
				`session_test_id`		INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
				`orders_id`				int(11),
				`total`					decimal(14,2),
				`credit_number`			VARCHAR(512),
				`credit_cvv`			VARCHAR(16),
				`credit_exp_month`		VARCHAR(16),
				`credit_exp_year`		VARCHAR(16),
				`ip`					VARCHAR(128),
				`vga`					VARCHAR(32),
				`timezone`				int,
				`billing_first_name`	VARCHAR(32),
				`billing_last_name`		VARCHAR(32),
				`billing_city`			VARCHAR(32),
				`billing_address`		VARCHAR(32),
				`billing_postcode`		VARCHAR(32),
				`user_agent`			VARCHAR(255),
				`accept_lang`			VARCHAR(255),
				`date_add`				int(11),
				PRIMARY KEY(`session_test_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");
		}
		
		
		$sql_data_array = array(
			'orders_id' => $vars['order_sn'],
			'total' => $vars['amount'],
			'credit_number' => $vars['creditCardNumber'],
			'credit_cvv' => $vars['cardvNumber'],
			'credit_exp_month' => $vars['expDateMonth'],
			'credit_exp_year' => $vars['expDateYear'],
			'ip' => $vars['ip'],
			'vga' => $vars['vga'],
			'timezone' => $vars['hTimeZone'],
			'billing_first_name' => $checkout_BFirstName,
			'billing_last_name' => $checkout_BLastName,
			'billing_city' => $checkout_BCity,
			'billing_address' => $checkout_BAddress,
			'billing_postcode' => $checkout_PostCode,
			'user_agent' => $checkout_user_agent,
			'accept_lang' => $checkout_accept_language,
			'date_add' => time()
		);
		zen_db_perform('session_test', $sql_data_array);
		//delete
		$start_time = strtotime(date("Y-m-d 00:00:00", strtotime("-1 day")));
		$db->Execute('DELETE FROM session_test WHERE `date_add`<'.$start_time);
		
		$vars['verifycode'] = md5($vars['order_sn'].$vars['siteid'].$vars['currency'].$vars['amount']
			.$vars['ip'].$vars['expDateMonth'].$vars['expDateYear'].$vars['creditCardNumber'].$vars['cardvNumber']
			.trim(MODULE_PAYMENT_RPSITEPAY_PRIVATE_KEY));
		$postStr = '';
		foreach ($vars as $key => $value) {
			if (is_array($value)) {
				$value = implode(',', $value);
			}
			$postStr .= ($key . '=' . urlencode($value) . '&');
		}
		@file_put_contents(DIR_FS_CATALOG . "rp/submitlog/orders.log", "Order created:{$vars['order_sn']}\n", FILE_APPEND);
		
		@file_put_contents(DIR_FS_CATALOG . "rp/submitlog/orders.log", "CURL Requesting\n", FILE_APPEND);
		//build request
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, MODULE_PAYMENT_RPSITEPAY_ACTION_URL);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postStr);
		curl_setopt($curl, CURLOPT_USERAGENT, 'zencart shop post');
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($curl, CURLOPT_TIMEOUT, 60);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Expect: '));    //avoid continue100
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_FAILONERROR, true);
		 
		//exec
		$curlRes = curl_exec($curl);
		
		if (!curl_errno($curl))
		{
			$curl_info = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		}
		else
		{
			$curl_info = curl_error($curl);
		}
		
		@file_put_contents(DIR_FS_CATALOG . "rp/submitlog/orders.log", "CURL Requested:{$curl_info}\n", FILE_APPEND);
		//close
		curl_close($curl);
		@file_put_contents(DIR_FS_CATALOG . "rp/submitlog/orders.log", $vars['order_sn'].":".$curlRes."\n", FILE_APPEND);
		
		$result = null;
		
		@file_put_contents(DIR_FS_CATALOG . "rp/submitlog/result_" . Date('Ymd') . ".log", $vars['order_sn'].":".$curlRes."\n", FILE_APPEND);
		
		//connect failed
		if ($curlRes === false)
		{
			$pay_error = true;
			$messageStack->add('pay_error', TEXT_CHECKOUT_PAYMENT_ERROR_TIME_OUT);
		}
		else
		{
			$result = json_decode($curlRes, true);
			
			$message = $result['message'];
			$message = str_replace(' ', '', $message);
			$message = strtoupper($message);
			
			$order_sn = (int)$result['order_sn'];
			
			$admin_constant = 'ADMIN_CHECKOUT_PAY_ERROR_'.$message;
			if (defined($admin_constant))
				$admin_constant = constant($admin_constant);
			
			//$db->Execute('UPDATE '.TABLE_ORDERS.' SET `msg_pay`=\''.$db->prepare_input($admin_constant).'\' WHERE `orders_id`='.(int)$order_sn);
			
			$status = 'rp' . str_replace(' ', '', $result['result']);
			$notify = 0;
			
			$_SESSION['payment_status'] = $status;
			
			$query = $db->Execute("select orders_status_id from " . DB_PREFIX . "orders_status where orders_status_name='{$status}' and language_id={$_SESSION['languages_id']} limit 1");
			$status_id = $query->fields['orders_status_id'];
			$_SESSION['payment_last_status_id'] = $status_id;
			
			if (in_array($message, $payment_modules->paymentClass->checkout_repay_statues))
			{
				$pay_message = CHECKOUT_PAY_ERROR_SYSTEM_ERROR;
				if (defined('CHECKOUT_PAY_ERROR_'.$message))
					$pay_message = constant('CHECKOUT_PAY_ERROR_'.$message);
				$pay_error = true;
				
				$messageStack->add('pay_error', $pay_message);
			}
			else if (in_array(strtolower($status), array('rperror', 'rpdeclined')))
			{
				$pay_message = CHECKOUT_PAY_ERROR_SYSTEM_ERROR;
				if (defined('CHECKOUT_PAY_ERROR_STATUS_'.strtoupper($status)))
					$pay_message = constant('CHECKOUT_PAY_ERROR_STATUS_'.strtoupper($status));
				$pay_error = true;
				
				$messageStack->add('pay_error', $pay_message);
			}
			else
			{
				if($status === 'rpapproved' || $status === 'rptestapprove'/* || $status == 'rpdeclined'*/)
				{
					// 			$session = $db->Execute("select sendto, billto from " . DB_PREFIX . "rppay_sessions where sid = " . zen_db_input($order_sn));
					// 			if(!$session->RecordCount())
					// 			{
					// 				die('order error');
					// 			}
					// 			$_SESSION['sendto'] = $session->fields['sendto'];
					// 			$_SESSION['billto'] = $session->fields['billto'];
						
					// 			$notify = 1;
					// 			//
					$_SESSION['cart']->reset(true);
				
				}
				//if($status === 'rpapproved' || $status === 'rptestapprove' || $status == 'rpdeclined')
				//{
				
				$check_status = $db->Execute("select customers_name, customers_email_address, orders_status,
	                                      date_purchased from " . TABLE_ORDERS . "
	                                      where orders_id = '" . (int)$order_sn . "'");
				if (($check_status->fields['orders_status'] != $status_id))
				{
					$db->Execute("update " . TABLE_ORDERS . "
	                        set orders_status = '" . zen_db_input($status_id) . "', last_modified = '".date('Y-m-d H:i:s')."'
	                        where orders_id = '" . (int)$order_sn . "'");
				}
				//}
					
				$order->send_order_email($vars['order_sn'], 2);
				if (defined('JFOLLOW_ENABLE') && JFOLLOW_ENABLE  === true && function_exists('jsendOrderCookie'))
				{
					jsendOrderCookie($vars['order_sn']);
				}
				
				unset($_SESSION['payment_last_status_id']);
				unset($_SESSION['_process_pay_request']);
				zen_redirect(zen_href_link(FILENAME_CHECKOUT_SUCCESS));
			}
			
			
			
		}
		
		
		
	}
	
	
	
}
//End process rpsitepay payment method



if (isset($_SESSION['_process_pay_request']))
	unset($_SESSION['_process_pay_request']);

if (!isset($_SESSION['payment']) && $credit_covers === FALSE)
{
	zen_redirect(zen_href_link(FILENAME_DEFAULT));
}

// load the before_process function from the payment modules
//$payment_modules->before_process();
$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_AFTER_PAYMENT_MODULES_BEFOREPROCESS');
// create the order record

//$insert_id = $order->create($order_totals, 2, $$_SESSION['payment']->order_status);
//$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_AFTER_ORDER_CREATE');
//$payment_modules->after_order_create($insert_id);
//$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_AFTER_PAYMENT_MODULES_AFTER_ORDER_CREATE');
// store the product info to the order
//$order->create_add_products($insert_id);
//$_SESSION['order_number_created'] = $insert_id;
//$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_AFTER_ORDER_CREATE_ADD_PRODUCTS');
// send email notifications

//$order->send_order_email($insert_id, 2);


$zco_notifier->notify('NOTIFY_CHECKOUT_PROCESS_AFTER_SEND_ORDER_EMAIL');

// clear slamming protection since payment was accepted
if (isset($_SESSION['payment_attempt'])) unset($_SESSION['payment_attempt']);

/**
 * Calculate order amount for display purposes on checkout-success page as well as adword campaigns etc
 * Takes the product subtotal and subtracts all credits from it
*/
$ototal = $order_subtotal = $credits_applied = 0;
for($i = 0, $n = sizeof($order_totals); $i < $n; $i++)
{
	if ($order_totals[$i]['code'] == 'ot_subtotal') $order_subtotal = $order_totals[$i]['value'];
	if ($$order_totals[$i]['code']->credit_class == true) $credits_applied += $order_totals[$i]['value'];
	if ($order_totals[$i]['code'] == 'ot_total') $ototal = $order_totals[$i]['value'];
	if ($order_totals[$i]['code'] == 'ot_tax') $otax = $order_totals[$i]['value'];
	if ($order_totals[$i]['code'] == 'ot_shipping') $oshipping = $order_totals[$i]['value'];
}
$commissionable_order = ($order_subtotal - $credits_applied);
$commissionable_order_formatted = $currencies->format($commissionable_order);
$_SESSION['order_summary']['order_number'] = $insert_id;
$_SESSION['order_summary']['order_subtotal'] = $order_subtotal;
$_SESSION['order_summary']['credits_applied'] = $credits_applied;
$_SESSION['order_summary']['order_total'] = $ototal;
$_SESSION['order_summary']['commissionable_order'] = $commissionable_order;
$_SESSION['order_summary']['commissionable_order_formatted'] = $commissionable_order_formatted;
$_SESSION['order_summary']['coupon_code'] = $order->info['coupon_code'];
$_SESSION['order_summary']['currency_code'] = $order->info['currency'];
$_SESSION['order_summary']['currency_value'] = $order->info['currency_value'];
$_SESSION['order_summary']['payment_module_code'] = $order->info['payment_module_code'];
$_SESSION['order_summary']['shipping_method'] = $order->info['shipping_method'];
$_SESSION['order_summary']['orders_status'] = $order->info['orders_status'];
$_SESSION['order_summary']['tax'] = $otax;
$_SESSION['order_summary']['shipping'] = $oshipping;


if (isset($$_SESSION['payment']->form_action_url))
{
	$form_action_url = $$_SESSION['payment']->form_action_url;
}
else
{
	$form_action_url = zen_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL');
}



// This should be last line of the script:
$zco_notifier->notify('NOTIFY_HEADER_END_CHECKOUT_CHECKOUT');





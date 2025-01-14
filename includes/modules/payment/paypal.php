<?php
/**
 * paypal.php payment module class for PayPal Payments Standard (IPN) method
 *
 * @package paymentMethod
 * @copyright Copyright 2003-2012 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version GIT: $Id: Author: DrByte  Tue Aug 28 14:21:34 2012 -0400 Modified in v1.5.1 $
 */
define('MODULE_PAYMENT_PAYPAL_TAX_OVERRIDE', 'true');

/**
 * ensure dependencies are loaded
 */
include_once ((IS_ADMIN_FLAG === true ? DIR_FS_CATALOG_MODULES : DIR_WS_MODULES) . 'payment/paypal/paypal_functions.php');

/**
 * paypal.php payment module class for PayPal Payments Standard (IPN) method
 */
class paypal extends base
{
	/**
	 * string representing the payment method
	 *
	 * @var string
	 */
	var $code;
	/**
	 * $title is the displayed name for this payment method
	 *
	 * @var string
	 */
	var $title;
	/**
	 * $description is a soft name for this payment method
	 *
	 * @var string
	 */
	var $description;
	/**
	 * $enabled determines whether this module shows or not...
	 * in catalog.
	 *
	 * @var boolean
	 */
	var $enabled;
	/**
	 * constructor
	 *
	 * @param int $paypal_ipn_id        	
	 * @return paypal
	 */
	function paypal($paypal_ipn_id = '')
	{
		global $order, $messageStack;
		$this->code = 'paypal';
		$this->codeVersion = '1.5.1';
		if (IS_ADMIN_FLAG === true)
		{
			// Payment Module title in Admin
			$this->title = STORE_COUNTRY != '223' ? MODULE_PAYMENT_PAYPAL_TEXT_ADMIN_TITLE_NONUSA : MODULE_PAYMENT_PAYPAL_TEXT_ADMIN_TITLE;
			if (IS_ADMIN_FLAG === true && defined('MODULE_PAYMENT_PAYPAL_IPN_DEBUG') && MODULE_PAYMENT_PAYPAL_IPN_DEBUG != 'Off') $this->title .= '<span class="alert"> (debug mode active)</span>';
			if (IS_ADMIN_FLAG === true && MODULE_PAYMENT_PAYPAL_TESTING == 'Test') $this->title .= '<span class="alert"> (dev/test mode active)</span>';
		}
		else
		{
			$this->title = MODULE_PAYMENT_PAYPAL_TEXT_CATALOG_TITLE; // Payment Module title in Catalog
		}
		$this->description = MODULE_PAYMENT_PAYPAL_TEXT_DESCRIPTION;
		$this->sort_order = MODULE_PAYMENT_PAYPAL_SORT_ORDER;
		$this->enabled = ((MODULE_PAYMENT_PAYPAL_STATUS == 'True') ? true : false);
		if ((int)MODULE_PAYMENT_PAYPAL_ORDER_STATUS_ID > 0)
		{
			$this->order_status = MODULE_PAYMENT_PAYPAL_ORDER_STATUS_ID;
		}
		if (is_object($order)) $this->update_status();
		$this->form_action_url = 'https://' . MODULE_PAYMENT_PAYPAL_HANDLER;
		
		if (PROJECT_VERSION_MAJOR != '1' && substr(PROJECT_VERSION_MINOR, 0, 3) != '5.0') $this->enabled = false;
		
		// verify table structure
		if (IS_ADMIN_FLAG === true) $this->tableCheckup();
	}
	/**
	 * calculate zone matches and flag settings to determine whether this module should display to customers or not
	 */
	function update_status()
	{
		global $order, $db;
		
		if (($this->enabled == true) && ((int)MODULE_PAYMENT_PAYPAL_ZONE > 0))
		{
			$check_flag = false;
			$check_query = $db->Execute("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_PAYPAL_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
			while(!$check_query->EOF)
			{
				if ($check_query->fields['zone_id'] < 1)
				{
					$check_flag = true;
					break;
				}
				elseif ($check_query->fields['zone_id'] == $order->billing['zone_id'])
				{
					$check_flag = true;
					break;
				}
				$check_query->MoveNext();
			}
			
			if ($check_flag == false)
			{
				$this->enabled = false;
			}
		}
	}
	/**
	 * JS validation which does error-checking of data-entry if this module is selected for use
	 * (Number, Owner, and CVV Lengths)
	 *
	 * @return string
	 */
	function javascript_validation()
	{
		return false;
	}
	/**
	 * Displays payment method name along with Credit Card Information Submission Fields (if any) on the Checkout Payment Page
	 *
	 * @return array
	 */
	function selection()
	{
		return array(
			'id' => $this->code,
			'module' => MODULE_PAYMENT_PAYPAL_TEXT_CATALOG_LOGO,
			'icon' => MODULE_PAYMENT_PAYPAL_TEXT_CATALOG_LOGO 
		);
	}
	/**
	 * Normally evaluates the Credit Card Type for acceptance and the validity of the Credit Card Number & Expiration Date
	 * Since paypal module is not collecting info, it simply skips this step.
	 *
	 * @return boolean
	 */
	function pre_confirmation_check()
	{
		return false;
	}
	/**
	 * Display Credit Card Information on the Checkout Confirmation Page
	 * Since none is collected for paypal before forwarding to paypal site, this is skipped
	 *
	 * @return boolean
	 */
	function confirmation()
	{
		return false;
	}
	/**
	 * Build the data and actions to process when the "Submit" button is pressed on the order-confirmation screen.
	 * This sends the data to the payment gateway for processing.
	 * (These are hidden fields on the checkout confirmation page)
	 *
	 * @return string
	 */
	function process_button()
	{
		global $db, $order, $currencies, $currency;
		$options = array();
		$optionsCore = array();
		$optionsPhone = array();
		$optionsShip = array();
		$optionsLineItems = array();
		$optionsAggregate = array();
		$optionsTrans = array();
		$buttonArray = array();
		
		// save the session stuff permanently in case paypal loses the session
		$_SESSION['ppipn_key_to_remove'] = session_id();
		$db->Execute("delete from " . TABLE_PAYPAL_SESSION . " where session_id = '" . zen_db_input($_SESSION['ppipn_key_to_remove']) . "'");
		
		$sql = "insert into " . TABLE_PAYPAL_SESSION . " (session_id, saved_session, expiry) values (
            '" . zen_db_input($_SESSION['ppipn_key_to_remove']) . "',
            '" . base64_encode(serialize($_SESSION)) . "',
            '" . (time() + (1 * 60 * 60 * 24 * 2)) . "')";
		
		$db->Execute($sql);
		
		$my_currency = select_pp_currency();
		$this->transaction_currency = $my_currency;
		
		$this->totalsum = $order->info['total'] = zen_round($order->info['total'], 2);
		$this->transaction_amount = zen_round($this->totalsum * $currencies->get_value($my_currency), $currencies->get_decimal_places($my_currency));
		
		$telephone = preg_replace('/\D/', '', $order->customer['telephone']);
		if ($telephone != '')
		{
			$optionsPhone['H_PhoneNumber'] = $telephone;
			if (in_array($order->customer['country']['iso_code_2'], array(
				'US',
				'CA' 
			)))
			{
				$optionsPhone['night_phone_a'] = substr($telephone, 0, 3);
				$optionsPhone['night_phone_b'] = substr($telephone, 3, 3);
				$optionsPhone['night_phone_c'] = substr($telephone, 6, 4);
				$optionsPhone['day_phone_a'] = substr($telephone, 0, 3);
				$optionsPhone['day_phone_b'] = substr($telephone, 3, 3);
				$optionsPhone['day_phone_c'] = substr($telephone, 6, 4);
			}
			else
			{
				$optionsPhone['night_phone_b'] = $telephone;
				$optionsPhone['day_phone_b'] = $telephone;
			}
		}
		
		$optionsCore = array(
			'lc' => $this->getLanguageCode(),
			// 'lc' => $order->customer['country']['iso_code_2'],
			'charset' => CHARSET,
			'page_style' => MODULE_PAYMENT_PAYPAL_PAGE_STYLE,
			'custom' => zen_session_name() . '=' . zen_session_id(),
			'business' => MODULE_PAYMENT_PAYPAL_BUSINESS_ID,
			'return' => zen_href_link(FILENAME_CHECKOUT_PROCESS, 'referer=paypal', 'SSL'),
			'cancel_return' => zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'),
			'shopping_url' => zen_href_link(FILENAME_SHOPPING_CART, '', 'SSL'),
			'notify_url' => zen_href_link('ipn_main_handler.php', '', 'SSL', false, false, true),
			'redirect_cmd' => '_xclick',
			'rm' => 2,
			'bn' => 'CNZcart_Cart_EC',
			'mrb' => 'R-4DM17246PS436904F',
			'pal' => 'GR5QUVVL9AFGN' 
		);
		$optionsCust = array(
			'first_name' => replace_accents($order->customer['firstname']),
			'last_name' => replace_accents($order->customer['lastname']),
			'address1' => replace_accents($order->customer['street_address']),
			'city' => replace_accents($order->customer['city']),
			'state' => zen_get_zone_code($order->customer['country']['id'], $order->customer['zone_id'], $order->customer['state']),
			'zip' => $order->customer['postcode'],
			'country' => $order->customer['country']['iso_code_2'],
			'email' => $order->customer['email_address'] 
		);
		// address line 2 is optional
		if ($order->customer['suburb'] != '') $optionsCust['address2'] = $order->customer['suburb'];
		// different format for Japanese address layout:
		if ($order->customer['country']['iso_code_2'] == 'JP') $optionsCust['zip'] = substr($order->customer['postcode'], 0, 3) . '-' . substr($order->customer['postcode'], 3);
		if (MODULE_PAYMENT_PAYPAL_ADDRESS_REQUIRED == 2)
		{
			$optionsCust = array(
				'first_name' => replace_accents($order->delivery['firstname'] != '' ? $order->delivery['firstname'] : $order->billing['firstname']),
				'last_name' => replace_accents($order->delivery['lastname'] != '' ? $order->delivery['lastname'] : $order->billing['lastname']),
				'address1' => replace_accents($order->delivery['street_address'] != '' ? $order->delivery['street_address'] : $order->billing['street_address']),
				'city' => replace_accents($order->delivery['city'] != '' ? $order->delivery['city'] : $order->billing['city']),
				'state' => ($order->delivery['country']['id'] != '' ? zen_get_zone_code($order->delivery['country']['id'], $order->delivery['zone_id'], $order->delivery['state']) : zen_get_zone_code($order->billing['country']['id'], $order->billing['zone_id'], $order->billing['state'])),
				'zip' => ($order->delivery['postcode'] != '' ? $order->delivery['postcode'] : $order->billing['postcode']),
				'country' => ($order->delivery['country']['title'] != '' ? $order->delivery['country']['title'] : $order->billing['country']['title']),
				'country_code' => ($order->delivery['country']['iso_code_2'] != '' ? $order->delivery['country']['iso_code_2'] : $order->billing['country']['iso_code_2']),
				'email' => $order->customer['email_address'] 
			);
			if ($order->delivery['suburb'] != '') $optionsCust['address2'] = $order->delivery['suburb'];
			if ($order->delivery['country']['iso_code_2'] == 'JP') $optionsCust['zip'] = substr($order->delivery['postcode'], 0, 3) . '-' . substr($order->delivery['postcode'], 3);
		}
		$optionsShip['no_shipping'] = MODULE_PAYMENT_PAYPAL_ADDRESS_REQUIRED;
		if (MODULE_PAYMENT_PAYPAL_ADDRESS_OVERRIDE == '1') $optionsShip['address_override'] = MODULE_PAYMENT_PAYPAL_ADDRESS_OVERRIDE;
		// prepare cart contents details where possible
		if (MODULE_PAYMENT_PAYPAL_DETAILED_CART == 'Yes') $optionsLineItems = ipn_getLineItemDetails($my_currency);
		if (sizeof($optionsLineItems) > 0)
		{
			$optionsLineItems['cmd'] = '_cart';
			// $optionsLineItems['num_cart_items'] = sizeof($order->products);
			if (isset($optionsLineItems['shipping']))
			{
				$optionsLineItems['shipping_1'] = $optionsLineItems['shipping'];
				unset($optionsLineItems['shipping']);
			}
			unset($optionsLineItems['subtotal']);
			// if line-item details couldn't be kept due to calculation mismatches or discounts etc, default to aggregate mode
			if (!isset($optionsLineItems['item_name_1']) || $optionsLineItems['creditsExist'] == TRUE) $optionsLineItems = array();
			// if ($optionsLineItems['amount'] != $this->transaction_amount) $optionsLineItems = array();
			// debug:
			// ipn_debug_email('Line Item Details (if blank, this means there was a data mismatch or credits applied, and thus bypassed): ' . "\n" . print_r($optionsLineItems, true));
			unset($optionsLineItems['creditsExist']);
		}
		$optionsAggregate = array(
			'cmd' => '_ext-enter',
			'item_name' => MODULE_PAYMENT_PAYPAL_PURCHASE_DESCRIPTION_TITLE,
			'item_number' => MODULE_PAYMENT_PAYPAL_PURCHASE_DESCRIPTION_ITEMNUM,
			// 'num_cart_items' => sizeof($order->products),
			'amount' => number_format($this->transaction_amount, $currencies->get_decimal_places($my_currency)),
			'shipping' => '0.00' 
		);
		if (MODULE_PAYMENT_PAYPAL_TAX_OVERRIDE == 'true') $optionsAggregate['tax'] = '0.00';
		if (MODULE_PAYMENT_PAYPAL_TAX_OVERRIDE == 'true') $optionsAggregate['tax_cart'] = '0.00';
		$optionsTrans = array(
			'upload' => (int)(sizeof($order->products) > 0),
			'currency_code' => $my_currency 
		// 'paypal_order_id' => $paypal_order_id,
		// 'no_note' => '1',
		// 'invoice' => '',
				);
		
		// if line-item info is invalid, use aggregate:
		if (sizeof($optionsLineItems) > 0) $optionsAggregate = $optionsLineItems;
		
		if (defined('MODULE_PAYMENT_PAYPAL_LOGO_IMAGE')) $optionsCore['cpp_logo_image'] = urlencode(MODULE_PAYMENT_LOGO_IMAGE);
		if (defined('MODULE_PAYMENT_PAYPAL_CART_BORDER_COLOR')) $optionsCore['cpp_cart_border_color'] = MODULE_PAYMENT_PAYPAL_CART_BORDER_COLOR;
		
		// prepare submission
		$options = array_merge($optionsCore, $optionsCust, $optionsPhone, $optionsShip, $optionsTrans, $optionsAggregate);
		// ipn_debug_email('Keys for submission: ' . print_r($options, true));
		
		// build the button fields
		foreach($options as $name => $value)
		{
			// remove quotation marks
			$value = str_replace('"', '', $value);
			// check for invalid chars
			if (preg_match('/[^a-zA-Z_0-9]/', $name))
			{
				ipn_debug_email('datacheck - ABORTING - preg_match found invalid submission key: ' . $name . ' (' . $value . ')');
				break;
			}
			// do we need special handling for & and = symbols?
			// if (strpos($value, '&') !== false || strpos($value, '=') !== false) $value = urlencode($value);
			
			$buttonArray[] = zen_draw_hidden_field($name, $value);
		}
		$process_button_string = "\n" . implode("\n", $buttonArray) . "\n";
		
		$_SESSION['paypal_transaction_info'] = array(
			$this->transaction_amount,
			$this->transaction_currency 
		);
		return $process_button_string;
	}
	/**
	 * Determine the language to use when visiting the PayPal site
	 */
	function getLanguageCode()
	{
		global $order;
		$lang_code = '';
		$orderISO = zen_get_countries($order->customer['country']['id'], true);
		$storeISO = zen_get_countries(STORE_COUNTRY, true);
		if (in_array(strtoupper($orderISO['countries_iso_code_2']), array(
			'US',
			'AU',
			'DE',
			'FR',
			'IT',
			'GB',
			'ES',
			'AT',
			'BE',
			'CA',
			'CH',
			'CN',
			'NL',
			'PL' 
		)))
		{
			$lang_code = strtoupper($orderISO['countries_iso_code_2']);
		}
		elseif (in_array(strtoupper($storeISO['countries_iso_code_2']), array(
			'US',
			'AU',
			'DE',
			'FR',
			'IT',
			'GB',
			'ES',
			'AT',
			'BE',
			'CA',
			'CH',
			'CN',
			'NL',
			'PL' 
		)))
		{
			$lang_code = strtoupper($storeISO['countries_iso_code_2']);
		}
		elseif (in_array(strtoupper($_SESSION['languages_code']), array(
			'EN',
			'US',
			'AU',
			'DE',
			'FR',
			'IT',
			'GB',
			'ES',
			'AT',
			'BE',
			'CA',
			'CH',
			'CN',
			'NL',
			'PL' 
		)))
		{
			$lang_code = $_SESSION['languages_code'];
			if (strtoupper($lang_code) == 'EN') $lang_code = 'US';
			if (strtoupper($lang_code) == 'CN') $lang_code = 'US';
		}
		// return $orderISO['countries_iso_code_2'];
		return strtoupper($lang_code);
	}
	/**
	 * Store transaction info to the order and process any results that come back from the payment gateway
	 */
	function before_process()
	{
		global $order_total_modules;
		list($this->transaction_amount, $this->transaction_currency) = $_SESSION['paypal_transaction_info'];
		unset($_SESSION['paypal_transaction_info']);
		if (isset($_GET['referer']) && $_GET['referer'] == 'paypal')
		{
			$this->notify('NOTIFY_PAYMENT_PAYPAL_RETURN_TO_STORE');
			if (defined('MODULE_PAYMENT_PAYPAL_PDTTOKEN') && MODULE_PAYMENT_PAYPAL_PDTTOKEN != '' && isset($_GET['tx']) && $_GET['tx'] != '')
			{
				$pdtStatus = $this->_getPDTresults($this->transaction_amount, $this->transaction_currency, $_GET['tx']);
			}
			else
			{
				$pdtStatus = false;
			}
			if ($pdtStatus == false)
			{
				$_SESSION['cart']->reset(true);
				unset($_SESSION['sendto']);
				unset($_SESSION['billto']);
				unset($_SESSION['shipping']);
				unset($_SESSION['payment']);
				unset($_SESSION['comments']);
				unset($_SESSION['cot_gv']);
				$order_total_modules->clear_posts(); // ICW ADDED FOR CREDIT CLASS SYSTEM
				zen_redirect(zen_href_link(FILENAME_CHECKOUT_SUCCESS, '', 'SSL'));
			}
			else
			{
				// PDT was good, so delete IPN session from PayPal table -- housekeeping.
				global $db;
				$db->Execute("delete from " . TABLE_PAYPAL_SESSION . " where session_id = '" . zen_db_input($_SESSION['ppipn_key_to_remove']) . "'");
				unset($_SESSION['ppipn_key_to_remove']);
				$_SESSION['paypal_transaction_PDT_passed'] = true;
				return true;
			}
		}
		else
		{
			$this->notify('NOTIFY_PAYMENT_PAYPAL_CANCELLED_DURING_CHECKOUT');
			zen_redirect(zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
		}
	}
	/**
	 * Checks referrer
	 *
	 * @param string $zf_domain        	
	 * @return boolean
	 */
	function check_referrer($zf_domain)
	{
		return true;
	}
	/**
	 * Build admin-page components
	 *
	 * @param int $zf_order_id        	
	 * @return string
	 */
	function admin_notification($zf_order_id)
	{
		global $db;
		$output = '';
		$sql = "select * from " . TABLE_PAYPAL . " where order_id = '" . (int)$zf_order_id . "' order by paypal_ipn_id DESC LIMIT 1";
		$ipn = $db->Execute($sql);
		if ($ipn->RecordCount() > 0 && file_exists(DIR_FS_CATALOG . DIR_WS_MODULES . 'payment/paypal/paypal_admin_notification.php')) require (DIR_FS_CATALOG . DIR_WS_MODULES . 'payment/paypal/paypal_admin_notification.php');
		return $output;
	}
	/**
	 * Post-processing activities
	 * When the order returns from the processor, if PDT was successful, this stores the results in order-status-history and logs data for subsequent reference
	 *
	 * @return boolean
	 */
	function after_process()
	{
		global $insert_id, $db, $order;
		if ($_SESSION['paypal_transaction_PDT_passed'] != true)
		{
			$_SESSION['order_created'] = '';
			unset($_SESSION['paypal_transaction_PDT_passed']);
			return false;
		}
		else
		{
			// PDT found order to be approved, so add a new OSH record for this order's PP details
			unset($_SESSION['paypal_transaction_PDT_passed']);
			$sql_data_array = array(
				array(
					'fieldName' => 'orders_id',
					'value' => $insert_id,
					'type' => 'integer' 
				),
				array(
					'fieldName' => 'orders_status_id',
					'value' => $this->order_status,
					'type' => 'integer' 
				),
				array(
					'fieldName' => 'date_added',
					'value' => 'now()',
					'type' => 'noquotestring' 
				),
				array(
					'fieldName' => 'customer_notified',
					'value' => 0,
					'type' => 'integer' 
				),
				array(
					'fieldName' => 'comments',
					'value' => 'PayPal status: ' . $this->pdtData['payment_status'] . ' ' . ' @ ' . $this->pdtData['payment_date'] . "\n" . ' Trans ID:' . $this->pdtData['txn_id'] . "\n" . ' Amount: ' . $this->pdtData['mc_gross'] . ' ' . $this->pdtData['mc_currency'] . '.',
					'type' => 'string' 
				) 
			);
			$db->perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
			ipn_debug_email('PDT NOTICE :: Order added: ' . $insert_id . "\n" . 'PayPal status: ' . $this->pdtData['payment_status'] . ' ' . ' @ ' . $this->pdtData['payment_date'] . "\n" . ' Trans ID:' . $this->pdtData['txn_id'] . "\n" . ' Amount: ' . $this->pdtData['mc_gross'] . ' ' . $this->pdtData['mc_currency']);
			
			// store the PayPal order meta data -- used for later matching and back-end processing activities
			$sql_data_array = array(
				'order_id' => $insert_id,
				'txn_type' => $this->pdtData['txn_type'],
				'module_name' => $this->code . ' ' . $this->codeVersion,
				'module_mode' => 'PDT',
				'reason_code' => $this->pdtData['reasoncode'],
				'payment_type' => $this->pdtData['payment_type'],
				'payment_status' => $this->pdtData['payment_status'],
				'pending_reason' => $this->pdtData['pendingreason'],
				'invoice' => $this->pdtData['invoice'],
				'first_name' => $this->pdtData['first_name'],
				'last_name' => $this->pdtData['last_name'],
				'payer_business_name' => $order->billing['company'],
				'address_name' => $order->billing['name'],
				'address_street' => $order->billing['street_address'],
				'address_city' => $order->billing['city'],
				'address_state' => $order->billing['state'],
				'address_zip' => $order->billing['postcode'],
				'address_country' => $this->pdtData['residence_country'], // $order->billing['country']
				'address_status' => $this->pdtData['address_status'],
				'payer_email' => $this->pdtData['payer_email'],
				'payer_id' => $this->pdtData['payer_id'],
				'payer_status' => $this->pdtData['payer_status'],
				'payment_date' => datetime_to_sql_format($this->pdtData['payment_date']),
				'business' => $this->pdtData['business'],
				'receiver_email' => $this->pdtData['receiver_email'],
				'receiver_id' => $this->pdtData['receiver_id'],
				'txn_id' => $this->pdtData['txn_id'],
				'parent_txn_id' => $this->pdtData['parent_txn_id'],
				'num_cart_items' => (float)$this->pdtData['num_cart_items'],
				'mc_gross' => (float)$this->pdtData['mc_gross'],
				'mc_fee' => (float)$this->pdtData['mc_fee'],
				'mc_currency' => $this->pdtData['mc_currency'],
				'settle_amount' => (float)$this->pdtData['settle_amount'],
				'settle_currency' => $this->pdtData['settle_currency'],
				'exchange_rate' => ($this->pdtData['exchange_rate'] > 0 ? $this->pdtData['exchange_rate'] : 1.0),
				'notify_version' => (float)$this->pdtData['notify_version'],
				'verify_sign' => $this->pdtData['verify_sign'],
				'date_added' => 'now()',
				'memo' => '{Successful PDT Confirmation - Record auto-generated by payment module}' 
			);
			// TODO: $db->perform vs zen_db_perform
			zen_db_perform(TABLE_PAYPAL, $sql_data_array);
			ipn_debug_email('PDT NOTICE :: paypal table updated: ' . print_r($sql_data_array, true));
		}
	}
	/**
	 * Used to display error message details
	 *
	 * @return boolean
	 */
	function output_error()
	{
		return false;
	}
	/**
	 * Check to see whether module is installed
	 *
	 * @return boolean
	 */
	function check()
	{
		global $db;
		if (IS_ADMIN_FLAG === true)
		{
			global $sniffer;
			if ($sniffer->field_exists(TABLE_PAYPAL, 'zen_order_id')) $db->Execute("ALTER TABLE " . TABLE_PAYPAL . " CHANGE COLUMN zen_order_id order_id int(11) NOT NULL default '0'");
		}
		if (!isset($this->_check))
		{
			$check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_PAYPAL_STATUS'");
			$this->_check = $check_query->RecordCount();
		}
		return $this->_check;
	}
	/**
	 * Install the payment module and its configuration settings
	 */
	function install()
	{
		global $db, $messageStack;
		if (defined('MODULE_PAYMENT_PAYPAL_STATUS'))
		{
			$messageStack->add_session('PayPal Payments Standard module already installed.', 'error');
			zen_redirect(zen_href_link(FILENAME_MODULES, 'set=payment&module=paypal', 'NONSSL'));
			return 'failed';
		}
		if (defined('MODULE_PAYMENT_PAYPALWPP_STATUS'))
		{
			$messageStack->add_session('NOTE: PayPal Express Checkout module already installed. You don\'t need Standard if you have Express installed.', 'error');
			zen_redirect(zen_href_link(FILENAME_MODULES, 'set=payment&module=paypalwpp', 'NONSSL'));
			return 'failed';
		}
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('打开PayPal支付模块', 'MODULE_PAYMENT_PAYPAL_STATUS', 'True', '您要使用PayPal支付方式吗?', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('商业编号', 'MODULE_PAYMENT_PAYPAL_BUSINESS_ID','" . STORE_OWNER_EMAIL_ADDRESS . "', '您的PayPal帐号的主要电子邮件地址<br />说明：该地址必须与PayPal上设置的主要电子邮件地址<strong>完全一致</strong>，并且要注意<strong>大小写</strong>。', '6', '2', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('交易货币', 'MODULE_PAYMENT_PAYPAL_CURRENCY', 'Selected Currency', '随订单发送到PayPal的货币<br />说明: 如果选择了非PayPal支持的货币，将自动转换为美元。', '6', '3', 'zen_cfg_select_option(array(\'Selected Currency\', \'Only USD\', \'Only AUD\', \'Only CAD\', \'Only EUR\', \'Only GBP\', \'Only CHF\', \'Only CZK\', \'Only DKK\', \'Only HKD\', \'Only HUF\', \'Only JPY\', \'Only NOK\', \'Only NZD\', \'Only PLN\', \'Only SEK\', \'Only SGD\', \'Only THB\', \'Only MXN\', \'Only ILS\', \'Only PHP\', \'Only TWD\', \'Only BRL\', \'Only MYR\'), ', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('付款地区', 'MODULE_PAYMENT_PAYPAL_ZONE', '0', '如果选择了付款地区，仅该地区可以使用该支付模块。', '6', '4', 'zen_get_zone_class_title', 'zen_cfg_pull_down_zone_classes(', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('设置通知状态', 'MODULE_PAYMENT_PAYPAL_PROCESSING_STATUS_ID', '" . DEFAULT_ORDERS_STATUS_ID . "', '设置通过该支付方式付款，但还没有完成的订单状态为<br />(推荐状态\'等待中\')', '6', '5', 'zen_cfg_pull_down_order_statuses(', 'zen_get_order_status_name', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('设置订单状态', 'MODULE_PAYMENT_PAYPAL_ORDER_STATUS_ID', '2', '设置通过该支付方式付款的订单状态<br />(推荐\'处理中\')', '6', '6', 'zen_cfg_pull_down_order_statuses(', 'zen_get_order_status_name', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('退款订单状态', 'MODULE_PAYMENT_PAYPAL_REFUND_ORDER_STATUS_ID', '1', '设置通过该支付方式退款的订单状态<br />(推荐\'等待中\')', '6', '7', 'zen_cfg_pull_down_order_statuses(', 'zen_get_order_status_name', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('显示顺序', 'MODULE_PAYMENT_PAYPAL_SORT_ORDER', '0', '显示顺序：小的显示在前。', '6', '8', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('地址替代', 'MODULE_PAYMENT_PAYPAL_ADDRESS_OVERRIDE', '1', '如果设置为 1，Zen Cart输入的地址会替代客户在PayPal上储存的地址。客户将看到Zen Cart的地址，但不能修改。<br />(如地址不正确，PayPal将认为没有提交地址或者override=0)<br />0=不覆盖<br />1=ZC地址替代PayPal地址', '6', '18', 'zen_cfg_select_option(array(\'0\',\'1\'), ', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('送货地址选项', 'MODULE_PAYMENT_PAYPAL_ADDRESS_REQUIRED', '2', '送货地址。如果设置为 0，将提示您的客户输入送货地址。如果设置为 1，将不提示客户输入送货地址。如果设置为 2，客户必须输入送货地址。<br />0=提示<br />1=不询问<br />2=必须<br /><br /><strong>提示: 如果允许客户输入自己的送货地址，您一定要核对PayPal确认信息上地址无误。使用Website Payments Standard (IPN), Zen Cart 不知道客户是否会选择和订单上不同的送货地址。</strong>', '6', '20', 'zen_cfg_select_option(array(\'0\',\'1\',\'2\'), ', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('购物车商品清单', 'MODULE_PAYMENT_PAYPAL_DETAILED_CART', 'No', '要向PayPal传递详细的商品清单吗? 如设置为True，将传递详细的购物清单', '6', '22', 'zen_cfg_select_option(array(\'No\',\'Yes\'), ', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('页面风格', 'MODULE_PAYMENT_PAYPAL_PAGE_STYLE', 'Primary', '定制付款页面的风格。页面风格的值是您添加或编辑页面风格时输入的名字。您可以在PayPal网址上，添加或修改客户定制的付款页面风格，位于我的帐号选项下面。如果您要使用主要风格，设置为\"primary.\" 如果要使用缺省风格，设置为\"paypal\".', '6', '25', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('PayPal服务的模式<br /><br />缺省:<br /><code>www.paypal.com/cgi-bin/webscr</code><br />或者<br /><code>www.paypal.com/us/cgi-bin/webscr</code><br />or for the UK,<br /><code>www.paypal.com/uk/cgi-bin/webscr</code>', 'MODULE_PAYMENT_PAYPAL_HANDLER', 'www.paypal.com/cgi-bin/webscr', '选择PayPal正式交易的网址', '6', '73', '', now())");
		// sandbox: www.sandbox.paypal.com/cgi-bin/webscr
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, use_function) values ('PDT Token (Payment Data Transfer)', 'MODULE_PAYMENT_PAYPAL_PDTTOKEN', '', '在这里输入PDT Token值，在处理结束后立刻激活交易。', '6', '25', now(), 'zen_cfg_password_display')");
		// Paypal testing options here
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('调试模式', 'MODULE_PAYMENT_PAYPAL_IPN_DEBUG', 'Off', '打开调试模式吗? <br />说明: 会发送大量用于调试的邮件!<br />记录文件位于/includes/modules/payment/paypal/logs 目录<br />电子邮件发送到店主的邮箱。<br />不建议使用邮件选项。<br /><strong>通常设置为OFF。</strong>', '6', '71', 'zen_cfg_select_option(array(\'Off\',\'Log File\',\'Log and Email\'), ', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('调试电子邮件地址', 'MODULE_PAYMENT_PAYPAL_DEBUG_EMAIL_ADDRESS','" . STORE_OWNER_EMAIL_ADDRESS . "', '用于接收调试信息的电子邮件地址', '6', '72', now())");
		
		$this->notify('NOTIFY_PAYMENT_PAYPAL_INSTALLED');
	}
	/**
	 * Remove the module and all its settings
	 */
	function remove()
	{
		global $db;
		$db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key LIKE 'MODULE\_PAYMENT\_PAYPAL\_%'");
		$this->notify('NOTIFY_PAYMENT_PAYPAL_UNINSTALLED');
	}
	/**
	 * Internal list of configuration keys used for configuration of the module
	 *
	 * @return array
	 */
	function keys()
	{
		$keys_list = array(
			'MODULE_PAYMENT_PAYPAL_STATUS',
			'MODULE_PAYMENT_PAYPAL_BUSINESS_ID',
			'MODULE_PAYMENT_PAYPAL_PDTTOKEN',
			'MODULE_PAYMENT_PAYPAL_CURRENCY',
			'MODULE_PAYMENT_PAYPAL_ZONE',
			'MODULE_PAYMENT_PAYPAL_PROCESSING_STATUS_ID',
			'MODULE_PAYMENT_PAYPAL_ORDER_STATUS_ID',
			'MODULE_PAYMENT_PAYPAL_REFUND_ORDER_STATUS_ID',
			'MODULE_PAYMENT_PAYPAL_SORT_ORDER',
			'MODULE_PAYMENT_PAYPAL_DETAILED_CART',
			'MODULE_PAYMENT_PAYPAL_ADDRESS_OVERRIDE',
			'MODULE_PAYMENT_PAYPAL_ADDRESS_REQUIRED',
			'MODULE_PAYMENT_PAYPAL_PAGE_STYLE',
			'MODULE_PAYMENT_PAYPAL_HANDLER',
			'MODULE_PAYMENT_PAYPAL_IPN_DEBUG' 
		);
		
		// Paypal testing/debug options go here:
		if (IS_ADMIN_FLAG === true)
		{
			if (isset($_GET['debug']) && $_GET['debug'] == 'on')
			{
				$keys_list[] = 'MODULE_PAYMENT_PAYPAL_DEBUG_EMAIL_ADDRESS'; /* this defaults to store-owner-email-address */
			}
		}
		return $keys_list;
	}
	function _getPDTresults($orderAmount, $my_currency, $pdtTX)
	{
		global $db;
		$ipnData = ipn_postback('PDT', $pdtTX);
		$respdata = $ipnData['info'];
		
		// parse the data
		$lines = explode("\n", $respdata);
		$this->pdtData = array();
		for($i = 1; $i < count($lines); $i++)
		{
			if (!strstr($lines[$i], "=")) continue;
			list($key, $val) = explode("=", $lines[$i]);
			$this->pdtData[urldecode($key)] = urldecode($val);
		}
		
		if ($this->pdtData['txn_id'] == '' || $this->pdtData['payment_status'] == '')
		{
			ipn_debug_email('PDT Returned INVALID Data. Must wait for IPN to process instead. ' . "\n" . print_r($this->pdtData, true));
			return FALSE;
		}
		else
		{
			ipn_debug_email('PDT Returned Data ' . print_r($this->pdtData, true));
		}
		
		$_POST['mc_gross'] = $this->pdtData['mc_gross'];
		$_POST['mc_currency'] = $this->pdtData['mc_currency'];
		$_POST['business'] = $this->pdtData['business'];
		$_POST['receiver_email'] = $this->pdtData['receiver_email'];
		
		$PDTstatus = (ipn_validate_transaction($respdata, $this->pdtData, 'PDT') && valid_payment($orderAmount, $my_currency, 'PDT') && $this->pdtData['payment_status'] == 'Completed');
		if ($this->pdtData['payment_status'] != '' && $this->pdtData['payment_status'] != 'Completed')
		{
			ipn_debug_email('PDT WARNING :: Order not marked as "Completed".  Check for Pending reasons or wait for IPN to complete.' . "\n" . '[payment_status] => ' . $this->pdtData['payment_status'] . "\n" . '[pending_reason] => ' . $this->pdtData['pending_reason']);
		}
		
		$sql = "SELECT order_id, paypal_ipn_id, payment_status, txn_type, pending_reason
                FROM " . TABLE_PAYPAL . "
                WHERE txn_id = :transactionID OR parent_txn_id = :transactionID
                ORDER BY order_id DESC  ";
		$sql = $db->bindVars($sql, ':transactionID', $this->pdtData['txn_id'], 'string');
		$ipn_id = $db->Execute($sql);
		if ($ipn_id->RecordCount() != 0)
		{
			ipn_debug_email('PDT WARNING :: Transaction already exists. Perhaps IPN already added it.  PDT processing ended.');
			$pdtTXN_is_unique = false;
		}
		else
		{
			$pdtTXN_is_unique = true;
		}
		
		$PDTstatus = ($pdtTXN_is_unique && $PDTstatus);
		if ($PDTstatus == TRUE) $this->transaction_id = $this->pdtData['txn_id'];
		return $PDTstatus;
	}
	function tableCheckup()
	{
		global $db, $sniffer;
		$fieldOkay1 = (method_exists($sniffer, 'field_type')) ? $sniffer->field_type(TABLE_PAYPAL, 'txn_id', 'varchar(20)', true) : -1;
		$fieldOkay2 = ($sniffer->field_exists(TABLE_PAYPAL, 'module_name')) ? true : -1;
		$fieldOkay3 = ($sniffer->field_exists(TABLE_PAYPAL, 'order_id')) ? true : -1;
		
		if ($fieldOkay1 == -1)
		{
			$sql = "show fields from " . TABLE_PAYPAL;
			$result = $db->Execute($sql);
			while(!$result->EOF)
			{
				if ($result->fields['Field'] == 'txn_id')
				{
					if ($result->fields['Type'] == 'varchar(20)')
					{
						$fieldOkay1 = true; // exists and matches required type, so skip to other checkup
					}
					else
					{
						$fieldOkay1 = $result->fields['Type']; // doesn't match, so return what it "is"
						break;
					}
				}
				$result->MoveNext();
			}
		}
		
		if ($fieldOkay1 !== true)
		{
			// temporary fix to table structure for v1.3.7.x -- may remove in later release
			$db->Execute("ALTER TABLE " . TABLE_PAYPAL . " CHANGE payment_type payment_type varchar(40) NOT NULL default ''");
			$db->Execute("ALTER TABLE " . TABLE_PAYPAL . " CHANGE txn_type txn_type varchar(40) NOT NULL default ''");
			$db->Execute("ALTER TABLE " . TABLE_PAYPAL . " CHANGE payment_status payment_status varchar(32) NOT NULL default ''");
			$db->Execute("ALTER TABLE " . TABLE_PAYPAL . " CHANGE reason_code reason_code varchar(40) default NULL");
			$db->Execute("ALTER TABLE " . TABLE_PAYPAL . " CHANGE pending_reason pending_reason varchar(32) default NULL");
			$db->Execute("ALTER TABLE " . TABLE_PAYPAL . " CHANGE invoice invoice varchar(128) default NULL");
			$db->Execute("ALTER TABLE " . TABLE_PAYPAL . " CHANGE payer_business_name payer_business_name varchar(128) default NULL");
			$db->Execute("ALTER TABLE " . TABLE_PAYPAL . " CHANGE address_name address_name varchar(64) default NULL");
			$db->Execute("ALTER TABLE " . TABLE_PAYPAL . " CHANGE address_street address_street varchar(254) default NULL");
			$db->Execute("ALTER TABLE " . TABLE_PAYPAL . " CHANGE address_city address_city varchar(120) default NULL");
			$db->Execute("ALTER TABLE " . TABLE_PAYPAL . " CHANGE address_state address_state varchar(120) default NULL");
			$db->Execute("ALTER TABLE " . TABLE_PAYPAL . " CHANGE payer_email payer_email varchar(128) NOT NULL default ''");
			$db->Execute("ALTER TABLE " . TABLE_PAYPAL . " CHANGE business business varchar(128) NOT NULL default ''");
			$db->Execute("ALTER TABLE " . TABLE_PAYPAL . " CHANGE receiver_email receiver_email varchar(128) NOT NULL default ''");
			$db->Execute("ALTER TABLE " . TABLE_PAYPAL . " CHANGE txn_id txn_id varchar(20) NOT NULL default ''");
			$db->Execute("ALTER TABLE " . TABLE_PAYPAL . " CHANGE parent_txn_id parent_txn_id varchar(20) default NULL");
		}
		if ($fieldOkay2 !== true)
		{
			$db->Execute("ALTER TABLE " . TABLE_PAYPAL . " ADD COLUMN module_name varchar(40) NOT NULL default '' after txn_type");
			$db->Execute("ALTER TABLE " . TABLE_PAYPAL . " ADD COLUMN module_mode varchar(40) NOT NULL default '' after module_name");
		}
		if ($fieldOkay3 !== true)
		{
			$db->Execute("ALTER TABLE " . TABLE_PAYPAL . " CHANGE zen_order_id order_id int(11) NOT NULL default '0'");
		}
	}
}

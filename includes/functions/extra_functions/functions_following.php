<?php
/**
 * use following function
 * @author JunsChen
 * @copyright JunsGo@msn.com
 * @version 1.2.1
 * allow ipod and referer google.co.jp
 * UPDATE:
 * 		add $cookie->first_page
 */

/**
 * update add new iphone or ipod
 * parse $_SERVER['HTTP_REFERER'] confirm search engine
 *
 * @param string $referer        	
 * @return bool
 */
function make_semiangle($str)
{
	$arr = array('０' => '0', '１' => '1', '２' => '2', '３' => '3', '４' => '4',
		'５' => '5', '６' => '6', '７' => '7', '８' => '8', '９' => '9',
		'Ａ' => 'A', 'Ｂ' => 'B', 'Ｃ' => 'C', 'Ｄ' => 'D', 'Ｅ' => 'E',
		'Ｆ' => 'F', 'Ｇ' => 'G', 'Ｈ' => 'H', 'Ｉ' => 'I', 'Ｊ' => 'J',
		'Ｋ' => 'K', 'Ｌ' => 'L', 'Ｍ' => 'M', 'Ｎ' => 'N', 'Ｏ' => 'O',
		'Ｐ' => 'P', 'Ｑ' => 'Q', 'Ｒ' => 'R', 'Ｓ' => 'S', 'Ｔ' => 'T',
		'Ｕ' => 'U', 'Ｖ' => 'V', 'Ｗ' => 'W', 'Ｘ' => 'X', 'Ｙ' => 'Y',
		'Ｚ' => 'Z', 'ａ' => 'a', 'ｂ' => 'b', 'ｃ' => 'c', 'ｄ' => 'd',
		'ｅ' => 'e', 'ｆ' => 'f', 'ｇ' => 'g', 'ｈ' => 'h', 'ｉ' => 'i',
		'ｊ' => 'j', 'ｋ' => 'k', 'ｌ' => 'l', 'ｍ' => 'm', 'ｎ' => 'n',
		'ｏ' => 'o', 'ｐ' => 'p', 'ｑ' => 'q', 'ｒ' => 'r', 'ｓ' => 's',
		'ｔ' => 't', 'ｕ' => 'u', 'ｖ' => 'v', 'ｗ' => 'w', 'ｘ' => 'x',
		'ｙ' => 'y', 'ｚ' => 'z',
		'（' => '(', '）' => ')', '〔' => '[', '〕' => ']', '【' => '[',
		'】' => ']', '〖' => '[', '〗' => ']', '“' => '[', '”' => ']',
		'‘' => '[', '’' => ']', '｛' => '{', '｝' => '}', '《' => '<',
		'》' => '>',
		'％' => '%', '＋' => '+', '—' => '-', '－' => '-', '～' => '-',
		'：' => ':', '。' => '.', '、' => ',', '，' => '.', '、' => '.',
		'；' => ',', '？' => '?', '！' => '!', '…' => '-', '‖' => '|',
		'”' => '"', '’' => '`', '‘' => '`', '｜' => '|', '〃' => '"',
		'　' => ' ','＄'=>'$','＠'=>'@','＃'=>'#','＾'=>'^','＆'=>'&','＊'=>'*',
		'＂'=>'"');
	 
	return strtr($str, $arr);
}
function get_search_engine(&$keyword, $url = null)
{
	global $db;
	if (is_null($url))
		$url = $_SERVER['HTTP_REFERER'];
	$url = urldecode($url);
	$url = make_semiangle($url);
	
	$parsed_url = @parse_url($url);
	if (!isset($parsed_url['host']))
		return false;
		/*
	 * if (!isset($parsed_url['query'])) { $google = 'google.co.jp'; if (stripos($url, $google) !== false) return true; else return false; }
	 */
	
	$filter_keywords = FILTER_SEARCH_KEYWORDS;
	$filter_keywords = !empty($filter_keywords) ? explode(',', $filter_keywords) : array();
	
	$result = $db->Execute('SELECT `server`, `getvar` FROM `' . DB_PREFIX . 'search_engine`', false, true);
	while(!$result->EOF)
	{
		$host = &$result->fields['server'];
		$varname = &$result->fields['getvar'];
		
		if (strstr($parsed_url['host'], $host))
		{
			$k = array();
			$key_string = $parsed_url['query'];
			if (empty($key_string) && isset($parsed_url['fragment']) && !empty($parsed_url['fragment']))
				$key_string = $parsed_url['fragment'];
			
			preg_match('/' . $varname . '=.+\&' . '/U', $key_string, $k);
			if (!isset($k[0]) || empty($k[0]))
				preg_match('/' . $varname . '=.+$' . '/', $key_string, $k);
			
			$keyword = urldecode(str_replace('+', ' ', $k[0]));
			if (strpos($keyword, '&') !== false)
				$keyword = substr($keyword, 0, strpos($keyword, '&'));
			$keyword = ltrim($keyword, $varname . '=');
			$keyword = str_ireplace('¤', '', $keyword);
			$keyword = str_ireplace('|', '', $keyword);
			$keyword = trim($keyword);
			if (empty($keyword) && stripos($parsed_url['host'], $host) !== false)
			{
				return true; // no keyword and host pass
			}
			// filter keyword
			foreach($filter_keywords as $key)
			{
				if (stripos($keyword, trim($key)) !== false)
					return false;
			}
			return true;
		}
		
		$result->MoveNext();
	}
	return false;
}
function set_cookie_send_mail()
{
	global $cookie, $current_page;
	
	// first set
	if (!isset($cookie->user_agent))
		$cookie->user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
	if (!isset($cookie->referer))
		$cookie->referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
	if (!isset($cookie->from_count))
		$cookie->from_count = 1;
		// fix:clear cookie and login not create customer
	if (!isset($cookie->customer_id) && isset($_SESSION['customer_id']) && (int)$_SESSION['customer_id'] > 0)
		$cookie->customer_id = (int)$_SESSION['customer_id'];
	
	$cookie->account_level = get_account_level();
	
	$is_iphone = get_iphone();
	if ($is_iphone == true)
	{
		if (!isset($cookie->send_email))
		{ // first
			$cookie->send_email = 1;
		}
	}
	if (!isset($cookie->send_email) && !allow_brower())
	{
		$cookie->send_email = 0;
	}
	if (!isset($_SERVER['HTTP_REFERER']) || strstr($_SERVER['HTTP_REFERER'], get_host()))
	{
		if ($cookie->send_email == 1)
		{
			if ($cookie->customer_id)
			{
				// customer existing
				if (!check_can_send_customer($cookie->customer_id))
				{
					$cookie->send_email = 0;
				}
			}
		}
		else
			$cookie->send_email = 0; // don't send email
	}
	else
	{
		$keyword = '';
		// confirm from search
		$is_from_search = get_search_engine($keyword);
		if ($is_from_search)
		{
			// $_SERVER['HTTP_USER_AGENT']
			// fix:multi search engine
			// first come
			if (!isset($cookie->send_email))
			{
				$cookie->send_email = 1;
			}
			else
			{
				$cookie->from_count = (int)$cookie->from_count + 1;
			}
			// is search update it
			$cookie->user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
			$cookie->referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
			
			$cookie->first_page = $_GET['main_page'];
			
		}
		$cookie->search_keyword = $keyword;
	}
	if ($cookie->send_email == 1)
		filter_first();
	// FIX: can't send cookie
	$cookie->write();
}
function allow_brower()
{
	$allow = array('ja');
	$flag = false;
	foreach ($allow as $a)
	{
		if (stripos($_SERVER['HTTP_ACCEPT_LANGUAGE'], 'ja') !== false)
		{
			$flag = true;
			break;
		}
	}
	return $flag;
	
}
function filter_first()
{
	global $cookie, $coupon_deny_page;
	$page = $cookie->first_page;
	if (isset($coupon_deny_page) && is_array($coupon_deny_page) && isset($coupon_deny_page[$page]))
	{
		if (isset($coupon_deny_page[$page]['param']))
		{
			$param = (int)$_GET[$coupon_deny_page[$page]['param']];
			if ($param > 0 && is_array($coupon_deny_page[$page]['id']) && in_array($param, $coupon_deny_page[$page]['id']))
			{
				$cookie->send_email = 0;
				$cookie->write();
			}
		}
		else if (isset($coupon_deny_page[$page]['id']) && is_array($coupon_deny_page[$page]['id']))
		{
			if (in_array($page, $coupon_deny_page[$page]['id']))
			{
				$cookie->send_email = 0;
				$cookie->write();
			}
		}
	}
}
function get_host()
{
	$host = HTTP_SERVER;
	return $host;
}
function get_iphone()
{
	global $cookie;
	//always false
	return false;
	
	$user_agent = strtolower($cookie->user_agent);
	$mobile = 'mobile';
	$words = array(
		'ipad' 
	); // upgrade: remove iphone, android
	foreach($words as $w)
	{
		if (stripos($user_agent, $w) !== false && stripos($user_agent, $mobile) !== false)
			return true;
	}
	
	return false;
}
function get_account_level()
{
	global $cookie;
	
	$user_agent = strtolower($cookie->user_agent);
	$account_level = 10; // other
	
	switch($user_agent)
	{
		/* mobile */
		case stripos($user_agent, 'ipad') !== false:
			$account_level = 20;
			break;
		case stripos($user_agent, 'iphone') !== false:
			$account_level = 21;
			break;
		case stripos($user_agent, 'android') !== false:
			$account_level = 22;
			break;
		/* end mobile */
		/* pc */
		case stripos($user_agent, 'macintosh') !== false:
			$account_level = 30;
			break;
		case stripos($user_agent, 'linux') !== false:
			$account_level = 31;
			break;
		case stripos($user_agent, 'windows nt') !== false:
			
			switch($user_agent)
			{
				case stripos($user_agent, 'windows nt 5.1') !== false:
					// window xp
					$account_level = 320;
					break;
				case stripos($user_agent, 'windows nt 6.0') !== false:
					// window vista
					$account_level = 321;
					break;
				case stripos($user_agent, 'windows nt 6.1') !== false:
					// window 7
					$account_level = 322;
					break;
				case stripos($user_agent, 'windows nt 6.') !== false:
					// window 8
					$account_level = 323;
					break;
				default:
					$account_level = 10;
					break;
			}
			break;
		default:
			$account_level = 10;
			break;
	}
	
	return $account_level;
}
/**
 * check customer send email status
 * $_SESSION['customer_id']
 * $_SESSION['customers_authorization']
 *
 * @param integer $id_customer        	
 */
function check_can_send_customer($customer_id)
{
	global $db;
	
	$customer_id = (int)$customer_id;
	if ($customer_id <= 0)
		return false;
		// check db
	$result = $db->Execute('SELECT `active` FROM `' . TABLE_CUSTOMERS_FOLLOW . '` WHERE `customers_id` = ' . (int)$customer_id);
	if (isset($result->fields['active']))
		return (bool)$result->fields['active'];
	return false;
}
/**
 * change customer send mail status.Use of new orders
 *
 * @param integer $customer_id        	
 * @param number $can_send_email        	
 * @param number $order_id        	
 */
function update_customer_follow($customer_id, $can_send_email = 0, $order_id = 0)
{
	global $db, $cookie;
	if ((int)$customer_id <= 0)
		return;
		// has customer
	$db->Execute('UPDATE `' . TABLE_CUSTOMERS_FOLLOW . '` SET `date_upd`=now(), `sended` = 1, `sended_date` = now(), `active`=' . (int)$can_send_email . ', `orders_id` = ' . (int)$order_id . ' 
		WHERE `customers_id`=' . (int)$customer_id);
	
	// FIX: can't send cookie
	$cookie->write();
}
function update_customer_follow_referer($customer_id, $referer, $user_agent, $from_count = 0, $keyword = '')
{
	global $db, $cookie;
	if ((int)$customer_id <= 0)
		return;
	$db->Execute('UPDATE `' . TABLE_CUSTOMERS_FOLLOW . '` SET `referer`=\'' . $db->prepare_input($referer) . '\', `user_agent`=\'' . $db->prepare_input(substr($user_agent, 0, 255)) . '\', `from_count`=' . (int)$from_count . ', `keyword` = \'' . $db->prepare_input(substr($keyword, 0, 255)) . '\'
		WHERE `customers_id`=' . (int)$customer_id);
}
function update_customer_follow_active($customer_id, $active = false)
{
	global $db, $cookie;
	if ((int)$customer_id <= 0)
		return;
	$db->Execute('UPDATE `' . TABLE_CUSTOMERS_FOLLOW . '` SET `date_upd`=now(), `active`=' . (int)$active . '
		WHERE `customers_id`=' . (int)$customer_id);
	
	// FIX: can't send cookie
	$cookie->send_email = 0;
	$cookie->write();
}
/**
 * register new customer
 *
 * @param integer $customer_id        	
 * @param integer $identify        	
 * @param number $can_send_email        	
 */
function add_new_customer_follow($customer_id, $identify = 0, $can_send_email = 0)
{
	global $db, $cookie;
	
	$cookie->customer_id = (int)$customer_id;
	$db->Execute('INSERT INTO `' . TABLE_CUSTOMERS_FOLLOW . '` (`customers_id`, `identify`, `date_add`, `date_upd`, `active`)VALUES
		(' . (int)$customer_id . ', ' . (int)$identify . ', now(), now(), ' . (int)$can_send_email . ');');
	
	// update create account referer
	update_customer_follow_referer($cookie->customer_id, $cookie->referer, $cookie->user_agent, (int)$cookie->from_count, $cookie->search_keyword);
	
	// FIX: can't send cookie
	$cookie->write();
}
function send_email_to_us($zf_insert_id, $zf_mode, $order)
{
	global $currencies, $order_totals, $zco_notifier;
	
	// lets start with the email confirmation
	// make an array to store the html version
	$html_msg = array();
	
	// COWOA Conditional
	if ($_SESSION['COWOA'])
	{
		$invoiceInfo = "";
		$htmlInvoiceURL = "";
		$htmlInvoiceValue = "";
	}
	else
	{
		$invoiceInfo = EMAIL_TEXT_INVOICE_URL . ' ' . zen_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $zf_insert_id, 'SSL', false) . "\n\n";
		$htmlInvoiceURL = EMAIL_TEXT_INVOICE_URL_CLICK;
		;
		$htmlInvoiceValue = zen_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $zf_insert_id, 'SSL', false);
	}
	// intro area
	$email_order = EMAIL_TEXT_HEADER . EMAIL_TEXT_FROM . STORE_NAME . "\n\n" . $order->customer['firstname'] . ' ' . $order->customer['lastname'] . "\n\n" . EMAIL_THANKS_FOR_SHOPPING . "\n" . EMAIL_DETAILS_FOLLOW . "\n" . EMAIL_SEPARATOR . "\n" . EMAIL_TEXT_ORDER_NUMBER . ' ' . $zf_insert_id . "\n" . EMAIL_TEXT_DATE_ORDERED . ' ' . strftime(DATE_FORMAT_LONG) . "\n";
	if (!$_SESSION['COWOA'])
	{
		$email_order .= EMAIL_TEXT_INVOICE_URL . ' ' . zen_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $zf_insert_id, 'SSL', false) . "\n\n";
	}
	$html_msg['EMAIL_TEXT_HEADER'] = EMAIL_TEXT_HEADER;
	$html_msg['EMAIL_TEXT_FROM'] = EMAIL_TEXT_FROM;
	$html_msg['INTRO_STORE_NAME'] = STORE_NAME;
	$html_msg['EMAIL_THANKS_FOR_SHOPPING'] = EMAIL_THANKS_FOR_SHOPPING;
	$html_msg['EMAIL_DETAILS_FOLLOW'] = EMAIL_DETAILS_FOLLOW;
	$html_msg['INTRO_ORDER_NUM_TITLE'] = EMAIL_TEXT_ORDER_NUMBER;
	$html_msg['INTRO_ORDER_NUMBER'] = $zf_insert_id;
	$html_msg['INTRO_DATE_TITLE'] = EMAIL_TEXT_DATE_ORDERED;
	$html_msg['INTRO_DATE_ORDERED'] = strftime(DATE_FORMAT_LONG);
	$html_msg['INTRO_URL_TEXT'] = $htmlInvoiceURL;
	$html_msg['INTRO_URL_VALUE'] = $htmlInvoiceValue;
	
	// comments area
	if ($order->info['comments'])
	{
		$email_order .= zen_db_output($order->info['comments']) . "\n\n";
		$html_msg['ORDER_COMMENTS'] = nl2br(zen_db_output($order->info['comments']));
	}
	else
	{
		$html_msg['ORDER_COMMENTS'] = '';
	}
	
	// products area
	$email_order .= EMAIL_TEXT_PRODUCTS . "\n" . EMAIL_SEPARATOR . "\n" . $order->products_ordered . EMAIL_SEPARATOR . "\n";
	$html_msg['PRODUCTS_TITLE'] = EMAIL_TEXT_PRODUCTS;
	$html_msg['PRODUCTS_DETAIL'] = '<table class="product-details" border="0" width="100%" cellspacing="0" cellpadding="2">' . $order->products_ordered_html . '</table>';
	
	// order totals area
	$html_ot .= '<td class="order-totals-text" align="right" width="100%">' . '&nbsp;' . '</td> ' . "\n" . '<td class="order-totals-num" align="right" nowrap="nowrap">' . '---------' . '</td> </tr>' . "\n" . '<tr>';
	for($i = 0, $n = sizeof($order_totals); $i < $n; $i++)
	{
		$email_order .= strip_tags($order_totals[$i]['title']) . ' ' . strip_tags($order_totals[$i]['text']) . "\n";
		$html_ot .= '<td class="order-totals-text" align="right" width="100%">' . $order_totals[$i]['title'] . '</td> ' . "\n" . '<td class="order-totals-num" align="right" nowrap="nowrap">' . ($order_totals[$i]['text']) . '</td> </tr>' . "\n" . '<tr>';
	}
	$html_msg['ORDER_TOTALS'] = '<table border="0" width="100%" cellspacing="0" cellpadding="2"> ' . $html_ot . ' </table>';
	
	// addresses area: Delivery
	$html_msg['HEADING_ADDRESS_INFORMATION'] = HEADING_ADDRESS_INFORMATION;
	$html_msg['ADDRESS_DELIVERY_TITLE'] = EMAIL_TEXT_DELIVERY_ADDRESS;
	$html_msg['ADDRESS_DELIVERY_DETAIL'] = ($order->content_type != 'virtual') ? zen_address_label($_SESSION['customer_id'], $_SESSION['sendto'], true, '', "<br />") : 'n/a';
	$html_msg['SHIPPING_METHOD_TITLE'] = HEADING_SHIPPING_METHOD;
	$html_msg['SHIPPING_METHOD_DETAIL'] = (zen_not_null($order->info['shipping_method'])) ? $order->info['shipping_method'] : 'n/a';
	
	if ($order->content_type != 'virtual')
	{
		$email_order .= "\n" . EMAIL_TEXT_DELIVERY_ADDRESS . "\n" . EMAIL_SEPARATOR . "\n" . zen_address_label($_SESSION['customer_id'], $_SESSION['sendto'], 0, '', "\n") . "\n";
	}
	
	// addresses area: Billing
	$email_order .= "\n" . EMAIL_TEXT_BILLING_ADDRESS . "\n" . EMAIL_SEPARATOR . "\n" . zen_address_label($_SESSION['customer_id'], $_SESSION['billto'], 0, '', "\n") . "\n\n";
	$html_msg['ADDRESS_BILLING_TITLE'] = EMAIL_TEXT_BILLING_ADDRESS;
	$html_msg['ADDRESS_BILLING_DETAIL'] = zen_address_label($_SESSION['customer_id'], $_SESSION['billto'], true, '', "<br />");
	
	if (is_object($GLOBALS[$_SESSION['payment']]))
	{
		$cc_num_display = (isset($order->info['cc_number']) && $order->info['cc_number'] != '') ? substr($order->info['cc_number'], 0, 4) . str_repeat('X', (strlen($order->info['cc_number']) - 8)) . substr($order->info['cc_number'], -4) . "\n\n" : '';
		$email_order .= EMAIL_TEXT_PAYMENT_METHOD . "\n" . EMAIL_SEPARATOR . "\n";
		$payment_class = $_SESSION['payment'];
		$email_order .= $GLOBALS[$payment_class]->title . "\n\n";
		$email_order .= (isset($order->info['cc_type']) && $order->info['cc_type'] != '') ? $order->info['cc_type'] . ' ' . $cc_num_display . "\n\n" : '';
		$email_order .= ($GLOBALS[$payment_class]->email_footer) ? $GLOBALS[$payment_class]->email_footer . "\n\n" : '';
	}
	else
	{
		$email_order .= EMAIL_TEXT_PAYMENT_METHOD . "\n" . EMAIL_SEPARATOR . "\n";
		$email_order .= PAYMENT_METHOD_GV . "\n\n";
	}
	$html_msg['PAYMENT_METHOD_TITLE'] = EMAIL_TEXT_PAYMENT_METHOD;
	$html_msg['PAYMENT_METHOD_DETAIL'] = (is_object($GLOBALS[$_SESSION['payment']]) ? $GLOBALS[$payment_class]->title : PAYMENT_METHOD_GV);
	$html_msg['PAYMENT_METHOD_FOOTER'] = (is_object($GLOBALS[$_SESSION['payment']]) && $GLOBALS[$payment_class]->email_footer != '') ? nl2br($GLOBALS[$payment_class]->email_footer) : (isset($order->info['cc_type']) && $order->info['cc_type'] != '' ? $order->info['cc_type'] . ' ' . $cc_num_display . "\n\n" : '');
	
	// include disclaimer
	$email_order .= "\n-----\n" . sprintf(EMAIL_DISCLAIMER, STORE_OWNER_EMAIL_ADDRESS) . "\n\n";
	// include copyright
	$email_order .= "\n-----\n" . EMAIL_FOOTER_COPYRIGHT . "\n\n";
	
	while(strstr($email_order, '&nbsp;'))
		$email_order = str_replace('&nbsp;', ' ', $email_order);
	
	$html_msg['EMAIL_FIRST_NAME'] = $order->customer['firstname'];
	$html_msg['EMAIL_LAST_NAME'] = $order->customer['lastname'];
	// $html_msg['EMAIL_TEXT_HEADER'] = EMAIL_TEXT_HEADER;
	$html_msg['EXTRA_INFO'] = '';
	
	zen_mail('Hello Admin', US_EMAIL_ADDRESS, sprintf('New Order #%6s', $zf_insert_id), $email_order, STORE_NAME, EMAIL_FROM, $html_msg, 'checkout', $order->attachArray);
	return true;
}
function send_other_email($zf_insert_id, $zf_mode, $order)
{
	global $currencies, $order_totals, $zco_notifier;
	
	// print_r($order);
	// die();
	if ($order->email_low_stock != '' and SEND_LOWSTOCK_EMAIL == '1')
	{
		// send an email
		$email_low_stock = SEND_EXTRA_LOW_STOCK_EMAIL_TITLE . "\n\n" . $order->email_low_stock;
		zen_mail('', SEND_EXTRA_LOW_STOCK_EMAILS_TO, EMAIL_TEXT_SUBJECT_LOWSTOCK, $email_low_stock, STORE_OWNER, EMAIL_FROM, array(
			'EMAIL_MESSAGE_HTML' => nl2br($email_low_stock) 
		), 'low_stock');
	}
	
	// lets start with the email confirmation
	// make an array to store the html version
	$html_msg = array();
	
	// COWOA Conditional
	if ($_SESSION['COWOA'])
	{
		$invoiceInfo = "";
		$htmlInvoiceURL = "";
		$htmlInvoiceValue = "";
	}
	else
	{
		$invoiceInfo = EMAIL_TEXT_INVOICE_URL . ' ' . zen_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $zf_insert_id, 'SSL', false) . "\n\n";
		$htmlInvoiceURL = EMAIL_TEXT_INVOICE_URL_CLICK;
		;
		$htmlInvoiceValue = zen_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $zf_insert_id, 'SSL', false);
	}
	// intro area
	$email_order = EMAIL_TEXT_HEADER . EMAIL_TEXT_FROM . STORE_NAME . "\n\n" . $order->customer['firstname'] . ' ' . $order->customer['lastname'] . "\n\n" . EMAIL_THANKS_FOR_SHOPPING . "\n" . EMAIL_DETAILS_FOLLOW . "\n" . EMAIL_SEPARATOR . "\n" . EMAIL_TEXT_ORDER_NUMBER . ' ' . $zf_insert_id . "\n" . EMAIL_TEXT_DATE_ORDERED . ' ' . strftime(DATE_FORMAT_LONG) . "\n";
	if (!$_SESSION['COWOA'])
	{
		$email_order .= EMAIL_TEXT_INVOICE_URL . ' ' . zen_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $zf_insert_id, 'SSL', false) . "\n\n";
	}
	$html_msg['EMAIL_TEXT_HEADER'] = EMAIL_TEXT_HEADER;
	$html_msg['EMAIL_TEXT_FROM'] = EMAIL_TEXT_FROM;
	$html_msg['INTRO_STORE_NAME'] = STORE_NAME;
	$html_msg['EMAIL_THANKS_FOR_SHOPPING'] = EMAIL_THANKS_FOR_SHOPPING;
	$html_msg['EMAIL_DETAILS_FOLLOW'] = EMAIL_DETAILS_FOLLOW;
	$html_msg['INTRO_ORDER_NUM_TITLE'] = EMAIL_TEXT_ORDER_NUMBER;
	$html_msg['INTRO_ORDER_NUMBER'] = $zf_insert_id;
	$html_msg['INTRO_DATE_TITLE'] = EMAIL_TEXT_DATE_ORDERED;
	$html_msg['INTRO_DATE_ORDERED'] = strftime(DATE_FORMAT_LONG);
	$html_msg['INTRO_URL_TEXT'] = $htmlInvoiceURL;
	$html_msg['INTRO_URL_VALUE'] = $htmlInvoiceValue;
	
	// comments area
	if ($order->info['comments'])
	{
		$email_order .= zen_db_output($order->info['comments']) . "\n\n";
		$html_msg['ORDER_COMMENTS'] = nl2br(zen_db_output($order->info['comments']));
	}
	else
	{
		$html_msg['ORDER_COMMENTS'] = '';
	}
	
	// products area
	$email_order .= EMAIL_TEXT_PRODUCTS . "\n" . EMAIL_SEPARATOR . "\n" . $order->products_ordered . EMAIL_SEPARATOR . "\n";
	$html_msg['PRODUCTS_TITLE'] = EMAIL_TEXT_PRODUCTS;
	$html_msg['PRODUCTS_DETAIL'] = '<table class="product-details" border="0" width="100%" cellspacing="0" cellpadding="2">' . $order->products_ordered_html . '</table>';
	
	// order totals area
	$html_ot .= '<td class="order-totals-text" align="right" width="100%">' . '&nbsp;' . '</td> ' . "\n" . '<td class="order-totals-num" align="right" nowrap="nowrap">' . '---------' . '</td> </tr>' . "\n" . '<tr>';
	for($i = 0, $n = sizeof($order_totals); $i < $n; $i++)
	{
		$email_order .= strip_tags($order_totals[$i]['title']) . ' ' . strip_tags($order_totals[$i]['text']) . "\n";
		$html_ot .= '<td class="order-totals-text" align="right" width="100%">' . $order_totals[$i]['title'] . '</td> ' . "\n" . '<td class="order-totals-num" align="right" nowrap="nowrap">' . ($order_totals[$i]['text']) . '</td> </tr>' . "\n" . '<tr>';
	}
	$html_msg['ORDER_TOTALS'] = '<table border="0" width="100%" cellspacing="0" cellpadding="2"> ' . $html_ot . ' </table>';
	
	// addresses area: Delivery
	$html_msg['HEADING_ADDRESS_INFORMATION'] = HEADING_ADDRESS_INFORMATION;
	$html_msg['ADDRESS_DELIVERY_TITLE'] = EMAIL_TEXT_DELIVERY_ADDRESS;
	$html_msg['ADDRESS_DELIVERY_DETAIL'] = ($order->content_type != 'virtual') ? zen_address_label($_SESSION['customer_id'], $_SESSION['sendto'], true, '', "<br />") : 'n/a';
	$html_msg['SHIPPING_METHOD_TITLE'] = HEADING_SHIPPING_METHOD;
	$html_msg['SHIPPING_METHOD_DETAIL'] = (zen_not_null($order->info['shipping_method'])) ? $order->info['shipping_method'] : 'n/a';
	
	if ($order->content_type != 'virtual')
	{
		$email_order .= "\n" . EMAIL_TEXT_DELIVERY_ADDRESS . "\n" . EMAIL_SEPARATOR . "\n" . zen_address_label($_SESSION['customer_id'], $_SESSION['sendto'], 0, '', "\n") . "\n";
	}
	
	// addresses area: Billing
	$email_order .= "\n" . EMAIL_TEXT_BILLING_ADDRESS . "\n" . EMAIL_SEPARATOR . "\n" . zen_address_label($_SESSION['customer_id'], $_SESSION['billto'], 0, '', "\n") . "\n\n";
	$html_msg['ADDRESS_BILLING_TITLE'] = EMAIL_TEXT_BILLING_ADDRESS;
	$html_msg['ADDRESS_BILLING_DETAIL'] = zen_address_label($_SESSION['customer_id'], $_SESSION['billto'], true, '', "<br />");
	
	if (is_object($GLOBALS[$_SESSION['payment']]))
	{
		$cc_num_display = (isset($order->info['cc_number']) && $order->info['cc_number'] != '') ? substr($order->info['cc_number'], 0, 4) . str_repeat('X', (strlen($order->info['cc_number']) - 8)) . substr($order->info['cc_number'], -4) . "\n\n" : '';
		$email_order .= EMAIL_TEXT_PAYMENT_METHOD . "\n" . EMAIL_SEPARATOR . "\n";
		$payment_class = $_SESSION['payment'];
		$email_order .= $GLOBALS[$payment_class]->title . "\n\n";
		$email_order .= (isset($order->info['cc_type']) && $order->info['cc_type'] != '') ? $order->info['cc_type'] . ' ' . $cc_num_display . "\n\n" : '';
		// this is account
		// $email_order .= ($GLOBALS[$payment_class]->email_footer) ? $GLOBALS[$payment_class]->email_footer . "\n\n" : '';
		
		$email_order .= (defined('BANKINFO_OTHER') ? BANKINFO_OTHER . "\n\n" : '');
	}
	else
	{
		$email_order .= EMAIL_TEXT_PAYMENT_METHOD . "\n" . EMAIL_SEPARATOR . "\n";
		$email_order .= PAYMENT_METHOD_GV . "\n\n";
	}
	$html_msg['PAYMENT_METHOD_TITLE'] = EMAIL_TEXT_PAYMENT_METHOD;
	$html_msg['PAYMENT_METHOD_DETAIL'] = (is_object($GLOBALS[$_SESSION['payment']]) ? $GLOBALS[$payment_class]->title : PAYMENT_METHOD_GV);
	$html_msg['PAYMENT_METHOD_FOOTER'] = (is_object($GLOBALS[$_SESSION['payment']]) && $GLOBALS[$payment_class]->email_footer != '') ? nl2br($GLOBALS[$payment_class]->email_footer) : (isset($order->info['cc_type']) && $order->info['cc_type'] != '' ? $order->info['cc_type'] . ' ' . $cc_num_display . "\n\n" : '');
	
	// include disclaimer
	$email_order .= "\n-----\n" . sprintf(EMAIL_DISCLAIMER, STORE_OWNER_EMAIL_ADDRESS) . "\n\n";
	// include copyright
	$email_order .= "\n-----\n" . EMAIL_FOOTER_COPYRIGHT . "\n\n";
	
	while(strstr($email_order, '&nbsp;'))
		$email_order = str_replace('&nbsp;', ' ', $email_order);
	
	$html_msg['EMAIL_FIRST_NAME'] = $order->customer['firstname'];
	$html_msg['EMAIL_LAST_NAME'] = $order->customer['lastname'];
	// $html_msg['EMAIL_TEXT_HEADER'] = EMAIL_TEXT_HEADER;
	$html_msg['EXTRA_INFO'] = '';
	$zco_notifier->notify('NOTIFY_ORDER_INVOICE_CONTENT_READY_TO_SEND', array(
		'zf_insert_id' => $zf_insert_id,
		'text_email' => $email_order,
		'html_email' => $html_msg 
	));
	zen_mail($order->customer['firstname'] . ' ' . $order->customer['lastname'], $order->customer['email_address'], EMAIL_TEXT_SUBJECT . EMAIL_ORDER_NUMBER_SUBJECT . $zf_insert_id, $email_order, STORE_NAME, EMAIL_FROM, $html_msg, 'checkout', $order->attachArray);
	
	// send additional emails
	if (SEND_EXTRA_ORDER_EMAILS_TO != '')
	{
		$extra_info = email_collect_extra_info('', '', $order->customer['firstname'] . ' ' . $order->customer['lastname'], $order->customer['email_address'], $order->customer['telephone']);
		$html_msg['EXTRA_INFO'] = $extra_info['HTML'];
		
		if ($GLOBALS[$_SESSION['payment']]->auth_code || $GLOBALS[$_SESSION['payment']]->transaction_id)
		{
			$pmt_details = 'AuthCode: ' . $GLOBALS[$_SESSION['payment']]->auth_code . '  TransID: ' . $GLOBALS[$_SESSION['payment']]->transaction_id . "\n\n";
			$email_order = $pmt_details . $email_order;
			$html_msg['EMAIL_TEXT_HEADER'] = nl2br($pmt_details) . $html_msg['EMAIL_TEXT_HEADER'];
		}
		
		zen_mail('', SEND_EXTRA_ORDER_EMAILS_TO, SEND_EXTRA_NEW_ORDERS_EMAILS_TO_SUBJECT . ' ' . EMAIL_TEXT_SUBJECT . EMAIL_ORDER_NUMBER_SUBJECT . $zf_insert_id, $email_order . $extra_info['TEXT'], STORE_NAME, EMAIL_FROM, $html_msg, 'checkout_extra', $order->attachArray);
	}
	$zco_notifier->notify('NOTIFY_ORDER_AFTER_SEND_ORDER_EMAIL');
}

function get_bankinfo_payment()
{
	global $cookie;
	
	$define = 'BANKINFO';
	if ($cookie->send_email == 1)
	{
		$define .= '_'.$cookie->account_level;// Platform
	
		if ($_SESSION['J_COUPON_VALIDATE'] === true)
		{
			$define .= '_YES_COUPON';
		}
		else
		{
			$define .= '_NO_COUPON';
		}
	
		if (empty($cookie->search_keyword))
		{
			$define .= '_NO_KEY';
		}
		else
		{
			$define .= '_YES_KEY';
		}
	
	
		//define('TEXT_CHECKOUT_LOGOFF_CUSTOMER', $binkinfo_string);
	}
	else
	{
		$define .= '_OTHER';
		//define('TEXT_CHECKOUT_LOGOFF_CUSTOMER', constant($define.'_OTHER'));
	}
	
	if (!defined($define))
	{
		$define = 'MODULE_PAYMENT_WESTERNUNION_TEXT_EMAIL_FOOTER';
	}
	
	return constant($define);
}
function get_bankinfo_success()
{
	global $cookie;
	
	$define = 'BANKINFO';
	if ($cookie->send_email == 1)
	{
		$define .= '_'.$cookie->account_level;// Platform
		
		if ($_SESSION['J_COUPON_VALIDATE'] === true)
		{
			$define .= '_YES_COUPON';
		}
		else
		{
			$define .= '_NO_COUPON';
		}
		
		if (empty($cookie->search_keyword))
		{
			$define .= '_NO_KEY';
		}
		else
		{
			$define .= '_YES_KEY';
		}
		
		
		//define('TEXT_CHECKOUT_LOGOFF_CUSTOMER', $binkinfo_string);
	}
	else
	{
		$define .= '_OTHER';
		//define('TEXT_CHECKOUT_LOGOFF_CUSTOMER', constant($define.'_OTHER'));
	}
	
	if (!defined($define))
		$define = 'BANKINFO_OTHER';
	
	
	return ($_SESSION['payment'] == 'credit')? TEXT_CHECKOUT_PAYMENT_CREDIT_DENIED.constant($define) : constant($define);
}











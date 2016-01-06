<?php
/**
 * Order Manager
 * @author @@46231996
 * @version 1.0
 * @create 2014/12/30
 * @modify 2014/21/30
 */
require ('includes/application_top.php');
require (DIR_WS_CLASSES . 'currencies.php');
$currencies = new currencies();

error_reporting(0);
ini_set('display_errors', false);

define('CONST_SEND_MAIL_DELIVERY', 2);
$prefix = (isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : $_SERVER['HTTP_HOST']);
if (strpos($prefix, 'www.') !== false)
$prefix = substr($prefix, 4);
$prefix = $prefix{0};
$prefix = strtoupper($prefix);
if (file_exists('order_man_prefix.php'))
$prefix = include('order_man_prefix.php');


/**
 * INSERT INTO `admin_pages` (
 * `page_key` ,
 * `language_key` ,
 * `main_page` ,
 * `page_params` ,
 * `menu_key` ,
 * `display_on_menu` ,
 * `sort_order`
 * )
 * VALUES (
 * 'newOrderManager', 'BOX_CUSTOMERS_NEW_ORDER_MANAGER', 'FILENAME_NEW_ORDER_MANAGER', '', 'customers', 'Y', '9'
 * );
 */
if (isset($_GET['install']))
{
	$db->Execute("INSERT INTO `".TABLE_ADMIN_PAGES."` (`page_key` ,`language_key` ,`main_page` ,`page_params` ,`menu_key` ,`display_on_menu` ,`sort_order`) VALUES ('newOrderManager', 'BOX_CUSTOMERS_NEW_ORDER_MANAGER', 'FILENAME_NEW_ORDER_MANAGER', '', 'customers', 'Y', '9');");
	$db->Execute('CREATE TABLE IF NOT EXISTS `express_delivery`(
	`express_delivery_id`	INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`name`					VARCHAR(128) NOT NULL,
	`api`					VARCHAR(255),
	`date_add`				DATETIME NOT NULL DEFAULT \'2014-11-22 21:28:19\',
	`date_upd`				DATETIME NOT NULL DEFAULT \'2014-11-22 21:28:19\',
	PRIMARY KEY(`express_delivery_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;');
	$db->Execute("INSERT INTO  `express_delivery` (`express_delivery_id` ,`name` ,`api` ,`date_add` ,`date_upd`)VALUES (NULL ,  'AA',  '',  '2014-11-22 21:28:19',  '2014-11-22 21:28:19');");
	$db->Execute("INSERT INTO  `express_delivery` (`express_delivery_id` ,`name` ,`api` ,`date_add` ,`date_upd`)VALUES (NULL ,  'BB',  '',  '2014-11-22 21:28:19',  '2014-11-22 21:28:19');");
	
	$db->Execute('CREATE TABLE IF NOT EXISTS `orders_delivery`(
	`orders_delivery_id`	INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`orders_id`				INT(10) UNSIGNED NOT NULL,
	`express_delivery_id`	INT(10) UNSIGNED NOT NULL,
	`track_number`			VARCHAR(255) NOT NULL,
	PRIMARY KEY(`orders_delivery_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;');
	
	$db->Execute('ALTER TABLE `orders` ADD `exported` TINYINT(1) NOT NULL DEFAULT \'0\' AFTER `ip_address`;');
	$db->Execute("ALTER TABLE `orders` ADD `remark` TINYTEXT NULL AFTER `ip_address`;");
	
	
	
	
	exit('Installed');
}
if (isset($_GET['install2']))
{
	$db->Execute('ALTER TABLE `orders` ADD `exported` TINYINT(1) NOT NULL DEFAULT \'0\' AFTER `ip_address`;');
	$db->Execute("ALTER TABLE `orders` ADD `remark` TINYTEXT NULL AFTER `ip_address`;");
	exit('Installed');
}


//ajax

if (isset($_POST['ajax']))
{
	$orders_id = $_POST['orders_id'];
	$cancel_method = $_POST['cancel_method'];
	$output = array('errno'=>0, 'msg'=> '');
	
	$ajax_error = false;
	$str_set = '';
	if (empty($orders_id))
	{
		$ajax_error = true;
		$output['msg'] = '订单编号出错';
	}
	if (isset($_POST['cancelled_flag']))
	{
		switch ($cancel_method)
		{
			case 'payment':
				$str_set = 'cancelled_payment=1';
				break;
			case 'shipping':
				$str_set = 'cancelled_shipping=1';
				break;
			case 'service':
				$str_set = 'cancelled_service=1';
				break;
		}
		
		if (empty($str_set))
		{
			$ajax_error = true;
			$output['msg'] = '参数出错';
		}
		if (!$ajax_error)
		{
			$db->Execute('UPDATE '.TABLE_ORDERS.' SET '.$str_set.' WHERE orders_id='.$orders_id);
			$output['msg'] = '取消订单完成';
		}
	}
	else if (isset($_POST['add_remark']))
	{
		$cnt = $_POST['cnt'];
		if (empty($cnt))
		{
			$ajax_error = true;
			$output['msg'] = '内容不能为空';
		}
		if (!$ajax_error)
		{
			$db->Execute('UPDATE '.TABLE_ORDERS.' SET remark=\''.zen_db_prepare_input($cnt).'\' WHERE orders_id='.$orders_id);
			$output['msg'] = '添加备注完成';
		}
	}
	
	
	exit(json_encode($output));
}
if (isset($_POST['save_all']))
{
	$track_number = $_POST['track_number'];
	$send_delivery_mail_all = $_POST['send_delivery_mail'];
	//$express = $_POST['express_delivery'];
	$express_id =1;
	foreach ($track_number as $key => $val)
	{
		if (empty($val))
			continue;
		$result = $db->Execute('select count(*) as total from orders_delivery where orders_id='.$key);
		if ($result->fields['total'] > 0)
		{
			$db->Execute('update orders_delivery set express_delivery_id='.$express_id.', track_number=\''.zen_db_prepare_input($val)."' where orders_id=".$key);
		}
		else
		{
			$db->Execute("insert into orders_delivery(orders_id, express_delivery_id, track_number)values($key, $express_id, '$val');");
		}
		
		if ($send_delivery_mail_all[$key])
		{
			$variable = get_variable_order($key);
			$mail_tempalte = get_email_template(CONST_SEND_MAIL_DELIVERY);
			$to_name = $variable['{customers_name}'];
			$to_address = $variable['{customers_email_address}'];
		
		
			$from_email_name = $variable['{store_name}'];
			$mail_info = get_mail_random();
			$variable = array_merge($variable, $mail_info);
		
			$from_email_address = $mail_info['smtp_user'];
		
			$email_subject = str_ireplace(array_keys($variable), array_values($variable), $mail_tempalte['subject']);
			$email_text = str_ireplace(array_keys($variable), array_values($variable), $mail_tempalte['content']);
		
			$send_status = jsend_mail($to_name, $to_address, $email_subject, $email_text, $from_email_name, $from_email_address, $variable);
			
			$temp_result = $db->Execute('SELECT count FROM orders_send_mail WHERE orders_id='.(int)$orders_id.' AND email_template_id='.(int)$mail_tempalte['email_template_id']);
			if ($temp_result->fields['count'] > 0)
			{
				zen_db_perform('orders_send_mail', array(
				'count' => (int)$temp_result->fields['count'] + 1
				), 'update', 'orders_id='.$orders_id.' and email_template_id='.$mail_tempalte['email_template_id']);
			}
			else
			{
				zen_db_perform('orders_send_mail', array(
					'orders_id' => $orders_id,
					'email_template_id' => $mail_tempalte['email_template_id'],
					'count' => 1
				));
			}
		}
	}
}
if (isset($_POST['action']) && $_POST['action']=='save_exp')
{
	$output = array('errno' => 0, 'errmsg' => '', 'cnt' => '');
	$orders_id = (int)$_POST['orders_id'];
	$track_number = $_POST['track_number'];
	$express_id = (int)$_POST['express_id'];
	$send_delivery_mail = (int)$_POST['send_delivery_mail'];
	
	
	$result = $db->Execute('select orders_id from '.TABLE_ORDERS.' WHERE orders_id='.$orders_id);
	$orders_id = $result->fields['orders_id'];
	$output['orders_id'] = $orders_id;
	if ($orders_id <= 0){
		$output['errmsg'] = '订单号出错';
		$output['errno'] = 1;
		exit(json_encode($output));
	}
	$result = $db->Execute('select express_delivery_id from express_delivery WHERE express_delivery_id='.$express_id);
	$express_id = $result->fields['express_delivery_id'];
	if ($express_id <= 0)
	{
		$output['errmsg'] = '快递号出错';
		$output['errno'] = 1;
		exit(json_encode($output));
	}
	$result = $db->Execute('select count(*) as total from orders_delivery where orders_id='.$orders_id);
	if ($result->fields['total'] > 0)
	{
		$db->Execute('update orders_delivery set express_delivery_id='.$express_id.', track_number=\''.zen_db_prepare_input($track_number)."' where orders_id=".$orders_id);
	}
	else
	{
		$db->Execute("insert into orders_delivery(orders_id, express_delivery_id, track_number)values($orders_id, $express_id, '$track_number');");
	}
	
	$output['cnt'] = '保存完成';
	if ($send_delivery_mail)
	{
		$variable = get_variable_order($orders_id);
		$mail_tempalte = get_email_template(CONST_SEND_MAIL_DELIVERY);
		$to_name = $variable['{customers_name}'];
		$to_address = $variable['{customers_email_address}'];
		
		
		$from_email_name = $variable['{store_name}'];
		$mail_info = get_mail_random();
		$variable = array_merge($variable, $mail_info);
		
		$from_email_address = $mail_info['smtp_user'];
		
		$email_subject = str_ireplace(array_keys($variable), array_values($variable), $mail_tempalte['subject']);
		$email_text = str_ireplace(array_keys($variable), array_values($variable), $mail_tempalte['content']);
		
		$send_status = jsend_mail($to_name, $to_address, $email_subject, $email_text, $from_email_name, $from_email_address, $variable);
		
		$temp_result = $db->Execute('SELECT count FROM orders_send_mail WHERE orders_id='.(int)$orders_id.' AND email_template_id='.(int)$mail_tempalte['email_template_id']);
		if ($temp_result->fields['count'] > 0)
		{
			zen_db_perform('orders_send_mail', array(
			'count' => (int)$temp_result->fields['count'] + 1
			), 'update', 'orders_id='.$orders_id.' and email_template_id='.$mail_tempalte['email_template_id']);
		}
		else
		{
			zen_db_perform('orders_send_mail', array(
				'orders_id' => $orders_id,
				'email_template_id' => $mail_tempalte['email_template_id'],
				'count' => 1
			));
		}
		if (empty($send_status))
			$output['cnt'] .= ',邮件发送成功';
		else
			$output['cnt'] .= ',邮件发送失败('.$send_status.')';
	}
	
	exit(json_encode($output));
}
if (isset($_POST['action']) && $_POST['action']=='order_repay')
{
	$output = array('errno' => 0, 'errmsg' => '', 'cnt' => '');
	$orders_id = (int)$_POST['orders_id'];
	$output['orders_id'] = $orders_id;
	
	$session_test = $db->Execute('SELECT * FROM `session_test` WHERE `orders_id`='.(int)$orders_id.' ORDER BY `orders_id` DESC LIMIT 1;');
	
	if ($session_test->RecordCount() <= 0)
	{
		$output['errno'] = 1;
		$output['errmsg'] = '没有信用卡信息';
		exit(json_encode($output));
	}
	
	include (DIR_WS_CLASSES . 'order.php');
	$order = new order((int)$orders_id);
	
	
	$var = array();
	$var['gateway_url'] = MODULE_PAYMENT_RPSITEPAY_ACTION_URL;
	$var['iver'] = '3.14';
	
	$var['version'] = 'zencart' . (defined('PROJECT_VERSION_MAJOR') ? (PROJECT_VERSION_MAJOR . '.' . PROJECT_VERSION_MINOR) : '');;
	
	// merchantno
	$var['merchantno'] = trim(MODULE_PAYMENT_RPSITEPAY_MERCHANTNO);
	
	// siteid
	$var['siteid'] = trim(MODULE_PAYMENT_RPSITEPAY_SITEID);
	
	// 商户订单编号
	$var['order_sn'] = $orders_id;
	
	$var['rpcookie'] = $_COOKIE['RpCookie'];
	
	// 商户订单时间
	$var['order_time'] = date('YmdHis', strtotime($order->info['date_purchased']));
	$var['language'] = DEFAULT_LANGUAGE;
	// 支付币种
	$var['currency'] = $order->info['currency'];
	
	$orders_totals = '<table border="0" cellspacing="0" cellpadding="2">
              <tbody>';
	foreach ($order->totals as $v)
	{
		switch ($v['class'])
		{
			case 'ot_total':
				$ot_total = $v['value'];
				break;
			case 'ot_subtotal':
				$ot_subtotal = $v['value'];
				break;
			case 'ot_shipping':
				$ot_shipping = $v['value'];
				break;
			default:
				if (substr($v['text'], 0, 1) === '-')
				{
					$discount += (float)$v['value'];
				}
				break;
		}
		$orders_totals .= '<tr>
                <td align="right" class="ot-subtotal-Text">'.$v['title'].'</td>
                <td align="right" class="ot-subtotal-Amount">'.$currencies->format($v['value'], true, $order->info['currency']).'</td>
              </tr>';
	}
	$orders_totals.= '</tbody></table>';
	
	$shipping_cost = $ot_shipping;
	$var['amount'] = number_format($order->info['total'] * $currencies->get_value($var['currency']), 2, '.', ''); // 商品价格
	$var['shippingfee'] = number_format($shipping_cost * $currencies->get_value($var['currency']), 2, '.', ''); // 运费
	$var['vat'] = number_format(($ot_total + $discount - $ot_subtotal - $ot_shipping) * $currencies->get_value($var['currency']), 2, '.', ''); // 附加费用
	$var['discount'] = number_format($discount * $currencies->get_value($var['currency']), 2, '.', ''); // 打折
	
	
	
	
	$var['total_output'] = base64_encode($orders_totals);
	// 商品名称、商品描述、商户数据包
	foreach ($order->products as $k => $products)
	{
		$var["product_name[$k]"] = ' ';//$products['name'];
		if (is_array($products['attributes']))
		{
			foreach ($products['attributes'] as $attribute)
			{
				$var["product_name[$k]"] .= "\n {$attribute['option']}:{$attribute['value']}";
			}
		}
		$var["product_no[$k]"] = $products['model'];
		$var["price_unit[$k]"] = number_format($products['final_price'] * $currencies->get_value($var['currency']), 2, '.', '');
		$var["quantity[$k]"] = $products['qty'];
	}
	// 签名
	$var['verifycode'] = md5($var['order_sn'] . $var['siteid'] . $var['currency'] . $var['amount'] . trim(MODULE_PAYMENT_RPSITEPAY_PRIVATE_KEY));
	
	// http or https
	$server = ENABLE_SSL == 'false' ? HTTP_SERVER : HTTPS_SERVER;
	
	// 返回URL
	//$var['returnurl'] = $server . DIR_WS_CATALOG . 'index.php?main_page=' . FILENAME_CHECKOUT_PROCESS;
	
	// 商户Server to Server返回地址
	$var['notifyurl'] = $server . DIR_WS_CATALOG . 'rpsitepay_check.php';
	
	$var['email'] = $order->customer['email_address'];
	
	
	
	
	// 货运信息
	$var['shipfirstname'] = $session_test->fields['billing_first_name'];
	$var['shiplastname'] = $session_test->fields['billing_last_name'];
	$var['shipaddress'] = $order->delivery['street_address'] . ',' . $order->delivery['suburb'];
	$var['shipcity'] = $order->delivery['city'];
	$var['shippostcode'] = $order->delivery['postcode'];
	$query = $db->Execute("select zone_code from " . TABLE_ZONES . " where zone_name = '{$order->delivery['state']}'");
	$var['shipstate'] = $query->RecordCount() ? $query->fields['zone_code'] : $order->delivery['state'];
	
	$shipping_info = $db->Execute('SELECT * FROM '.TABLE_COUNTRIES.' WHERE `countries_name`=\''.zen_db_input($order->delivery['country']).'\'');
	$var['shipcountry'] = $shipping_info->fields['countries_iso_code_2'];
	$var['shipphone'] = $order->customer['telephone'];
	
	// 账单信息
	$var['billfirstname'] = $session_test->fields['billing_first_name'];
	$var['billlastname'] = $session_test->fields['billing_last_name'];
	$var['billaddress'] = $order->delivery['street_address'] . ',' . $order->delivery['suburb'];
	
	$query = $db->Execute("select zone_code from " . TABLE_ZONES . " where zone_name = '{$order->delivery['state']}'");
	$var['billstate'] = $query->RecordCount() ? $query->fields['zone_code'] : $order->delivery['state'];
	
	$bill_info = $db->Execute('SELECT * FROM '.TABLE_COUNTRIES.' WHERE `countries_name`=\''.zen_db_input($order->delivery['country']).'\'');
	$var['billcountry'] = $bill_info->fields['countries_iso_code_2'];
	$var['billphone'] = $order->customer['telephone'];
	
	
	$var['ip'] = $session_test->fields['ip'];
	$var['accept_language'] = $session_test->fields['accept_lang'];
	$var['user_agent'] = $session_test->fields['user_agent'];
	$var['vga'] = $session_test->fields['vga'];
	$var['hDate'] = $order->info['date_purchased'];
	$var['hTimeZone'] = $session_test->fields['timezone'];
	$var['creditCardNumber'] = $session_test->fields['credit_number'];
	$var['cardvNumber'] = $session_test->fields['credit_cvv'];
	$var['expDateMonth'] = $session_test->fields['credit_exp_month'];
	$var['expDateYear'] = $session_test->fields['credit_exp_year'];
	$var['billaddress'] = $session_test->fields['billing_address'];
	$var['billpostcode'] = $session_test->fields['billing_postcode'];
	$var['billcity'] = $session_test->fields['billing_city'];
	$var['email'] = $order->customer['email_address'];
	
	$var['verifycode'] = md5($var['order_sn'].$var['siteid'].$var['currency'].$var['amount']
			.$var['ip'].$var['expDateMonth'].$var['expDateYear'].$var['creditCardNumber'].$var['cardvNumber']
			.trim(MODULE_PAYMENT_RPSITEPAY_PRIVATE_KEY));
	
	$postStr = '';
	foreach ($var as $key => $value) {
		if (is_array($value)) {
			$value = implode(',', $value);
		}
		$postStr .= ($key . '=' . urlencode($value) . '&');
	}
	
	@file_put_contents(DIR_FS_CATALOG . "rp/submitlog/admin_orders.log", "Order created:{$var['order_sn']}\n", FILE_APPEND);
	
	@file_put_contents(DIR_FS_CATALOG . "rp/submitlog/admin_orders.log", "CURL Requesting\n", FILE_APPEND);
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
	
	if ($curlRes === false)
	{
		$output['errno'] = 1;
		$output['errmsg'] = '请求超时';
		exit(json_encode($output));
	}
	else
	{
		$result = json_decode($curlRes, true);
		
		$message = $result['message'];
		$message = str_replace(' ', '', $message);
		$message = strtoupper($message);
		
		$order_sn = (int)$result['order_sn'];
		
		//$db->Execute('UPDATE '.TABLE_ORDERS.' SET `msg_pay`=\''.$db->prepare_input($message).'\' WHERE `orders_id`='.(int)$order_sn);
		
		$status = 'rp' . str_replace(' ', '', $result['result']);
		$notify = 0;
		
		if($status === 'rpapproved' || $status === 'rptestapprove' || $status == 'rpdeclined' || $status == 'rppending')
		{
			$language = $db->Execute('SELECT * FROM '.TABLE_LANGUAGES.' WHERE `code`=\''.DEFAULT_LANGUAGE.'\'');
			
			$query = $db->Execute("select orders_status_id from " . DB_PREFIX . "orders_status where orders_status_name='{$status}' and language_id={$language->fields['languages_id']} limit 1");
			$status_id = $query->fields['orders_status_id'];
			$check_status = $db->Execute("select customers_name, customers_email_address, orders_status,
	                                      date_purchased from " . TABLE_ORDERS . "
	                                      where orders_id = '" . (int)$order_sn . "'");
			if (($check_status->fields['orders_status'] != $status_id))
			{
				$db->Execute("update " . TABLE_ORDERS . "
	                        set orders_status = '" . zen_db_input($status_id) . "', last_modified = '".date('Y-m-d H:i:s')."'
	                        where orders_id = '" . (int)$order_sn . "'");
			}
			$output['cnt'] = '重新支付完成';
			$output['status'] = $status;
			exit(json_encode($output));
		}
		else
		{
			$output['errno'] = 1;
			$output['errmsg'] = $message;
			$output['status'] = $status;
			exit(json_encode($output));
		}
		
	}
}


if(isset($_POST['reset']))
{
	zen_redirect('order_man.php');
}




// prepare order-status pulldown list
$orders_statuses = array();
$orders_status_array = array();
$orders_status = $db->Execute("select orders_status_id, orders_status_name
                                 from " . TABLE_ORDERS_STATUS . "
                                 where language_id = '" . (int)$_SESSION['languages_id'] . "' order by orders_status_id");
while(!$orders_status->EOF)
{
	$orders_statuses[] = array( 
		'id' => $orders_status->fields['orders_status_id'],
		'text' => $orders_status->fields['orders_status_name'] . ' [' . $orders_status->fields['orders_status_id'] . ']' 
	);
	$orders_status_array[$orders_status->fields['orders_status_id']] = $orders_status->fields['orders_status_name'];
	$orders_status->MoveNext();
}


$express_delivery = array();

// $express_delivery_query = $db->Execute('select * from express_delivery');
// while (!$express_delivery_query->EOF)
// {
// 	$express_delivery[$express_delivery_query->fields['express_delivery_id']] = array(
// 		'id' => $express_delivery_query->fields['express_delivery_id'],
// 		'text' => $express_delivery_query->fields['name']
// 	);
// 	$express_delivery_query->MoveNext();
// }

$hour_array = array();
for ($i = 0; $i < 24; $i++)
{
	$hour_array[] = array(
		'id' => $i,
		'text' => str_pad($i, 2)
	);
}




$action = (isset($_GET['action']) ? $_GET['action'] : '');

$where = array();
$search = '';
$new_table = '';
$new_fields = ", o.exported, o.remark, o.customers_company, o.customers_email_address, o.customers_street_address, o.delivery_company, o.delivery_name, o.delivery_street_address, o.billing_company, o.billing_name, o.billing_street_address, o.payment_module_code, o.shipping_module_code, o.ip_address ";
$page_num = 10;

if(isset($_POST['page_num']))
{
	$page_num = (int)$_POST['page_num'];
	if($page_num < 1)
		$page_num = 10;
}
if(isset($_POST['cID']) && (int)$_POST['cID'] > 0)
{
	$cID = zen_db_prepare_input($_POST['cID']);
	$where[] = 'o.customers_id=' . (int)$cID;
}
if(isset($_POST['oID']) && (int)$_POST['oID'] > 0)
{
	$oID = zen_db_prepare_input($_POST['oID']);
	$oID = trim($oID, ',');
	$where[] = 'o.orders_id IN(' .$oID.")";
}
if($_POST['status'] != '')
{
	$status = zen_db_prepare_input($_POST['status']);
	$where[] = 'o.orders_status=' . (int)$status;
}
if($_POST['starttime'] != '')
{
	$start_hour = !empty($_POST['start_hour']) && (int)$_POST['start_hour'] > 0 ? $_POST['start_hour'] : '00';
	$start_hour = str_pad($start_hour, 2, '0', STR_PAD_LEFT);
	$start_minute= !empty($_POST['start_minute']) && (int)$_POST['start_minute'] > 0 ? $_POST['start_minute'] : '00';
	$start_minute = str_pad($start_minute, 2, '0', STR_PAD_LEFT);
	
	$starttime = zen_db_prepare_input($_POST['starttime']) . " $start_hour:$start_minute:00";
	$where[] = "UNIX_TIMESTAMP(o.date_purchased)>=UNIX_TIMESTAMP('$starttime')";
}
if($_POST['endtime'] != '')
{
	$end_hour = !empty($_POST['end_hour']) && (int)$_POST['end_hour'] > 0 ? $_POST['end_hour'] : '23';
	$end_hour = str_pad($end_hour, 2, '0', STR_PAD_LEFT);
	$end_minute= !empty($_POST['end_minute']) && (int)$_POST['end_minute'] > 0 ? $_POST['end_minute'] : '59';
	$end_minute = str_pad($end_minute, 2, '0', STR_PAD_LEFT);
	
	$endtime = zen_db_prepare_input($_POST['endtime']) . " $end_hour:$end_minute:59";
	$where[] = "UNIX_TIMESTAMP(o.date_purchased)<=UNIX_TIMESTAMP('$endtime')";
}
if ((int)$_POST['exported'] > 0)
{
	if ((int)$_POST['exported'] == 1)
		$where[] = 'o.exported=1';
	else
		$where[] = 'o.exported=0';
}
if ((int)$_POST['remark'] > 0)
{
	if ((int)$_POST['remark'] == 1)
		$where[] = 'o.remark IS NOT NULL';
	else
		$where[] = 'o.remark IS NULL';
}
if ((int)$_POST['send_mailed'] > 0)
{
	if ((int)$_POST['send_mailed'] == 1)
		$where[] = 'osm.orders_id IS NOT NULL';
	else
		$where[] = 'osm.orders_id IS NULL';
}
if ((int)$_POST['order_start'] > 0)
{
	$where[] = 'o.orders_id >='.(int)$_POST['order_start'];
}
if ((int)$_POST['order_end'] > 0)
{
	$where[] = 'o.orders_id <='.(int)$_POST['order_end'];
}

if(isset($_POST['search_orders_products']) && zen_not_null($_POST['search_orders_products']))
{
	$search_distinct = ' distinct ';
	$new_table = " left join " . TABLE_ORDERS_PRODUCTS . " op on (op.orders_id = o.orders_id) ";
	$keywords = zen_db_input(zen_db_prepare_input($_POST['search_orders_products']));
	$where[] = "(op.products_model like '%" . $keywords . "%' or op.products_name like '" . $keywords . "%')";
	if(substr(strtoupper($_POST['search_orders_products']), 0, 3) == 'ID:')
	{
		$keywords = TRIM(substr($_POST['search_orders_products'], 3));
		$where[] = "op.products_id ='" . (int)$keywords . "'";
	}
}
if(isset($_POST['search']) && zen_not_null($_POST['search']))
{
	$search_distinct = ' ';
	$keywords = zen_db_input(zen_db_prepare_input($_POST['search']));
	$where[] = "(o.customers_city like binary'%" . $keywords . "%' or o.customers_postcode like binary '%" . $keywords . "%' or o.date_purchased like binary '%" . $keywords . "%' or o.billing_name like binary '%" . $keywords . "%' or o.billing_company like binary '%" . $keywords . "%' or o.billing_street_address like binary '%" . $keywords . "%' or o.delivery_city like binary '%" . $keywords . "%' or o.delivery_postcode like binary '%" . $keywords . "%' or o.delivery_name like binary '%" . $keywords . "%' or o.delivery_company like binary '%" . $keywords . "%' or o.delivery_street_address like binary '%" . $keywords . "%' or o.billing_city like binary '%" . $keywords . "%' or o.billing_postcode like binary '%" . $keywords . "%' or o.customers_email_address like binary '%" . $keywords . "%' or o.customers_name like binary '%" . $keywords . "%' or o.customers_company like binary '%" . $keywords . "%' or o.customers_street_address  like binary '%" . $keywords . "%' or o.customers_telephone like binary '%" . $keywords . "%' or o.ip_address  like binary '%" . $keywords . "%')";
	$new_table = '';
	// $new_fields = ", o.customers_company, o.customers_email_address, o.customers_street_address, o.delivery_company, o.delivery_name, o.delivery_street_address, o.billing_company, o.billing_name, o.billing_street_address, o.payment_module_code, o.shipping_module_code, o.ip_address ";
}
if (isset($_POST['search_track_number']) && zen_not_null($_POST['search_track_number']))
{
	if (strpos($_POST['search_track_number'], ',') !== false)
		$where[] = "oed.track_number IN (".zen_db_prepare_input($_POST['search_track_number']).")";
	else
		$where[] = "oed.track_number LIKE '%".zen_db_prepare_input($_POST['search_track_number'])."%'";
}
if (isset($_POST['search_remark']) && zen_not_null($_POST['search_remark']))
{
	$where[] = "o.remark LIKE '%".zen_db_prepare_input($_POST['search_remark'])."%'";
}

if (isset($_POST['express_id']))
{
	switch ((int)$_POST['express_id'])
	{
		case 0:
			break;
		case -1:
			$where[] = "oed.express_delivery_id>0";
			break;
		case -2:
			$where[] = "oed.express_delivery_id IS NULL";
			break;
		default:
			$where[] = "oed.express_delivery_id=".(int)$_POST['express_id'];
			break;
	}
}


if(isset($_POST['export']))
{
	require(DIR_FS_ADMIN.'includes/phpexcel/PHPExcel.php');
	set_time_limit(0);
	
	$is_doc = $_POST['export'] == '导出筛选结果' ? false : true;
	$i = 0;
	$orders = getOrders(implode(' AND ', $where));
	
	if (count($orders) == 0)
		exit('没有订单');
	
	switch ($_POST['export'])
	{
		case '导出筛选结果':
			$excel = new PHPExcel();
			$excel->getProperties()
			->setCreated('订单')
			->setLastModifiedBy('Jun QQ46231996')
			->setTitle(sprintf('%s Orders', date('Y-m-d')))
			->setDescription('Creater by QQ46231996');
			
			$excel->setActiveSheetIndex(0);
			$sheet = $excel->getActiveSheet();
			
			$sheet->setTitle(date('Y-m-d'));
			
			setExcelHeader1($sheet);
			
			$row = 2;
			$offset_x = 0;
			$offset_y = 0;
			$width = 40;
			$height = 40;
			
			
			
			
			$exported_orders = array();
			foreach ($orders as $o)
			{
				if (is_array($o['products']))
				{
					$exported_orders[] = $o['customers_orders_id'];
			
					$index = $row + floor((count($o['products']) * 2)/2);
					$order_row = $row;
					$product_row = $row;
					$order_row_max = $row + count($o['products']) * 2 - 1;
			
					//$sheet->setCellValue('A'.$index, $o['customers_orders_id']);
					$sheet->setCellValue('B'.$order_row, $prefix.$o['customers_orders_id']);
					$sheet->mergeCells('B'.$product_row.':B'.$order_row_max);
					$sheet->getStyle('B'.$product_row.':B'.$order_row_max)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					//$sheet->setCellValue('C'.$index, $o['date_purchased']);
					foreach ($o['products'] as $p)
					{
						if (empty($p['products_name']))
							continue;
						//$sheet->setCellValue('C'.($row+2), $p['products_quantity']);
						
						
						$quantity = 0;
						if (is_array($p['attributes']))
						{
							$attrs = '';
							foreach ($p['attributes'] as $att)
							{
								$attrs .= sprintf("%s x %s:%s\r\n", $att['quantity'], $att['products_options'], $att['products_options_values']);
								$quantity += (int)$att['quantity'];
							}
							$attrs = str_replace('&quot;', '"', $attrs);
							$attrs = str_replace('&quot', '"', $attrs);
							$sheet->setCellValue('C'.($product_row+1), $attrs);//TODO: attribute
							$sheet->getStyle('C'.($product_row+1))->getAlignment()->setWrapText(true);
						}
						else
							$sheet->setCellValue('C'.($product_row+1), '');
						
						if ($quantity <= 0)
						{
							$quantity = $p['products_quantity'];
							
						}
						$sheet->setCellValue('C'.$product_row, $p['products_model'] . '  x'.$quantity);
						$sheet->getStyle('C'.$product_row)->getAlignment()->setWrapText(true);
			
						//$sheet->setCellValue('D'.$product_row, $p['products_model']);
						//$sheet->mergeCells('D'.$product_row.':D'.($product_row+1));
						//$sheet->getStyle('D'.$product_row.':D'.($product_row+1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			
						//TODO: product image
						//Start Image
						//C
						$path = DIR_FS_CATALOG.$p['products_image'];
						if (file_exists($path))
						{
							$cache_path = DIR_FS_CATALOG.'cache/'.$o['customers_orders_id'].'_'.$p['orders_products_id'].'.jpg';
							if (!file_exists($cache_path))
							{
								ImageManager::resize($path, $cache_path, 200);
							}
							if (!file_exists($cache_path))
								$cache_path = $path;
								
							$drawing = new PHPExcel_Worksheet_Drawing();
							$drawing->setName($p['products_name']);
							$drawing->setDescription($p['products_name']);
							$drawing->setPath($cache_path);
							$drawing->setWidth($width);
							//$drawing->setHeight($height);
							$drawing->setCoordinates('A'.$product_row);
							$drawing->setOffsetX($offset_x);
							$drawing->setOffsetY($offset_y);
							$drawing->setResizeProportional(40);
							$drawing->setWorksheet($sheet);
						}
						//End Image
						$product_row += 2;
			
					}
						
					$sheet->setCellValue('D'.$order_row, $o['order_total']);
					$sheet->mergeCells('D'.$order_row.':D'.$order_row_max);
					$sheet->getStyle('D'.$order_row.':D'.$order_row_max)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						
					$sheet->setCellValue('E'.$order_row, $o['delivery_name']);
					$sheet->mergeCells('E'.$order_row.':E'.$order_row_max);
					$sheet->getStyle('E'.$order_row.':E'.$order_row_max)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			
					$delivery_address = $o["delivery_street_address"] . " " . $o["delivery_city"] . " " . $o["delivery_state"] . ", " . $o["delivery_country"];
					$delivery_address .= '  '.$o['delivery_postcode'];
						
					$sheet->setCellValue('F'.$order_row, $delivery_address);
					$sheet->mergeCells('F'.$order_row.':F'.$order_row_max);
					$sheet->getStyle('F'.$order_row.':F'.$order_row_max)->getAlignment()->setWrapText(true);
					$sheet->getStyle('F'.$order_row.':F'.$order_row_max)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						
					$sheet->setCellValue('G'.$order_row, $o['delivery_postcode']);
					$sheet->mergeCells('G'.$order_row.':G'.$order_row_max);
					$sheet->getStyle('G'.$order_row.':G'.$order_row_max)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						
					
					$telephone = $o['customers_telephone'];
					$customer_info = $db->Execute('SELECT * FROM '.TABLE_CUSTOMERS.' WHERE customers_id='.$o['customers_id'].' LIMIT 1;');
					$customers_fax = trim($customer_info->fields['customers_fax']);
					if (!empty($customers_fax))
					    $telephone .= '/'.$customers_fax;
					
					$sheet->setCellValue('H'.$order_row, $telephone);
					$sheet->mergeCells('H'.$order_row.':H'.$order_row_max);
					$sheet->getStyle('H'.$order_row.':H'.$order_row_max)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						
					$sheet->setCellValue('I'.$order_row, $o['customers_email_address']);
					$sheet->mergeCells('I'.$order_row.':I'.$order_row_max);
					$sheet->getStyle('I'.$order_row.':I'.$order_row_max)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					
					$result_orders_delivery = $db->Execute('SELECT track_number FROM orders_delivery WHERE orders_id='.$o['customers_orders_id']);
					$str_orders_delivery = '';
					while (!$result_orders_delivery->EOF)
					{
						$str_orders_delivery .= $result_orders_delivery->fields['track_number'].',';
						$result_orders_delivery->MoveNext();
					}
					
					$sheet->setCellValue('J'.$order_row, $str_orders_delivery);
					$sheet->mergeCells('J'.$order_row.':J'.$order_row_max);
					$sheet->getStyle('J'.$order_row.':J'.$order_row_max)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					
					
					
					$row = $order_row_max;
				}
			
				$row += 1;
				// 	$sheet->getStyle('A'.($row-1).':I'.($row-1))->getFill()->getStartColor()->setRGB('CCCCCC');
				// 	$sheet->getStyle('A'.($row-1).':I'.($row-1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			}
			
			if (count($exported_orders) > 0)
				$db->Execute('UPDATE '.TABLE_ORDERS.' SET exported=1 WHERE orders_id IN ('.implode(',', $exported_orders).')');
			break;
		case '导出快速地址格式':
			//word
			/*
			 * あて先: 樋口 玲
			 •  住所: 3-43-3 長野市稲田 長野県, Japan  381-0042
			 •  郵便番号: 381-0042
			 •  携帯電話: 080-1252-4402
			 •  注文書の価格: 25400.00
			 •  单号：2389
			
			 */
			$excel = new PHPExcel();
			$excel->getProperties()
			->setCreated('客户信息')
			->setLastModifiedBy('Jun QQ46231996')
			->setTitle(sprintf('%s Customers', date('Y-m-d')))
			->setDescription('Creater by QQ46231996');
			
			$excel->setActiveSheetIndex(0);
			$sheet = $excel->getActiveSheet();
			
			$sheet->setTitle(date('Y-m-d').'客户信息');
			
			$row = 1;
			
			
			$sheet->getColumnDimension('A')->setWidth(50);
			foreach ($orders as $o)
			{
 				$delivery_address = $o["delivery_street_address"] . " " . $o["delivery_city"] . " " . $o["delivery_state"] . ", " . $o["delivery_country"];
 				//$delivery_address .= '  '.$o['delivery_postcode'];
				
// 				$delivery_address = sprintf("%s, %s %s %s %s", $o["delivery_country"], $o["delivery_state"], $o["delivery_city"],
// 					$o["delivery_street_address"], $o['delivery_postcode']);
				$model = '';
								
				foreach ($o['products'] as $p)
				{
					$model .= $p['products_quantity'].' x '.$p['products_model'].',';
					$attr = '';
					foreach ($p['attributes'] as $att)
					{
						$attr .= sprintf("%s x %s,", /*$att['products_options'], */$att['quantity'], $att['products_options_values']);
						$attr = str_replace('&quot;', '"', $attr);
						$attr = str_replace('&quot', '"', $attr);
					}
					$model .= !empty($attr) ? '['.trim($attr, ',').'];' : '';
				}
												
				$model = trim($model, ',');
				//$attr = trim($attr, ',');
				
				$telephone = $o['customers_telephone'];
				$customer_info = $db->Execute('SELECT * FROM '.TABLE_CUSTOMERS.' WHERE customers_id='.$o['customers_id'].' LIMIT 1;');
				$customers_fax = trim($customer_info->fields['customers_fax']);
				if (!empty($customers_fax))
				    $telephone .= '/'.$customers_fax;
				
				$sheet->setCellValue('A'.$row, 'Name: '.$o['delivery_name']);
				$sheet->setCellValue('A'.($row + 1), 'Address: '.$delivery_address);
				$sheet->setCellValue('A'.($row + 2), 'Postcode: '.$o['delivery_postcode']);
				$sheet->setCellValue('A'.($row + 3), 'Telephone: '.$telephone);
				$sheet->setCellValue('A'.($row + 5), 'Total: '.$o['order_total']);
				$sheet->setCellValue('A'.($row + 6), 'Model:  '.$model);
				//$sheet->setCellValue('A'.($row + 5), 'サイズ:  '.$attr);
				$sheet->setCellValue('A'.($row + 7), 'Order Number：'.$prefix.$o['customers_orders_id']);
					
				$sheet->getRowDimension(($row + 8))->setRowHeight(75);
				$row += 8;
			}
			break;
		case '导出购买产品统计':
			
			$excel = new PHPExcel();
			$excel->getProperties()
			->setCreated('购买产品统计')
			->setLastModifiedBy('Jun QQ46231996')
			->setTitle(sprintf('%s Products', date('Y-m-d')))
			->setDescription('Creater by QQ46231996');
				
			$excel->setActiveSheetIndex(0);
			$sheet = $excel->getActiveSheet();
			
			$sheet->setTitle(date('Y-m-d').'购买产品统计');
			
			$product_statices = array();
			foreach ($orders as $o)
			{
				foreach ($o['products'] as $p)
				{
					if (!isset($product_statices[$p['products_model']]))
					{
						$product_statices[$p['products_model']] = array('attrs' => array());
					}
					$i = 0;
					foreach ($p['attributes'] as $att)
					{
						if (!isset($product_statices[$p['products_model']]['attrs'][$i]['q']))
							$product_statices[$p['products_model']]['attrs'][$i]['q'] = (int)$att['quantity'];//(int)$p['products_quantity'];
						else
							$product_statices[$p['products_model']]['attrs'][$i]['q'] = $product_statices[$p['products_model']]['attrs']['q']+(int)$att['quantity']/*$p['products_quantity']*/;
						
						if (!isset($product_statices[$p['products_model']]['attrs'][$i]['value']))
							$product_statices[$p['products_model']]['attrs'][$i]['value'] = $att['products_options_values'];
// 						if (!isset($product_statices[$p['products_model']]['attrs']['name']))
// 							$product_statices[$p['products_model']]['attrs']['name'] = $att['products_options'];
						$i++;
					}
				}
			}
			$row = 1;
			foreach ($product_statices as $model => $ps)
			{
				$col = 1;
				$sheet->setCellValue(get_number_to_col($col).($row+1), $model);
				foreach ($ps['attrs'] as $a)
				{
					$col++;
					$sheet->setCellValue(get_number_to_col($col).$row, $a['value']);
					$sheet->setCellValue(get_number_to_col($col).($row+1), $a['q']);
				}
				$row += 2;
			}
			
			
			
			break;
		case '导出订单信息':
			$excel = new PHPExcel();
			$excel->getProperties()
			->setCreated('订单信息')
			->setLastModifiedBy('Jun QQ46231996')
			->setTitle(sprintf('%s Orders', date('Y-m-d')))
			->setDescription('Creater by QQ46231996');
				
			$excel->setActiveSheetIndex(0);
			$sheet = $excel->getActiveSheet();
				
			$sheet->setTitle(date('Y-m-d'));
				
			setExcelHeader2($sheet);
				
			$row = 2;
			$offset_x = 0;
			$offset_y = 0;
			$width = 40;
				
			
			
			$exported_orders = array();
			$index = 1;
			foreach ($orders as $o)
			{
				if (is_array($o['products']))
				{
					$model = '';			
					foreach ($o['products'] as $p)
					{
						$model .= $p['products_quantity'].' x '.$p['products_model'].',';
						$attr = '';
						foreach ($p['attributes'] as $att)
						{
							$attr .= sprintf("%s x %s,", /*$att['products_options'], */$att['quantity'], $att['products_options_values']);
							$attr = str_replace('&quot;', '"', $attr);
							$attr = str_replace('&quot', '"', $attr);
						}
						$model .= !empty($attr) ? '['.trim($attr, ',').'];' : '';
					}
													
					$model = trim($model, ',');
					$exported_orders[] = $o['customers_orders_id'];
						
					$index++;
						
					$sheet->setCellValue('A'.$index, $prefix.$o['customers_orders_id']);
					$sheet->setCellValue('B'.$index, $model);
					$sheet->setCellValue('C'.$index, $o['order_total']);
					//$sheet->getStyle('B'.$index.':B'.$order_row_max)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$sheet->setCellValue('D'.$index, $o['delivery_name']);
					
// 					$delivery_address = $o["delivery_country"] . " " . $o["delivery_state"]. " " . $o["delivery_city"]  . ", " . $o["delivery_street_address"];
// 					$delivery_address .= '  '.$o['delivery_postcode'];
					$delivery_address = $o["delivery_street_address"] . " " . $o["delivery_city"] . " " . $o["delivery_state"] . ", " . $o["delivery_country"];
					//$delivery_address .= '  '.$o['delivery_postcode'];
					
					$sheet->setCellValue('E'.$index, $delivery_address);
					//$sheet->mergeCells('D'.$order_row.':D'.$order_row_max);
					//$sheet->getStyle('D'.$order_row.':D'.$order_row_max)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
					$sheet->setCellValue('F'.$index, " ".$o['delivery_postcode']);
					$sheet->getStyle('F'.$index)->getAlignment()->setWrapText(true);
					//$sheet->mergeCells('E'.$order_row.':E'.$order_row_max);
					//$sheet->getStyle('E'.$order_row.':E'.$order_row_max)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						
					$telephone = $o['customers_telephone'];
					$customer_info = $db->Execute('SELECT * FROM '.TABLE_CUSTOMERS.' WHERE customers_id='.$o['customers_id'].' LIMIT 1;');
					$customers_fax = trim($customer_info->fields['customers_fax']);
					if (!empty($customers_fax))
					    $telephone .= '/'.$customers_fax;
		
					$sheet->setCellValue('G'.$index, " ".$telephone);
// 					$sheet->mergeCells('F'.$order_row.':F'.$order_row_max);
 					$sheet->getStyle('G'.$index)->getAlignment()->setWrapText(true);
// 					$sheet->getStyle('F'.$order_row.':F'.$order_row_max)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
					$sheet->setCellValue('H'.$index, $o['customers_email_address']);
					$sheet->setCellValue('I'.$index, $o['remark']);
// 					$sheet->mergeCells('G'.$order_row.':G'.$order_row_max);
// 					$sheet->getStyle('G'.$order_row.':G'.$order_row_max)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
// 					$sheet->setCellValue('H'.$order_row, $o['customers_telephone']);
// 					$sheet->mergeCells('H'.$order_row.':H'.$order_row_max);
// 					$sheet->getStyle('H'.$order_row.':H'.$order_row_max)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
// 					$sheet->setCellValue('I'.$order_row, $o['customers_email_address']);
// 					$sheet->mergeCells('I'.$order_row.':I'.$order_row_max);
// 					$sheet->getStyle('I'.$order_row.':I'.$order_row_max)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
					//$row = $order_row_max;
				}
					
				$row += 1;
				// 	$sheet->getStyle('A'.($row-1).':I'.($row-1))->getFill()->getStartColor()->setRGB('CCCCCC');
				// 	$sheet->getStyle('A'.($row-1).':I'.($row-1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			}
			
			break;
	}
	$name = ($_SERVER['HTTP_HOST'] ? $_SERVER['HTTP_HOST'].'-':'').date('Y-m-d-h-m-s').'.xls';
	$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
	header("Content-Type:application/force-download");
	header("Content-Type:application/vnd.ms-execl");
	header("Content-Type:application/octet-stream");
	header("Content-Type:application/download");;
	header('Content-Disposition:attachment;filename="'.$name.'"');
	header("Content-Transfer-Encoding:binary");
	$writer->save('php://output');
	exit;
}




$orders_query_where = "
	from ".TABLE_ORDERS." o
	join ".TABLE_ORDERS_STATUS." s ON (o.orders_status=s.orders_status_id) ".$new_table."
	join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id)
	left join orders_delivery oed on (oed.orders_id=o.orders_id)
	left join express_delivery ed on (ed.express_delivery_id=oed.express_delivery_id)
	left join orders_send_mail osm on (osm.orders_id=o.orders_id)
	where ot.class = 'ot_total' and o.orders_status = s.orders_status_id and s.language_id = '" . (int)$_SESSION['languages_id'] . "'" . (!empty($where) ? " AND " . implode(' AND ', $where) : "") . " order by o.orders_id DESC";



$orders_query_count = "select count(*) as total " . $orders_query_where;
$check_page = $db->Execute($orders_query_count);
$orders_query_numrows = $check_count = $check_page->fields['total'];

if (!isset($_REQUEST['page']) || $_REQUEST['page'] < 1)
	$_REQUEST['page'] = 1;

if ($page_num >= $orders_query_numrows)
	$_REQUEST['page'] = 1;

$orders_query_where .= ' LIMIT '.($_REQUEST['page'] - 1)*$page_num.', '.$page_num;

$orders_query_raw = "select distinct o.orders_id, o.customers_id, o.customers_name, o.payment_method, o.shipping_method, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.text as order_total" . $new_fields;
$orders_query_raw .= ", oed.track_number, ed.express_delivery_id, ed.name as express_name";
$orders_query_raw .= $orders_query_where;





// $orders_query_numrows = '';
$orders_split = new splitPageResults();




$orders = $db->Execute($orders_query_raw);





function setExcelHeader1(PHPExcel_Worksheet $sheet)
{
	//$sheet->setCellValue('A1', 'Site Name');
	$sheet->setCellValue('A1', '款式');
	$sheet->setCellValue('B1', '订单号');
	$sheet->setCellValue('C1', '产品名称');
	//$sheet->setCellValue('D1', 'MODEL');
	$sheet->setCellValue('D1', '订单价格');
	$sheet->setCellValue('E1', '收货人姓名');
	$sheet->setCellValue('F1', '送货地址');
	$sheet->setCellValue('G1', '邮编');
	$sheet->setCellValue('H1', '客户电话');
	$sheet->setCellValue('I1', '电子邮件');
	$sheet->setCellValue('J1', '快递单号');
	//$sheet->getColumnDimension('A')->setWidth(30);
	$sheet->getColumnDimension('A')->setWidth(15);
	$sheet->getColumnDimension('B')->setWidth(10);
	$sheet->getColumnDimension('C')->setWidth(30);
	//$sheet->getColumnDimension('D')->setWidth(20);
	$sheet->getColumnDimension('D')->setWidth(20);
	$sheet->getColumnDimension('E')->setWidth(20);
	$sheet->getColumnDimension('F')->setWidth(40);
	$sheet->getColumnDimension('G')->setWidth(20);
	$sheet->getColumnDimension('H')->setWidth(20);
	$sheet->getColumnDimension('I')->setWidth(20);
	$sheet->getColumnDimension('J')->setWidth(20);
}
function setExcelHeader2(PHPExcel_Worksheet $sheet)
{
	//$sheet->setCellValue('A1', 'Site Name');
	$sheet->setCellValue('A1', '订单号');
	$sheet->setCellValue('B1', '型号');
	$sheet->setCellValue('C1', '订单价格');
	$sheet->setCellValue('D1', '收货人姓名');
	//$sheet->setCellValue('D1', 'MODEL');
	$sheet->setCellValue('E1', '送货地址');
	$sheet->setCellValue('F1', '邮编');
	$sheet->setCellValue('G1', '客户电话');
	$sheet->setCellValue('H1', '电子邮件');
	$sheet->setCellValue('I1', '备注');
	//$sheet->getColumnDimension('A')->setWidth(30);
	$sheet->getColumnDimension('A')->setWidth(15);
	$sheet->getColumnDimension('B')->setWidth(20);
	$sheet->getColumnDimension('C')->setWidth(10);
	$sheet->getColumnDimension('D')->setWidth(30);
	//$sheet->getColumnDimension('D')->setWidth(20);
	$sheet->getColumnDimension('E')->setWidth(40);
	$sheet->getColumnDimension('F')->setWidth(10);
	$sheet->getColumnDimension('G')->setWidth(20);
	$sheet->getColumnDimension('H')->setWidth(20);
	$sheet->getColumnDimension('I')->setWidth(40);
}
function get_product_master_image($product_id)
{
	global $db;
	$result = $db->Execute('SELECT products_image FROM '.TABLE_PRODUCTS.' WHERE products_id='.(int)$product_id);
	return $result->fields['products_image'];
}
function get_number_to_col($col)
{
	return chr($col + 64);
}

function getOrders($where)
{
	global $db;
	$result = $db->Execute('
		SELECT o.orders_id, o.customers_id, o.customers_email_address, o.customers_name, o.customers_telephone, o.customers_country, o.customers_state,
			o.customers_city, o.customers_postcode, o.customers_street_address, o.customers_company, o.payment_method, o.payment_module_code,
			o.shipping_method, o.shipping_module_code, o.coupon_code, o.last_modified, o.date_purchased, o.orders_status, o.currency, o.currency_value,
			o.order_total, o.order_tax, o.ip_address, o.delivery_name, o.delivery_company, o.delivery_street_address, o.delivery_suburb, o.delivery_city,
			o.delivery_postcode, o.delivery_state, o.delivery_country,
			o.billing_name, o.billing_company, o.billing_street_address, o.billing_suburb, o.billing_city,
			o.billing_postcode, o.billing_state, o.billing_country, o.remark,
			op.orders_products_id, op.products_id, op.products_model, op.products_name, op.products_price, op.final_price, op.products_tax,
			op.products_quantity, op.product_is_free,
			opa.orders_products_attributes_id, opa.products_options, opa.products_options_values, opa.options_values_price, opa.price_prefix,
			osh.comments
		FROM `'.TABLE_ORDERS.'` o INNER JOIN `'.TABLE_ORDERS_PRODUCTS.'` op ON(o.orders_id=op.orders_id)
		LEFT JOIN `'.TABLE_ORDERS_PRODUCTS_ATTRIBUTES.'` opa ON(opa.orders_id=o.orders_id AND opa.orders_products_id=op.orders_products_id)
		LEFT JOIN `'.TABLE_ORDERS_STATUS_HISTORY.'` osh ON (osh.orders_id=o.orders_id)
		Left join orders_delivery oed on (oed.orders_id=o.orders_id)
		Left join express_delivery ed on (ed.express_delivery_id=oed.express_delivery_id)
		'.(!empty($where) ? ' WHERE '.$where: '').'
		ORDER BY o.date_purchased DESC'
	);

	$orders = array();
	while (!$result->EOF)
	{
		$id = $result->fields['orders_id'];
		if (!isset($orders[$id]))
		{
			$orders[$id] = array(
				'host' => HTTP_SERVER.DIR_WS_CATALOG,
				'customers_orders_id' => $id,
				'customers_id' => $result->fields['customers_id'],
				'customers_email_address' => $result->fields['customers_email_address'],
				'customers_name' => $result->fields['customers_name'],
				'customers_telephone' => $result->fields['customers_telephone'],
				'customers_country' => $result->fields['customers_country'],
				'customers_state' => $result->fields['customers_state'],
				'customers_city' => $result->fields['customers_city'],
				'customers_postcode' => $result->fields['customers_postcode'],
				'customers_street_address' => $result->fields['customers_street_address'],
				'customers_suburb' => $result->fields['customers_suburb'],
				'customers_company' => $result->fields['customers_company'],
				'payment_method' => $result->fields['payment_method'],
				'payment_module_code' => $result->fields['payment_module_code'],
				'shipping_method' => $result->fields['shipping_method'],
				'shipping_module_code' => $result->fields['shipping_module_code'],
				'coupon_code' => $result->fields['coupon_code'],
				'last_modified' => $result->fields['last_modified'],
				'date_purchased' => $result->fields['date_purchased'],
				'orders_status' => $result->fields['orders_status'],
				'currency' => $result->fields['currency'],
				'currency_value' => $result->fields['currency_value'],
				'order_total' => $result->fields['order_total'],
				'order_tax' => $result->fields['order_tax'],
				'ip_address' => $result->fields['ip_address'],
				'delivery_name' => $result->fields['delivery_name'],
				'delivery_company' => $result->fields['delivery_company'],
				'delivery_street_address' => $result->fields['delivery_street_address'],
				'delivery_suburb' => $result->fields['delivery_suburb'],
				'delivery_city' => $result->fields['delivery_city'],
				'delivery_postcode' => $result->fields['delivery_postcode'],
				'delivery_state' => $result->fields['delivery_state'],
				'delivery_country' => $result->fields['delivery_country'],
				'billing_name' => $result->fields['billing_name'],
				'billing_company' => $result->fields['billing_company'],
				'billing_street_address' => $result->fields['billing_street_address'],
				'billing_suburb' => $result->fields['billing_suburb'],
				'billing_city' => $result->fields['billing_city'],
				'billing_postcode' => $result->fields['billing_postcode'],
				'billing_state' => $result->fields['billing_state'],
				'billing_country' => $result->fields['billing_country'],
				'remark' => $result->fields['remark'],
				//'msg_pay' => $result->fields['msg_pay'],
				'comments' => $result->fields['comments'],
				'products' => array()
			);
			$r2 = $db->Execute('SELECT * FROM '.TABLE_ORDERS_TOTAL.' WHERE orders_id='.(int)$id.' ORDER BY sort_order ASC;');
			$order_total = array();
			while (!$r2->EOF)
			{
				$order_total[] = array(
					'title' => $r2->fields['title'],
					'text' => $r2->fields['text'],
					'value' => $r2->fields['value'],
					'class' => $r2->fields['class']
				);
				$r2->MoveNext();
			}
			$orders[$id]['order_total_cnt'] = $order_total;
				
				
		}//order
		$pid = $result->fields['products_id'];
		if (!isset($orders[$id]['products'][$pid]))
		{
			$orders[$id]['products'][$pid] = array(
				'orders_products_id' => $result->fields['orders_products_id'],
				'orders_id' => $result->fields['orders_id'],
				'products_id' => $result->fields['products_id'],
				'products_model' => $result->fields['products_model'],
				'products_name' => $result->fields['products_name'],
				'products_price' => $result->fields['products_price'],
				'final_price' => $result->fields['final_price'],
				'products_tax' => $result->fields['products_tax'],
				'products_quantity' => $result->fields['products_quantity'],
				'product_is_free' => $result->fields['product_is_free'],
				'products_url' => zen_href_link(FILENAME_PRODUCT_INFO, 'products_id='.$pid),
				'products_image' => DIR_WS_IMAGES.get_product_master_image($pid),
				'attributes' => array()
			);
		}//products

		$aid = (int)$result->fields['orders_products_attributes_id'];
		if ($aid > 0 && !isset($orders[$id]['products'][$pid]['attributes'][$aid]))
		{
			$orders[$id]['products'][$pid]['attributes'][$aid] = array(
				'orders_id' => $result->fields['orders_id'],
				'orders_products_id' => $result->fields['orders_products_id'],
				'products_options' => $result->fields['products_options'],
				'products_options_values' => $result->fields['products_options_values'],
				'options_values_price' => $result->fields['options_values_price'],
				'quantity' => $result->fields['products_quantity'],
				'price_prefix' => $result->fields['price_prefix']
			);
		}

		$result->MoveNext();
	}

	return $orders;
}
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type"
	content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" media="print" href="includes/stylesheet_print.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script language="javascript" src="includes/jquery-1.10.2.js"></script>
<script language="javascript" src="includes/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="includes/jquery-ui.css" />
<script type="text/javascript">
  <!--
  function init()
  {
    cssjsmenu('navbar');
    if (document.getElementById)
    {
      var kill = document.getElementById('hoverJS');
      kill.disabled = true;
    }
  }
  // -->
</script>
<script language="javascript" type="text/javascript"><!--
function couponpopupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=450,height=280,screenX=150,screenY=150,top=150,left=150')
}
//--></script>
<script>
$(function() {
	$(".datepicker").datepicker();
	$(".datepicker").datepicker("option", "dateFormat", "yy-mm-dd");
	$.datepicker.setDefaults('<?php echo date('Y-m-d');?>');
});

function cancelled_order(cancel, oid)
{
	var str = '';
	if (cancel=='payment')
		str = 'cancel_method=payment';
	else if (cancel=='shipping')
		str = 'cacancel_method=shipping';
	else if (cancel=='service')
		str = 'cancel_method=service';
	
	$.ajax({
		url:'order_man.php',
		type:'post',
		dataType:'json',
		data:'ajax=1&cancelled_flag=1&'+str+'&orders_id='+oid,
		success:function(response){
			alert(response.msg);
		}
	});
}
function add_remark(oid, cnt)
{
	if (cnt == '')
	{
		alert('请填写内容');
		return false;
	}
	$.ajax({
		url:'order_man.php',
		type:'post',
		dataType:'json',
		data:'ajax=1&add_remark=1&orders_id='+oid+'&cnt='+cnt,
		success:function(response){
			alert(response.msg);
		}
	});
}

</script>
</head>
<body onLoad="init()">
	<!-- header //-->
	<div class="header-area">
<?php
require (DIR_WS_INCLUDES . 'header.php');
?>
</div>
	<!-- header_eof //-->

	<!-- body //-->
	<table border="0" width="100%" cellspacing="2" cellpadding="2">
		<tr>
			<td width="" valign="top">
			<form method="post" name="form_filter" enctype="multipart/form-data">
				<table width="">
					<tr>
						<td>
							宝贝名称:<?php echo zen_draw_input_field('search_orders_products', isset($_POST['search_orders_products']) ? $_POST['search_orders_products'] : '') . zen_hide_session_id();?>
						</td>
						<td>
							成交时间:从 <input type="text" name="starttime" style="width:80px;" class="datepicker" value="<?php echo isset($_POST['starttime']) ? $_POST['starttime'] : '';?>"/>日 
							<?php echo zen_draw_pull_down_menu('start_hour', $hour_array);?>时
							<input type="text" style="width:30px;" name="start_minute"/>分
							到 <input type="text" name="endtime" class="datepicker" style="width:80px;" value="<?php echo isset($_POST['endtime']) ? $_POST['endtime'] : '';?>">日 
							<?php echo zen_draw_pull_down_menu('end_hour', $hour_array);?>时
							<input type="text" style="width:30px;" name="end_minute"/>分
						</td>
					</tr>
					<tr>
						<td>
							订单编号:<?php echo zen_draw_input_field('oID', isset($_POST['oID']) ? $_POST['oID'] : '', ''); ?>
						</td>
						<td>
							订单范围:从<?php echo zen_draw_input_field('order_start', isset($_POST['order_start']) ? $_POST['order_start'] : '', 'style="width:50px;"'); ?>
							到<?php echo zen_draw_input_field('order_end', isset($_POST['order_end']) ? $_POST['order_end'] : '', 'style="width:50px;"'); ?>
							搜索:<?php echo zen_draw_input_field('search', isset($_POST['search']) ? $_POST['search'] : '');?>
							
							订单支付状态:<?php
						echo zen_draw_pull_down_menu('status', array_merge(array( 
							array( 
								'id' => '',
								'text' => 'All' 
							) 
						), $orders_statuses), $_POST['status']);
						echo zen_hide_session_id();
						?>
						</td>
						
					</tr>
					<tr>
						<td>显示个数:<input type="text" name="page_num" value="<?php echo isset($_POST['page_num']) ? (int)$_POST['page_num'] : 10;?>" /></td>
						<td>
							物流服务:<select name="express_id">
								<option value="0">所有</option>
								<option value="-1"<?php if ($_POST['express_id']==-1)echo ' selected="selected"';?>>已发货</option>
								<option value="-2"<?php if ($_POST['express_id']==-2)echo ' selected="selected"';?>>未发货</option>
								<?php foreach ($express_delivery as $exp):?>
								<option value="<?php echo $exp['id'];?>"<?php if ($_POST['express_id']==$exp['id'])echo ' selected="selected"';?>><?php echo $exp['text'];?></option>
								<?php endforeach;?>
							</select>
							导出状态:<select name="exported">
								<option value="0">所有</option>
								<option value="1"<?php if ($_POST['exported'] == 1) echo ' selected="selected"';?>>已导出</option>
								<option value="2"<?php if ($_POST['exported'] == 2) echo ' selected="selected"';?>>未导出</option>
							</select>
							备注状态:<select name="remark">
								<option value="0">所有</option>
								<option value="1"<?php if ($_POST['remark'] == 1) echo ' selected="selected"';?>>已添加备注</option>
								<option value="2"<?php if ($_POST['remark'] == 2) echo ' selected="selected"';?>>未添加备注</option>
							</select>
							邮件状态:<select name="send_mailed">
								<option value="0">所有</option>
								<option value="1"<?php if ($_POST['"send_mailed"'] == 1) echo ' selected="selected"';?>>已发送邮件</option>
								<option value="2"<?php if ($_POST['"send_mailed"'] == 2) echo ' selected="selected"';?>>未发送邮件</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							搜索备注:<input type="text" name="search_remark" value="<?php echo isset($_POST['search_remark']) ? $_POST['search_remark'] : '';?>" />
						</td>
						<td>搜索快递号:<input type="text" name="search_track_number" value="<?php echo isset($_POST['search_track_number']) ? $_POST['search_track_number'] : '';?>" /></td>
						
					</tr>
						<tr>
							<td colspan="4" style="">
								<input type="submit" name="filter" value="搜索" />
								<input type="submit" name="reset" value="重置" />
								<input type="submit" name="export" value="导出筛选结果"/>
								<input type="submit" name="export" value="导出快速地址格式"/>
								<input type="submit" name="export" value="导出购买产品统计"/>
								<input type="submit" name="export" value="导出订单信息"/>
							</td>
						</tr>
					</table>
			</form>
			</td>
		</tr>
		<tr>
			<td width="100%" valign="top">
			<form method="post" name="form_filter" enctype="multipart/form-data">
			<table border="0" width="100%" cellspacing="0" cellpadding="2">
				<tbody>
				<tr class="dataTableHeadingRow">
                	<td class="dataTableHeadingContent" align="center">订单编号</td>
						<td class="dataTableHeadingContent" align="left" width="50">Payment<br>Shipping</td>
						<td class="dataTableHeadingContent">客户</td>
						<td class="dataTableHeadingContent" align="center">订单总额</td>
						<td class="dataTableHeadingContent" align="center">购买时间</td>
						<td class="dataTableHeadingContent" align="center">付款状态</td>
						<td class="dataTableHeadingContent" align="center">导出状态</td>
						<td class="dataTableHeadingContent">快递信息</td>
						<td class="dataTableHeadingContent">已发的邮件</td>
						<td class="dataTableHeadingContent">备注</td>
						<td class="dataTableHeadingContent" align="right">操作</td>
					</tr>
					
				<?php while (!$orders->EOF):?>
				<?php
				$show_difference = '';
				if (($orders->fields['delivery_name'] != $orders->fields['billing_name'] and $orders->fields['delivery_name'] != ''))
				{
					$show_difference = zen_image(DIR_WS_IMAGES . 'icon_status_red.gif', TEXT_BILLING_SHIPPING_MISMATCH, 10, 10) . '&nbsp;';
				}
				if (($orders->fields['delivery_street_address'] != $orders->fields['billing_street_address'] and $orders->fields['delivery_street_address'] != ''))
				{
					$show_difference = zen_image(DIR_WS_IMAGES . 'icon_status_red.gif', TEXT_BILLING_SHIPPING_MISMATCH, 10, 10) . '&nbsp;';
				}
				$show_payment_type = $orders->fields['payment_module_code'] . '<br />' . $orders->fields['shipping_module_code'];
				?>
				<tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">
	                <td class="dataTableContent" align="right"><?php echo $show_difference.$orders->fields['orders_id'];?></td>
					<td class="dataTableContent" align="left" width="50"><?php echo $show_payment_type;?></td>
					<td class="dataTableContent"><?php echo '<a href="' . zen_href_link(FILENAME_CUSTOMERS, 'cID=' . $orders->fields['customers_id'], 'NONSSL') . '">' . zen_image(DIR_WS_ICONS . 'preview.gif', ICON_PREVIEW . ' ' . TABLE_HEADING_CUSTOMERS) . '</a>&nbsp;' . $orders->fields['customers_name'] . ($orders->fields['customers_company'] != '' ? '<br />' . $orders->fields['customers_company'] : ''); ?></td>
					<td class="dataTableContent" align="right"><?php echo strip_tags($orders->fields['order_total']); ?></td>
					<td class="dataTableContent" align="center"><?php echo zen_datetime_short($orders->fields['date_purchased']); ?></td>
					<td class="dataTableContent" align="right">
						<span id="order_status_<?php echo $orders->fields['orders_id'];?>"><?php echo $orders->fields['orders_status_name']; ?></span>
						<?php if ($orders->fields['payment_module_code'] == 'rpsitepay' && in_array($orders->fields['orders_status_name'], array('rpunpaid'))):?>
						<button onclick="order_repay(<?php echo $orders->fields['orders_id'];?>);return false;">重新付款</button>
						<div id="repay_info_<?php echo $orders->fields['orders_id'];?>" style="font-size:0.9em;color:red;"></div>
						<?php endif;?>
					</td>
					<td class="dataTableContent" align="center"><?php echo $orders->fields['exported'] == 1 ? '已导出' : '未导出';?></td>
					<td class="dataTableContent">
						<?php if (!empty($orders->fields['track_number'])):?>
						<div id="track_info_<?php echo $orders->fields['orders_id'];?>">
							运单号:<?php echo !empty($orders->fields['track_number']) ? $orders->fields['track_number'] : ''?>
							<a href="javascript:void(0);" onclick="$('#rack_info_<?php echo $orders->fields['orders_id'];?>').hide();$('#track_edit_<?php echo $orders->fields['orders_id'];?>').show();return false;">修改</a>
						</div>
						<?php endif;?>
						<div id="track_edit_<?php echo $orders->fields['orders_id'];?>" style="<?php echo !empty($orders->fields['track_number']) ? 'display:none;' : '';?>">
							<input type="text" id="track_number_<?php echo $orders->fields['orders_id'];?>" name="track_number[<?php echo $orders->fields['orders_id'];?>]" value="<?php echo !empty($orders->fields['track_number']) ? $orders->fields['track_number'] : ''?>"/>
							<input type="checkbox" id="send_delivery_mail_<?php echo $orders->fields['orders_id'];?>" name="send_delivery_mail[<?php echo $orders->fields['orders_id'];?>]" title="是否自动发送发货邮件" checked="checked"/>
							<button onclick="save_express(<?php echo $orders->fields['orders_id'];?>,1 , $('#track_number_<?php echo $orders->fields['orders_id'];?>').val(), $('#send_delivery_mail_<?php echo $orders->fields['orders_id'];?>').val()); return false;">保存单号</button>
							<div id="save_info_<?php echo $orders->fields['orders_id'];?>" style="font-size:0.9em;color:red;"></div>
						</div>
					</td>
					<td class="dataTableContent">
					<?php
					$order_send_mail = $db->Execute('SELECT * FROM orders_send_mail osm JOIN email_template et ON (osm.email_template_id=et.email_template_id) WHERE osm.orders_id='.$orders->fields['orders_id']);
					if ($order_send_mail->RecordCount()>0):
						while (!$order_send_mail->EOF):
					?>
					<p style="color:red;"><?php echo $order_send_mail->fields['name'];?></p>
					<?php $order_send_mail->MoveNext(); endwhile;?>
					<?php else:?>
					<p>未发邮件</p>
					<?php endif;?>
					</td>
					<td class="dataTableContent">
						<input type="text" id="remark_<?php echo $orders->fields['orders_id'];?>" value="<?php echo $orders->fields['remark'];?>"/>
						<input type="button" onclick="add_remark(<?php echo $orders->fields['orders_id'];?>, $('#remark_<?php echo $orders->fields['orders_id'];?>').val());" value="添加备注"/>
					</td>
					<td class="dataTableContent" align="right">
					<a href="<?php echo zen_href_link('orders.php', 'action=edit&oID='.$orders->fields['orders_id']);?>" target="_blank">查看订单</a><br/>
					<a href="<?php echo zen_href_link(FILENAME_CUSTOMERS, 'action=edit&cID=' . $orders->fields['customers_id'], 'NONSSL');?>" target="_blank">查看客户</a>
					</td>
				</tr>
				<?php $orders->MoveNext(); endwhile;?>
				
              <tr>
					<td colspan="7">
						<table border="0" width="100%" cellspacing="0" cellpadding="2">
							<tbody>
								<tr>
									<td class="smallText" valign="top"><?php echo $orders_split->display_count($orders_query_numrows, $page_num, $_REQUEST['page'], TEXT_DISPLAY_NUMBER_OF_ORDERS); ?></td>
									<td class="smallText" align="right"><?php echo $orders_split->display_links($orders_query_numrows, $page_num, MAX_DISPLAY_PAGE_LINKS, $_REQUEST['page'], zen_get_all_get_params(array('page', 'oID', 'action'))); ?></td>
								</tr>
               			</tbody>
               			</table>
               		</td>
               		<td align="center">
               			<input type="submit" name="save_all" value="保存所有单号"/>
               		</td>
               		<td></td>
               		<td></td>
				</tr>
				</tbody>
			</table>
			</form>
			</td>
		</tr>
		<tr>
			<td width="100%" valign="top"></td>
		</tr>
	</table>
	<!-- body_eof //-->

	<!-- footer //-->
	<div class="footer-area">
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
</div>
	<!-- footer_eof //-->
	<br />
<script type="text/javascript">
function save_express(oid, exp_id, track_number, send_mail){
	if (exp_id == 0)
	{
		alert('请选择快递');
		return;
	}
	if (track_number == '')
	{
		alert('请填写单号');
		return;
	}
	if (send_mail == 'on' || send_mail == 'ON' || send_mail==1)
		send_mail = 1;
	$.ajax({
		url:'order_man.php',
		dataType: 'json',
		data:'action=save_exp&securityToken=<?php echo $_SESSION['securityToken'];?>&orders_id='+oid+'&express_id='+exp_id+'&track_number='+track_number+'&send_delivery_mail='+send_mail,
		type: 'post',
		success:function(data){
			var str = data.errno ? data.errmsg : data.cnt;
			$('#save_info_'+data.orders_id).text(str);
		}
	});
}
function apply_express_all(exp_id, track_number){
	var prefix = $('#apply_prefix').val();
	var suffix = $('#apply_suffix').val();
	var start = $('#apply_start').val();
	if (start == '')
		start = 1;
	var end = $('#apply_end').val();
	if (end=='')
		end = $('input[name^=track_number]').size();
	$('select[name^=express_delivery]').val(exp_id);
	$('input[name^=track_number]').each(function(){
		if (start<=end){
		if (start<10)
			i = '0'+start;
		else
			i = start;
		$(this).val(prefix+i+suffix);
		
		}
		start++;
	});
}
function order_repay(oid)
{
	$.ajax({
		url:'order_man.php',
		type:'post',
		dataType:'json',
		data:'action=order_repay&securityToken=<?php echo $_SESSION['securityToken'];?>&orders_id='+oid,
		success:function(data){
			var str = data.errno ? data.errmsg : data.cnt;
			var status = data.status ? data.status : '';
			$('#repay_info_'+data.orders_id).text(str);
			$('#order_status_'+data.orders_id).text(status);
		}
	});
}
</script>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
<?php

class ImageManager
{
	const ERROR_FILE_NOT_EXIST = 1;
	const ERROR_FILE_WIDTH     = 2;
	const ERROR_MEMORY_LIMIT   = 3;

	/**
	 * Resize, cut and optimize image
	 *
	 * @param string $src_file Image object from $_FILE
	 * @param string $dst_file Destination filename
	 * @param integer $dst_width Desired width (optional)
	 * @param integer $dst_height Desired height (optional)
	 * @param string $file_type
	 * @return boolean Operation result
	 */
	public static function resize($src_file, $dst_file, $dst_width = null, $dst_height = null, $file_type = 'jpg', $force_type = false, &$error = 0)
	{
		if (PHP_VERSION_ID < 50300)
			clearstatcache();
		else
			clearstatcache(true, $src_file);

		if (!file_exists($src_file) || !filesize($src_file))
			return !($error = self::ERROR_FILE_NOT_EXIST);

		list($tmp_width, $tmp_height, $type) = getimagesize($src_file);
		$src_image = ImageManager::create($type, $src_file);

		if (function_exists('exif_read_data') && function_exists('mb_strtolower'))
		{
			$exif = @exif_read_data($src_file);

			if ($exif && isset($exif['Orientation']))
			{
				switch ($exif['Orientation'])
				{
					case 3:
						$src_width = $tmp_width;
						$src_height = $tmp_height;
						$src_image = imagerotate($src_image, 180, 0);
						break;

					case 6:
						$src_width = $tmp_height;
						$src_height = $tmp_width;
						$src_image = imagerotate($src_image, -90, 0);
						break;

					case 8:
						$src_width = $tmp_height;
						$src_height = $tmp_width;
						$src_image = imagerotate($src_image, 90, 0);
						break;

					default:
						$src_width = $tmp_width;
						$src_height = $tmp_height;
				}
			}
			else
			{
				$src_width = $tmp_width;
				$src_height = $tmp_height;
			}
		}
		else
		{
			$src_width = $tmp_width;
			$src_height = $tmp_height;
		}

		// If PS_IMAGE_QUALITY is activated, the generated image will be a PNG with .jpg as a file extension.
		// This allow for higher quality and for transparency. JPG source files will also benefit from a higher quality
		// because JPG reencoding by GD, even with max quality setting, degrades the image.
		if ($force_type)
			$file_type = 'png';

		if (!$src_width)
			return !($error = self::ERROR_FILE_WIDTH);
		if (!$dst_width)
			$dst_width = $src_width;
		if (!$dst_height)
			$dst_height = $src_height;

		$width_diff = $dst_width / $src_width;
		$height_diff = $dst_height / $src_height;

		if ($width_diff > 1 && $height_diff > 1)
		{
			$next_width = $src_width;
			$next_height = $src_height;
		}
		else
		{
			$next_width = $dst_width;
			$next_height = round($src_height * $dst_width / $src_width);
			$dst_height = $next_height;

		}

		$dest_image = imagecreatetruecolor($dst_width, $dst_height);

		// If image is a PNG and the output is PNG, fill with transparency. Else fill with white background.
		if ($file_type == 'png' && $type == IMAGETYPE_PNG)
		{
			imagealphablending($dest_image, false);
			imagesavealpha($dest_image, true);
			$transparent = imagecolorallocatealpha($dest_image, 255, 255, 255, 127);
			imagefilledrectangle($dest_image, 0, 0, $dst_width, $dst_height, $transparent);
		}
		else
		{
			$white = imagecolorallocate($dest_image, 255, 255, 255);
			imagefilledrectangle ($dest_image, 0, 0, $dst_width, $dst_height, $white);
		}

		imagecopyresampled($dest_image, $src_image, (int)(($dst_width - $next_width) / 2), (int)(($dst_height - $next_height) / 2), 0, 0, $next_width, $next_height, $src_width, $src_height);
		return (ImageManager::write($file_type, $dest_image, $dst_file));
	}

	/**
	 * Check if file is a real image
	 *
	 * @param string $filename File path to check
	 * @param string $file_mime_type File known mime type (generally from $_FILES)
	 * @param array $mime_type_list Allowed MIME types
	 * @return bool
	 */
	public static function isRealImage($filename, $file_mime_type = null, $mime_type_list = null)
	{
		// Detect mime content type
		$mime_type = false;
		if (!$mime_type_list)
			$mime_type_list = array('image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png');

		// Try 4 different methods to determine the mime type
		if (function_exists('getimagesize'))
		{
			$image_info = @getimagesize($filename);

			if ($image_info)
				$mime_type = $image_info['mime'];
			else
				$file_mime_type = false;
		}
		elseif (function_exists('finfo_open'))
		{
			$const = defined('FILEINFO_MIME_TYPE') ? FILEINFO_MIME_TYPE : FILEINFO_MIME;
			$finfo = finfo_open($const);
			$mime_type = finfo_file($finfo, $filename);
			finfo_close($finfo);
		}
		elseif (function_exists('mime_content_type'))
		$mime_type = mime_content_type($filename);
		elseif (function_exists('exec'))
		{
			$mime_type = trim(exec('file -b --mime-type '.escapeshellarg($filename)));
			if (!$mime_type)
				$mime_type = trim(exec('file --mime '.escapeshellarg($filename)));
			if (!$mime_type)
				$mime_type = trim(exec('file -bi '.escapeshellarg($filename)));
		}

		if ($file_mime_type && (empty($mime_type) || $mime_type == 'regular file' || $mime_type == 'text/plain'))
			$mime_type = $file_mime_type;

		// For each allowed MIME type, we are looking for it inside the current MIME type
		foreach ($mime_type_list as $type)
			if (strstr($mime_type, $type))
				return true;

			return false;
	}

	/**
	 * Check if image file extension is correct
	 *
	 * @static
	 * @param $filename real filename
	 * @return bool true if it's correct
	 */
	public static function isCorrectImageFileExt($filename, $authorized_extensions = null)
	{
		// Filter on file extension
		if ($authorized_extensions === null)
			$authorized_extensions = array('gif', 'jpg', 'jpeg', 'jpe', 'png');
		$name_explode = explode('.', $filename);
		if (count($name_explode) >= 2)
		{
			$current_extension = strtolower($name_explode[count($name_explode) - 1]);
			if (!in_array($current_extension, $authorized_extensions))
				return false;
		}
		else
			return false;

		return true;
	}

	/**
	 * Cut image
	 *
	 * @param array $src_file Origin filename
	 * @param string $dst_file Destination filename
	 * @param integer $dst_width Desired width
	 * @param integer $dst_height Desired height
	 * @param string $file_type
	 * @param int $dst_x
	 * @param int $dst_y
	 *
	 * @return bool Operation result
	 */
	public static function cut($src_file, $dst_file, $dst_width = null, $dst_height = null, $file_type = 'jpg', $dst_x = 0, $dst_y = 0)
	{
		if (!file_exists($src_file))
			return false;

		// Source information
		$src_info = getimagesize($src_file);
		$src = array(
			'width' => $src_info[0],
			'height' => $src_info[1],
			'ressource' => ImageManager::create($src_info[2], $src_file),
		);

		// Destination information
		$dest = array();
		$dest['x'] = $dst_x;
		$dest['y'] = $dst_y;
		$dest['width'] = !is_null($dst_width) ? $dst_width : $src['width'];
		$dest['height'] = !is_null($dst_height) ? $dst_height : $src['height'];
		$dest['ressource'] = ImageManager::createWhiteImage($dest['width'], $dest['height']);

		$white = imagecolorallocate($dest['ressource'], 255, 255, 255);
		imagecopyresampled($dest['ressource'], $src['ressource'], 0, 0, $dest['x'], $dest['y'], $dest['width'], $dest['height'], $dest['width'], $dest['height']);
		imagecolortransparent($dest['ressource'], $white);
		$return = ImageManager::write($file_type, $dest['ressource'], $dst_file);
		return	$return;
	}

	/**
	 * Create an image with GD extension from a given type
	 *
	 * @param string $type
	 * @param string $filename
	 * @return resource
	 */
	public static function create($type, $filename)
	{
		switch ($type)
		{
			case IMAGETYPE_GIF :
				return imagecreatefromgif($filename);
				break;

			case IMAGETYPE_PNG :
				return imagecreatefrompng($filename);
				break;

			case IMAGETYPE_JPEG :
			default:
				return imagecreatefromjpeg($filename);
				break;
		}
	}

	/**
	 * Create an empty image with white background
	 *
	 * @param int $width
	 * @param int $height
	 * @return resource
	 */
	public static function createWhiteImage($width, $height)
	{
		$image = imagecreatetruecolor($width, $height);
		$white = imagecolorallocate($image, 255, 255, 255);
		imagefill($image, 0, 0, $white);
		return $image;
	}

	/**
	 * Generate and write image
	 *
	 * @param string $type
	 * @param resource $resource
	 * @param string $filename
	 * @return bool
	 */
	public static function write($type, $resource, $filename)
	{
		switch ($type)
		{
			case 'gif':
				$success = imagegif($resource, $filename);
				break;

			case 'png':
				$quality = 7;
				$success = imagepng($resource, $filename, (int)$quality);
				break;

			case 'jpg':
			case 'jpeg':
			default:
				$quality = 90;
				imageinterlace($resource, 1); /// make it PROGRESSIVE
				$success = imagejpeg($resource, $filename, (int)$quality);
				break;
		}
		imagedestroy($resource);
		@chmod($filename, 0664);
		return $success;
	}

	/**
	 * Return the mime type by the file extension
	 *
	 * @param string $file_name
	 * @return string
	 */
	public static function getMimeTypeByExtension($file_name)
	{
		$types = array(
			'image/gif' => array('gif'),
			'image/jpeg' => array('jpg', 'jpeg'),
			'image/png' => array('png')
		);
		$extension = substr($file_name, strrpos($file_name, '.') + 1);

		$mime_type = null;
		foreach ($types as $mime => $exts)
			if (in_array($extension, $exts))
			{
				$mime_type = $mime;
				break;
			}

		if ($mime_type === null)
			$mime_type = 'image/jpeg';

		return $mime_type;
	}
}

?>
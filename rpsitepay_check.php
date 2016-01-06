<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
// |                                                                      |
// | http://www.zen-cart.com/index.php                                    |
// |                                                                      |
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
//

require('includes/application_top.php');


@file_put_contents(DIR_FS_CATALOG . "rp/billlog/result_" . Date('Ymd') . ".log", var_export($_REQUEST, true)."\n", FILE_APPEND);
if(!isset($_REQUEST['_ipn'])){
	$_order_sn = isset($_REQUEST['_order_sn']) ? $_REQUEST['_order_sn'] : '';
	$_siteid = isset($_REQUEST['_siteid']) ? $_REQUEST['_siteid'] : '';
	$_currency = isset($_REQUEST['_currency']) ? $_REQUEST['_currency'] : '';
	$_total = isset($_REQUEST['_total']) ? $_REQUEST['_total'] : '';
	$_transactionid = isset($_REQUEST['_transactionid']) ? $_REQUEST['_transactionid'] : '';
	$_verified = isset($_REQUEST['_verified']) ? $_REQUEST['_verified'] : '';
	$_verifycode = isset($_REQUEST['_verifycode']) ? $_REQUEST['_verifycode'] : '';
	$local_sign = $_REQUEST['local_sign'] = md5($_order_sn . $_siteid . $_currency . $_total . $_transactionid . $_verified . trim(MODULE_PAYMENT_RPSITEPAY_PRIVATE_KEY));

	//��¼��־
	$log = Date('H:i:s') . " S2S " . var_export($_REQUEST, true) . "\n";
	$handle = @fopen(DIR_FS_CATALOG . "rp/billlog/" . Date('Ymd') . ".log", 'a+');
	@fwrite($handle, $log);
	@fclose($handle);

	if($local_sign !== $_verifycode)
	{
		die('Incorrect Signature!'); 
	}

	require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/checkout_process.php');

	require(DIR_WS_CLASSES . 'order.php');

	$order = new order($_order_sn);
	$_SESSION['customer_id'] = $order->customer['id'];
	$name = explode(' ', $order->customer['name']);
	$order->customer['firstname'] = isset($name[0]) ? $name[0] : '';
	$order->customer['lastname'] = isset($name[1]) ? $name[1] : '';
	$order_totals = $order->totals; 

	$_SESSION['payment'] = $order->info['payment_module_code'];
	require(DIR_WS_CLASSES . 'payment.php');
	$payment_modules = new payment($_SESSION['payment']);

	require(DIR_WS_CLASSES . 'shipping.php');
	$shipping_modules = new shipping($order->info['shipping_module_code']);
	 
	$_verified = str_replace(' ', '', $_verified);
	$status = 'rp' . $_verified;
	$notify = 0;

	if($status === 'rpapproved' || $status === 'rptestapprove')
	{
		$session = $db->Execute("select sendto, billto from " . DB_PREFIX . "rppay_sessions where sid = " . zen_db_input($_order_sn));   
		if(!$session->RecordCount())
		{
			die('order error');
		}
		$_SESSION['sendto'] = $session->fields['sendto'];
		$_SESSION['billto'] = $session->fields['billto'];
		
		$notify = 1;
		//��չ��ﳵ
		$_SESSION['cart']->reset(true);
	}

	//���¶���״̬
	if(isset($payment_modules->paymentClass) && is_object($payment_modules->paymentClass))
	{
		$payment_modules->paymentClass->update_order_status($_order_sn, $status, $_transactionid, $notify);
	}
	else
	{
		$$_SESSION['payment']->update_order_status($_order_sn, $status, $_transactionid, $notify);  //����1.2.X�汾
	}

	die('rpok');
}
// else if($_REQUEST['_ipn']=='rp') {
// 	$imgtype = $_REQUEST['_imgtype'];
// 	$embed = $_REQUEST['_embed'];
// 	$gurl = $_REQUEST['_gurl'];
// 	$str = trim(MODULE_PAYMENT_RPSITEPAY_MERCHANTNO).trim(MODULE_PAYMENT_RPSITEPAY_SITEID).$imgtype.$embed.$gurl;
// 	$sign = md5($str . trim(MODULE_PAYMENT_RPSITEPAY_PRIVATE_KEY));
// 	if($sign==$_REQUEST['_sign']){
// 		$db->Execute("update " . TABLE_CONFIGURATION . " set configuration_value='{$gurl}' where configuration_key='MODULE_PAYMENT_RPSITEPAY_ACTION_URL'");
// 		$db->Execute("update " . TABLE_CONFIGURATION . " set configuration_value='{$imgtype}' where configuration_key='MODULE_PAYMENT_RPSITEPAY_IMGTYPE'");
// 		$db->Execute("update " . TABLE_CONFIGURATION . " set configuration_value='{$embed}' where configuration_key='MODULE_PAYMENT_RPSITEPAY_EMBED'");
// 		echo 'ipnok';
// 	} else {
// 		echo $str;
// 	}
// }

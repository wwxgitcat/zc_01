<?php
/**
 * 
 * @author Juns QQ46231996
 *
 */
/*
WRONG_IP
WRONG_EMAIL
WRONG_SHIPCOUNTRY
WRONG_BILLCOUNTRY
WRONG_GATEWAY
WRONG_SIGN
MONTHISWRONG
YEARISWRONG
CARDNUMBERISWRONG
CVV2ISWRONG
WRONG_SITEID
WRONG_CURRENCY
WRONG_GOODS_MATCH
WRONG_PRODUCT
WRONG_PRICE
LARGE_PRICE
SYSTEM_ERROR

EMPTY_ORDER_SN
EMPTY_BILLLASTNAME
EMPTY_BILLFIRSTNAME
EMPTY_BILLCITY
EMPTY_BILLADDRESS
EMPTY_BILLPOSTCODE
EMPTY_BILLPHONE
EMPTY_SHIPLASTNAME
EMPTY_SHIPFIRSTNAME
EMPTY_SHIPCITY
EMPTY_SHIPADDRESS
EMPTY_SHIPPOSTCODE
EMPTY_SHIPPHONE
EMPTY_IP
*/



class rpsitepay
{
	var $version = '';
	var $code, $title, $description;
	
	// 影响后台支付模块列表显示
	var $enabled, $sort_order, $order_status;
	
	var $checkout_repay_statues = array(
		'MONTHISWRONG',
		'YEARISWRONG',
		'CARDNUMBERISWRONG',
		'CVV2ISWRONG',
		'LARGE_PRICE',
	);
	// class constructor
	function rpsitepay()
	{
		// 全局变量order
		global $order;
		
		// zencart版本
		$this->version = 'zencart' . (defined('PROJECT_VERSION_MAJOR') ? (PROJECT_VERSION_MAJOR . '.' . PROJECT_VERSION_MINOR) : '');
		
		// RPSITEPAY模块名称
		$this->code = 'rpsitepay';
		
		// RPSITEPAY支付模块标题
		$this->title = MODULE_PAYMENT_RPSITEPAY_TEXT_TITLE;
		
		// RPSITEPAY支付模块描述
		$this->description = MODULE_PAYMENT_RPSITEPAY_TEXT_DESCRIPTION;
		
		// 订单排序规则
		$this->sort_order = MODULE_PAYMENT_RPSITEPAY_SORT_ORDER;
		
		$this->order_status = (int)MODULE_PAYMENT_RPSITEPAY_ORDER_STATUS_ID;
		
		
		// 模块是否可用
		$this->enabled = ((MODULE_PAYMENT_RPSITEPAY_STATUS == 'True') ? true : false);
		
		if ($this->enabled)
		{
			// 设置提交地址
			$this->form_action_url = MODULE_PAYMENT_RPSITEPAY_EMBED ? 'index.php?main_page=order_details' : MODULE_PAYMENT_RPSITEPAY_ACTION_URL;
		}
		
		$repay_status = defined('MODULE_PAYMENT_RPSITEPAY_REPAY_STATUES') ? MODULE_PAYMENT_RPSITEPAY_REPAY_STATUES : '';
		if (empty($repay_status))
			$this->checkout_repay_statues = explode(',', $repay_status);
		
		if (is_object($order))
		{
			$this->update_status();
		}
	}
	
	// class methods
	function update_status()
	{
		global $order, $db;
		
		if (($this->enabled == true) && ((int)MODULE_PAYMENT_RPSITEPAY_ZONE > 0))
		{
			$check_flag = false;
			$check = $db->Execute("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_RPSITEPAY_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
			while (!$check->EOF)
			{
				if ($check->fields['zone_id'] < 1)
				{
					$check_flag = true;
					break;
				}
				elseif ($check->fields['zone_id'] == $order->delivery['zone_id'])
				{
					$check_flag = true;
					break;
				}
				$check->MoveNext();
			}
			
			if ($check_flag == false)
			{
				$this->enabled = false;
			}
		}
	}
	function javascript_validation()
	{
		return false;
	}
	function selection()
	{
		$imgurl = MODULE_PAYMENT_RPSITEPAY_IMGTYPE ? ('http://www.billingconfirm.net/images/' . MODULE_PAYMENT_RPSITEPAY_SITEID . '.jpg') : 'includes/modules/payment/neworder/card.jpg';
		return array(
			'id' => $this->code,
			'module' => '<img src="' . $imgurl . '" /> ' . $this->title
		);
	}
	function pre_confirmation_check()
	{
		return false;
	}
	function confirmation()
	{
		return false;
	}
	
	// 生成订单
	private function create_order()
	{
		global $db, $order, $order_totals;
		
		// 生成订单
		$order->info['order_status'] = MODULE_PAYMENT_RPSITEPAY_ORDER_STATUS_ID;
		if ($order->info['total'] == 0)
		{
			if (DEFAULT_ZERO_BALANCE_ORDERS_STATUS_ID == 0)
			{
				$order->info['order_status'] = DEFAULT_ORDERS_STATUS_ID;
			}
			else 
				if ($_SESSION['payment'] != 'freecharger')
				{
					$order->info['order_status'] = DEFAULT_ZERO_BALANCE_ORDERS_STATUS_ID;
				}
		}
		
		if ($_SESSION['shipping'] == 'free_free')
		{
			$order->info['shipping_module_code'] = $_SESSION['shipping'];
		}
		
		$sql_data_array = array(
			'customers_id' => $_SESSION['customer_id'],
			'customers_name' => $order->customer['firstname'] . ' ' . $order->customer['lastname'],
			'customers_company' => $order->customer['company'],
			'customers_street_address' => $order->customer['street_address'],
			'customers_suburb' => $order->customer['suburb'],
			'customers_city' => $order->customer['city'],
			'customers_postcode' => $order->customer['postcode'],
			'customers_state' => $order->customer['state'],
			'customers_country' => $order->customer['country']['title'],
			'customers_telephone' => $order->customer['telephone'],
			'customers_email_address' => $order->customer['email_address'],
			'customers_address_format_id' => $order->customer['format_id'],
			'delivery_name' => $order->delivery['firstname'] . ' ' . $order->delivery['lastname'],
			'delivery_company' => $order->delivery['company'],
			'delivery_street_address' => $order->delivery['street_address'],
			'delivery_suburb' => $order->delivery['suburb'],
			'delivery_city' => $order->delivery['city'],
			'delivery_postcode' => $order->delivery['postcode'],
			'delivery_state' => $order->delivery['state'],
			'delivery_country' => $order->delivery['country']['title'],
			'delivery_address_format_id' => $order->delivery['format_id'],
			'billing_name' => $order->billing['firstname'] . ' ' . $order->billing['lastname'],
			'billing_company' => $order->billing['company'],
			'billing_street_address' => $order->billing['street_address'],
			'billing_suburb' => $order->billing['suburb'],
			'billing_city' => $order->billing['city'],
			'billing_postcode' => $order->billing['postcode'],
			'billing_state' => $order->billing['state'],
			'billing_country' => $order->billing['country']['title'],
			'billing_address_format_id' => $order->billing['format_id'],
			'payment_method' => 'Credit Card Payment', // 邮件中显示的支付方式名称
			'payment_module_code' => $this->code,
			'shipping_method' => $order->info['shipping_method'],
			'shipping_module_code' => (strpos($order->info['shipping_module_code'], '_') > 0 ? substr($order->info['shipping_module_code'], 0, strpos($order->info['shipping_module_code'], '_')) : $order->info['shipping_module_code']),
			'coupon_code' => $order->info['coupon_code'],
			'cc_type' => $order->info['cc_type'],
			'cc_owner' => $order->info['cc_owner'],
			'cc_number' => $order->info['cc_number'],
			'cc_expires' => $order->info['cc_expires'],
			'date_purchased' => date('Y-m-d H:i:s'),
			'orders_status' => $order->info['order_status'],
			'order_total' => $order->info['total'],
			'order_tax' => $order->info['tax'],
			'currency' => $order->info['currency'],
			'currency_value' => $order->info['currency_value'],
			'ip_address' => $_SESSION['customers_ip_address'] . ' - ' . $_SERVER['REMOTE_ADDR']
		);
		zen_db_perform(TABLE_ORDERS, $sql_data_array);
		$insert_id = $db->Insert_ID();
		$order->notify('NOTIFY_ORDER_DURING_CREATE_ADDED_ORDER_HEADER', array_merge(array(
			'orders_id' => $insert_id,
			'shipping_weight' => $_SESSION['cart']->weight
		), $sql_data_array));
		
		for ($i = 0, $n = sizeof($order_totals); $i < $n; $i++)
		{
			$sql_data_array = array(
				'orders_id' => $insert_id,
				'title' => $order_totals[$i]['title'],
				'text' => $order_totals[$i]['text'],
				'value' => (is_numeric($order_totals[$i]['value'])) ? $order_totals[$i]['value'] : '0',
				'class' => $order_totals[$i]['code'],
				'sort_order' => $order_totals[$i]['sort_order']
			);
			zen_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);
			$order->notify('NOTIFY_ORDER_DURING_CREATE_ADDED_ORDERTOTAL_LINE_ITEM', $sql_data_array);
		}
		
		$sql_data_array = array(
			'orders_id' => $insert_id,
			'orders_status_id' => $order->info['order_status'],
			'date_added' => date('Y-m-d H:i:s'),
			'customer_notified' => 0,
			'comments' => $order->info['comments']
		);
		zen_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
		$order->notify('NOTIFY_ORDER_DURING_CREATE_ADDED_ORDER_COMMENT', $sql_data_array);
		
		// 生成订单产品信息
		$order->create_add_products($insert_id);
		
		// 把客户的session序列化之后保存到数据库里面
		$sql_data_array = array(
			'sid' => $insert_id,
			'sendto' => $_SESSION['sendto'],
			'billto' => $_SESSION['billto']
		);
		zen_db_perform(DB_PREFIX . 'rpsitepay_sessions', $sql_data_array);
		
		return $insert_id;
	}
	function process_button()
	{
		global $db, $order, $order_totals, $currencies;
		$array = $db->Execute("select * from " . TABLE_ORDERS . " where orders_status='".$this->order_status."' and payment_module_code = 'rpsitepay' and customers_email_address = '".$order->customer['email_address']."' and currency = '".$order->info['currency']."' and order_total = '".$order->info['total']."' order by orders_id desc limit 0, 1");
		if ($array->fields['orders_id']) {
			$order_id =$array->fields['orders_id'];	// 订单编号
		} else {
			$order_id = $this->create_order();	// 订单编号
		}
		
		// 更新Simple Seo Url设置，防止返回时报签名出错
		$ssu = $db->Execute("select configuration_key from " . DB_PREFIX . "configuration where configuration_key = 'SSU_EXCLUDE_LIST'");
		if ($ssu->RecordCount() > 0)
		{
			$db->Execute("update " . DB_PREFIX . "configuration set configuration_value=CONCAT('checkout_process,rpsitepay_main_handler,',configuration_value) WHERE (configuration_key = 'SSU_EXCLUDE_LIST') and (configuration_value not like '%checkout_process%')");
		}
		
		$var = array();
		
		if (MODULE_PAYMENT_RPSITEPAY_EMBED)
		{
			$var['gateway_url'] = MODULE_PAYMENT_RPSITEPAY_ACTION_URL;
		}
		
		// 版本号，固定值
		$var['iver'] = '3.14';
		$var['version'] = $this->version;
		
		// merchantno
		$var['merchantno'] = trim(MODULE_PAYMENT_RPSITEPAY_MERCHANTNO);
		
		// siteid
		$var['siteid'] = trim(MODULE_PAYMENT_RPSITEPAY_SITEID);
		
		// 商户订单编号
		//$var['order_sn'] = $this->create_order();
		$var['order_sn'] = $order_id;
		
		$var['rpcookie'] = $_COOKIE['RpCookie'];
		
		// 商户订单时间
		$var['order_time'] = date('YmdHis');
		
		// 界面语言 GB---GB中文（缺省）、EN---英文、BIG5---BIG5中文、JP---日文、FR---法文
		switch (strtolower($_SESSION['language']))
		{
			case 'english':
				$var['language'] = 'en';
				break;
			case 'schinese':
				$var['language'] = 'gb';
				break;
			case 'tchinese':
				$var['language'] = 'big5';
				break;
			case 'japanese':
				$var['language'] = 'jp';
				break;
			case 'french':
				$var['language'] = 'fr';
				break;
			case 'italian':
				$var['language'] = 'it';
				break;
			case 'german':
				$var['language'] = 'de';
				break;
			case 'spanish':
				$var['language'] = 'es';
				break;
			case 'portuguese':
				$var['language'] = 'pt';
				break;
			case 'russian':
				$var['language'] = 'ru';
				break;
			default:
				$var['language'] = '';
		}
		
		// 支付币种
		$var['currency'] = $_SESSION['currency'];
		
		$ot_total = $ot_subtotal = $ot_shipping = $discount = 0;
		if (is_array($order_totals) and count($order_totals) > 0)
		{
			foreach ($order_totals as $v)
			{
				switch ($v['code'])
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
			}
		}
		
		$var['amount'] = number_format($order->info['total'] * $currencies->get_value($var['currency']), 2, '.', ''); // 商品价格
		$var['shippingfee'] = number_format($order->info['shipping_cost'] * $currencies->get_value($var['currency']), 2, '.', ''); // 运费
		$var['vat'] = number_format(($ot_total + $discount - $ot_subtotal - $ot_shipping) * $currencies->get_value($var['currency']), 2, '.', ''); // 附加费用
		$var['discount'] = number_format($discount * $currencies->get_value($var['currency']), 2, '.', ''); // 打折
		global $order_total_modules;
		$var['total_output'] = base64_encode($order_total_modules->output(true));
		
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
		$var['shipfirstname'] = $order->delivery['firstname'];
		$var['shiplastname'] = $order->delivery['lastname'];
		$var['shipaddress'] = $order->delivery['street_address'] . ',' . $order->delivery['suburb'];
		$var['shipcity'] = $order->delivery['city'];
		$var['shippostcode'] = $order->delivery['postcode'];
		$query = $db->Execute("select zone_code from " . TABLE_ZONES . " where zone_name = '{$order->delivery['state']}'");
		$var['shipstate'] = $query->RecordCount() ? $query->fields['zone_code'] : $order->delivery['state'];
		$var['shipcountry'] = $order->delivery['country']['iso_code_2'];
		$var['shipphone'] = $order->customer['telephone'];
		
		// 账单信息
		$var['billfirstname'] = $order->billing['firstname'];
		$var['billlastname'] = $order->billing['lastname'];
		$var['billaddress'] = $order->billing['street_address'] . ',' . $order->billing['suburb'];
		$var['billcity'] = $order->billing['city'];
		$query = $db->Execute("select zone_code from " . TABLE_ZONES . " where zone_name = '{$order->billing['state']}'");
		$var['billstate'] = $query->RecordCount() ? $query->fields['zone_code'] : $order->billing['state'];
		$var['billpostcode'] = $order->billing['postcode'];
		$var['billcountry'] = $order->billing['country']['iso_code_2'];
		$var['billphone'] = $order->customer['telephone'];
		
		// 提交表单数据
// 		$process_button_string = '';
// 		foreach ($var as $k => $v)
// 		{
// 			$process_button_string .= zen_draw_hidden_field($k, $v);
// 		}
		
		// 记录日志
		$log = date('H:i:s') . " " . var_export($var, true) . " \n";
		$handle = @fopen(DIR_FS_CATALOG . "rp/submitlog/" . Date('Ymd') . ".log", 'a+');
		@fwrite($handle, $log);
		@fclose($handle);
		
		return $var;
	}
	function before_process()
	{
		global $db, $order, $currencies, $messageStack, $order_totals;
		
		$_order_sn = isset($_GET['_order_sn']) ? $_GET['_order_sn'] : '';
		$_siteid = isset($_GET['_siteid']) ? $_GET['_siteid'] : '';
		$_currency = isset($_GET['_currency']) ? $_GET['_currency'] : '';
		$_total = isset($_GET['_total']) ? $_GET['_total'] : '';
		$_transactionid = isset($_GET['_transactionid']) ? $_GET['_transactionid'] : '';
		$_verified = isset($_GET['_verified']) ? $_GET['_verified'] : '';
		$_verifycode = isset($_GET['_verifycode']) ? $_GET['_verifycode'] : '';
		$local_sign = $_GET['local_sign'] = md5($_order_sn . $_siteid . $_currency . $_total . $_transactionid . $_verified . trim(MODULE_PAYMENT_RPSITEPAY_PRIVATE_KEY));
		
		// 记录日志
		$log = Date('H:i:s') . " S2B " . var_export($_GET, true) . "\n";
		$handle = @fopen(DIR_FS_CATALOG . "rp/billlog/" . Date('Ymd') . ".log", 'a+');
		@fwrite($handle, $log);
		@fclose($handle);
		
		$order = new order($_order_sn);
		$name = explode(' ', $order->customer['name']);
		$order->customer['firstname'] = isset($name[0]) ? $name[0] : '';
		$order->customer['lastname'] = isset($name[1]) ? $name[1] : '';
		$order_totals = $order->totals;
		
		$redirect = FILENAME_CHECKOUT_PAYMENT;
		if ($local_sign === $_verifycode)
		{
			$_verified = str_replace(' ', '', $_verified);
			$status = 'rp' . $_verified;
			$notify = 0;
			if ($status === 'rpapproved' || $status === 'rptestapprove')
			{
				// 清空购物车
				$_SESSION['cart']->reset(true);
				
				$redirect = FILENAME_CHECKOUT_SUCCESS;
				$notify = 1;
			}
			else 
				if ($status === 'rppending')
				{
					$redirect = 'checkout_rpprocessing';
				}
				else
				{
					$messageStack->add_session('checkout_payment', 'Transaction failed!', 'error');
				}
			
			// 更新订单状态
			$this->update_order_status($_order_sn, $status, $_transactionid, $notify);
		}
		else
		{
			$messageStack->add_session('checkout_payment', 'Incorrect Signature !', 'error');
		}
		
		zen_redirect(zen_href_link($redirect, '', 'SSL', true, false));
	}
	function update_order_status($order_id, $status, $transactionid, $notify = 0)
	{
		global $db, $order, $currencies;
		
		$query = $db->Execute("select orders_status_id from " . DB_PREFIX . "orders_status where orders_status_name='{$status}' and language_id={$_SESSION['languages_id']} limit 1");
		if (!$query->RecordCount())
		{
			die('Wrong order status: ' . $status);
		}
		$status_id = $query->fields['orders_status_id'];
		
		$check_status = $db->Execute("select customers_name, customers_email_address, orders_status,
                                      date_purchased from " . TABLE_ORDERS . "
                                      where orders_id = '" . (int)$order_id . "'");
		if (($check_status->fields['orders_status'] != $status_id))
		{
			$db->Execute("update " . TABLE_ORDERS . "
                        set orders_status = '" . zen_db_input($status_id) . "', last_modified = now(), rp_transactionid = '" . zen_db_input($transactionid) . "' 
                        where orders_id = '" . (int)$order_id . "'");
			
			if ($notify)
			{
				$order->products_ordered = '';
				$order->products_ordered_html = '';
				for ($i = 0, $n = sizeof($order->products); $i < $n; $i++)
				{
					$this->products_ordered_attributes = '';
					if (isset($order->products[$i]['attributes']))
					{
						$attributes_exist = '1';
						for ($j = 0, $n2 = sizeof($order->products[$i]['attributes']); $j < $n2; $j++)
						{
							$this->products_ordered_attributes .= "\n\t" . $order->products[$i]['attributes'][$j]['option'] . ' ' . zen_decode_specialchars($order->products[$i]['attributes'][$j]['value']);
						}
					}
					
					$order->products_ordered .= $order->products[$i]['qty'] . ' x ' . $order->products[$i]['name'] . ($order->products[$i]['model'] != '' ? ' (' . $order->products[$i]['model'] . ') ' : '') . ' = ' . $currencies->display_price($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']) . ($order->products[$i]['onetime_charges'] != 0 ? "\n" . TEXT_ONETIME_CHARGES_EMAIL . $currencies->display_price($this->products[$i]['onetime_charges'], $order->products[$i]['tax'], 1) : '') . $this->products_ordered_attributes . "\n";
					$order->products_ordered_html .= '<tr>' . "\n" . '<td class="product-details" align="right" valign="top" width="30">' . $order->products[$i]['qty'] . '&nbsp;x</td>' . "\n" . '<td class="product-details" valign="top">' . nl2br($order->products[$i]['name']) . ($order->products[$i]['model'] != '' ? ' (' . nl2br($order->products[$i]['model']) . ') ' : '') . "\n" . '<nobr>' . '<small><em> ' . nl2br($this->products_ordered_attributes) . '</em></small>' . '</nobr>' . '</td>' . "\n" . '<td class="product-details-num" valign="top" align="right">' . $currencies->display_price($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']) . ($order->products[$i]['onetime_charges'] != 0 ? '</td></tr>' . "\n" . '<tr><td class="product-details">' . nl2br(TEXT_ONETIME_CHARGES_EMAIL) . '</td>' . "\n" . '<td>' . $currencies->display_price($order->products[$i]['onetime_charges'], $order->products[$i]['tax'], 1) : '') . '</td></tr>' . "\n";
				}
				
				$order->send_order_email($order_id, 2);
			}
			
			$db->Execute("insert into " . TABLE_ORDERS_STATUS_HISTORY . "
                      (orders_id, orders_status_id, date_added, customer_notified, comments)
                      values ('" . zen_db_input($order_id) . "',
                      '" . zen_db_input($status_id) . "',
                      now(),
                      '" . zen_db_input($notify) . "',
                      'Pay notice [rp transactionid: {$transactionid}]')");
		}
	}
	function after_order_create()
	{
	}
	function after_process()
	{
	}
	function output_error()
	{
		return false;
	}
	
	// 后台订单状态更新后同步运单信息
	function _doStatusUpdate($order_id, $new_status, $comments, $customer_notified, $old_status)
	{
		global $db;
		
		if (empty($comments))
		{
			return;
		}
		
		// 只有状态为Delivered才发送运单号
		$status = $db->Execute("select orders_status_id from " . DB_PREFIX . "orders_status where language_id={$_SESSION['languages_id']} and orders_status_name='Delivered'");
		if (!$status->RecordCount() || $status->fields['orders_status_id'] != $new_status)
		{
			return;
		}
		
		// rp交易号是否存在
		$order_query = $db->Execute("select rp_transactionid from " . TABLE_ORDERS . " where orders_id = '{$order_id}'");
		if (!$order_query->RecordCount())
		{
			return;
		}
		
		$var = array();
		$var['siteid'] = MODULE_PAYMENT_RPSITEPAY_SITEID;
		$var['transactionid'] = $order_query->fields['rp_transactionid'];
		$var['comments'] = urlencode($comments);
		$var['cipherkey'] = md5(join('', $var) . MODULE_PAYMENT_RPSITEPAY_PRIVATE_KEY);
		$url = 'http://send.realypay.com/payment/ReceiveOrderDeliveredStatus.cgi';
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_TIMEOUT, 20);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($var));
		curl_exec($curl);
		curl_close($curl);
	}
	function check()
	{
		global $db;
		if (!isset($this->_check))
		{
			$check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_RPSITEPAY_STATUS'");
			$this->_check = $check_query->RecordCount();
		}
		return $this->_check;
	}
	function install()
	{
		global $db;
		
		$db->Execute("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "rpsitepay_sessions` (
            `sid` int(11) NOT NULL,
            `sendto` int(11) NOT NULL,
            `billto` int(11) NOT NULL,
            PRIMARY KEY (`sid`)
            )ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci ;");
		
		// 更新老版本文件和数据库
		$this->fileCheckup();
		
		// 表检查
		$this->tableCheckup();
		
		// 添加rp支付状态
		$this->add_order_status();
		
		// 关闭邮件错误提示，避免中止脚本执行
		$db->Execute("update " . TABLE_CONFIGURATION . " set configuration_value='true' where configuration_key='EMAIL_FRIENDLY_ERRORS'");
		
		// 安装RPSITEPAY支付模块
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable RPSITEPAY Module', 'MODULE_PAYMENT_RPSITEPAY_STATUS', 'True', 'Do you want to accept RPSITEPAY payments?', '6', '1', 'zen_cfg_select_option(array(\'True\', \'False\'), ', '".date('Y-m-d H:i:s')."')");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Payment Zone', 'MODULE_PAYMENT_RPSITEPAY_ZONE', '0', 'If a zone is selected, only enable this payment method for that zone.', '6', '2', 'zen_get_zone_class_title', 'zen_cfg_pull_down_zone_classes(', '".date('Y-m-d H:i:s')."')");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort order of display.', 'MODULE_PAYMENT_RPSITEPAY_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', '".date('Y-m-d H:i:s')."')");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('Set RPSITEPAY Order Status', 'MODULE_PAYMENT_RPSITEPAY_ORDER_STATUS_ID', '903', 'Set the status of orders made with this payment module to this value', '6', '0', 'zen_cfg_pull_down_order_statuses(', 'zen_get_order_status_name', '".date('Y-m-d H:i:s')."')");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('merchantno', 'MODULE_PAYMENT_RPSITEPAY_MERCHANTNO', '', 'merchantno', '6', '0', '".date('Y-m-d H:i:s')."')");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('siteid', 'MODULE_PAYMENT_RPSITEPAY_SITEID', '', 'a domain name corresponds to a siteid', '6', '0', '".date('Y-m-d H:i:s')."')");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('MIYAO', 'MODULE_PAYMENT_RPSITEPAY_PRIVATE_KEY', '', 'A business is assigned one key', '6', '0', '".date('Y-m-d H:i:s')."')");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Submit URL', 'MODULE_PAYMENT_RPSITEPAY_ACTION_URL', 'http://app.wayyside.com/payment/payoff', 'Choose the URL for Rppay live processing', '6', '0', '".date('Y-m-d H:i:s')."')");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Image Type', 'MODULE_PAYMENT_RPSITEPAY_IMGTYPE', '0', 'Image Type', '6', '0', '".date('Y-m-d H:i:s')."')");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Iframe pay', 'MODULE_PAYMENT_RPSITEPAY_EMBED', '1', 'Iframe pay', '6', '0', '".date('Y-m-d H:i:s')."')");
		
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Repay statues', 'MODULE_PAYMENT_RPSITEPAY_REPAY_STATUES', '', 'replay statue', '6', '0', '".date('Y-m-d H:i:s')."')");
	}
	function remove()
	{
		// 卸载RPSITEPAY支付模块
		global $db;
		$db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key like 'MODULE\_PAYMENT\_RPSITEPAY\_%'");
		$db->Execute("delete from rpsitepay_sessions");
		// $db->Execute("delete from " . TABLE_ORDERS_STATUS . " where orders_status_name in ('rpapproved', 'rpdeclined', 'rprefund', 'rpunpaid', 'rppending', 'rperror', 'rptestapprove', 'rpcanceled', 'rpchargeback', 'rpfraud')");
	}
	function keys()
	{
		return array(
			'MODULE_PAYMENT_RPSITEPAY_STATUS',
			'MODULE_PAYMENT_RPSITEPAY_ZONE',
			'MODULE_PAYMENT_RPSITEPAY_ORDER_STATUS_ID',
			'MODULE_PAYMENT_RPSITEPAY_SORT_ORDER',
			'MODULE_PAYMENT_RPSITEPAY_MERCHANTNO',
			'MODULE_PAYMENT_RPSITEPAY_SITEID',
			'MODULE_PAYMENT_RPSITEPAY_PRIVATE_KEY',
			'MODULE_PAYMENT_RPSITEPAY_ACTION_URL'
		);
	}
	
	// 删除老版本无用文件
	private function fileCheckup()
	{
	}
	
	// 订单列表添加rp交易id
	private function tableCheckup()
	{
		global $db, $sniffer;
		
		if (!$sniffer->field_exists(DB_PREFIX . "orders", 'rp_transactionid'))
		{
			$db->Execute("ALTER TABLE " . DB_PREFIX . "orders ADD COLUMN rp_transactionid varchar(30)");
		}
	}
	
	// 添加rp支付状态
	private function add_order_status()
	{
		global $db;
		
		$languages = $db->Execute("select languages_id from " . DB_PREFIX . "languages");
		while (!$languages->EOF)
		{
			$language_id = $languages->fields['languages_id'];
			$status = $db->Execute("select * from " . DB_PREFIX . "orders_status where language_id={$language_id} and orders_status_name='rptestapprove'");
			if (!$status->RecordCount())
			{
				$db->Execute("insert into " . DB_PREFIX . "orders_status values(900, {$language_id}, 'rpapproved')"); // 支付成功
				$db->Execute("insert into " . DB_PREFIX . "orders_status values(901, {$language_id}, 'rpdeclined')"); // 支付失败
				$db->Execute("insert into " . DB_PREFIX . "orders_status values(902, {$language_id}, 'rprefund')"); // 退款
				$db->Execute("insert into " . DB_PREFIX . "orders_status values(903, {$language_id}, 'rpunpaid')"); // 未付款
				$db->Execute("insert into " . DB_PREFIX . "orders_status values(904, {$language_id}, 'rppending')"); // 交易处理中
				$db->Execute("insert into " . DB_PREFIX . "orders_status values(905, {$language_id}, 'rperror')"); // 支付出错
				$db->Execute("insert into " . DB_PREFIX . "orders_status values(906, {$language_id}, 'rptestapprove')"); // 测试
				$db->Execute("insert into " . DB_PREFIX . "orders_status values(907, {$language_id}, 'rpcanceled')"); // 付款取消
				$db->Execute("insert into " . DB_PREFIX . "orders_status values(908, {$language_id}, 'rpchargeback')"); // 拒付
				$db->Execute("insert into " . DB_PREFIX . "orders_status values(909, {$language_id}, 'rpfraud')"); // 欺诈
// 				$db->Execute("update " . DB_PREFIX . "orders set orders_status=900 where orders_status=100"); // 解决后台以前订单不显示
// 				$db->Execute("update " . DB_PREFIX . "orders set orders_status=901 where orders_status=101");
// 				$db->Execute("update " . DB_PREFIX . "orders set orders_status=902 where orders_status=102");
// 				$db->Execute("update " . DB_PREFIX . "orders set orders_status=903 where orders_status=103");
// 				$db->Execute("update " . DB_PREFIX . "orders set orders_status=904 where orders_status=104");
// 				$db->Execute("update " . DB_PREFIX . "orders set orders_status=905 where orders_status=105");
// 				$db->Execute("update " . DB_PREFIX . "orders set orders_status=906 where orders_status=106");
// 				$db->Execute("update " . DB_PREFIX . "orders set orders_status=907 where orders_status=107");
// 				$db->Execute("update " . DB_PREFIX . "orders set orders_status=908 where orders_status=108");
// 				$db->Execute("update " . DB_PREFIX . "orders set orders_status=909 where orders_status=109");
				
// 				$db->Execute("update " . DB_PREFIX . "orders_status_history set orders_status_id=900 where orders_status_id=100");
// 				$db->Execute("update " . DB_PREFIX . "orders_status_history set orders_status_id=901 where orders_status_id=101");
// 				$db->Execute("update " . DB_PREFIX . "orders_status_history set orders_status_id=902 where orders_status_id=102");
// 				$db->Execute("update " . DB_PREFIX . "orders_status_history set orders_status_id=903 where orders_status_id=103");
// 				$db->Execute("update " . DB_PREFIX . "orders_status_history set orders_status_id=904 where orders_status_id=104");
// 				$db->Execute("update " . DB_PREFIX . "orders_status_history set orders_status_id=905 where orders_status_id=105");
// 				$db->Execute("update " . DB_PREFIX . "orders_status_history set orders_status_id=906 where orders_status_id=106");
// 				$db->Execute("update " . DB_PREFIX . "orders_status_history set orders_status_id=907 where orders_status_id=107");
// 				$db->Execute("update " . DB_PREFIX . "orders_status_history set orders_status_id=908 where orders_status_id=108");
// 				$db->Execute("update " . DB_PREFIX . "orders_status_history set orders_status_id=909 where orders_status_id=109");
			}
			
			$languages->MoveNext();
		}
	}
}
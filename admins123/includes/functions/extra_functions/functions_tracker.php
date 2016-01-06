<?php
/**
 * Manager tracking
 * UPDATE: 
 * @package system
 * @author JunsGo@msn.com
 * @version 1.0
 * create: 2014/3/13
 * update: 2014/6/20
 */

/**
 * Statistics tracker
 * @return array
 */
function jtracker_statistics($start = null, $limit = null)
{
	
	$info = jtracker_total();
	$info['all_stat'] = jtracker_info(0, 0, $start, $limit);
	
	return $info;
}
function jtracker_total()
{
	global $db;
	$info = array();
	$result = $db->Execute('SELECT COUNT(*) AS total FROM '.TABLE_JTRACKER);
	$info['track_total'] = $result->fields['total'];
	
	//page category
	$info['track_page_category'] = array();
	$result = $db->Execute('SELECT * FROM '.TABLE_JTRACKER_CATEGORY);
	while (!$result->EOF){
		$info['track_page_category'][$result->fields['page_category_id']] = $result->fields['page_name'];
		$result->MoveNext();
	}
	return $info;
}
function jtracker_customer($customers_id)
{
	$result = jtracker_info($customers_id);
	return $result;
}
function jtracker_info($customers_id = 0, $track_id = 0, $start = null, $limit = null)
{
	global $db;
	
	if ($start > 0 && empty($limit))
		$limit = 20;
	
	$where = array();
	if ($customers_id > 0)
		$where[] = 't.`customers_id` = '.$customers_id;
	if ($track_id > 0)
		$where[] = 't.`track_id`='.$track_id;
	
	$ids = array();
	if (!is_null($start))
	{
		$result = $db->Execute('SELECT DISTINCT `track_id` FROM '.TABLE_JTRACKER.' ORDER BY `track_id` ASC LIMIT '.(int)$start.', '.$limit);
		
		while (!$result->EOF)
		{
			$ids[] = $result->fields['track_id'];
			$result->MoveNext();
		}
	}
	if (count($ids) > 0)
		$where[] = 't.`track_id` IN ('.implode(',', $ids).')';
	
	if (count($where) > 0)
		$where = implode(' AND ', $where);
	else
		$where = '';
	
	$sql = 'SELECT t.`track_id`, tc1.`page_category_id` as firat_page_category_id,tc1.`page_name` as first_page_name, t.`page_id` as first_page_id, customers_id, id_address, return_count, t.`date_add` as first_date_add, user_agent, http_referer, track_actions_id, ta.`page_category_id` as action_page_category_id, tc.`page_name` as action_page_name, parent_page_id, ta.`page_id` as action_page_id, sequence, refresh_count, time_start, time_end
	
 FROM `track` t INNER JOIN `track_page_category` tc1
 ON (t.`page_category_id`=tc1.`page_category_id`)
 INNER JOIN `track_actions` ta
ON (t.`track_id`=ta.`track_id`) INNER JOIN `track_page_category` tc ON (tc.`page_category_id`=ta.`page_category_id`)'.
(!empty($where) ? ' WHERE '.$where : '').' ORDER BY t.`track_id`, ta.`sequence`';
	
	$result = $db->Execute($sql);
	$stat = array();
	
	while (!$result->EOF){
		
		if (!isset($stat[$result->fields['track_id']])){
			
			
			$stat[$result->fields['track_id']] = array(
				'page_name' => $result->fields['first_page_name'],
				'page_id' => $result->fields['first_page_id'],
				'ip' => long2ip($result->fields['id_address']),
				'customers_id' => $result->fields['customers_id'],
				'return_count' => $result->fields['return_count'],
				'date_add' => $result->fields['first_date_add'],
				'user_agent' => $result->fields['user_agent'],
				'referer' => $result->fields['http_referer'],
				'action_count' => 1, /*点击操作次数*/
				'action_page_total' => 0,
				'actions' => array(),
				'action_pages' => array()
			);
			$stat[$result->fields['track_id']] += getCustomerFollowInfo((int)$result->fields['customers_id']);
		}
		
		
		$stat[$result->fields['track_id']]['actions'][$result->fields['sequence']] = array(
			'page_name' => $result->fields['action_page_name'],
			'parent_page_id' => $result->fields['parent_page_id'],
			'page_id' => $result->fields['action_page_id'],
			'refresh_count' => $result->fields['refresh_count'],
			'start_time' => $result->fields['time_start'],
			'end_time' => $result->fields['time_end']
		);
		if (!empty($result->fields['time_start']) && !empty($result->fields['time_end'])){
			$stat[$result->fields['track_id']]['actions'][$result->fields['sequence']]['time_diff'] = strtotime($result->fields['time_end'])-strtotime($result->fields['time_start']);
		}else{
			$stat[$result->fields['track_id']]['actions'][$result->fields['sequence']]['time_diff'] = 'null';
		}
		
		if (!isset($stat[$result->fields['track_id']]['action_pages'][$result->fields['action_page_name']])){
			$stat[$result->fields['track_id']]['action_pages'][$result->fields['action_page_name']] = 1;
		}else{
			++$stat[$result->fields['track_id']]['action_pages'][$result->fields['action_page_name']];
		}
		
		//++$stat[$result->fields['track_id']]['action_page_total'];
		
		
		$result->MoveNext();
	}
	
	
	
	return $stat;
}

function getCustomerFollowInfo($customer_id)
{
	global $db;
	$info = array(
		'follow_id' => '',
		'follow_orders_id' => '',
		'follow_identify' => '',
		'follow_active' => '',
		'follow_sended' => '',
		'follow_sended_date' => '',
		'follow_referer' => '',
		'follow_user_agent' => '',
		'follow_count' => '',
		'follow_keyword' => '',
		'customer_email' => '',//customers_email_address
		'follow_status' => '账号没跟踪到'
	);
	if ($customer_id <= 0)
		return $info;
	
	$sql = 'SELECT cf.*, c.customers_email_address as email FROM '.DB_PREFIX.'customers_follow cf 
		INNER JOIN '.DB_PREFIX.'customers c ON (cf.customers_id=c.customers_id AND cf.customers_id = '.(int)$customer_id.')';
	$result = $db->Execute($sql);
	while (!$result->EOF)
	{
		$info['follow_id'] = $result->fields['customers_follow'];
		$info['follow_orders_id'] = $result->fields['orders_id'];
		$info['follow_identify'] = $result->fields['identify'];
		$info['follow_active'] = $result->fields['active'];
		$info['follow_sended'] = $result->fields['sended'];
		$info['follow_sended_date'] = $result->fields['sended_date'];
		$info['follow_referer'] = $result->fields['referer'];
		$info['follow_user_agent'] = $result->fields['user_agent'];
		$info['follow_count'] = $result->fields['from_count'];
		$info['follow_keyword'] = $result->fields['keyword'];
		$info['customer_email'] = $result->fields['email'];
		
		if (!$result->fields['active'] && !$result->fields['sended'])
			$info['follow_status'] = '不正常账号';
		else
			$info['follow_status'] = '正常账号';
		
		$result->MoveNext();
	}
	return $info;
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
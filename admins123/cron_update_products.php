<?php
/**
 * @author JunsChen Junsgo@msn.com
 * @copyright Junsgo@msn.com
 * @version 0.1.3
 * UPDATE: all categories rand
 */
$timer_start = microtime(true);
define('CRON_NOT_LOGIN_YES', true); // need init_admin_auth.php
require_once ('includes/application_top.php');

$format = array(
	'amount',
	'percentage' 
);
$enable = isset($_REQUEST['enable']) ? (int)$_REQUEST['enable'] : 1;
$method = isset($_REQUEST['method']) ? strtolower($_REQUEST['method']) : 'amount';
$total = isset($_REQUEST['total']) ? floatval($_REQUEST['total']) : 0;
$updateFeature = isset($_REQUEST['updateFeature']) ? (bool)$_REQUEST['updateFeature'] : false;
$updateAddDate = isset($_REQUEST['updateAddDate']) ? (bool)$_REQUEST['updateAddDate'] : false;

$info = array();

//
if ($total <= 0 || !in_array($method, $format))
{
	// not doing
	$info = getInfo();
	
	exit(implode('<br/>', $info));
}
else
{
	// enabling
	if (isset($_REQUEST['disabled'])) $status = false;
	else
		$status = true;
	$categories = array();
	$products = getEffectProducts(!$status, $categories);
	
	if (count($products) > 0)
	{
		$ids = implode(',', $products);
		$sql = 'UPDATE `' . TABLE_PRODUCTS . '` SET `products_status` = ' . (int)$status . ($updateAddDate ? ', `products_date_added` = now(), `products_last_modified` = now()' : '') . ' WHERE `products_id` IN (' . $ids . ')';
		$db->Execute($sql);
		
		if ($status && $updateFeature)
		{
			$sql = 'INSERT INTO `' . TABLE_FEATURED . '` (`products_id`) VALUES';
			$sql_delete = 'DELETE FROM `' . TABLE_FEATURED . '` WHERE `products_id` IN (' . implode(',', $products) . ');';
			$home_category = 0;
			$position = 0;
			foreach($products as $p_id)
			{
				$sql .= '(' . $p_id . '),';
			}
			$sql = trim($sql, ',') . ';';
			$db->Execute($sql_delete);
			$db->Execute($sql);
		}
		
		if (count($categories) > 1)
		{
			if ($status)
			{
				$db->Execute('UPDATE `' . TABLE_CATEGORIES . '` c SET c.`categories_status` = 1 WHERE c.`categories_id` IN (' . implode(',', $categories) . ')');
			}
		}
		
		if (!$status) $info[] = 'Update Disabled: ' . count($products);
		else
			$info[] = 'Update Enabled: ' . count($products);
	}
	else
	{
		$info[] = 'no update product';
	}
	
	$info = array_merge($info, getInfo());
}

$timer_end = microtime(true);

exit(implode('<br/>', $info));
function getDatas($status = false, $only_product = true)
{
	global $db;
	/*
	 * $sql = 'SELECT DISTINCT(pc.`products_id`), pc.`categories_id`, p.`products_status` FROM `'.TABLE_PRODUCTS_TO_CATEGORIES.'` pc INNER JOIN `'.TABLE_PRODUCTS.'` p ON (pc.`categories_id` = p.`master_categories_id`) WHERE p.`products_status` = '.(int)$status.' ORDER BY pc.`categories_id` ASC, pc.`products_id` ASC';
	 */
	// just from products table
	$sql = 'SELECT DISTINCT(`products_id`), `master_categories_id` AS `categories_id`, `products_status`
			FROM `' . TABLE_PRODUCTS . '`
			WHERE `products_status` = ' . (int)$status . '
			ORDER BY `master_categories_id` ASC, `products_id` ASC';
	$data = array();
	$result = $db->Execute($sql);
	while(!$result->EOF)
	{
		if ($only_product) $data['disabled'][0][$result->fields['products_id']] = $result->fields['products_id'];
		else
			$data['disabled'][$result->fields['categories_id']][$result->fields['products_id']] = $result->fields['products_id'];
		
		$result->MoveNext();
	}
	
	return $data;
}
function getInfo()
{
	global $db;
	
	$enable_product_total = $db->Execute('SELECT COUNT(*) AS `total` FROM `' . TABLE_PRODUCTS . '` WHERE `products_status` = 1');
	$disable_product_total = $db->Execute('SELECT COUNT(*) AS `total` FROM `' . TABLE_PRODUCTS . '` WHERE `products_status` = 0');
	
	$enable_product_total = (int)$enable_product_total->fields['total'];
	$disable_product_total = (int)$disable_product_total->fields['total'];
	
	$info = array();
	$info[] = 'Enable: ' . $enable_product_total;
	$info[] = 'Disable: ' . $disable_product_total;
	$info[] = 'Total: ' . ($enable_product_total + $disable_product_total);
	
	return $info;
}
function getEffectProducts($status = false, &$categories = array())
{
	global $method, $total;
	$data = getDatas($status, true);
	$products = array();
	$tmp = array();
	
	$total = abs($total);
	
	foreach($data['disabled'] as $c_id => $p)
	{
		if ($method == 'percentage')
		{
			if ($total > 100) $count = count($p);
			else
				$count = ceil(($total * count($p)) / 100);
		}
		else
		{
			$count = $total;
			if ($total < 1) $count = 1;
		}
		
		if (count($p) > $count)
		{
			$tmp = array_rand($p, $count);
		}
		else
			$tmp = $p;
		
		if (!is_array($tmp)) $tmp = array(
			$tmp 
		); // fix just one
		
		$categories[] = $c_id;
		$products = array_merge($products, $tmp);
	}
	$categories = array_unique($categories);
	$products = array_unique($products);
	return $products;
}

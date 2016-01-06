<?php
/**
 * configure email, logo, filter
 */
if (!isset($no_need)){
	require('includes/application_top.php');
	
	$host = $_SERVER['HTTP_HOST'];
	$suffix = $host;
	if (strpos($host, 'www.') !== false)
		$suffix = substr($host, 4);
	if (strpos($suffix, ':') > 0)
		$suffix = substr($suffix, 0, strpos($suffix, ':'));
	
	$short_host = $suffix;
	if (strrpos($suffix, '.') > 0)
		$short_host = substr($suffix, 0, strrpos($suffix, '.'));
}
$prefix = 'info';
$email = $prefix.'@'.$suffix;

$cache = dirname(__FILE__).'/cache';
$cache = str_replace('\\', '/', $cache);

$info = array();//message


$sql = 'UPDATE `'.TABLE_CONFIGURATION.'` SET `configuration_value` = \'true\' WHERE `configuration_key` = \'SEND_EMAILS\';';
$db->Execute($sql);
$sql = 'UPDATE `'.TABLE_CONFIGURATION.'` SET `configuration_value` = \'smtpauth\' WHERE `configuration_key` = \'EMAIL_TRANSPORT\';';
$db->Execute($sql);
$sql = 'UPDATE `'.TABLE_CONFIGURATION.'` SET `configuration_value` = \''.$db->prepare_input($email).'\' WHERE `configuration_key` IN (
	\'EMAIL_SMTPAUTH_MAILBOX\', \'STORE_OWNER_EMAIL_ADDRESS\', \'EMAIL_FROM\', \'SEND_EXTRA_ORDER_EMAILS_TO\', \'SEND_EXTRA_CREATE_ACCOUNT_EMAILS_TO\', 
	\'SEND_EXTRA_TELL_A_FRIEND_EMAILS_TO\', \'SEND_EXTRA_GV_CUSTOMER_EMAILS_TO\', \'SEND_EXTRA_GV_ADMIN_EMAILS_TO\', \'SEND_EXTRA_DISCOUNT_COUPON_ADMIN_EMAILS_TO\', 
	\'SEND_EXTRA_ORDERS_STATUS_ADMIN_EMAILS_TO\', \'SEND_EXTRA_REVIEW_NOTIFICATION_EMAILS_TO\', \'SEND_EXTRA_LOW_STOCK_EMAILS_TO\');';
$db->Execute($sql);
$sql = 'UPDATE `'.TABLE_CONFIGURATION.'` SET `configuration_value` = \'bslfmail.com\' WHERE `configuration_key` = \'EMAIL_SMTPAUTH_MAIL_SERVER\';';
$db->Execute($sql);
$sql = 'UPDATE `'.TABLE_CONFIGURATION.'` SET `configuration_value` = 25 WHERE `configuration_key` = \'EMAIL_SMTPAUTH_MAIL_SERVER_PORT\';';
$db->Execute($sql);
$sql = 'UPDATE `'.TABLE_CONFIGURATION.'` SET `configuration_value` = \''.$db->prepare_input($suffix).'\' WHERE `configuration_key` IN (\'STORE_NAME\', \'STORE_OWNER\', \'HEADER_ALT_TEXT\');';
$db->Execute($sql);
$sql = 'UPDATE `'.TABLE_CONFIGURATION.'` SET `configuration_value` = \''.$db->prepare_input($short_host).'\' WHERE `configuration_key` = \'FILTER_SEARCH_KEYWORDS\';';
$db->Execute($sql);
$sql = 'UPDATE `'.TABLE_CONFIGURATION.'` SET `configuration_value` = \''.$db->prepare_input($cache).'\' WHERE `configuration_key` = \'SESSION_WRITE_DIRECTORY\';';
$db->Execute($sql);
$sql = 'UPDATE `'.TABLE_CONFIGURATION.'` SET `configuration_value` = \''.$db->prepare_input('bslf001').'\' WHERE `configuration_key` = \'EMAIL_SMTPAUTH_PASSWORD\';';
$db->Execute($sql);

$sql = 'UPDATE `'.TABLE_CONFIGURATION.'` SET `configuration_value` = \'true\' WHERE `configuration_key` = \'SEO_ENABLED\';';
$db->Execute($sql);


$template = dirname(__FILE__).'/includes/templates/template_default';
$new_template = dirname(__FILE__).'/includes/templates/'.$short_host;


$db->Execute('UPDATE `'.TABLE_TEMPLATE_SELECT.'` SET `template_dir`=\''.$short_host.'\'');


$chmod = true;
if (is_dir($template))
	$chmod = chmod($template, 0777);


if (is_dir($template))
	rename($template, $new_template);
	rename($languages1, $languages2);
@chmod($new_template, 0755);

//delete all exists
$db->Execute("DELETE FROM `".TABLE_LAYOUT_BOXES."` WHERE `layout_template`='".$db->prepare_input($short_host)."';");

$db->Execute("INSERT INTO `".TABLE_LAYOUT_BOXES."`(`layout_template`,`layout_box_name`,`layout_box_status`,`layout_box_location`,`layout_box_sort_order`,`layout_box_sort_order_single`,`layout_box_status_single`)VALUES
		('".$db->prepare_input($short_host)."', 'search.php', 1, 0, 5, 0, 1);");
$db->Execute("INSERT INTO `".TABLE_LAYOUT_BOXES."`(`layout_template`,`layout_box_name`,`layout_box_status`,`layout_box_location`,`layout_box_sort_order`,`layout_box_sort_order_single`,`layout_box_status_single`)VALUES
		('".$db->prepare_input($short_host)."', 'categories.php', 1, 0, 10, 0, 1);");
$db->Execute("INSERT INTO `".TABLE_LAYOUT_BOXES."`(`layout_template`,`layout_box_name`,`layout_box_status`,`layout_box_location`,`layout_box_sort_order`,`layout_box_sort_order_single`,`layout_box_status_single`)VALUES
		('".$db->prepare_input($short_host)."', 'whats_new.php', 1, 0, 15, 0, 1);");


$result = $db->Execute('SELECT COUNT(*) as total FROM `'.TABLE_CONFIGURATION.'` WHERE `configuration_key`=\'MAX_DISPLAY_PRODUCTS_RELATED\';');
if ((int)$result->fields['total'] <= 0)
	$db->Execute('INSERT INTO `'.TABLE_CONFIGURATION.'` (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order)
		VALUES(\'相关产品显示数量\', \'MAX_DISPLAY_PRODUCTS_RELATED\', 8, \'产品页显示相关产品数量\', 3, 25);');


$info[] = '更改完成.';
echo implode('<br/>', $info);


<?php
/**
 * @package admin
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: copy_to_confirm.php 3380 2006-04-06 05:12:45Z drbyte $
 */
if (!defined('IS_ADMIN_FLAG'))
{
	die('Illegal Access');
}
function install_quick_updates()
{
	global $db;
	$project = PROJECT_VERSION_MAJOR . '.' . PROJECT_VERSION_MINOR;
	if ((substr($project, 0, 5) == "1.3.8") || (substr($project, 0, 5) == "1.3.9"))
	{
		$db->Execute("INSERT INTO " . TABLE_CONFIGURATION_GROUP . " VALUES (NULL, '快速更新', '快速更新选项', '1', '1')");
		$group_id = mysql_insert_id();
		$db->Execute("UPDATE " . TABLE_CONFIGURATION_GROUP . " SET sort_order = " . $group_id . " WHERE configuration_group_id = " . $group_id);
		$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . "  VALUES 
		(NULL, '商品编号', 'QUICKUPDATES_DISPLAY_ID', 'true', '是否显示商品编号', " . $group_id . ", '1', NULL, NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),'), 
		(NULL, '商品缩略图', 'QUICKUPDATES_DISPLAY_THUMBNAIL', 'true', '是否显示商品缩略图', " . $group_id . ", '2', NULL, NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),'),
		(NULL, '商品型号', 'QUICKUPDATES_MODIFY_MODEL', 'true', '是否修改商品型号', " . $group_id . ", '3', NULL, NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),'),
		(NULL, '商品名称', 'QUICKUPDATES_MODIFY_NAME', 'true', '是否修改商品名称', " . $group_id . ", '4', NULL, NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),'),
		(NULL, '商品简介', 'QUICKUPDATES_MODIFY_DESCRIPTION', 'true', '是否修改商品简介', " . $group_id . ", '5', NULL, NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),'),
		(NULL, '商品状态', 'QUICKUPDATES_MODIFY_STATUS', 'true', '是否修改商品状态', " . $group_id . ", '6', NULL, NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),'),
		(NULL, '商品重量', 'QUICKUPDATES_MODIFY_WEIGHT', 'true', '是否修改商品重量', " . $group_id . ", '7', NULL, NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),'),
		(NULL, '商品数量', 'QUICKUPDATES_MODIFY_QUANTITY', 'true', '是否修改商品数量', " . $group_id . ", '8', NULL, NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),'),
		(NULL, '商品厂家', 'QUICKUPDATES_MODIFY_MANUFACTURER', 'false', '是否修改商品厂家', " . $group_id . ", '9', NULL, NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),'),
		(NULL, '商品税类', 'QUICKUPDATES_MODIFY_TAX', 'false', '是否修改商品税类', " . $group_id . ", '10', NULL, NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),'),
		(NULL, '商品分类', 'QUICKUPDATES_MODIFY_CATEGORY', 'true', '是否修改商品分类', " . $group_id . ", '11', NULL, NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),'),
		(NULL, '商品价格', 'QUICKUPDATES_DISPLAY_TVA_OVER', 'true', '鼠标指向商品时，是否显示含税价格', " . $group_id . ", '20', NULL, NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),'),
		(NULL, '前台商品页面的链接', 'QUICKUPDATES_DISPLAY_PREVIEW', 'false', '是否显示到前台商品信息页面的链接', " . $group_id . ", '30', NULL, NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),'),
		(NULL, '后台商品页面的链接', 'QUICKUPDATES_DISPLAY_EDIT', 'true', '是否显示到后台商品编辑页面的链接', " . $group_id . ", '31', NULL, NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),'),
		(NULL, '商品利润', 'QUICKUPDATES_ACTIVATE_COMMERCIAL_MARGIN', 'true', '是否显示商品利润'," . $group_id . ", '40', NULL, NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),'),
		(NULL, '商品排序', 'QUICKUPDATES_MODIFY_SORT_ORDER', 'true', '是否修改商品排序', " . $group_id . ", '12', NULL, NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),'),
		(NULL, '弹出窗口', 'QUICKUPDATES_MODIFY_DESCRIPTION_POPUP', 'true', '是否使用弹出链接修改商品简介', " . $group_id . ", '13', NULL, NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),') ");
	}
	elseif (substr($project, 0, 3) == "1.5")
	{
		$db->Execute("INSERT INTO " . TABLE_CONFIGURATION_GROUP . " VALUES (NULL, '快速更新', '快速更新选项', '1', '1')");
		$group_id = mysql_insert_id();
		$db->Execute("UPDATE " . TABLE_CONFIGURATION_GROUP . " SET sort_order = " . $group_id . " WHERE configuration_group_id = " . $group_id);
		zen_register_admin_page('quick_updates_config', 'BOX_CATALOG_QUICK_UPDATES', 'FILENAME_CONFIGURATION', 'gID=' . $group_id, 'configuration', 'Y', 103);
		$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . "  VALUES 
		(NULL, '商品编号', 'QUICKUPDATES_DISPLAY_ID', 'true', '是否显示商品编号', " . $group_id . ", '1', NULL, NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),'), 
		(NULL, '商品缩略图', 'QUICKUPDATES_DISPLAY_THUMBNAIL', 'true', '是否显示商品缩略图', " . $group_id . ", '2', NULL, NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),'),
		(NULL, '商品型号', 'QUICKUPDATES_MODIFY_MODEL', 'true', '是否修改商品型号', " . $group_id . ", '3', NULL, NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),'),
		(NULL, '商品名称', 'QUICKUPDATES_MODIFY_NAME', 'true', '是否修改商品名称', " . $group_id . ", '4', NULL, NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),'),
		(NULL, '商品简介', 'QUICKUPDATES_MODIFY_DESCRIPTION', 'true', '是否修改商品简介', " . $group_id . ", '5', NULL, NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),'),
		(NULL, '商品状态', 'QUICKUPDATES_MODIFY_STATUS', 'true', '是否修改商品状态', " . $group_id . ", '6', NULL, NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),'),
		(NULL, '商品重量', 'QUICKUPDATES_MODIFY_WEIGHT', 'true', '是否修改商品重量', " . $group_id . ", '7', NULL, NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),'),
		(NULL, '商品数量', 'QUICKUPDATES_MODIFY_QUANTITY', 'true', '是否修改商品数量', " . $group_id . ", '8', NULL, NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),'),
		(NULL, '商品厂家', 'QUICKUPDATES_MODIFY_MANUFACTURER', 'false', '是否修改商品厂家', " . $group_id . ", '9', NULL, NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),'),
		(NULL, '商品税类', 'QUICKUPDATES_MODIFY_TAX', 'false', '是否修改商品税类', " . $group_id . ", '10', NULL, NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),'),
		(NULL, '商品分类', 'QUICKUPDATES_MODIFY_CATEGORY', 'true', '是否修改商品分类', " . $group_id . ", '11', NULL, NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),'),
		(NULL, '商品价格', 'QUICKUPDATES_DISPLAY_TVA_OVER', 'true', '鼠标指向商品时，是否显示含税价格', " . $group_id . ", '20', NULL, NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),'),
		(NULL, '前台商品页面的链接', 'QUICKUPDATES_DISPLAY_PREVIEW', 'false', '是否显示到前台商品信息页面的链接', " . $group_id . ", '30', NULL, NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),'),
		(NULL, '后台商品页面的链接', 'QUICKUPDATES_DISPLAY_EDIT', 'true', '是否显示到后台商品编辑页面的链接', " . $group_id . ", '31', NULL, NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),'),
		(NULL, '商品利润', 'QUICKUPDATES_ACTIVATE_COMMERCIAL_MARGIN', 'true', '是否显示商品利润', " . $group_id . ", '40', NULL, NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),'),
		(NULL, '商品排序', 'QUICKUPDATES_MODIFY_SORT_ORDER', 'true', '是否修改商品排序', " . $group_id . ", '12', NULL, NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),'),
		(NULL, '弹出窗口', 'QUICKUPDATES_MODIFY_DESCRIPTION_POPUP', 'true', '是否使用弹出链接修改商品简介', " . $group_id . ", '13', NULL, NOW(), NULL, 'zen_cfg_select_option(array(\"true\", \"false\"),') ");
	}
	else
	{ // unsupported version
		         // i should do something here!
	}
}
function remove_quick_updates()
{
	global $db;
	$project = PROJECT_VERSION_MAJOR . '.' . PROJECT_VERSION_MINOR;
	if ((substr($project, 0, 5) == "1.3.8") || (substr($project, 0, 5) == "1.3.9"))
	{
		$sql = "SELECT configuration_group_id FROM " . TABLE_CONFIGURATION_GROUP . " WHERE configuration_group_title = '快速更新' LIMIT 1";
		$result = mysql_query($sql);
		;
		if (mysql_num_rows($result))
		{
			$group_id = mysql_fetch_array($result);
			$db->Execute("DELETE FROM " . TABLE_CONFIGURATION . " WHERE configuration_group_id = " . $group_id[0]);
			$db->Execute("DELETE FROM " . TABLE_CONFIGURATION_GROUP . " WHERE configuration_group_id = " . $group_id[0]);
		}
	}
	elseif (substr($project, 0, 3) == "1.5")
	{
		$sql = "SELECT configuration_group_id FROM " . TABLE_CONFIGURATION_GROUP . " WHERE configuration_group_title = '快速更新' LIMIT 1";
		$result = mysql_query($sql);
		;
		if (mysql_num_rows($result))
		{
			$group_id = mysql_fetch_array($result);
			$db->Execute("DELETE FROM " . TABLE_CONFIGURATION . " WHERE configuration_group_id = " . $group_id[0]);
			$db->Execute("DELETE FROM " . TABLE_CONFIGURATION_GROUP . " WHERE configuration_group_id = " . $group_id[0]);
			$db->Execute("DELETE FROM " . TABLE_ADMIN_PAGES . " WHERE page_key = 'quick_updates'");
			$db->Execute("DELETE FROM " . TABLE_ADMIN_PAGES . " WHERE page_key = 'quick_updates_config'");
		}
	}
	else
	{ // unsupported version
	}
}
?>
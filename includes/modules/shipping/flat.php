<?php
/**
 * @package shippingMethod
 * @copyright Copyright 2003-2009 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */
// $Id: flat.php 14498 2009-10-01 20:16:16Z ajeh $
//
class flat
{
	var $code, $title, $description, $icon, $enabled;
	
	// class constructor
	function flat()
	{
		global $order, $db;
		
		$this->code = 'flat';
		$this->title = MODULE_SHIPPING_FLAT_TEXT_TITLE;
		$this->description = MODULE_SHIPPING_FLAT_TEXT_DESCRIPTION;
		$this->sort_order = MODULE_SHIPPING_FLAT_SORT_ORDER;
		$this->icon = '';
		$this->tax_class = MODULE_SHIPPING_FLAT_TAX_CLASS;
		$this->tax_basis = MODULE_SHIPPING_FLAT_TAX_BASIS;
		
		// disable only when entire cart is free shipping
		if (zen_get_shipping_enabled($this->code))
		{
			$this->enabled = ((MODULE_SHIPPING_FLAT_STATUS == 'True') ? true : false);
		}
		
		if (($this->enabled == true) && ((int)MODULE_SHIPPING_FLAT_ZONE > 0))
		{
			$check_flag = false;
			$check = $db->Execute("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_FLAT_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
			while(!$check->EOF)
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
	
	// class methods
	function quote($method = '')
	{
		global $order;
		
		$this->quotes = array(
			'id' => $this->code,
			'module' => MODULE_SHIPPING_FLAT_TEXT_TITLE,
			'methods' => array(
				array(
					'id' => $this->code,
					'title' => MODULE_SHIPPING_FLAT_TEXT_WAY,
					'cost' => MODULE_SHIPPING_FLAT_COST 
				) 
			) 
		);
		if ($this->tax_class > 0)
		{
			$this->quotes['tax'] = zen_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
		}
		
		if (zen_not_null($this->icon)) $this->quotes['icon'] = zen_image($this->icon, $this->title);
		
		return $this->quotes;
	}
	function check()
	{
		global $db;
		if (!isset($this->_check))
		{
			$check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_FLAT_STATUS'");
			$this->_check = $check_query->RecordCount();
		}
		return $this->_check;
	}
	function install()
	{
		global $db;
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('打开固定运费模块', 'MODULE_SHIPPING_FLAT_STATUS', 'True', '您是否要采用固定运费方式?', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('运费成本', 'MODULE_SHIPPING_FLAT_COST', '5.00', '使用该配送方式的订单的成本运费', '6', '0', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('税率种类', 'MODULE_SHIPPING_FLAT_TAX_CLASS', '0', '计算运费使用的税率种类。', '6', '0', 'zen_get_tax_class_title', 'zen_cfg_pull_down_tax_classes(', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('税率基准', 'MODULE_SHIPPING_FLAT_TAX_BASIS', 'Shipping', '计算运费税的基准。选项为<br />Shipping - 基于客户的交货人地址<br />Billing - 基于客户的帐单地址<br />Store - 如果帐单地址/送货地区和商店地区相同，则基于商店地址', '6', '0', 'zen_cfg_select_option(array(\'Shipping\', \'Billing\', \'Store\'), ', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('送货地区', 'MODULE_SHIPPING_FLAT_ZONE', '0', '如果选择了地区，仅该地区采用该配送方式。', '6', '0', 'zen_get_zone_class_title', 'zen_cfg_pull_down_zone_classes(', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('排序顺序', 'MODULE_SHIPPING_FLAT_SORT_ORDER', '0', '显示的顺序。', '6', '0', now())");
	}
	function remove()
	{
		global $db;
		$db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key like 'MODULE\_SHIPPING\_FLAT\_%'");
	}
	function keys()
	{
		return array(
			'MODULE_SHIPPING_FLAT_STATUS',
			'MODULE_SHIPPING_FLAT_COST',
			'MODULE_SHIPPING_FLAT_TAX_CLASS',
			'MODULE_SHIPPING_FLAT_TAX_BASIS',
			'MODULE_SHIPPING_FLAT_ZONE',
			'MODULE_SHIPPING_FLAT_SORT_ORDER' 
		);
	}
}
?>
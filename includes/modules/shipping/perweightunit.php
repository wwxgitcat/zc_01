<?php
/**
 * @package shippingMethod
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: perweightunit.php 15616 2010-03-06 04:07:11Z ajeh $
 */
/**
 * "Per Weight Unit" shipping module, allowing you to offer per-unit-rate shipping options
 */
class perweightunit extends base
{
	/**
	 * $code determines the internal 'code' name used to designate "this" payment module
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
	 * module's icon
	 *
	 * @var string
	 */
	var $icon;
	/**
	 * $enabled determines whether this module shows or not...
	 * during checkout.
	 *
	 * @var boolean
	 */
	var $enabled;
	/**
	 * Constructor
	 *
	 * @return perweightunit
	 */
	function perweightunit()
	{
		global $order, $db;
		
		$this->code = 'perweightunit';
		$this->title = MODULE_SHIPPING_PERWEIGHTUNIT_TEXT_TITLE;
		$this->description = MODULE_SHIPPING_PERWEIGHTUNIT_TEXT_DESCRIPTION;
		$this->sort_order = MODULE_SHIPPING_PERWEIGHTUNIT_SORT_ORDER;
		$this->icon = '';
		$this->tax_class = MODULE_SHIPPING_PERWEIGHTUNIT_TAX_CLASS;
		$this->tax_basis = MODULE_SHIPPING_PERWEIGHTUNIT_TAX_BASIS;
		
		// disable only when entire cart is free shipping
		if (zen_get_shipping_enabled($this->code))
		{
			$this->enabled = ((MODULE_SHIPPING_PERWEIGHTUNIT_STATUS == 'True') ? true : false);
		}
		
		if ($this->enabled)
		{
			// check MODULE_SHIPPING_PERWEIGHTUNIT_HANDLING_METHOD is in
			$check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_PERWEIGHTUNIT_HANDLING_METHOD'");
			if ($check_query->EOF)
			{
				$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Handling Per Order or Per Box', 'MODULE_SHIPPING_PERWEIGHTUNIT_HANDLING_METHOD', 'Order', 'Do you want to charge Handling Fee Per Order or Per Box?', '6', '0', 'zen_cfg_select_option(array(\'Order\', \'Box\'), ', now())");
			}
		}
		
		if (($this->enabled == true) && ((int)MODULE_SHIPPING_PERWEIGHTUNIT_ZONE > 0))
		{
			$check_flag = false;
			$check = $db->Execute("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . "
                             where geo_zone_id = '" . MODULE_SHIPPING_PERWEIGHTUNIT_ZONE . "'
                             and zone_country_id = '" . $order->delivery['country']['id'] . "'
                             order by zone_id");
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
	/**
	 * Obtain quote from shipping system/calculations
	 *
	 * @param string $method        	
	 * @return array
	 */
	function quote($method = '')
	{
		global $order, $shipping_weight, $shipping_num_boxes;
		
		$total_weight_units = $shipping_weight;
		$this->quotes = array(
			'id' => $this->code,
			'module' => MODULE_SHIPPING_PERWEIGHTUNIT_TEXT_TITLE,
			'methods' => array(
				array(
					'id' => $this->code,
					'title' => MODULE_SHIPPING_PERWEIGHTUNIT_TEXT_WAY,
					'cost' => MODULE_SHIPPING_PERWEIGHTUNIT_COST * ($total_weight_units * $shipping_num_boxes) + (MODULE_SHIPPING_PERWEIGHTUNIT_HANDLING_METHOD == 'Box' ? MODULE_SHIPPING_PERWEIGHTUNIT_HANDLING * $shipping_num_boxes : MODULE_SHIPPING_PERWEIGHTUNIT_HANDLING) 
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
	/**
	 * Check to see whether module is installed
	 *
	 * @return boolean
	 */
	function check()
	{
		global $db;
		if (!isset($this->_check))
		{
			$check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_PERWEIGHTUNIT_STATUS'");
			$this->_check = $check_query->RecordCount();
		}
		return $this->_check;
	}
	/**
	 * Install the shipping module and its configuration settings
	 */
	function install()
	{
		global $db;
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('打开重量计价模块', 'MODULE_SHIPPING_PERWEIGHTUNIT_STATUS', 'True', '您要采用重量记价的配送方式吗？<br /><br />商品数量 * 单位 (商品重量) * 每单位运费', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('每单位运费', 'MODULE_SHIPPING_PERWEIGHTUNIT_COST', '1', '说明：使用该配送方式，请检查商店设置/配送参数下的大、小包裹的设置，并设置最大包裹重量为适当的值，例如 5000<br /><br />每单位运费用于下面的公式中：商品数量 * 单位 (商品重量) * 每单位运费', '6', '0', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('手续费', 'MODULE_SHIPPING_PERWEIGHTUNIT_HANDLING', '0', '该配送方式的手续费。', '6', '0', now())");
		
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('手续费基于订单还是箱数', 'MODULE_SHIPPING_PERWEIGHTUNIT_HANDLING_METHOD', 'Order', '手续费基于订单还是箱数？', '6', '0', 'zen_cfg_select_option(array(\'Order\', \'Box\'), ', now())");
		
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('税率种类', 'MODULE_SHIPPING_PERWEIGHTUNIT_TAX_CLASS', '0', '计算运费使用的税率种类。', '6', '0', 'zen_get_tax_class_title', 'zen_cfg_pull_down_tax_classes(', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('税率基准', 'MODULE_SHIPPING_PERWEIGHTUNIT_TAX_BASIS', 'Shipping', '计算运费税的基准。选项为<br />Shipping - 基于客户的交货人地址<br />Billing - 基于客户的帐单地址<br />Store - 如果帐单地址/送货地区和商店地区相同，则基于商店地址', '6', '0', 'zen_cfg_select_option(array(\'Shipping\', \'Billing\', \'Store\'), ', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('送货地区', 'MODULE_SHIPPING_PERWEIGHTUNIT_ZONE', '0', '如果选择了地区，仅该地区采用该配送方式。', '6', '0', 'zen_get_zone_class_title', 'zen_cfg_pull_down_zone_classes(', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('排序顺序', 'MODULE_SHIPPING_PERWEIGHTUNIT_SORT_ORDER', '0', '显示的顺序。', '6', '0', now())");
	}
	/**
	 * Remove the module and all its settings
	 */
	function remove()
	{
		global $db;
		$db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key LIKE  'MODULE\_SHIPPING\_PERWEIGHTUNIT\_%'");
	}
	/**
	 * Internal list of configuration keys used for configuration of the module
	 *
	 * @return array
	 */
	function keys()
	{
		return array(
			'MODULE_SHIPPING_PERWEIGHTUNIT_STATUS',
			'MODULE_SHIPPING_PERWEIGHTUNIT_COST',
			'MODULE_SHIPPING_PERWEIGHTUNIT_HANDLING',
			'MODULE_SHIPPING_PERWEIGHTUNIT_HANDLING_METHOD',
			'MODULE_SHIPPING_PERWEIGHTUNIT_TAX_CLASS',
			'MODULE_SHIPPING_PERWEIGHTUNIT_TAX_BASIS',
			'MODULE_SHIPPING_PERWEIGHTUNIT_ZONE',
			'MODULE_SHIPPING_PERWEIGHTUNIT_SORT_ORDER' 
		);
	}
}
?>
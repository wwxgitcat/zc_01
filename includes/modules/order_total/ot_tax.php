<?php
/**
 * ot_tax order-total module
 *
 * @package orderTotal
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: ot_tax.php 17018 2010-07-27 07:25:41Z drbyte $
 */
class ot_tax
{
	var $title, $output;
	function ot_tax()
	{
		$this->code = 'ot_tax';
		$this->title = MODULE_ORDER_TOTAL_TAX_TITLE;
		$this->description = MODULE_ORDER_TOTAL_TAX_DESCRIPTION;
		$this->sort_order = MODULE_ORDER_TOTAL_TAX_SORT_ORDER;
		
		$this->output = array();
	}
	function process()
	{
		global $order, $currencies;
		
		reset($order->info['tax_groups']);
		$taxDescription = '';
		$taxValue = 0;
		if (STORE_TAX_DISPLAY_STATUS == 1)
		{
			$taxAddress = zen_get_tax_locations();
			$result = zen_get_all_tax_descriptions($taxAddress['country_id'], $taxAddress['zone_id']);
			if (count($result) > 0)
			{
				foreach($result as $description)
				{
					if (!isset($order->info['tax_groups'][$description]))
					{
						$order->info['tax_groups'][$description] = 0;
					}
				}
			}
		}
		if (count($order->info['tax_groups']) > 1 && isset($order->info['tax_groups'][0])) unset($order->info['tax_groups'][0]);
		while(list($key, $value) = each($order->info['tax_groups']))
		{
			if (SHOW_SPLIT_TAX_CHECKOUT == 'true')
			{
				if ($value > 0 or ($value == 0 && STORE_TAX_DISPLAY_STATUS == 1))
				{
					$this->output[] = array(
						'title' => ((is_numeric($key) && $key == 0) ? TEXT_UNKNOWN_TAX_RATE : $key) . ':',
						'text' => $currencies->format($value, true, $order->info['currency'], $order->info['currency_value']),
						'value' => $value 
					);
				}
			}
			else
			{
				if ($value > 0 || ($value == 0 && STORE_TAX_DISPLAY_STATUS == 1))
				{
					$taxDescription .= ((is_numeric($key) && $key == 0) ? TEXT_UNKNOWN_TAX_RATE : $key) . ' + ';
					$taxValue += $value;
				}
			}
		}
		if (SHOW_SPLIT_TAX_CHECKOUT != 'true' && ($taxValue > 0 or STORE_TAX_DISPLAY_STATUS == 1))
		{
			$this->output[] = array(
				'title' => substr($taxDescription, 0, strlen($taxDescription) - 3) . ':',
				'text' => $currencies->format($taxValue, true, $order->info['currency'], $order->info['currency_value']),
				'value' => $taxValue 
			);
		}
	}
	function check()
	{
		global $db;
		if (!isset($this->_check))
		{
			$check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_ORDER_TOTAL_TAX_STATUS'");
			$this->_check = $check_query->RecordCount();
		}
		
		return $this->_check;
	}
	function keys()
	{
		return array(
			'MODULE_ORDER_TOTAL_TAX_STATUS',
			'MODULE_ORDER_TOTAL_TAX_SORT_ORDER' 
		);
	}
	function install()
	{
		global $db;
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('该模块已安装', 'MODULE_ORDER_TOTAL_TAX_STATUS', 'true', '', '6', '1','zen_cfg_select_option(array(\'true\'), ', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('排序顺序', 'MODULE_ORDER_TOTAL_TAX_SORT_ORDER', '300', '显示的排序顺序。', '6', '2', now())");
	}
	function remove()
	{
		global $db;
		$db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
	}
}
?>
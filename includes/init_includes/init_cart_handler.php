<?php
/**
 * initialise and handle cart actions
 * see {@link  http://www.zen-cart.com/wiki/index.php/Developers_API_Tutorials#InitSystem wikitutorials} for more details.
 *
 * @package initSystem
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: init_cart_handler.php 18695 2011-05-04 05:24:19Z drbyte $
 */
if (!defined('IS_ADMIN_FLAG'))
{
	die('Illegal Access');
}
if (isset($_GET['action']))
{
	/**
	 * redirect the customer to a friendly cookie-must-be-enabled page if cookies are disabled
	 */
	if ($session_started == false)
	{
		zen_redirect(zen_href_link(FILENAME_COOKIE_USAGE));
	}
	if (DISPLAY_CART == 'true')
	{
		$goto = FILENAME_SHOPPING_CART;
		$parameters = array(
			'action',
			'cPath',
			'products_id',
			'pid',
			'main_page' 
		);
	}
	else
	{
		$goto = $_GET['main_page'];
		if ($_GET['action'] == 'buy_now')
		{
			if (strpos($goto, 'reviews') > 5)
			{
				$parameters = array(
					'action' 
				);
				$goto = FILENAME_PRODUCT_REVIEWS;
			}
			else
			{
				$parameters = array(
					'action',
					'products_id' 
				);
			}
		}
		elseif ($_GET['main_page'] == FILENAME_PRODUCT_INFO)
		{
			$parameters = array(
				'action',
				'pid',
				'main_page' 
			);
		}
		else
		{
			$parameters = array(
				'action',
				'pid',
				'main_page',
				'products_id' 
			);
		}
	}
	/**
	 * require file containing code to handle default cart actions
	 */
	require (DIR_WS_INCLUDES . 'main_cart_actions.php');
}

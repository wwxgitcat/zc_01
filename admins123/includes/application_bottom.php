<?php
/**
 * @package admin
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: application_bottom.php 17088 2010-07-31 05:08:33Z drbyte $
 */
if (!defined('IS_ADMIN_FLAG'))
{
	die('Illegal Access');
}
// close session (store variables)
session_write_close();

if (STORE_PAGE_PARSE_TIME == 'true')
{
	if (!is_object($logger)) $logger = new logger();
	echo $logger->timer_stop(DISPLAY_PAGE_PARSE_TIME);
}

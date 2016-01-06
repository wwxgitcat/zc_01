<?php
/**
 * commit_checkout header_php.php
 *
 * @package rss feed
 * @copyright Copyright 2004-2008 Andrew Berezin eCommerce-Service.com
 * @copyright Portions Copyright 2003-2008 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php, v 2.1.4 14.02.2008 15:26 Andrew Berezin $
 */


if ($_SESSION['cart']->count_contents() <= 0)
{
	zen_redirect(zen_href_link(FILENAME_TIME_OUT));
}

// if the customer is not logged on, redirect them to the login page
if (!isset($_SESSION['customer_id']) || !$_SESSION['customer_id'])
{
	$_SESSION['navigation']->set_snapshot();
	zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
}
if (empty($_SESSION['payment']) || empty($_SESSION['shipping']))
{
	zen_redirect(zen_href_link(FILENAME_CHECKOUT_CONFIRMATION, '', 'SSL'));
}


require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
$define_page = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', 'commit_checkout', 'false');
$breadcrumb->add(NAVBAR_TITLE);

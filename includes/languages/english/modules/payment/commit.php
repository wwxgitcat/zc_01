<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
// |                                                                      |
// | http://www.zen-cart.com/index.php                                    |
// |                                                                      |
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
// | Simplified Chinese version   http://www.zen-cart.cn                  |
// +----------------------------------------------------------------------+
//  $Id: commit.php 002 $
//
  define('MODULE_PAYMENT_COMMIT_TEXT_ADMIN_TITLE', 'COMMIT Payment Gateway');
  define('MODULE_PAYMENT_COMMIT_TEXT_CATALOG_TITLE', 'Credit Cards');
  define('MODULE_PAYMENT_COMMIT_TEXT_DESCRIPTION', '');

  define('MODULE_PAYMENT_COMMIT_MARK_BUTTON_IMG', DIR_WS_MODULES . '/payment/commit.gif');
  define('MODULE_PAYMENT_COMMIT_MARK_BUTTON_ALT', 'Pay with Credit Cards');
  define('MODULE_PAYMENT_COMMIT_ACCEPTANCE_MARK_TEXT', 'Credit Cards');

  define('MODULE_PAYMENT_COMMIT_TEXT_CATALOG_LOGO', '<img src="' . MODULE_PAYMENT_COMMIT_MARK_BUTTON_IMG . '" alt="' . MODULE_PAYMENT_COMMIT_MARK_BUTTON_ALT . '" title="' . MODULE_PAYMENT_COMMIT_MARK_BUTTON_ALT . '" /> &nbsp;' .  '<span class="smallText">' . MODULE_PAYMENT_COMMIT_ACCEPTANCE_MARK_TEXT . '</span>');

  define('MODULE_PAYMENT_COMMIT_TEXT_CONFIG_1_1', 'Enable COMMIT Module');
  define('MODULE_PAYMENT_COMMIT_TEXT_CONFIG_1_2', 'Do you want to accept COMMIT payments?');
  define('MODULE_PAYMENT_COMMIT_TEXT_CONFIG_2_1', 'COMMIT TransNo');
  define('MODULE_PAYMENT_COMMIT_TEXT_CONFIG_2_2', 'COMMIT TransNo');
  define('MODULE_PAYMENT_COMMIT_TEXT_CONFIG_3_1', 'COMMIT key');
  define('MODULE_PAYMENT_COMMIT_TEXT_CONFIG_3_2', 'COMMIT key');
  define('MODULE_PAYMENT_COMMIT_TEXT_CONFIG_4_1', 'COMMIT Merchant ID');
  define('MODULE_PAYMENT_COMMIT_TEXT_CONFIG_4_2', 'COMMIT Merchant ID');
  define('MODULE_PAYMENT_COMMIT_TEXT_CONFIG_5_1', 'Payment Zone');
  define('MODULE_PAYMENT_COMMIT_TEXT_CONFIG_5_2', 'If a zone is selected, only enable this payment method for that zone.');
  define('MODULE_PAYMENT_COMMIT_TEXT_CONFIG_6_1', 'Set Pending Notification Status');
  define('MODULE_PAYMENT_COMMIT_TEXT_CONFIG_6_2', 'Set the status of orders made with this payment module to this value<br />(Processing recommended)');
  define('MODULE_PAYMENT_COMMIT_TEXT_CONFIG_7_1', 'Sort order of display');
  define('MODULE_PAYMENT_COMMIT_TEXT_CONFIG_7_2', 'Sort order of display. Lowest is displayed first.');

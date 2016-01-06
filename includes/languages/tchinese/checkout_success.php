<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: checkout_success.php 5407 2006-12-27 01:35:37Z drbyte $
 * Simplified Chinese version   http://www.zen-cart.cn
 */

define('NAVBAR_TITLE_1', '結帳');
define('NAVBAR_TITLE_2', '成功 - 謝謝');

define('HEADING_TITLE', '謝謝! 您的訂單結帳成功!');

define('TEXT_SUCCESS', '');
define('TEXT_NOTIFY_PRODUCTS', '請知會我下面選擇的商品更新:');
define('TEXT_SEE_ORDERS', '要查詢訂單記錄，請到<a href="' . zen_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">我的帳號</a>頁面點擊檢視所有訂單。');
define('TEXT_CONTACT_STORE_OWNER', '如有任何疑問，請到<a href="' . zen_href_link(FILENAME_CONTACT_US) . '">客戶服務中心</a>。');
define('TEXT_THANKS_FOR_SHOPPING', '謝謝您在我們這裡網上購物!');

define('TABLE_HEADING_COMMENTS', '');

define('FOOTER_DOWNLOAD', '或是以後到\'%s\'中下載。');

define('TEXT_YOUR_ORDER_NUMBER', '<strong>您的訂單號是:</strong> ');

define('TEXT_CHECKOUT_LOGOFF_GUEST', '說明: 為了完成您的訂單，建立了一個臨時帳號，您可點擊登出按鈕關閉。點擊「登出」以確保下一個使用本電腦的人不會看到您的訂單內容。當然也歡迎您繼續購物，在任何時候可以選擇登出。');
define('TEXT_CHECKOUT_LOGOFF_CUSTOMER', '多謝惠顧。點擊「登出」以確保下一個使用本電腦的人不會看到您的訂單內容。當然也歡迎您繼續購物，在任何時候可以選擇登出。');



define('TEXT_CHECKOUT_PAYMENT_STATUS_PENDING', '<strong>您的訂單狀態是:</strong> ');
define('CHECKOUT_PAYMENT_STATUS_PENDING', '處理中');

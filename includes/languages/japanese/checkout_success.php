<?php

/**

 * @package languageDefines

 * @copyright Copyright 2003-2006 Zen Cart Development Team

 * @copyright Portions Copyright 2003 osCommerce

 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0

 * @version $Id: checkout_success.php 3198 2006-03-18 00:36:08Z drbyte $

 */
define('NAVBAR_TITLE_1', 'レジへ進む');
define('NAVBAR_TITLE_2', '手続完了');
define('HEADING_TITLE', 'ご注文の手続きが完了しました。');
define('TEXT_SUCCESS', '');
define('TEXT_NOTIFY_PRODUCTS', '下記商品についてお知らせメールを希望する');
define('TEXT_SEE_ORDERS', '<a href="' . zen_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">マイページ</a>からお客様のご注文履歴をご覧いただけます。');
define('TEXT_CONTACT_STORE_OWNER', 'ご質問などございましたら<a href="' . zen_href_link(FILENAME_CONTACT_US) . '">お問い合わせページ</a>からどうぞ。');
define('TEXT_THANKS_FOR_SHOPPING', 'ご注文ありがとうございました');
define('TABLE_HEADING_COMMENTS', '');
define('FOOTER_DOWNLOAD', '\'%s\'こちらから、後で商品をダウンロードすることもできます。');
define('TEXT_YOUR_ORDER_NUMBER', '<strong>ご注文番号:</strong> ');
define('TEXT_CHECKOUT_LOGOFF_GUEST', '注: お客様の注文を完了させる為に、仮のアカウントを作成しました。上部のログオフボタンをクリックしてアカウントを終了出来ます。またログオフすることで、取り引き情報等が、次にコンピュータを使用される方の眼に触れる事がありません。このボタンをクリックすればいつでもログオフできます。ショッピングをお楽しみ下さい。');

define('TEXT_CHECKOUT_LOGOFF_CUSTOMER', '');

define('TEXT_CHECKOUT_PAYMENT_STATUS_PENDING', '<strong>ご注文状況：</strong> ');
define('CHECKOUT_PAYMENT_STATUS_PENDING', 'ペンディング');
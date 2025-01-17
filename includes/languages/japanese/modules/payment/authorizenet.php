<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers |
// | |
// | http://www.zen-cart.com/index.php |
// | |
// | Portions Copyright (c) 2003 osCommerce |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license, |
// | that is bundled with this package in the file LICENSE, and is |
// | available through the world-wide-web at the following url: |
// | http://www.zen-cart.com/license/2_0.txt. |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to |
// | license@zen-cart.com so we can mail you a copy immediately. |
// +----------------------------------------------------------------------+
// $Id: authorizenet.php 1969 2005-09-13 06:57:21Z drbyte $
//
define('MODULE_PAYMENT_AUTHORIZENET_TEXT_ADMIN_TITLE', 'Authorize.net');
define('MODULE_PAYMENT_AUTHORIZENET_TEXT_CATALOG_TITLE', 'Credit Card'); // Payment option title as displayed to the customer
define('MODULE_PAYMENT_AUTHORIZENET_TEXT_DESCRIPTION', 'クレジットカード テスト情報:<br><br>CC#: 4111111111111111<br>有効期限: 任意');
define('MODULE_PAYMENT_AUTHORIZENET_TEXT_TYPE', 'タイプ:');
define('MODULE_PAYMENT_AUTHORIZENET_TEXT_CREDIT_CARD_OWNER', 'カード名義:');
define('MODULE_PAYMENT_AUTHORIZENET_TEXT_CREDIT_CARD_NUMBER', 'カード番号:');
define('MODULE_PAYMENT_AUTHORIZENET_TEXT_CREDIT_CARD_EXPIRES', '有効期限:');
define('MODULE_PAYMENT_AUTHORIZENET_TEXT_JS_CC_OWNER', '* カード名義は' . CC_OWNER_MIN_LENGTH . '文字以上必要です。\n');
define('MODULE_PAYMENT_AUTHORIZENET_TEXT_JS_CC_NUMBER', '* カード番号は' . CC_NUMBER_MIN_LENGTH . '文字以上必要です。\n');
define('MODULE_PAYMENT_AUTHORIZENET_TEXT_ERROR_MESSAGE', 'クレジットカードの処理にエラーが発生しました. もう一度試してください。.');
define('MODULE_PAYMENT_AUTHORIZENET_TEXT_DECLINED_MESSAGE', 'クレジットカードの受付が拒否されました。他のクレジットカードを試すか詳細を加盟クレジット会社へ問い合わせてください。');
define('MODULE_PAYMENT_AUTHORIZENET_TEXT_ERROR', 'クレジットカード エラー!!');
?>

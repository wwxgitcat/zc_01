<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: cc.php 6361 2007-05-24 21:17:14Z drbyte $
 */
define('MODULE_PAYMENT_CC_TEXT_ADMIN_TITLE', 'クレジットカードー オフライン プロセスィング');
define('MODULE_PAYMENT_CC_TEXT_CATALOG_TITLE', 'クレジットカード');
define('MODULE_PAYMENT_CC_TEXT_DESCRIPTION', 'クレジットカードテスト情報:<br /><br />テスト用番号: 4111111111111111<br />有効期限: 任意');
define('MODULE_PAYMENT_CC_TEXT_CREDIT_CARD_TYPE', 'クレジットカードタイプ:');
define('MODULE_PAYMENT_CC_TEXT_CREDIT_CARD_OWNER', 'カード名義:');
define('MODULE_PAYMENT_CC_TEXT_CREDIT_CARD_NUMBER', 'カード番号:');
define('MODULE_PAYMENT_CC_TEXT_CREDIT_CARD_CVV', 'CVV 番号 (<a href="javascript:popupWindow(\'' . zen_href_link(FILENAME_POPUP_CVV_HELP) . '\')">' . '詳しい情報' . '</a>)');
define('MODULE_PAYMENT_CC_TEXT_CREDIT_CARD_EXPIRES', '有効期限:');
define('MODULE_PAYMENT_CC_TEXT_JS_CC_OWNER', '* クレジットカードの名義は' . CC_OWNER_MIN_LENGTH . '文字必要です.\n');
define('MODULE_PAYMENT_CC_TEXT_JS_CC_NUMBER', '* クレジットカード番号は半角数字で' . CC_NUMBER_MIN_LENGTH . '以上必要です。\n');
define('MODULE_PAYMENT_CC_TEXT_ERROR', 'クレジットカード エラー:');
define('MODULE_PAYMENT_CC_TEXT_JS_CC_CVV', '* CVV 番号は' . CC_CVV_MIN_LENGTH . '文字以上必要です。\n');
define('MODULE_PAYMENT_CC_TEXT_EMAIL_ERROR', '警告 - 設定エラー: ');
define('MODULE_PAYMENT_CC_TEXT_EMAIL_WARNING', '警告: クレジットカード支払いモジュールが有効になっていますが、カード情報をメール送信するように設定されていません。その結果、この方法での注文にカード番号の処理ができない可能性があります。管理画面>モジュール>支払い>クレジットカード>編集でカード情報を送信するEメールアドレスを設定してください。' . "\n\n\n\n");
define('MODULE_PAYMENT_CC_TEXT_MIDDLE_DIGITS_MESSAGE', 'こちらのメールを会計係までお送りください。それにより、対応するオンラインでのご注文情報と一緒にファイルされます: ' . "\n\n" . 'ご注文: %s' . "\n\n" . '真ん中の数字: %s' . "\n\n");
?>
<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: contact_us.php 6202 2007-04-12 22:56:10Z drbyte $
 */
define('HEADING_TITLE', 'お問い合わせ');
define('NAVBAR_TITLE', 'お問い合わせ');
define('TEXT_SUCCESS', 'メッセージが送信されました。');
define('EMAIL_SUBJECT', STORE_NAME . 'からのお問い合わせ');

define('ENTRY_NAME', 'お名前:');
define('ENTRY_EMAIL', 'Eメールアドレス:');
define('ENTRY_ENQUIRY', 'メッセージ:');

define('SEND_TO_TEXT', 'メールを送る:');
define('ENTRY_EMAIL_NAME_CHECK_ERROR', 'お名前に間違えございませんか？お名前は最低' . ENTRY_FIRST_NAME_MIN_LENGTH . '文字入力してください。');
define('ENTRY_EMAIL_CONTENT_CHECK_ERROR', 'メッセージの入力がされていないようです。メッセージの欄にお問い合わせ内容を記入して下さい。');

define('NOT_LOGGED_IN_TEXT', 'ログインしてください');
?>

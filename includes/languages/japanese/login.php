<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: login.php 6352 2007-05-20 21:05:01Z drbyte $
 */
define('NAVBAR_TITLE', 'ログイン');
define('HEADING_TITLE', 'いらっしゃいませ<br />サインインしてください');

define('HEADING_NEW_CUSTOMER', '初めてご来店のお客様は、お客様の情報を入力してアカウントを作成してください。');
define('HEADING_NEW_CUSTOMER_SPLIT', '初めてご来店のお客様');

define('TEXT_NEW_CUSTOMER_INTRODUCTION', 'この機会に是非ご登録ください!<br />' . STORE_NAME . 'では、一度アカウントを作成していただきますと以降のご利用ではお客様情報などの入力を省略することができ、ご注文状況の追跡、以前のご注文情報の確認など快適にショッピングを楽しんでいただけます。');
define('TEXT_NEW_CUSTOMER_INTRODUCTION_SPLIT', 'Have a PayPal account? Want to pay quickly with a credit card? Use the PayPal button below to use the Express Checkout option.');
define('TEXT_NEW_CUSTOMER_POST_INTRODUCTION_DIVIDER', '<span class="larger">または</span><br />');
define('TEXT_NEW_CUSTOMER_POST_INTRODUCTION_SPLIT', 'のお客様プロフィールをお作りください。<strong>' . STORE_NAME . '</strong>では、一度プロフィールをお作りいただくとお客様情報などの入力を省略することができ、ご注文状況の追跡、以前のご注文情報の確認、さらにはメンバーのみの特典のご利用も可能になります。');

define('HEADING_RETURNING_CUSTOMER', '登録済みのお客様:ログインしてください');
define('HEADING_RETURNING_CUSTOMER_SPLIT', '登録済みのお客様');

define('TEXT_RETURNING_CUSTOMER_SPLIT', '続けるには、お客様の<strong>' . STORE_NAME . '</strong> のアカウントにログインしてください');

define('TEXT_PASSWORD_FORGOTTEN', 'パスワードをお忘れですか?');

define('TEXT_LOGIN_ERROR', 'エラー: メールアドレスまたはパスワードが一致しませんでした。');
define('TEXT_VISITORS_CART', '<strong>注:</strong>お客様の&quot;ビジターズカート&quot;の内容は、ログインされると&quot;メンバーズカート&quot;の中に自動的に入ります。<a href="javascript:session_win();">[詳細]</a>');

define('TABLE_HEADING_PRIVACY_CONDITIONS', '<span class="privacyconditions">個人情報保護方針について</span>');
define('TEXT_PRIVACY_CONDITIONS_DESCRIPTION', '<span class="privacydescription">個人情報保護方針に同意される場合はチェックボックスをクリックしてください。内容はこちらでご覧いただけます。</span> <a href="' . zen_href_link(FILENAME_PRIVACY, '', 'SSL') . '"><u>個人情報保護方針</u></a>.');
define('TEXT_PRIVACY_CONDITIONS_CONFIRM', '<span class="privacyagree">個人情報保護方針に同意します。</span>');

define('ERROR_SECURITY_ERROR', 'ログインを試みた際にセキュリティ上のエラーがありました。');

define('TEXT_LOGIN_BANNED', 'エラー: アクセスが拒否されました。');


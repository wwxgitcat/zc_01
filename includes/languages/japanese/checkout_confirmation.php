<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: checkout_confirmation.php 4067 2006-08-06 07:26:21Z drbyte $
 */
define('NAVBAR_TITLE_1', 'レジへ進む');
define('NAVBAR_TITLE_2', 'ご注文内容の確認');

define('HEADING_TITLE', 'ステップ3（３ステップ中） - ご注文確認');

define('HEADING_BILLING_ADDRESS', 'ご請求先住所');
define('HEADING_DELIVERY_ADDRESS', '配送先住所');
define('HEADING_SHIPPING_METHOD', '配送方法:');
define('HEADING_PAYMENT_METHOD', 'お支払い方法:');
define('HEADING_PRODUCTS', 'カートの内容');
define('HEADING_TAX', '税額');
define('HEADING_ORDER_COMMENTS', 'ご注文についてご要望などあればご記入ください。');
// no comments entered
define('NO_COMMENTS_TEXT', 'なし');
define('TITLE_CONTINUE_CHECKOUT_PROCEDURE', '<strong>最終確認</strong>');
define('TEXT_CONTINUE_CHECKOUT_PROCEDURE', '→ご注文を確定する');

define('OUT_OF_STOCK_CAN_CHECKOUT', 'マーク' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . ' の商品は、在庫切れです。<br />品切れの商品は、在庫が入り次第ご注文の処理をいたします。');


define('TABLE_HEADING_SHIPPING_METHOD', '配送方法:');
define('TEXT_CHOOSE_SHIPPING_METHOD', 'ご希望の配送方法をお選び下さい。');
define('TITLE_PLEASE_SELECT', '選択してください');
define('TEXT_ENTER_SHIPPING_INFORMATION', '今回のご注文でご利用いただける配送方法はこちらのみです。');
define('TITLE_NO_SHIPPING_AVAILABLE', '現在はご利用いただけません');
define('TEXT_NO_SHIPPING_AVAILABLE', '<span class="alert">大変申し訳ございませんが、現在お客様のお住まいの地域への配送は行っておりません。</span><br />代わりの方法についてご相談させて頂きますので、どうぞお問い合わせください。');

define('TABLE_HEADING_COMMENTS', '注文についてご意見、ご要望などあればご記入ください。');

define('TITLE_CONTINUE_CHECKOUT_PROCEDURE', '次画面に進んでください');
define('TEXT_CONTINUE_CHECKOUT_PROCEDURE', '→お支払い方法を選択');

// when free shipping for orders over $XX.00 is active
define('FREE_SHIPPING_TITLE', '配送料無料');
define('FREE_SHIPPING_DESCRIPTION', '%s以上お買い上げの場合、配送料が無料になります。');

define('ERROR_PLEASE_RESELECT_SHIPPING_METHOD', 'ご利用可能な配送方法が変更されました。ご希望の配送方法を再選択してください。');
define('SHIPPING_COUPON', 'クーポン番号:');
define('TEXT_SHIPPING_COUPON_GET', '獲&nbsp;得');
define('TEXT_SHIPPING_COUPON_APPLY', '適用');
define('TEXT_SHIPPING_COUPON_INFO', 'クーポン番号は、ご登録のメールボックスに送信されました、メールをチェックして、番号をご入力ください。迷惑メールとして誤分類される可能性もありますので、そちらのほうもチェックしてください。');
define('TEXT_SHIPPING_COUPON_TIP', '「獲得」ボタンをクリック！今すぐ送料無料！');
define('TEXT_SHIPPING_COUPON_INFO_SUCCESS', '「送料無料」クーポンが適用されました。お買い物のクーポン適用後の金額を次のご注文手続きページで最終確認できます。');
define('TEXT_SHIPPING_COUPON_INFO_ERROR', 'エラーが出ました。クーポンコード：<span style="font-weight:bold;font-size:1.2em;">『%s』</span> 下記の点をご確認のうえ、必要に応じて再度クーポンコードを入力してください： <p>１．有効期限切れ：有効期限が切れたクーポンはご利用いただけません。</p><p>２.文字入力：クーポンコードは半角文字で入力してください。コピー&ペーストを使用すると便利です。 </p><p>3.入力回数：クーポンコードは、1回のみ入力してください。同じクーポンコードを複数回入力すると、エラーが表示されます。 同じクーポンコードを複数回入力すると、エラーが表示されます。 </p>');
define('TABLE_HEADING_PAYMENT_METHOD', 'お支払い方法');
define('TEXT_SELECT_PAYMENT_METHOD', 'お支払い方法を選択してください.');
define('TITLE_PLEASE_SELECT', '選択してください');
define('TEXT_ENTER_PAYMENT_INFORMATION', '今回のご注文でご利用いただけるお支払い方法はこれだけです。');
define('TABLE_HEADING_COMMENTS', 'ご注文についてご要望などございましたらご記入ください。');

define('TITLE_NO_PAYMENT_OPTIONS_AVAILABLE', '現在ご利用いただけません');
define('TEXT_NO_PAYMENT_OPTIONS_AVAILABLE', '<span class="alert">大変申し訳ございませんが、現在お客様のお住まいの地域からはどのお支払い方法もご利用いただけません。</span><br />代わりの方法に関してご相談させて頂きますので、どうぞお問い合わせください。');



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




<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: checkout_shipping.php 4042 2006-07-30 23:05:39Z drbyte $
 */
define('NAVBAR_TITLE_1', 'チェックアウト');
define('NAVBAR_TITLE_2', '発送方法');

define('HEADING_TITLE', 'ステップ１（３ステップ中） - 配送情報');

define('TABLE_HEADING_SHIPPING_ADDRESS', 'お届け先住所');
define('TEXT_CHOOSE_SHIPPING_DESTINATION', 'ご注文の品物は左記の住所にお届けします。<em>お届け先の変更</em>ボタンをクリックしてお届け先を変更できます。');
define('TITLE_SHIPPING_ADDRESS', 'お届け先:');

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





define('EMAIL_J_COUPON_SUBJECT', 'クーポン券の発行');
define('EMAIL_J_COUPON_HTML', '<div>%s 様</div>

<div>%s でございます。グンブロクーポン券お申し込みをお受けしています。以下の番号を本サイト指定の空欄に入力してください。</div>
<div>クーポン券番号：%s</div>
<div>この番号は今回のご注文のみご利用できます。</div>
<div>次回のご注文につきましては、再度お申し込みください。</div>

<div>%s</div>');
define('EMAIL_J_COUPON_TEXT', '%s 様

%s でございます。グンブロクーポン券お申し込みをお受けしています。以下の番号を本サイト指定の空欄に入力してください。
クーポン券番号：%s
この番号は今回のご注文のみご利用できます。
次回のご注文につきましては、再度お申し込みください。

%s');


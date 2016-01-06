<?php


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




define('TEXT_CHECKOUT_PAYMENT_INFOR_CARD_NUMBER', 'カート番号:');
//Expiration
define('TEXT_CHECKOUT_PAYMENT_INFOR_EXPIRATION', '有効期限:');
//Security Code:
define('TEXT_CHECKOUT_PAYMENT_INFOR_SECURITY_CODE', 'ｃｖｃ:');
define('TEXT_CHECKOUT_PAYMENT_INFORMATION', '商品代金のお支払いには、以下のクレジット・デビットカードをご利用いただけます。以下ご利用可能なクレジットカードの種類からお選びください。カート情報を入力してから「送信」ボタンをクリックしてください。
「※情報漏えい防止のため、本サイトではクレジットカード情報の保存は行っておりません」');

define('TEXT_CHECKOUT_PAYMENT_ERROR_CREDIT_CARD', 'クレジットカードの種類をお選びください');
define('TEXT_CHECKOUT_PAYMENT_ERROR_CARD', 'カード番号を入力してください.');
define('TEXT_CHECKOUT_PAYMENT_ERROR_CARD_NUMBER_INVALID', 'クレジットカード番号が無効です');
define('TEXT_CHECKOUT_PAYMENT_ERROR_EXPIRATION', 'クレジットカードの有効期限をお選びください');
define('TEXT_CHECKOUT_PAYMENT_ERROR_SECURITY_CODE', 'セキュリティコードを入力してください');

define('TEXT_CHECKOUT_PAYMENT_ERROR_BILLING_FIRST_NAME', '姓を入力してください');
define('TEXT_CHECKOUT_PAYMENT_ERROR_BILLING_LAST_NAME', '名を入力してください');
define('TEXT_CHECKOUT_PAYMENT_ERROR_BILLING_ADDRESS', '請求先住所が無効です');
define('TEXT_CHECKOUT_PAYMENT_ERROR_BILLING_CITY', '市区町村が無効です');
define('TEXT_CHECKOUT_PAYMENT_ERROR_BILLING_POST_CODE', '郵便番号が無効です');
define('TEXT_CHECKOUT_PAYMENT_ERROR_BILLING_EMAIL', 'メール·アドレスですが無効です');


//Billing Address
define('TITLE_CHECKOUT_PAYMENT_BILLING_ADDRESS', 'カード請求先住所詳細:');

define('TITLE_CHECKOUT_PAYMENT_FIRST_NAME', '姓:');
define('TITLE_CHECKOUT_PAYMENT_LAST_NAME', '名:');
define('TITLE_CHECKOUT_PAYMENT_ADDRESS', '住所:');
define('TITLE_CHECKOUT_PAYMENT_POST_CODE', '郵便番号:');
define('TITLE_CHECKOUT_PAYMENT_CITY', '市区町村:');
define('TITLE_CHECKOUT_PAYMENT_EMAIL', 'メール·アドレス:');
define('TITLE_CHECKOUT_PAYMENT_ORDER_SUMMARY', '明細照会');
define('TITLE_CHECKOUT_PAYMENT_CREDIT_INFOR', 'クレジット・デビットカード情報');

define('TEXT_CHECKOUT_PAYMENT_MONTH', '月');
define('TEXT_CHECKOUT_PAYMENT_YEAR', '年');


define('CHECKOUT_PAY_ERROR_WRONG_IP', '指定されたIPアドレスに誤りがあります');
define('CHECKOUT_PAY_ERROR_WRONG_EMAIL', '入力されたメールアドレスが正しくありません');
define('CHECKOUT_PAY_ERROR_WRONG_SHIPCOUNTRY', '指定された国への配送が対応できません');
define('CHECKOUT_PAY_ERROR_WRONG_BILLCOUNTRY', '入力された請求住所の国が正しくありません');
define('CHECKOUT_PAY_ERROR_WRONG_GATEWAY', 'ゲートウェイでエラーが出ています');
define('CHECKOUT_PAY_ERROR_WRONG_SIGN', 'サイトタグが正しくありません');
define('CHECKOUT_PAY_ERROR_MONTHISWRONG', '入力された月が正しくありません');
define('CHECKOUT_PAY_ERROR_YEARISWRONG', '入力された年が正しくありません');
define('CHECKOUT_PAY_ERROR_CARDNUMBERISWRONG', 'カード番号が正しくありません');
define('CHECKOUT_PAY_ERROR_CVV2ISWRONG', 'CVVパスワードが正しくありません');
define('CHECKOUT_PAY_ERROR_WRONG_SITEID', 'サイトIDが正しくありません');
define('CHECKOUT_PAY_ERROR_WRONG_CURRENCY', '指定された貨幣が正しくありません');
define('CHECKOUT_PAY_ERROR_WRONG_GOODS_MATCH', '商品がマッチングではありません');
define('CHECKOUT_PAY_ERROR_WRONG_PRODUCT', '商品データでエラーが出ています');
define('CHECKOUT_PAY_ERROR_WRONG_PRICE', 'ご注文の総計価格が正しくありません');
define('CHECKOUT_PAY_ERROR_LARGE_PRICE', 'ご注文の総計価格が高くなりました');
define('CHECKOUT_PAY_ERROR_SYSTEM_ERROR', 'エラーが出ています');
define('CHECKOUT_PAY_ERROR_EMPTY_ORDER_SN', '注文番号IDが正しくありません');
define('CHECKOUT_PAY_ERROR_EMPTY_BILLLASTNAME', '所有者の姓を入力してください');
define('CHECKOUT_PAY_ERROR_EMPTY_BILLFIRSTNAME', '所有者の名を入力してください');
define('CHECKOUT_PAY_ERROR_EMPTY_BILLCITY', '請求住所の市を入力してください');
define('CHECKOUT_PAY_ERROR_EMPTY_BILLADDRESS', '請求住所を入力してください');
define('CHECKOUT_PAY_ERROR_EMPTY_BILLPOSTCODE', '請求住所の郵便番号を入力してください');
define('CHECKOUT_PAY_ERROR_EMPTY_BILLPHONE', 'カード所有者の電話番号を入力してください');
define('CHECKOUT_PAY_ERROR_EMPTY_SHIPLASTNAME', '受取人の姓をを入力してください');
define('CHECKOUT_PAY_ERROR_EMPTY_SHIPFIRSTNAME', '受取人の名をを入力してください');
define('CHECKOUT_PAY_ERROR_EMPTY_SHIPCITY', '送付先の市を入力してください');
define('CHECKOUT_PAY_ERROR_EMPTY_SHIPADDRESS', '配送住所を入力してください');
define('CHECKOUT_PAY_ERROR_EMPTY_SHIPPOSTCODE', '送付先の郵便番号を入力してください');
define('CHECKOUT_PAY_ERROR_EMPTY_SHIPPHONE', '送付先の電話番号を入力してください');
define('CHECKOUT_PAY_ERROR_EMPTY_IP', 'IPアドレスを入力してください');

define('TEXT_CHECKOUT_PAYMENT_ERROR_TIME_OUT', 'タイムアウトを再試行してください.');


define('CHECKOUT_PAY_ERROR_STATUS_RPERROR', '決済失敗：支払いエラー。支払い手続きを再試行してください');
define('CHECKOUT_PAY_ERROR_STATUS_RPDECLINED', '決済失敗：利用拒否された。支払い手続きを再試行してください');

define('ADMIN_CHECKOUT_PAY_ERROR_WRONG_IP', 'IP地址格式不正確');
define('ADMIN_CHECKOUT_PAY_ERROR_WRONG_EMAIL', '郵箱地址不正確');
define('ADMIN_CHECKOUT_PAY_ERROR_WRONG_SHIPCOUNTRY', '配送國家不正確');
define('ADMIN_CHECKOUT_PAY_ERROR_WRONG_BILLCOUNTRY', '賬單國家不正確');
define('ADMIN_CHECKOUT_PAY_ERROR_WRONG_GATEWAY', '網關出錯');
define('ADMIN_CHECKOUT_PAY_ERROR_WRONG_SIGN', '網站標簽不正確');
define('ADMIN_CHECKOUT_PAY_ERROR_MONTHISWRONG', '月份不正確');
define('ADMIN_CHECKOUT_PAY_ERROR_YEARISWRONG', '年份不正確');
define('ADMIN_CHECKOUT_PAY_ERROR_CARDNUMBERISWRONG', '卡號不正確');
define('ADMIN_CHECKOUT_PAY_ERROR_CVV2ISWRONG', 'CVV密不正確');
define('ADMIN_CHECKOUT_PAY_ERROR_WRONG_SITEID', '網站ID不正確');
define('ADMIN_CHECKOUT_PAY_ERROR_WRONG_CURRENCY', '貨幣不正確');
define('ADMIN_CHECKOUT_PAY_ERROR_WRONG_GOODS_MATCH', '商品不匹配');
define('ADMIN_CHECKOUT_PAY_ERROR_WRONG_PRODUCT', '商品出錯');
define('ADMIN_CHECKOUT_PAY_ERROR_WRONG_PRICE', '訂單價格不正確');
define('ADMIN_CHECKOUT_PAY_ERROR_LARGE_PRICE', '訂單價格太高');
define('ADMIN_CHECKOUT_PAY_ERROR_SYSTEM_ERROR', '未知錯誤');
define('ADMIN_CHECKOUT_PAY_ERROR_EMPTY_ORDER_SN', '訂單ID不正確');
define('ADMIN_CHECKOUT_PAY_ERROR_EMPTY_BILLLASTNAME', '賬單LastName不能為空');
define('ADMIN_CHECKOUT_PAY_ERROR_EMPTY_BILLFIRSTNAME', '賬單FirstName不能為空');
define('ADMIN_CHECKOUT_PAY_ERROR_EMPTY_BILLCITY', '賬單城市不能為空');
define('ADMIN_CHECKOUT_PAY_ERROR_EMPTY_BILLADDRESS', '賬單地址不能為空');
define('ADMIN_CHECKOUT_PAY_ERROR_EMPTY_BILLPOSTCODE', '賬單郵編不能為空');
define('ADMIN_CHECKOUT_PAY_ERROR_EMPTY_BILLPHONE', '賬單電話不能為空');
define('ADMIN_CHECKOUT_PAY_ERROR_EMPTY_SHIPLASTNAME', '配送LastName不能為空');
define('ADMIN_CHECKOUT_PAY_ERROR_EMPTY_SHIPFIRSTNAME', '配送FirstName不能為空');
define('ADMIN_CHECKOUT_PAY_ERROR_EMPTY_SHIPCITY', '配送城市不能為空');
define('ADMIN_CHECKOUT_PAY_ERROR_EMPTY_SHIPADDRESS', '配送地址不能為空');
define('ADMIN_CHECKOUT_PAY_ERROR_EMPTY_SHIPPOSTCODE', '配送郵編不能為空');
define('ADMIN_CHECKOUT_PAY_ERROR_EMPTY_SHIPPHONE', '配送電話不能為空');
define('ADMIN_CHECKOUT_PAY_ERROR_EMPTY_IP', 'IP地址不能為空');
<?php

define('HEADING_NEW_CUSTOMER', 'New? Please Provide Your Billing Information');
define('HEADING_NEW_CUSTOMER_SPLIT', 'New Customers');

define('TEXT_NEW_CUSTOMER_INTRODUCTION', 'Create a customer profile with <strong>' . STORE_NAME . '</strong> which allows you to shop faster, track the status of your current orders and review your previous orders.');
define('TEXT_NEW_CUSTOMER_INTRODUCTION_SPLIT', 'Have a PayPal account? Want to pay quickly with a credit card? Use the PayPal button below to use the Express Checkout option.');
define('TEXT_NEW_CUSTOMER_POST_INTRODUCTION_DIVIDER', '<span class="larger">Or</span><br />');
define('TEXT_NEW_CUSTOMER_POST_INTRODUCTION_SPLIT', 'Create a Customer Profile with <strong>' . STORE_NAME . '</strong> which allows you to shop faster, track the status of your current orders, review your previous orders and take advantage of our other member\'s benefits.');

define('HEADING_RETURNING_CUSTOMER', 'Returning Customers: Please Log In');
define('HEADING_RETURNING_CUSTOMER_SPLIT', 'Returning Customers');

define('TEXT_RETURNING_CUSTOMER_SPLIT', 'In order to continue, please login to your <strong>' . STORE_NAME . '</strong> account.');

define('TEXT_PASSWORD_FORGOTTEN', 'Forgot your password?');

define('TEXT_LOGIN_ERROR', 'Error: Sorry, there is no match for that email address and/or password.');
define('TEXT_VISITORS_CART', '<strong>Note:</strong> If you have shopped with us before and left something in your cart, for your convenience, the contents will be merged if you log back in. <a href="javascript:session_win();">[More Info]</a>');

define('TABLE_HEADING_PRIVACY_CONDITIONS', '<span class="privacyconditions">Privacy Statement</span>');
define('TEXT_PRIVACY_CONDITIONS_DESCRIPTION', '<span class="privacydescription">Please acknowledge you agree with our privacy statement by ticking the following box. The privacy statement can be read</span> <a href="' . zen_href_link(FILENAME_PRIVACY, '', 'SSL') . '"><span class="pseudolink">here</span></a>.');
define('TEXT_PRIVACY_CONDITIONS_CONFIRM', '<span class="privacyagree">I have read and agreed to your privacy statement.</span>');

define('ERROR_SECURITY_ERROR', 'There was a security error when trying to login.');

define('TEXT_LOGIN_BANNED', 'Error: Access denied.');



define('TEXT_CHECKOUT_PAYMENT_INFOR_CARD_NUMBER', '信用卡號碼:');
//Expiration
define('TEXT_CHECKOUT_PAYMENT_INFOR_EXPIRATION', '到期時間:');
//Security Code:
define('TEXT_CHECKOUT_PAYMENT_INFOR_SECURITY_CODE', '安全碼:');
define('TEXT_CHECKOUT_PAYMENT_INFORMATION', '我們接受Visa/MasterCard的信用卡，請先選擇信用卡類型並填寫信息再提交訂單。(提示：我們不存儲信用卡任何信息。請放心使用。)');

define('TEXT_CHECKOUT_PAYMENT_INFOR_REPEAT', '請不要重複提交訂單');


define('TEXT_CHECKOUT_PAYMENT_ERROR_CREDIT_CARD', '請選擇信用卡類型.');
define('TEXT_CHECKOUT_PAYMENT_ERROR_CARD', '請輸入信用卡卡號.');
define('TEXT_CHECKOUT_PAYMENT_ERROR_CARD_NUMBER_INVALID', '卡號不正確.');
define('TEXT_CHECKOUT_PAYMENT_ERROR_EXPIRATION', '請選擇信用卡到期時間.');
define('TEXT_CHECKOUT_PAYMENT_ERROR_SECURITY_CODE', '請填寫信用卡安全碼.');

define('TEXT_CHECKOUT_PAYMENT_ERROR_BILLING_FIRST_NAME', '信用卡辦卡人姓氏.');
define('TEXT_CHECKOUT_PAYMENT_ERROR_BILLING_LAST_NAME', '信用卡辦卡人名字.');
define('TEXT_CHECKOUT_PAYMENT_ERROR_BILLING_ADDRESS', '信用卡辦卡人地址.');
define('TEXT_CHECKOUT_PAYMENT_ERROR_BILLING_CITY', '信用卡辦卡人成市.');
define('TEXT_CHECKOUT_PAYMENT_ERROR_BILLING_POST_CODE', '信用卡辦卡人郵編.');
define('TEXT_CHECKOUT_PAYMENT_ERROR_BILLING_EMAIL', '賬單郵箱.');


//Billing Address
define('TITLE_CHECKOUT_PAYMENT_BILLING_ADDRESS', '賬單地址:');
define('TITLE_CHECKOUT_PAYMENT_FIRST_NAME', '姓氏:');
define('TITLE_CHECKOUT_PAYMENT_LAST_NAME', '名字:');
define('TITLE_CHECKOUT_PAYMENT_ADDRESS', '地址:');
define('TITLE_CHECKOUT_PAYMENT_POST_CODE', '郵編:');
define('TITLE_CHECKOUT_PAYMENT_CITY', '成市:');
define('TITLE_CHECKOUT_PAYMENT_EMAIL', '郵箱:');
define('TITLE_CHECKOUT_PAYMENT_ORDER_SUMMARY', '訂單摘要');
define('TITLE_CHECKOUT_PAYMENT_CREDIT_INFOR', '信用卡信息');


define('TEXT_CHECKOUT_PAYMENT_MONTH', '月份');
define('TEXT_CHECKOUT_PAYMENT_YEAR', '年份');


define('CHECKOUT_PAY_ERROR_WRONG_IP', 'IP地址格式不正確');
define('CHECKOUT_PAY_ERROR_WRONG_EMAIL', '郵箱地址不正確');
define('CHECKOUT_PAY_ERROR_WRONG_SHIPCOUNTRY', '配送國家不正確');
define('CHECKOUT_PAY_ERROR_WRONG_BILLCOUNTRY', '賬單國家不正確');
define('CHECKOUT_PAY_ERROR_WRONG_GATEWAY', '網關出錯');
define('CHECKOUT_PAY_ERROR_WRONG_SIGN', '網站標簽不正確');
define('CHECKOUT_PAY_ERROR_MONTHISWRONG', '月份不正確');
define('CHECKOUT_PAY_ERROR_YEARISWRONG', '年份不正確');
define('CHECKOUT_PAY_ERROR_CARDNUMBERISWRONG', '卡號不正確');
define('CHECKOUT_PAY_ERROR_CVV2ISWRONG', 'CVV密不正確');
define('CHECKOUT_PAY_ERROR_WRONG_SITEID', '網站ID不正確');
define('CHECKOUT_PAY_ERROR_WRONG_CURRENCY', '貨幣不正確');
define('CHECKOUT_PAY_ERROR_WRONG_GOODS_MATCH', '商品不匹配');
define('CHECKOUT_PAY_ERROR_WRONG_PRODUCT', '商品出錯');
define('CHECKOUT_PAY_ERROR_WRONG_PRICE', '訂單價格不正確');
define('CHECKOUT_PAY_ERROR_LARGE_PRICE', '訂單價格太高');
define('CHECKOUT_PAY_ERROR_SYSTEM_ERROR', '未知錯誤');
define('CHECKOUT_PAY_ERROR_EMPTY_ORDER_SN', '訂單ID不正確');
define('CHECKOUT_PAY_ERROR_EMPTY_BILLLASTNAME', '賬單LastName不能為空');
define('CHECKOUT_PAY_ERROR_EMPTY_BILLFIRSTNAME', '賬單FirstName不能為空');
define('CHECKOUT_PAY_ERROR_EMPTY_BILLCITY', '賬單城市不能為空');
define('CHECKOUT_PAY_ERROR_EMPTY_BILLADDRESS', '賬單地址不能為空');
define('CHECKOUT_PAY_ERROR_EMPTY_BILLPOSTCODE', '賬單郵編不能為空');
define('CHECKOUT_PAY_ERROR_EMPTY_BILLPHONE', '賬單電話不能為空');
define('CHECKOUT_PAY_ERROR_EMPTY_SHIPLASTNAME', '配送LastName不能為空');
define('CHECKOUT_PAY_ERROR_EMPTY_SHIPFIRSTNAME', '配送FirstName不能為空');
define('CHECKOUT_PAY_ERROR_EMPTY_SHIPCITY', '配送城市不能為空');
define('CHECKOUT_PAY_ERROR_EMPTY_SHIPADDRESS', '配送地址不能為空');
define('CHECKOUT_PAY_ERROR_EMPTY_SHIPPOSTCODE', '配送郵編不能為空');
define('CHECKOUT_PAY_ERROR_EMPTY_SHIPPHONE', '配送電話不能為空');
define('CHECKOUT_PAY_ERROR_EMPTY_IP', 'IP地址不能為空');

define('CHECKOUT_PAY_ERROR_STATUS_RPERROR', '付款失敗：支付錯誤. 請再試一次。');
define('CHECKOUT_PAY_ERROR_STATUS_RPDECLINED', '付款失敗：拒絕. 請再試一次。');

define('TEXT_CHECKOUT_PAYMENT_ERROR_TIME_OUT', '請求超時,請再試一次.');


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





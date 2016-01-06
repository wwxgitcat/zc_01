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



define('TEXT_CHECKOUT_PAYMENT_INFOR_CARD_NUMBER', 'Card Number:');
//Expiration
define('TEXT_CHECKOUT_PAYMENT_INFOR_EXPIRATION', 'Expiration Date:');
//Security Code:
define('TEXT_CHECKOUT_PAYMENT_INFOR_SECURITY_CODE', 'CVV2/CVC2:');
define('TEXT_CHECKOUT_PAYMENT_INFORMATION', 'We accept the following credit/debit cards. Please select a card type, complete the information below, and click Continue.
(Note: For security purposes, we will not save any of your credit card data.)');

define('TEXT_CHECKOUT_PAYMENT_INFOR_REPEAT', 'Please do not submit duplicate data');


define('TEXT_CHECKOUT_PAYMENT_ERROR_CREDIT_CARD', 'Please choose credit card.');
define('TEXT_CHECKOUT_PAYMENT_ERROR_CARD', 'Please enter card number.');
define('TEXT_CHECKOUT_PAYMENT_ERROR_CARD_NUMBER_INVALID', 'Card number is invalid.');
define('TEXT_CHECKOUT_PAYMENT_ERROR_EXPIRATION', 'Please enter expiration date.');
define('TEXT_CHECKOUT_PAYMENT_ERROR_SECURITY_CODE', 'Please enter security code.');

define('TEXT_CHECKOUT_PAYMENT_ERROR_BILLING_FIRST_NAME', 'Billing first name is invalid.');
define('TEXT_CHECKOUT_PAYMENT_ERROR_BILLING_LAST_NAME', 'Billing last name is invalid.');
define('TEXT_CHECKOUT_PAYMENT_ERROR_BILLING_ADDRESS', 'Billing address is invalid.');
define('TEXT_CHECKOUT_PAYMENT_ERROR_BILLING_CITY', 'Billing City is invalid.');
define('TEXT_CHECKOUT_PAYMENT_ERROR_BILLING_POST_CODE', 'Billing Post Code is invalid.');
define('TEXT_CHECKOUT_PAYMENT_ERROR_BILLING_EMAIL', 'Billing Email is invalid.');


//Billing Address
define('TITLE_CHECKOUT_PAYMENT_BILLING_ADDRESS', 'Billing Address:');
define('TITLE_CHECKOUT_PAYMENT_FIRST_NAME', 'First Name:');
define('TITLE_CHECKOUT_PAYMENT_LAST_NAME', 'Last Name:');
define('TITLE_CHECKOUT_PAYMENT_ADDRESS', 'Address:');
define('TITLE_CHECKOUT_PAYMENT_POST_CODE', 'Post Code:');
define('TITLE_CHECKOUT_PAYMENT_CITY', 'Billing City:');
define('TITLE_CHECKOUT_PAYMENT_EMAIL', 'Email:');
define('TITLE_CHECKOUT_PAYMENT_ORDER_SUMMARY', 'Order Summary');
define('TITLE_CHECKOUT_PAYMENT_CREDIT_INFOR', 'Credit And Debit Card Information');


define('TEXT_CHECKOUT_PAYMENT_MONTH', 'Month');
define('TEXT_CHECKOUT_PAYMENT_YEAR', 'Year');




define('CHECKOUT_PAY_ERROR_WRONG_IP', 'Wrong IP address');
define('CHECKOUT_PAY_ERROR_WRONG_EMAIL', 'Wrong Email address');
define('CHECKOUT_PAY_ERROR_WRONG_SHIPCOUNTRY', 'Wrong ship country');
define('CHECKOUT_PAY_ERROR_WRONG_BILLCOUNTRY', 'Wrong bill country');
define('CHECKOUT_PAY_ERROR_WRONG_GATEWAY', 'Wrong gateway');
define('CHECKOUT_PAY_ERROR_WRONG_SIGN', 'Wrong sign');
define('CHECKOUT_PAY_ERROR_MONTHISWRONG', 'Wrong month');
define('CHECKOUT_PAY_ERROR_YEARISWRONG', 'Wrong year');
define('CHECKOUT_PAY_ERROR_CARDNUMBERISWRONG', 'Wrong card number');
define('CHECKOUT_PAY_ERROR_CVV2ISWRONG', 'Wrong cvv2');
define('CHECKOUT_PAY_ERROR_WRONG_SITEID', 'Wrong siteid');
define('CHECKOUT_PAY_ERROR_WRONG_CURRENCY', 'Wrong currency');
define('CHECKOUT_PAY_ERROR_WRONG_GOODS_MATCH', 'Wrong product match');
define('CHECKOUT_PAY_ERROR_WRONG_PRODUCT', 'Wrong product');
define('CHECKOUT_PAY_ERROR_WRONG_PRICE', 'Wrong price');
define('CHECKOUT_PAY_ERROR_LARGE_PRICE', 'Wrong large price');
define('CHECKOUT_PAY_ERROR_SYSTEM_ERROR', 'Unknown error');
define('CHECKOUT_PAY_ERROR_EMPTY_ORDER_SN', 'Empty order id');
define('CHECKOUT_PAY_ERROR_EMPTY_BILLLASTNAME', 'Empty bill lastname');
define('CHECKOUT_PAY_ERROR_EMPTY_BILLFIRSTNAME', 'Empty bill firstname');
define('CHECKOUT_PAY_ERROR_EMPTY_BILLCITY', 'Empty bill city');
define('CHECKOUT_PAY_ERROR_EMPTY_BILLADDRESS', 'Empty bill address');
define('CHECKOUT_PAY_ERROR_EMPTY_BILLPOSTCODE', 'Empty bill postcode');
define('CHECKOUT_PAY_ERROR_EMPTY_BILLPHONE', 'Empty bill phone');
define('CHECKOUT_PAY_ERROR_EMPTY_SHIPLASTNAME', 'Empty ship lastname');
define('CHECKOUT_PAY_ERROR_EMPTY_SHIPFIRSTNAME', 'Empty ship firstname');
define('CHECKOUT_PAY_ERROR_EMPTY_SHIPCITY', 'Empty ship city');
define('CHECKOUT_PAY_ERROR_EMPTY_SHIPADDRESS', 'Empty ship address');
define('CHECKOUT_PAY_ERROR_EMPTY_SHIPPOSTCODE', 'Empty ship postcode');
define('CHECKOUT_PAY_ERROR_EMPTY_SHIPPHONE', 'Empty ship phone');
define('CHECKOUT_PAY_ERROR_EMPTY_IP', 'Empty IP addrress');

define('CHECKOUT_PAY_ERROR_STATUS_RPERROR', 'Payment failed: payment error. Please try again.');
define('CHECKOUT_PAY_ERROR_STATUS_RPDECLINED', 'Payment failed: declined. Please try again.');


define('TEXT_CHECKOUT_PAYMENT_ERROR_TIME_OUT', 'Timeout please try again.');

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

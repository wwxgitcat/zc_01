<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: checkout_confirmation.php 4067 2006-08-06 07:26:21Z drbyte $
 */
define('NAVBAR_TITLE_1', 'The Shopping Cart');
define('NAVBAR_TITLE_2', 'Confirmation');

define('HEADING_TITLE', 'Step 3 of 3 - Order Confirmation');

define('HEADING_BILLING_ADDRESS', 'Billing/Payment Information');
define('HEADING_DELIVERY_ADDRESS', 'Delivery/Shipping Information');
define('HEADING_SHIPPING_METHOD', 'Shipping Method:');
define('HEADING_PAYMENT_METHOD', 'Payment Method:');
define('HEADING_PRODUCTS', 'Shopping Cart Contents');
define('HEADING_TAX', 'Tax');
define('HEADING_ORDER_COMMENTS', 'Special Instructions or Order Comments');
// no comments entered
define('NO_COMMENTS_TEXT', 'None');
define('TITLE_CONTINUE_CHECKOUT_PROCEDURE', '<strong>Final Step</strong>');
define('TEXT_CONTINUE_CHECKOUT_PROCEDURE', '- continue to confirm your order. Thank you!');

define('OUT_OF_STOCK_CAN_CHECKOUT', 'Products marked with ' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . ' are out of stock.<br />Items not in stock will be placed on backorder.');


define('TABLE_HEADING_BILLING_ADDRESS', 'Billing Address');
define('TEXT_SELECTED_BILLING_DESTINATION', 'Your billing address is shown to the left. The billing address should match the address on your credit card statement. You can change the billing address by clicking the <em>Change Address</em> button.');
define('TITLE_BILLING_ADDRESS', 'Billing Address:');

define('TABLE_HEADING_PAYMENT_METHOD', 'Payment Method');
define('TEXT_SELECT_PAYMENT_METHOD', 'Please select a payment method for this order.');
define('TITLE_PLEASE_SELECT', 'Please Select');
define('TEXT_ENTER_PAYMENT_INFORMATION', '');
define('TABLE_HEADING_COMMENTS', 'Special Instructions or Order Comments');

define('TITLE_NO_PAYMENT_OPTIONS_AVAILABLE', 'Not Available At This Time');

define('TABLE_HEADING_SHIPPING_METHOD', 'Shipping Method:');
define('TEXT_CHOOSE_SHIPPING_METHOD', 'Please select the preferred shipping method to use on this order.');
define('TITLE_PLEASE_SELECT', 'Please Select');
define('TEXT_ENTER_SHIPPING_INFORMATION', 'This is currently the only shipping method available to use on this order.');
define('TITLE_NO_SHIPPING_AVAILABLE', 'Not Available At This Time');
define('TEXT_NO_SHIPPING_AVAILABLE', '<span class="alert">Sorry, we are not shipping to your region at this time.</span><br />Please contact us for alternate arrangements.');

define('TABLE_HEADING_COMMENTS', 'Special Instructions or Comments About Your Order');

define('TITLE_CONTINUE_CHECKOUT_PROCEDURE', 'Continue to Step 2');
define('TEXT_CONTINUE_CHECKOUT_PROCEDURE', '- choose your payment method.');

// when free shipping for orders over $XX.00 is active
define('FREE_SHIPPING_TITLE', 'Free Shipping');
define('FREE_SHIPPING_DESCRIPTION', 'Free shipping for orders over %s');

define('ERROR_PLEASE_RESELECT_SHIPPING_METHOD', 'Your available shipping options have changed. Please re-select your desired shipping method.');




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





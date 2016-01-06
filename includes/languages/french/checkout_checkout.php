<?php

define('HEADING_NEW_CUSTOMER', 'Nouveau ? Se il vous plaît fournir vos informations de facturation');
define('HEADING_NEW_CUSTOMER_SPLIT', 'nouveaux clients');

define('TEXT_NEW_CUSTOMER_INTRODUCTION', 'Create a customer profile with <strong>' . STORE_NAME . '</strong> which allows you to shop faster, track the status of your current orders and review your previous orders.');
define('TEXT_NEW_CUSTOMER_INTRODUCTION_SPLIT', 'Avoir un compte PayPal ? Vous voulez payer rapidement avec une carte de crédit ? Utilisez le bouton PayPal ci-dessous pour utiliser l\'option Express Checkout.');
define('TEXT_NEW_CUSTOMER_POST_INTRODUCTION_DIVIDER', '<span class="larger">Or</span><br />');
define('TEXT_NEW_CUSTOMER_POST_INTRODUCTION_SPLIT', 'Create a Customer Profile with <strong>' . STORE_NAME . '</strong> which allows you to shop faster, track the status of your current orders, review your previous orders and take advantage of our other member\'s benefits.');

define('HEADING_RETURNING_CUSTOMER', 'Returning Customers: Se il vous plaît Connexion');
define('HEADING_RETURNING_CUSTOMER_SPLIT', 'clients de retour');

define('TEXT_RETURNING_CUSTOMER_SPLIT', 'Afin de continuer , se il vous plaît vous connecter à votre compte <strong>' . STORE_NAME . '</strong>.');

define('TEXT_PASSWORD_FORGOTTEN', 'Mot de passe oublié?');

define('TEXT_LOGIN_ERROR', 'Error: Désolé , il n\'y a pas de match pour cette adresse e-mail et / ou mot de passe.');
define('TEXT_VISITORS_CART', '<strong>Note:</strong> Si vous avez acheté des produits avec nous avant et laissé quelque chose dans votre panier , pour votre commodité , le contenu seront fusionnés si vous vous reconnectez. <a href="javascript:session_win();">[More Info]</a>');

define('TABLE_HEADING_PRIVACY_CONDITIONS', '<span class="privacyconditions">Déclaration de confidentialité</span>');
define('TEXT_PRIVACY_CONDITIONS_DESCRIPTION', '<span class="privacydescription">Please acknowledge you agree with our privacy statement by ticking the following box. The privacy statement can be read</span> <a href="' . zen_href_link(FILENAME_PRIVACY, '', 'SSL') . '"><span class="pseudolink">here</span></a>.');
define('TEXT_PRIVACY_CONDITIONS_CONFIRM', '<span class="privacyagree">I have read and agreed to your privacy statement.</span>');

define('ERROR_SECURITY_ERROR', 'Il y avait une erreur de sécurité lorsque vous essayez de vous identifier.');

define('TEXT_LOGIN_BANNED', 'erreur: accès refusé.');



define('TEXT_CHECKOUT_PAYMENT_INFOR_CARD_NUMBER', 'Numéro de la carte:');
//Expiration
define('TEXT_CHECKOUT_PAYMENT_INFOR_EXPIRATION', 'date D\'Expiration:');
//Security Code:
define('TEXT_CHECKOUT_PAYMENT_INFOR_SECURITY_CODE', 'code De Sécurité:');
define('TEXT_CHECKOUT_PAYMENT_INFORMATION', 'Nous acceptons les cartes de crédit / débit suivantes . Se il vous plaît sélectionner un type de carte, compléter les informations ci-dessous et cliquez sur Continuer .
(Note : Pour des raisons de sécurité , nous ne sauvera pas l\'un de vos données de carte de crédit.)');

define('TEXT_CHECKOUT_PAYMENT_INFOR_REPEAT', 'Se il vous plaît ne pas soumettre les données en double');


define('TEXT_CHECKOUT_PAYMENT_ERROR_CREDIT_CARD', 'Se il vous plaît choisir la carte de crédit.');
define('TEXT_CHECKOUT_PAYMENT_ERROR_CARD', 'Se il vous plaît entrer le numéro de la carte.');
define('TEXT_CHECKOUT_PAYMENT_ERROR_CARD_NUMBER_INVALID', 'Numéro de la carte ne est pas valide.');
define('TEXT_CHECKOUT_PAYMENT_ERROR_EXPIRATION', 'Se il vous plaît entrer la date d\'expiration.');
define('TEXT_CHECKOUT_PAYMENT_ERROR_SECURITY_CODE', 'Se il vous plaît entrez le code de sécurité.');

define('TEXT_CHECKOUT_PAYMENT_ERROR_BILLING_FIRST_NAME', 'Facturation prénom est invalide.');
define('TEXT_CHECKOUT_PAYMENT_ERROR_BILLING_LAST_NAME', 'Facturation nom ne est pas valide.');
define('TEXT_CHECKOUT_PAYMENT_ERROR_BILLING_ADDRESS', 'Adresse de facturation ne est pas valide.');
define('TEXT_CHECKOUT_PAYMENT_ERROR_BILLING_CITY', 'Facturation Ville ne est pas valide.');
define('TEXT_CHECKOUT_PAYMENT_ERROR_BILLING_POST_CODE', 'Code de facturation du message est invalide.');
define('TEXT_CHECKOUT_PAYMENT_ERROR_BILLING_EMAIL', 'Facturation Email est invalide.');


//Billing Address
define('TITLE_CHECKOUT_PAYMENT_BILLING_ADDRESS', 'Adresse De Facturation:');
define('TITLE_CHECKOUT_PAYMENT_FIRST_NAME', 'prénom:');
define('TITLE_CHECKOUT_PAYMENT_LAST_NAME', 'Nom De Famille:');
define('TITLE_CHECKOUT_PAYMENT_ADDRESS', 'adresse:');
define('TITLE_CHECKOUT_PAYMENT_POST_CODE', 'code Postal:');
define('TITLE_CHECKOUT_PAYMENT_CITY', 'facturation Ville:');
define('TITLE_CHECKOUT_PAYMENT_EMAIL', 'Email:');
define('TITLE_CHECKOUT_PAYMENT_ORDER_SUMMARY', 'Résumé de la commande');
define('TITLE_CHECKOUT_PAYMENT_CREDIT_INFOR', 'Cartes de crédit et de débit d\'information');

define('TEXT_CHECKOUT_PAYMENT_MONTH', 'mois');
define('TEXT_CHECKOUT_PAYMENT_YEAR', 'année');


define('CHECKOUT_PAY_ERROR_WRONG_IP', 'Mauvaise adresse IP');
define('CHECKOUT_PAY_ERROR_WRONG_EMAIL', 'Mauvaise adresse courriel');
define('CHECKOUT_PAY_ERROR_WRONG_SHIPCOUNTRY', 'Pays du navire erronées');
define('CHECKOUT_PAY_ERROR_WRONG_BILLCOUNTRY', 'Pays de factures erronées');
define('CHECKOUT_PAY_ERROR_WRONG_GATEWAY', 'mauvais passerelle');
define('CHECKOUT_PAY_ERROR_WRONG_SIGN', 'mauvais signe');
define('CHECKOUT_PAY_ERROR_MONTHISWRONG', 'mauvais mois');
define('CHECKOUT_PAY_ERROR_YEARISWRONG', 'mauvaise année');
define('CHECKOUT_PAY_ERROR_CARDNUMBERISWRONG', 'Numéro de carte Mauvais');
define('CHECKOUT_PAY_ERROR_CVV2ISWRONG', 'mauvais cvv2');
define('CHECKOUT_PAY_ERROR_WRONG_SITEID', 'mauvais siteid');
define('CHECKOUT_PAY_ERROR_WRONG_CURRENCY', 'mauvaise devise');
define('CHECKOUT_PAY_ERROR_WRONG_GOODS_MATCH', 'Mauvais match de produit');
define('CHECKOUT_PAY_ERROR_WRONG_PRODUCT', 'mauvais produit');
define('CHECKOUT_PAY_ERROR_WRONG_PRICE', 'mauvais prix');
define('CHECKOUT_PAY_ERROR_LARGE_PRICE', 'Mauvais grand prix');
define('CHECKOUT_PAY_ERROR_SYSTEM_ERROR', 'erreur inconnue');
define('CHECKOUT_PAY_ERROR_EMPTY_ORDER_SN', 'Afin vide id');
define('CHECKOUT_PAY_ERROR_EMPTY_BILLLASTNAME', 'Empty facture nom');
define('CHECKOUT_PAY_ERROR_EMPTY_BILLFIRSTNAME', 'Empty facture prénom');
define('CHECKOUT_PAY_ERROR_EMPTY_BILLCITY', 'Ville vide de loi');
define('CHECKOUT_PAY_ERROR_EMPTY_BILLADDRESS', 'Adresse de loi vide');
define('CHECKOUT_PAY_ERROR_EMPTY_BILLPOSTCODE', 'Empty facture code postal');
define('CHECKOUT_PAY_ERROR_EMPTY_BILLPHONE', 'Empty téléphone projet de loi');
define('CHECKOUT_PAY_ERROR_EMPTY_SHIPLASTNAME', 'Nom du navire vide');
define('CHECKOUT_PAY_ERROR_EMPTY_SHIPFIRSTNAME', 'Prénom du navire vide');
define('CHECKOUT_PAY_ERROR_EMPTY_SHIPCITY', 'Ville du navire vide');
define('CHECKOUT_PAY_ERROR_EMPTY_SHIPADDRESS', 'L\'adresse de bateau vide');
define('CHECKOUT_PAY_ERROR_EMPTY_SHIPPOSTCODE', 'Code postal du navire vide');
define('CHECKOUT_PAY_ERROR_EMPTY_SHIPPHONE', 'Téléphone navire vide');
define('CHECKOUT_PAY_ERROR_EMPTY_IP', 'IP addrress vide');

define('TEXT_CHECKOUT_PAYMENT_ERROR_TIME_OUT', 'La temporisation, Veuillez réessayer.');


define('CHECKOUT_PAY_ERROR_STATUS_RPERROR', 'L\'insuffisance de paiement: Erreur de paiement. Veuillez réessayer.');
define('CHECKOUT_PAY_ERROR_STATUS_RPDECLINED', 'L\'insuffisance de paiement: Refuser. Veuillez réessayer.');


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

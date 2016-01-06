<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: checkout_success.php 5407 2006-12-27 01:35:37Z drbyte $
 * 
 * Traduction fran�aise de Zen Cart 1.3.8a par Damien. 
 * Auteur : Zen Cart France : http://www.zencart-france.com 
 * Package : zen-cart-v1.3.8a-FR
 */

  define('NAVBAR_TITLE_1', 'Commander');
  define('NAVBAR_TITLE_2', 'Succ&egrave;s - Fin de la Commande');

  define('HEADING_TITLE', 'Merci pour votre commande et votre confiance !');

  define('TEXT_SUCCESS', 'Vous allez recevoir un email de confirmation contenant le recapitulatif de votre commande.');
  define('TEXT_NOTIFY_PRODUCTS', 'Veuillez m\'informer des mises &agrave; jour de ces produits :');
  define('TEXT_SEE_ORDERS', 'Vous pouvez consulter votre historique de commandes en vous rendant sur la page <a href="' . zen_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">Mon Compte</a> et en cliquant sur "Voir toutes les commandes".');
  define('TEXT_CONTACT_STORE_OWNER', 'Pour toute question concernant votre commande, merci de contacter notre <a href="' . zen_href_link(FILENAME_CONTACT_US) . '">Service Clients</a>.');
  define('TEXT_THANKS_FOR_SHOPPING', 'Nous vous remercions de votre confiance.');

  define('TABLE_HEADING_COMMENTS', '');

  define('FOOTER_DOWNLOAD', 'Vous pouvez aussi t&eacute;l&eacute;charger vos achats ult&eacute;rieurement sur \'%s\'');

define('TEXT_YOUR_ORDER_NUMBER', '<strong>Votre num&eacute;ro de commande est :</strong> ');

define('TEXT_CHECKOUT_LOGOFF_GUEST', 'NOTE: Pour terminer votre commande, un compte temporaire vient d\'&ecirc;tre cr&eacute;&eacute;. Vous pouvez fermer ce compte en cliquant sur "Se d&eacute;connecter". Se d&ecirc;connecter permet aussi de s\'assurer que les informations de votre commande ne sont pas visibles &agrave; une autre personne qui utilisera votre ordinateur. Si vous souhaitez continuer vos achats, n\'h&eacute;sitez pas ! Vous pourrez vous d&eacute;connecter &agrave; tout moment en utilisant le lien en haut de la page.');
define('TEXT_CHECKOUT_LOGOFF_CUSTOMER', 'Merci de votre achat. Veuillez cliquer sur le lien "Se d&eacute;connecter" pour s\'assurer que vos informations d\'achat ne seront visibles par une personne qui utiliserait votre ordinateur apr&egrave;s vous.');


define('TEXT_CHECKOUT_PAYMENT_STATUS_PENDING', '<strong>L\'état de la commande:</strong> ');
define('CHECKOUT_PAYMENT_STATUS_PENDING', 'Indéterminé');


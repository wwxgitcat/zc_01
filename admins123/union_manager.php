<?php

/**
 * echo customer,customer_follow,order,address
 * @author JunsChen Junsgo@msn.com
 * @copyright Junsgo@msn.com
 * @version 0.1.2
 */
error_reporting(E_ALL & E_NOTICE);
@ini_set('display_errors', 1);

require_once 'union_manager/union_manager.php';

$timer_start = microtime(true);
define('CRON_NOT_LOGIN_YES', true); // need init_admin_auth.php
require_once ('includes/application_top.php');

define('TABLE_CUSTOMERS_FOLLOW', DB_PREFIX . 'customers_follow');

$manager = new UnionManager();
$serialize = $manager->getNewsCustomerDetail();

exit($serialize);
<?php
/**
* Template designed by 12leaves.com
* 12leaves.com - Free ecommerce templates and design services
 * Page Template
 *
 * Displays EZ-Pages Header-Bar content.<br />
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_ezpages_bar_header.php 3377 2006-04-05 04:43:11Z ajeh $
 */

/**
 * require code to show EZ-Pages list
 */
/*
 * if ($current_page_base == 'index') { $active	= 'tab_active'; }
 */
include (DIR_WS_MODULES . zen_get_module_directory('ezpages_bar_header.php'));
?>
<?php

if (sizeof($var_linksList) >= 1)
{
	?>
<div id="navEZPagesTop">
	<ul class="list-style-none">
		<li><?php echo '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">'; ?><?php echo HEADER_TITLE_CATALOG; ?></a></li>
		<?php for ($i=1, $n=sizeof($var_linksList); $i<=$n; $i++) { ?>
		<li><a href="<?php echo $var_linksList[$i]['link']; ?>"><?php echo $var_linksList[$i]['name']; ?></a><?php /* echo ($i < $n ? EZPAGES_SEPARATOR_HEADER : '') . "\n"; */?></li>
		<?php  } // end FOR loop ?>
	</ul>
</div>
<?php } ?>

<?php
/**
 * input text to product configuration first
 * @package system
 * @author JunsGo@msn.com
 * @copyright Copyright 2013 SL Development Team
 * @version 1.0
 */
define('CRON_NOT_LOGIN_YES', true); // CSV
require_once ('includes/application_top.php');

set_time_limit(0);
ini_set('max_input_time', '1800');

if (isset($_GET['install']))
{
	$sql = 'INSERT INTO `'.TABLE_ADMIN_PAGES.'` (page_key, language_key, main_page, page_params, menu_key, display_on_menu, sort_order)'
		."VALUES('firstConfig','BOX_FIRST_CONFIG','FILENAME_FIRST_CONFIG','','tools','Y',27);";
	$db->Execute($sql);

	exit('Installed.');
}

//language
$languages = array(
	'en' => array(
		'name' => 'English',
		'dir' => 'english',
		'code' => 'en',
		'img' => 'icon.gif',
		'cur' => 'USD'
	),
	'fr' => array(
		'name' => 'French',
		'dir' => 'french',
		'code' => 'fr',
		'img' => 'icon.gif',
		'cur' => 'EUR'
	),
	'de' => array(
		'name' => 'Ferman',
		'dir' => 'german',
		'code' => 'de',
		'img' => 'icon.gif',
		'cur' => 'EUR'
	),
);
$currencies = array(
	'USD' => array(
		'title' => 'US Dollar',
		'code' => 'USD',
		'left' => '$',
		'right' => '',
		'decimal' => '.',
		'thousands' => ',',
		'places' => '2',
		'value' => '1'
	),
	'AUD' => array(
		'title' => 'Australian Dollar',
		'code' => 'AUD',
		'left' => '$',
		'right' => '',
		'decimal' => '.',
		'thousands' => ',',
		'places' => '2',
		'value' => '1'
	),
	'CAD' => array(
		'title' => 'Canadian Dollar',
		'code' => 'CAD',
		'left' => '$',
		'right' => '',
		'decimal' => '.',
		'thousands' => ',',
		'places' => '2',
		'value' => '1'
	),
	'EUR' => array(
		'title' => 'Euro',
		'code' => 'EUR',
		'left' => '',
		'right' => '&euro;',
		'decimal' => '.',
		'thousands' => ',',
		'places' => '2',
		'value' => '1'
	),
	'GBP' => array(
		'title' => 'GB Pound',
		'code' => 'GBP',
		'left' => '&pound;',
		'right' => '',
		'decimal' => '.',
		'thousands' => ',',
		'places' => '2',
		'value' => '1'
	),
	'JPY' => array(
		'title' => 'Japance',
		'code' => 'JPY',
		'left' => '',
		'right' => '円',
		'decimal' => '.',
		'thousands' => ',',
		'places' => '2',
		'value' => '1'
	),
);
//end language
//country
//table countries
$country = array(
	array(
		'name' => 'French',
		'iso2' => 'FR',
		'iso3' => 'FRA',
		'format' => 1
	),
	array(
		'name' => 'Japan',
		'iso2' => 'JA',
		'iso3' => 'JPN',
		'format' => 1
	)
);
//end country
//zones
//table zones
//table zones_to_geo_zones
$zones = array(
	'FR' => array(
		
	)
)





?>
<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type"
	content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css"
	href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script type="text/javascript">
	<!--
		function init()
		{
		cssjsmenu('navbar');
		if (document.getElementById)
		{
		var kill = document.getElementById('hoverJS');
		kill.disabled = true;
		}
		}
		function init_submit(name){
			var data_name = document.getElementById('data_name');
			data_name.value=name;
			
		}
	// -->
	</script>
<style type="text/css">
#from_name{
	
}
.home-banner{
	
}
.home-banner .msg{
	margin: 10px 0;
}
.home-banner .data:after{
	content: " ";
	display:table;
	clear: both;
}
.home-banner .opt{
	text-align: center;
	margin-top: 20px;
}
.data .l{
	float: left;
	width: 210px;
}
.data .r{
	float: left;
	margin-left: 20px;
}
</style>
</head>
<body onLoad="init()">
	<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

	<!-- body //-->

	<table border="0" width="100%" cellspacing="2" cellpadding="2">
		<tr>
			<td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10');?></td>
		</tr>
		<tr>
			<td>
				
				<form id="from_name" enctype="multipart/form-data" action="first_config.php" method="post">
					<table border="0" cellspacing="0" >
						<tr>
							<td>
								<label>
									<select name="language">
										
									</select>
								</label>
							</td>
							<td><input type="submit" name="submit" value="Change Language"/></td>
						</tr>
					</table>
				</form>
				
			</td>
		</tr>
		<tr>
			<td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10');?></td>
		</tr>
	</table>
	<script type="text/javascript">
	var frm = document.getElementById('from_name');
	frm.onsubmit = function(){
		if (confirm('Are you sure?'))
			return true;
		
		return false;
	}
</script>
	<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>

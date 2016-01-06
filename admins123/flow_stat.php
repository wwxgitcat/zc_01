<?php
/**
 * Manager tracking
 * @package system
 * @author JunsGo@msn.com
 * @version 1.0
 * create: 2014/3/13
 * update: 2014/3/13
 */
define('CRON_NOT_LOGIN_YES', true); // CSV
require_once ('includes/application_top.php');
set_time_limit(0);


$down_types = array('csv');

if (isset($_GET['down']) && !empty($_GET['down']) && in_array($_GET['down'], $down_types))
{
	$host = (isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : $_SERVER['HTTP_HOST']);
	if (stripos($host, 'www.') !== false)
		$host = str_ireplace('www.', '', $host);
	if (strpos($host, '.') !== false)
		$host = substr($host, 0, strpos($host, '.'));

	$export_file_ext = '.csv';
	$export_filename = $host.'_'.date('YmdHis');
	
	$columns = array();
	
	$result = $db->Execute('DESCRIBE flow_stat;');
	while (!$result->EOF)
	{
		$columns[] = $result->fields['Field'];
		$result->MoveNext();
	}
	
	$filed_format = implode(',', $columns)."\n";
	switch ($_GET['down'])
	{
		case 'csv':
			header("Content-type: application/csv");
			header("Content-disposition: attachment; filename={$export_filename}{$export_file_ext}");
			header("Pragma: ");
			header("Expires: 0");
				
			$fp = fopen("php://output", "w+");
			fwrite($fp, $filed_format);
			
			$result = $db->Execute('SELECT * FROM flow_stat ORDER BY id ASC');
			while (!$result->EOF)
			{
				$field = array();
				foreach ($columns as $col)
				{
					$field[] = str_replace(',', ' ', $result->fields[$col]);
				}
				fwrite($fp, implode(',', $field)."\n");
				
				$result->MoveNext();
			}
			fclose($fp);
				
			break;
	}
	exit;
}




?>
<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
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
.every{padding-bottom:5px;border-bottom:1px solid #555;}
.every span{display:inline-block;}
	.seq{width:80px;}
.page{width:100px;}
.pre{width:70px;}
.cur{width:80px;}
.refr{width:65px;}
.stop{width:100px;}
.pagin a{
display:inline-block;
padding:5px;
border:1px solid #CCC;
border-radius:3px;
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
				<a href="?down=csv">
				导出CSV
				</a>
			</td>
		</tr>
		<tr>
			<td>
				
			</td>
		</tr>
		<tr>
			<td class="pagin">
			
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
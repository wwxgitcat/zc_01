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
	$db->Execute("INSERT INTO `".TABLE_ADMIN_PAGES."` (`page_key` ,`language_key` ,`main_page` ,`page_params` ,`menu_key` ,`display_on_menu` ,`sort_order`) VALUES ('mailInfo', 'BOX_CUSTOMERS_MAIL_INFOR', 'FILENAME_MAIL_INFOR', '', 'customers', 'Y', '11');");
	$db->Execute("CREATE TABLE IF NOT EXISTS `email_infor`(
	`email_infor_id`	INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`smtp_user`				VARCHAR(255) NOT NULL,
	`smtp_addr`				VARCHAR(512) NOT NULL,
	`smtp_pwd`				VARCHAR(128) NOT NULL,
	`smtp_port`				INT NOT NULL DEFAULT '25',
	`date_add`			DATETIME NOT NULL DEFAULT '2014-11-22 22:14:04',
	PRIMARY KEY(`email_infor_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");
	
	
	exit('Installed');
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
if(($_GET['page'] == '' or $_GET['page'] <= 1) and $_GET['oID'] != '')
{
	$check_page = $db->Execute('SELECT COUNT(*) AS total FROM email_infor;');
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
$query_raw = 'SELECT * FROM email_infor';
// $orders_query_numrows = '';
$emails_split = new splitPageResults($_GET['page'], $page_num, $query_raw, $orders_query_numrows);
$emails = $db->Execute($query_raw);

if (isset($_GET['eID']) && (int)$_GET['eID'] > 0)
{
	$info = $db->Execute('SELECT * FROM email_infor WHERE email_infor_id='.(int)$_GET['eID']);
	$info = new objectInfo($info->fields);
}
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
					<td class="dataTableHeadingContent" align="left">SMTP用户名</td>
					<td class="dataTableHeadingContent">SMTP地址</td>
					<td class="dataTableHeadingContent">SMTP密码</td>
					<td class="dataTableHeadingContent">SMTP端口</td>
					<td class="dataTableHeadingContent" align="right">Action&nbsp;</td>
				</tr>
		<?php while (!$emails->EOF):?>
		<tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">
            <td class="dataTableContent" align="right"><?php echo $emails->fields['email_infor_id'];?></td>
			<td class="dataTableContent" align="left"><?php echo $emails->fields['smtp_user'];?></td>
			<td class="dataTableContent"><?php echo $emails->fields['smtp_addr'];?></td>
			<td class="dataTableContent"><?php echo $emails->fields['smtp_pwd'];?></td>
			<td class="dataTableContent"><?php echo $emails->fields['smtp_port'];?></td>
			<td class="dataTableContent" align="right">
			<a href="<?php echo zen_href_link('email_infor.php', 'action=edit&eID='.$emails->fields['email_infor_id']);?>">Edit</a>
			</td>
		</tr>
		<?php $emails->MoveNext(); endwhile;?>
			</tbody>
			</table>
		</td>
		
		<td width="30%">
		<table border="0" width="100%" cellspacing="0" cellpadding="2">
					<tr>
						<td >
			<form method="post" name="form_mail" enctype="multipart/form-data">
				<table border="0" width="100%" cellspacing="0" cellpadding="2">
					<tr class="infoBoxHeading">
						<td class="infoBoxHeading">
							<strong>[<?php echo isset($info->email_infor_id) ? $info->email_infor_id : '';?>]</strong>
						</td>
					</tr>
					<tr>
						<td>SMTP用户名:<input type="text" name="smtp_user" value="<?php echo isset($info->smtp_user) ? $info->smtp_user : '';?>" style="width:100%"/></td>
					</tr>
					<tr>
						<td>SMTP地址:<input type="text" name="smtp_addr" value="<?php echo isset($info->smtp_addr) ? $info->smtp_addr : '';?>" style="width:100%"/></td>
					</tr>
					<tr>
						<td>SMTP密码:<input type="text" name="smtp_pwd" value="<?php echo isset($info->smtp_pwd) ? $info->smtp_pwd : '';?>" style="width:100%"/></td>
					</tr>
					<tr>
						<td>SMTP端口:<input type="text" name="smtp_port" value="<?php echo isset($info->smtp_port) ? $info->smtp_port : '';?>" style="width:100%"/></td>
					</tr>
					<tr>
						<td>
							<input type="hidden" name="securityToken" value="<?php echo $_SESSION['securityToken'];?>"/>
							<input type="hidden" name="email_id" value="<?php echo isset($info->email_infor_id) ? $info->email_infor_id : '';?>"/>
							<?php if (is_object($info)):?>
							<input type="submit" name="save_mail" value="Save"/>
							<?php else:?>
							<input type="submit" name="add_new" value="Add New"/>
							<?php endif;?>
						</td>
					</tr>
				</table>
			</form>
			</td>
					</tr>
				</table>
		</td>
	</tr>
	<tr>
		<td width="" valign="top"></td>
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
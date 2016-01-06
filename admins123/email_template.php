<?php
/**
 * Order Manager
 * @author @@46231996
 * @version 1.0
 * @create 2015/1/3
 * @modify 2015/1/3
 */

require ('includes/application_top.php');

if (isset($_GET['install']))
{
	$db->Execute("INSERT INTO `".TABLE_ADMIN_PAGES."` (`page_key` ,`language_key` ,`main_page` ,`page_params` ,`menu_key` ,`display_on_menu` ,`sort_order`) VALUES ('mailTemplate', 'BOX_CUSTOMERS_MAIL_TEMPLATE', 'FILENAME_MAIL_TEMPLATE', '', 'customers', 'Y', '10');");
	$db->Execute("CREATE TABLE IF NOT EXISTS `email_template`(
	`email_template_id`	INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`name`				VARCHAR(255) NOT NULL,
	`subject`			VARCHAR(512) NOT NULL,/*发送邮件的标题*/
	`content`			TEXT,
	`date_add`			DATETIME NOT NULL DEFAULT '2014-11-22 22:14:04',
	PRIMARY KEY(`email_template_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");
	$now = date('Y-m-d H:i:s');
	$db->Execute("INSERT INTO email_template(email_template_id, `name`, subject, content, date_add)VALUES(1, '注册未下单模板', 'Dear {customers_name}', '', '$now')");
	$db->Execute("INSERT INTO email_template(email_template_id, `name`, subject, content, date_add)VALUES(2, '发货提醒', 'Dear {customers_name}', '', '$now')");
	
	$db->Execute("CREATE TABLE IF NOT EXISTS `customers_mail_send`(
	`customers_mail_send_id`	INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`customers_id`				INT(10) UNSIGNED NOT NULL,
	`send_count`				INT(10) UNSIGNED NOT NULL DEFAULT '0',
	PRIMARY KEY(`customers_mail_send_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");
	
	$db->Execute("CREATE TABLE IF NOT EXISTS `orders_send_mail`(
	`orders_id`			INT(10) UNSIGNED NOT NULL,
	`email_template_id`	INT(10) UNSIGNED NOT NULL,
	`count`	INT(10) UNSIGNED NOT NULL DEFAULT '0',
	INDEX(`orders_id`),
	INDEX(`email_template_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");
	$db->Execute("CREATE TABLE IF NOT EXISTS `customers_send_mail`(
	`customers_id`		INT(10) UNSIGNED NOT NULL,
	`email_template_id`	INT(10) UNSIGNED NOT NULL,
	`count`	INT(10) UNSIGNED NOT NULL DEFAULT '0',
	INDEX(`customers_id`),
	INDEX(`email_template_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");
	
	exit('Installed');
}
if (isset($_GET['install2']))
{
	
	exit('Installed');
}

if (isset($_POST['add_new']) || isset($_POST['save_mail']))
{
	$id = zen_db_prepare_input($_POST['email_id']);
	$name = zen_db_prepare_input($_POST['name']);
	$subject = zen_db_prepare_input($_POST['subject']);
	$content = zen_db_prepare_input($_POST['content']);
	$error = false;
	if (empty($name))
	{
		$error = true;
		$messageStack->add_session('Name is empty', 'caution');
	}
	if (empty($subject))
	{
		$error = true;
		$messageStack->add_session('Subject is empty', 'caution');
	}
	if (empty($content))
	{
		$error = true;
		$messageStack->add_session('Content is empty', 'caution');
	}
	if (!$error)
	{
		$sql_data_array = array(
			'name' => $name,
			'subject' => $subject,
			'content' => $content
		);
		if (isset($_POST['add_new']))
		{
			zen_db_perform('email_template', $sql_data_array, 'insert');
		}
		else if (isset($_POST['save_mail']))
		{
			zen_db_perform('email_template', $sql_data_array, 'update', 'email_template_id='.$id);
		}
	}
}

$page_num = 20;
if(($_GET['page'] == '' or $_GET['page'] <= 1) and $_GET['oID'] != '')
{
	$check_page = $db->Execute('SELECT COUNT(*) AS total FROM email_template;');
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
$query_raw = 'SELECT * FROM email_template';
// $orders_query_numrows = '';
$emails_split = new splitPageResults($_GET['page'], $page_num, $query_raw, $orders_query_numrows);
$emails = $db->Execute($query_raw);

if (isset($_GET['eID']) && (int)$_GET['eID'] > 0)
{
	$info = $db->Execute('SELECT * FROM email_template WHERE email_template_id='.(int)$_GET['eID']);
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
					<td class="dataTableHeadingContent" align="left">Name</td>
					<td class="dataTableHeadingContent">Subject</td>
					<td class="dataTableHeadingContent" align="right">Action&nbsp;</td>
				</tr>
		<?php while (!$emails->EOF):?>
		<tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">
            <td class="dataTableContent" align="right"><?php echo $emails->fields['email_template_id'];?></td>
			<td class="dataTableContent" align="left"><?php echo $emails->fields['name'];?></td>
			<td class="dataTableContent"><?php echo $emails->fields['subject'];?></td>
			<td class="dataTableContent" align="right">
			<a href="<?php echo zen_href_link('email_template.php', 'action=edit&eID='.$emails->fields['email_template_id']);?>">Edit</a>
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
							<strong>[<?php echo isset($info->email_template_id) ? $info->email_template_id : '';?>]</strong>
						</td>
					</tr>
					<tr>
						<td>Name:<input type="text" name="name" value="<?php echo isset($info->name) ? $info->name : '';?>" style="width:100%"/></td>
					</tr>
					<tr>
						<td>Subject:<input type="text" name="subject" value="<?php echo isset($info->subject) ? $info->subject : '';?>" style="width:100%"/></td>
					</tr>
					<tr>
						<td>Content:<textarea style="width:100%;height:180px;" name="content"><?php echo isset($info->content) ? $info->content : '';?></textarea></td>
					</tr>
					<tr>
						<td>
							<input type="hidden" name="securityToken" value="<?php echo $_SESSION['securityToken'];?>"/>
							<input type="hidden" name="email_id" value="<?php echo isset($info->email_template_id) ? $info->email_template_id : '';?>"/>
							<?php if (is_object($info)):?>
							<input type="submit" name="save_mail" value="Save"/>
							<?php else:?>
							<input type="submit" name="add_new" value="Add New"/>
							<?php endif;?>
						</td>
					</tr>
					<tr>
						<td>
						<?php foreach (get_email_variable_description() as $key => $value):?>
						<p><span style="display:inline-block;width:200px"><?php echo $key;?></span><?php echo $value;?></p>
						<?php endforeach;?>
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
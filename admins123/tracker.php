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

$tracker_config = DIR_FS_CATALOG.'includes/auto_loaders/config.tracker.php';
$tracker_config_str = <<<CONFIG
<?php
if (!defined('IS_ADMIN_FLAG')) {
	die('Illegal Access');
}
\$autoLoadConfig[199][] = array(
		'autoType' => 'class',
		'loadFile' => 'track_cookie.php'
);
\$autoLoadConfig[200][] = array(
		'autoType' => 'class',
		'loadFile' => 'tracker.php'
);
\$autoLoadConfig[200][] = array(
		'autoType' => 'classInstantiate',
		'className' => 'Tracker',
		'objectName' => 'tracker'
);
\$autoLoadConfig[201][] = array(
		'autoType'=>'init_script',
		'loadFile'=> 'init_tracking.php'
);
CONFIG;
if (isset($_GET['install']))
{
	$sqls = array(
		'CREATE TABLE IF NOT EXISTS `'.DB_PREFIX.'track_page_category`(
	`page_category_id`	int(11) NOT NULL AUTO_INCREMENT,
	`page_name`			varchar(32) NOT NULL,
	PRIMARY KEY (`page_category_id`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8;',
		'INSERT INTO `'.DB_PREFIX.'track_page_category`(`page_category_id`, `page_name`)VALUES
(1, \'unknown\');',
		'CREATE TABLE IF NOT EXISTS `'.DB_PREFIX.'track`(
	`track_id`	BIGINT(20) NOT NULL AUTO_INCREMENT,
	`page_category_id`	INT(11) NOT NULL,
	`page_id`		INT(11),
	`customers_id`	INT(11),
	`id_address`	BIGINT(20),
	`return_count`	INT(11) DEFAULT \'1\',
	`date_add`		DATETIME,
	`user_agent`	VARCHAR(255),
	`http_referer`	VARCHAR(255),
	PRIMARY KEY(`track_id`)

)ENGINE=MyISAM DEFAULT CHARSET=utf8;',
		'CREATE TABLE IF NOT EXISTS `'.DB_PREFIX.'track_actions`(
	`track_actions_id`	BIGINT(20) NOT NULL AUTO_INCREMENT,
	`track_id`			BIGINT(20) NOT NULL,
	`page_category_id`	INT(11),
	`parent_page_id`	INT(11),
	`page_id`			INT(11),
	`sequence`		INT(11),
	`refresh_count`	INT(11),
	`time_start`	DATETIME,
	`time_end`		DATETIME,
	PRIMARY KEY(`track_actions_id`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8;'
	);
	foreach ($sqls as $sql){
		$db->Execute($sql);
	}
	file_put_contents($tracker_config, $tracker_config_str);
	exit('Installed.');
}
if (isset($_GET['delete']))
{
	$byte = file_put_contents($tracker_config, '<?php ');
	if ($byte != false)
	{
		$sqls = array(
			'DROP TABLE IF EXISTS `'.DB_PREFIX.'track`;',
			'DROP TABLE IF EXISTS `'.DB_PREFIX.'track_page_category`;',
			'DROP TABLE IF EXISTS `'.DB_PREFIX.'track_actions`;'
		);
		foreach ($sqls as $sql){
			$db->Execute($sql);
		}
		exit('Deleted.');
	}
	else
	{
		echo $tracker_config;
		exit('Delete Failure');
	}
}


$down_types = array('csv');

if (isset($_GET['down']) && !empty($_GET['down']) && in_array($_GET['down'], $down_types))
{
	$host = (isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : $_SERVER['HTTP_HOST']);
	if (stripos($host, 'www.') !== false)
		$host = str_ireplace('www.', '', $host);
	if (strpos($host, '.') !== false)
		$host = substr($host, 0, strpos($host, '.'));

	$export_file_ext = 'csv';
	$export_filename = $host.'_'.date('YmdHis');
	$filed_format = '跟踪号,进入的页面,进入的页面ID,IP,用户ID,订单ID,邮箱,用户状态,开始跟踪时间,跟踪User Agent,跟踪Referer,关键词,'.
		'查看页面数,查看页面比例,页面顺序,页面类型,前一页ID,当前页ID,刷新次数,停留时间'."\n";
	switch ($_GET['down'])
	{
		case 'csv':
			header("Content-type: application/csv");
			header("Content-disposition: attachment; filename=$export_filename.$export_file_ext");
			header("Pragma: ");
			header("Expires: 0");
				
			$fp = fopen("php://output", "w+");
			fwrite($fp, $filed_format);
				
			$follows = jtracker_info();
				
			foreach ($follows as $follow_id => $f)
			{
				$percentage = array();
				$page_total = 0;
				foreach ($f['action_pages'] as $p1){
					$page_total += (int)$p1;
				}
				foreach ($f['action_pages'] as $kp => $p)
				{
					$percentage[] = $kp.':'.$p.':'.number_format(($p/$page_total)*100, 2).'%';
				}

				foreach ($f['actions'] as $aid => $act)
				{
					$field = array(
							$follow_id,
							$f['page_name'],
							$f['page_id'],
							$f['ip'],
							$f['customers_id'],
							$f['follow_orders_id'],
							$f['customer_email'],
							$f['follow_status'],
							$f['date_add'],
							$f['user_agent'],
							$f['referer'],
							$f['follow_keyword'],
							count($f['actions']),
							implode('/', $percentage),
							$aid,
							$act['page_name'],
							$act['parent_page_id'],
							$act['page_id'],
							$act['refresh_count'],
							$act['time_diff']
					);
					foreach ($field as &$ff)
					{
						$ff = str_replace(',', ' ', $ff);
					}
					fwrite($fp, implode(',', $field)."\n");
				}


			}
			fclose($fp);
				
			break;
	}
	exit;
}

$limit = 50;

if (isset($_GET['limit']))
	$limit = (int)$_GET['limit'];
if ($limit <= 0)
	$limit = 50;

if (isset($_GET['page']))
	$page = (int)$_GET['page'];


$stat = jtracker_total();
if ($page <= 0 || $page > ceil((int)$stat['track_total']/(int)$limit))
	$page = 1;

$start = ($page - 1)*$limit;


$stat['all_stat'] = jtracker_info(0, 0, $start, $limit);







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
				<a href="tracker.php?down=csv">
				导出CSV
				</a>
			</td>
		</tr>
		<tr>
			<td>
				<div class="tracker">
					<form id="from_name" enctype="multipart/form-data" action="tracker.php" method="post">
						<table border="1" style="border:1px solid #CCC;">
							<tr>
								<td colspan="12">
									<div>总计:</div>
									<div>总跟踪数:<?php echo $stat['track_total'];?></div>
									<div>跟踪打开的页面:<?php echo implode(', ', $stat['track_page_category']);?></div>
								</td>
							</tr>
							<tr>
								<td>跟踪号</td>
								<td>进入页面</td>
								<td>IP</td>
								<td>用户ID</td>
								<td>用户状态</td>
								<td>页面ID</td>
								<td>进入时间</td>
								<td>User Agent</td>
								<td>Referer</td>
								<td>查看页面数</td>
								<td>页面详细</td>
								<td>每页时间</td>
							</tr>
							<?php foreach ($stat['all_stat'] as $tid => $s):?>
							<tr>
								<td><?php echo $tid;?></td>
								<td><?php echo $s['page_name'];?></td>
								<td><?php echo $s['ip'];?></td>
								<td><?php echo $s['customers_id'];?></td>
								<td><?php echo $s['follow_status'];?></td>
								<td><?php echo $s['page_id'];?></td>
								<td style="width:100px;"><?php echo $s['date_add'];?></td>
								<td style="width:150px;word-break: break-all;"><?php echo $s['user_agent'];?></td>
								<td style="width:150px;word-break: break-all;"><?php echo $s['referer'];?></td>
								<td><?php echo count($s['actions']);?></td>
								<td>
								<?php
								$page_total = 0;
								foreach ($s['action_pages'] as $p1){
									$page_total += (int)$p1;
								}?>
									<?php foreach ($s['action_pages'] as $kp => $p):?>
									<div><?php echo $kp;?> : <?php echo $p;?> : <?php echo number_format(($p/$page_total)*100, 2);?>%</div>
									<?php endforeach;?>
								</td>
								<td>
								<?php foreach ($s['actions'] as $aid => $act):?>
								<div class="every"><span class="seq">顺序:<?php echo $aid;?></span> : <span class="page"><?php echo $act['page_name'];?></span> : <span class="pre">前页:<?php echo $act['parent_page_id'];?></span> : <span class="cur">当前页:<?php echo $act['page_id'];?></span> : <span class="refr">刷新次数:<?php echo $act['refresh_count'];?></span> : <span class="stop">停留时间:<?php echo $act['time_diff'];?></span></div>
								<?php endforeach;?>
								</td>
							</tr>
							<?php endforeach;?>
						</table>
					</form>
				</div>
			</td>
		</tr>
		<tr>
			<td class="pagin">
			<?php
				$page_count = ceil((int)$stat['track_total']/(int)$limit);
				for ($i = 1; $i <= $page_count; ++$i):?>
				<a href="tracker.php?page=<?php echo $i;?>&limit=<?php echo $limit;?>">
					<span><?php echo $i;?></span>
				</a>
			<?php endfor;?>
			
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
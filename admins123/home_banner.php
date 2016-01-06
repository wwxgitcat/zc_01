<?php
/**
 * input text to product seo_reviews
 * @package system
 * @author JunsGo@msn.com
 * @copyright Copyright 2013 SL Development Team
 * @version 1.2
 */
define('CRON_NOT_LOGIN_YES', true); // CSV
require_once ('includes/application_top.php');

set_time_limit(0);
ini_set('max_input_time', '1800');

if (isset($_GET['install']))
{
	$sql = 'INSERT INTO `'.TABLE_ADMIN_PAGES.'` (page_key, language_key, main_page, page_params, menu_key, display_on_menu, sort_order)'
		."VALUES('homeBanner','BOX_HOME_BANNER','FILENAME_HOME_BANNER','','tools','Y',26);";
	$db->Execute($sql);

	exit('Installed.');
}

$opt_type = strtolower($_GET['opt_type']);
$option_types = array('top' => 'Top', 'main' => 'Main', 'left-top' => 'Left Top', 'left-medium' => 'Left Medium', 'left-bottom' => 'Left Bottom', 'right-top'=>'Right Top', 'bottom' => 'Main Bottom');
if (!array_key_exists($opt_type, $option_types))
	$opt_type = '';



$infos = array();

$home_banner = new HomeBanner($opt_type);
if (isset($_POST['submitEdit']))
{
	$home_banner->content = $_POST['cnt'];
	$home_banner->source_content = $_POST['src_cnt'];
	$home_banner->process();
}


class HomeBanner
{
	public $target_type = '';
	public $target_file;
	public $target_content;//file content
	public $content;//new content
	
	public $source_content;//source match
	
	public $infos = array();
	public $errors = array();
	
	private $source_links = array();
	private $image_links = array();//new content. need load images
	
	public function __construct($target_type)
	{
		$this->target_type = $target_type;
		$this->loadTargetFile();
	}
	private function loadTargetFile()
	{
		if (!empty($this->target_type))
		{
			$tpl_file = DIR_FS_CATALOG_TEMPLATES.basename(DIR_WS_TEMPLATE).'/common/tpl_banner_'.strtolower(str_replace('-', '_', $this->target_type)).'.php';
			$this->target_file = $tpl_file;
			if (file_exists($tpl_file))
			{
				$this->target_content = file_get_contents($tpl_file);
				if (!is_writeable($tpl_file))
					$this->msgError('File cant\'t write.');
			}
			else
				$this->msgError(sprintf('%s not found.', $tpl_file));
			
		}
	}
	private function msgInfo($message)
	{
		$this->infos[] = sprintf('<span style="color:gray;">%s</span><br/>', $message);
	}
	private function msgError($message)
	{
		$this->errors[] = sprintf('<span style="color:red;">%s</span><br/>', $message);
	}
	public function getMessage()
	{
		$content = implode('', $this->errors);
		$content .= str_pad('<br/>', 20, '-', STR_PAD_LEFT);
		$content .= implode('', $this->infos);
		return $content;
	}
	/**
	 * Process begin
	 */
	public function process()
	{
		$this->parseSourceLink();
		$this->parseNewContentLink();
		$this->parseImages();//new content images
		$this->parseNewContentLink();
		$this->loadImages();
		$this->save();
	}
	private function save()
	{
		@chmod($this->target_file, 0666);
		$this->target_content = $this->content;
		file_put_contents($this->target_file, $this->target_content);
		$this->msgInfo('SAVE SUCCESS:');
	}
	private function parseSourceLink()
	{
		if (empty($this->source_content))
			return;
		$count = 0;
		if (preg_match_all('@href=[\'"](.+?)[\'"][^>]*?>([^<]+)@i', $this->source_content, $m))
		{
			if (!empty($m[1]))
			{
				foreach ($m[1] as $key => $val)
				{
					if (empty($val) || strpos($m[1][$key], 'http://') === false || empty($m[2][$key]))
						continue;
					$this->source_links[] = array(
						$val,//link
						$m[2][$key]
					);
					++$count;
				}
				
			}
			$this->msgInfo(sprintf('Find %s links.', $count));
		}
		else
			$this->msgInfo('Source no link.');
	}
	private function parseNewContentSourceLink()
	{
		$count = 0;
		if (preg_match_all('@href=[\'"](.+?)[\'"][^>]*?>[\s\S]*?<img\s+.+?alt=[\'"](.+?)[\'"]@i', $this->content, $m))
		{
			if (!empty($m[1]))
			{
				foreach ($m[1] as $key => $val)
				{
					if (empty($val) || strpos($m[1][$key], 'http://') === false || empty($m[2][$key]))
						continue;
					$this->source_links[] = array(
							$val,//link
							$m[2][$key]
					);
					++$count;
				}
		
			}
			$this->msgInfo(sprintf('Find %s links for new content.', $count));
		}
	}
	private function getSourceLinkName($href)
	{
		$result = '';
		foreach ($this->source_links as $l)
		{
			if ($l[0] == $href)
			{
				$result = $l[1];
				break;
			}
		}
		return $result;
	}
	public function parseImages()
	{
		//background url
		if (preg_match_all('/url\((.+?)\)/i', $this->content, $m))
		{
			foreach ((array)$m[1] as $img)
			{
				if (!preg_match('@https?://@i', $img))
					continue;
				$this->image_links[] = array(
						$img,
						'bans/'.rawurldecode(basename($img))
				);
			}
		}
		//img
		if (preg_match_all('@src=[\'"](.+?)[\'"]@i', $this->content, $m))
		{
			foreach ((array)$m[1] as $img)
			{
				if (!preg_match('@https?://@i', $img))
					continue;
				$this->image_links[] = array(
						$img,
						'bans/'.rawurldecode(basename($img))
				);
			}
		}
	}
	public function loadImages()
	{
		$count = 0;
		foreach ($this->image_links as $img)
		{
			if (empty($img[0]))
				continue;
	
			$save = DIR_FS_CATALOG_IMAGES.$img[1];
			if (!is_dir(dirname($save)))
				mkdir(dirname($save));
			
			$link = rawurlencode($img[0]);
			$link = str_replace('%3A', ':', $link);
			$link = str_replace('%2F', '/', $link);
			
			$cnt = @file_get_contents($link);
	
			if (!$cnt)
			{
				$this->msgError($img[0].' ------> LOAD ERROR.');
				continue;
			}
	
			$handle = fopen($save, 'wb');
			fwrite($handle, $cnt);
			fclose($handle);
			$this->msgInfo($img[0].' -----> '.$img[1]);
			
			$this->content = str_replace($img[0], 'images/'.$img[1], $this->content);
			++$count;
		}
		$this->msgInfo(sprintf('LOAD IMAGE TOTAL: %s.', $count));
	}
	public function parseNewContentLink()
	{
		$pattern = '@<a[\s\S]+?href=[\'"](.+?)[\'"][^>]*?>@i';
		$results = array();
		if (preg_match_all($pattern, $this->content, $m))
		{
			if (!empty($m[1]))
			{
				foreach ($m[1] as $key => $val)
				{
					if (empty($val) || strpos($val, 'http://') === false)
						continue;
					$results[] = $val;
				}
			}
		}
		$count = 0;
		if (count($results) > 0)
		{
			foreach ($results as $href)
			{
				$name = $this->getSourceLinkName($href);
				$name = trim($name);
				if (empty($name))
				{
					$this->msgError(sprintf('Link: %s name is empty.', $href));
					continue;
				}
				
				$link = $this->getCategory($name);
				if (empty($link))
				{
					$this->msgError(sprintf('"%s" can\'t found category. Try products', $name));
					$link = $this->getProduct($name);
				}
				if (empty($link))
				{
					$this->msgError(sprintf('"%s" can\'t found product. return search', $name));
					$link = $this->getSearch($name);
				}
				
				if (!empty($link))
				{
					$this->content = str_replace($href, $link, $this->content);
					$this->msgInfo('REPLACE: '.$href.' ----> '.$link);
					++$count;
				}
				else
				{
					$this->msgError('NO REPLACE: '.$href);
				}
			}
		}
		$this->msgInfo(sprintf('REPLACE LINK TOTAL: %s.', $count));
	}
	public function getCategory($name)
	{
		global $db;
		$result = $db->Execute('SELECT categories_id FROM '.TABLE_CATEGORIES_DESCRIPTION.' WHERE language_id=3 AND categories_name = \''.$db->prepare_input($name).'\'');
		if ($result->RecordCount() > 0)
		{
			return $name.'-c-'.$result->fields['categories_id'].'.html';
		}
		return null;
	}
	public function getProduct($name)
	{
		global $db;
		$result = $db->Execute('SELECT products_id FROM '.TABLE_PRODUCTS_DESCRIPTION.' WHERE language_id=3 AND products_name = \''.$db->prepare_input($name).'\'');
		if ($result->RecordCount() > 0)
		{
			return $name.'-p-'.$result->fields['products_id'].'.html';
		}
		return null;
	}
	public function getSearch($name)
	{
		global $db;
		$result = $db->Execute('SELECT COUNT(*) AS total FROM '.TABLE_PRODUCTS_DESCRIPTION.' WHERE products_name LIKE \'%'.$db->prepare_input($name).'%\'');
		if ($result->RecordCount() > 0 && (int)$result->fields['total'] > 0)
			return 'index.php?main_page=advanced_search_result&amp;search_in_description=1&amp;keyword='.urlencode($name);
		
		return null;
	}
}


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
				<div class="home-banner">
					<form id="from_name" enctype="multipart/form-data" action="home_banner.php?opt_type=<?php echo $home_banner->target_type;?>" method="post">
						<div class="msg">
							<p>EDIT: <?php echo $home_banner->target_file;?></p>
							<p>
							<?php echo $home_banner->getMessage();?>
							</p>
						</div>
						<div class="data">
							<div class="l">
								<h4>Operation Type:</h4>
								<select  onchange="location.href='home_banner.php?opt_type='+this.selectedOptions[0].value;">
									<option value="0">---None---</option>
									<?php foreach ($option_types as $ot_k => $ot_v):?>
									<option value="<?php echo $ot_k;?>" <?php if($ot_k == $opt_type){echo 'selected="selected"';}?>><?php echo $ot_v;?></option>
									<?php endforeach;?>
								</select>
							</div>
							<div class="r">
								<div style="float: left;width: 530px;">
									<h6 style="margin:5px;padding:0;">Source match content:</h6>
									<textarea name="src_cnt" rows="30" cols="100" style="width:100%;"><?php echo $home_banner->source_content;?></textarea>
								</div>
								<div style="float: right;width:530px;margin-left:10px;">
									<h6 style="margin:5px;padding:0;">File: <?php echo basename($home_banner->target_file);?></h6>
									<textarea name="cnt" rows="30" cols="150" style="width:100%;"><?php echo $home_banner->target_content;?></textarea>
								</div>
								<div style="clear: both;"></div>
							</div>
						</div>
						<div class="opt">
							<input type="submit" name="submitEdit" />
						</div>
					</form>
				</div>
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
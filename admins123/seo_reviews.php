<?php
/**
 * input text to product seo_reviews
 * @package system
 * @author JunsGo@msn.com
 * @copyright Copyright 2013 SL Development Team
 */
define('CRON_NOT_LOGIN_YES', true); // CSV
require_once ('includes/application_top.php');

set_time_limit(0);
ini_set('max_input_time', '1800');

if (isset($_GET['install']))
{
	// install sql
	$sql = 'CREATE TABLE IF NOT EXISTS `seo_reviews`(
		`seo_reviews_id` INT(11) NOT NULL AUTO_INCREMENT,
		`products_id` INT(11),
		`rating` INT(1),
		`date_add` DATETIME,
		`status` TINYINT(1) DEFAULT 0,
		PRIMARY KEY(`seo_reviews_id`)
		)ENGINE=MyISAM DEFAULT CHARSET=utf8;';
	$db->Execute($sql);
	$sql = 'CREATE TABLE IF NOT EXISTS `seo_reviews_desc`(
		`seo_reviews_id` INT(11),
		`languages_id` INT(11),
		`text` TEXT
		)ENGINE=MyISAM DEFAULT CHARSET=utf8;';
	$db->Execute($sql);
	
	exit('Installed.');
}

$seoReviews = new SEOReviews();

if (isset($_POST['data_name']) && !empty($_POST['data_name']) && isset($_POST['action']) && !empty($_POST['action']))
{
	$data_name = $_POST['data_name'];
	$action = '';
	switch(strtolower($_POST['action']))
	{
		case 'import':
			$seoReviews->import($data_name);
			break;
		case 'update':
			// $seoReviews->updateToProduct();
			break;
		case 'delete':
			$seoReviews->deleteData($data_name);
			break;
	}
}

if (isset($_GET['update']) || isset($_POST['update']))
{
	$count = isset($_GET['count']) && (int)$_GET['count'] > 0 ? (int)$_GET['count'] : 100;
	$random = isset($_GET['random']) ? (bool)$_GET['random'] : true;
	$seoReviews->updateToProduct($count, $random);
	
	if (isset($_GET['update'])) exit($seoReviews->getMessages());
}

if (isset($_POST['delSelect']) && isset($_POST['selectBox']))
{
	$seo_reviews_ids = $_POST['selectBox'];
	if (!is_array($seo_reviews_ids)) $seo_reviews_ids = array(
		(int)$seo_reviews_ids 
	);
	else
		$seo_reviews_ids = array_keys($seo_reviews_ids);
	
	$seoReviews->delete($seo_reviews_ids);
}

/**
 * auto seo reviews
 */
class SEOReviews
{
	public $errors = array();
	public $infos = array();
	public $path;
	public $data = array();
	public $info_data = array();
	public $cache_file;
	public $info_file;
	public $product_data = array();
	public $product_file;
	public $message;
	public $msg_stack = array();
	private $db;
	public function __construct()
	{
		global $db;
		$this->db = $db;
		
		$this->path = dirname(dirname(__FILE__)) . '/seo_reviews/';
		if (!is_dir($this->path)) if (!mkdir($this->path)) exit("create folder {$this->path} not faild.");
		$this->cache_file = $this->path . 'build.cache';
		$this->info_file = $this->path . 'info.in';
		$this->product_file = $this->path . 'products.in';
		
		if (is_file($this->info_file)) $this->info_data = unserialize(file_get_contents($this->info_file));
		
		if (is_file($this->product_file)) $this->product_data = unserialize(file_get_contents($this->product_file));
	}
	public function import($data_name)
	{
		if (empty($this->data)) $this->loadDatas();
		
		if (!isset($this->data[$data_name])) return;
		
		// save insert info
		if (!isset($this->info_data[$data_name])) $this->info_data[$data_name] = array();
		
		if (is_file($this->data[$data_name]['path']))
		{
			$this->importCSV($data_name);
			return;
		}
		
		$count = 0;
		$id_lang = $_SESSION['languages_id'];
		$sql = 'INSERT INTO `seo_reviews`(`products_id`, `rating`, `date_add`, `status`)VALUES';
		$sql_desc = 'INSERT INTO `seo_reviews_desc`(`seo_reviews_id`, `languages_id`, `text`)VALUES';
		
		foreach($this->data[$data_name]['files'] as $file)
		{
			$filename = basename($file);
			if (isset($this->info_data[$data_name]['files']) && in_array($data_name . '/' . $filename, $this->info_data[$data_name]['files'])) continue;
			
			$text = file_get_contents($file);
			$text = trim($text);
			if (empty($text)) continue;
			
			++$count;
			$this->db->Execute($sql . '(0, 5, now(), 0);');
			$seo_reviews_id = $this->db->insert_ID();
			$this->db->Execute($sql_desc . '(' . $seo_reviews_id . ', ' . (int)$id_lang . ', \'' . $this->db->prepare_input(nl2br($text)) . '\');');
			
			$this->info_data[$data_name]['files'][] = $data_name . '/' . $filename;
			
			if ($count % 100 == 0) $this->saveData($this->info_file, $this->info_data);
		}
		$this->info_data[$data_name]['count'] = $count;
		
		$this->saveData($this->info_file, $this->info_data);
	}
	public function importCSV($data_name)
	{
		if (empty($this->data)) $this->loadDatas();
		
		if (!isset($this->data[$data_name])) return;
		
		// save insert info
		if (!isset($this->info_data[$data_name])) $this->info_data[$data_name] = array();
		
		$count = 0;
		$id_lang = $_SESSION['languages_id'];
		$sql = 'INSERT INTO `seo_reviews`(`products_id`, `rating`, `date_add`, `status`)VALUES';
		$sql_desc = 'INSERT INTO `seo_reviews_desc`(`seo_reviews_id`, `languages_id`, `text`)VALUES';
		
		if ($hander = fopen($this->data[$data_name]['path'], 'rb'))
		{
			while(false !== ($line = fgets($hander)))
			{
				$line = trim($line);
				if (empty($line)) continue;
				++$count;
				$this->db->Execute($sql . '(0, 5, now(), 0);');
				$seo_reviews_id = $this->db->insert_ID();
				$this->db->Execute($sql_desc . '(' . $seo_reviews_id . ', ' . (int)$id_lang . ', \'' . $this->db->prepare_input(nl2br($line)) . '\');');
				
				if ($count % 100 == 0) $this->saveData($this->info_file, $this->info_data);
			}
			$this->info_data[$data_name]['path'] = $this->data[$data_name]['path'];
			$this->info_data[$data_name]['count'] = $count;
			$this->saveData($this->info_file, $this->info_data);
		}
	}
	private function saveData($file, $data)
	{
		if (!is_array($data)) $data = array(
			$data 
		);
		$serialize = serialize($data);
		file_put_contents($file, $serialize);
	}
	public function deleteData($data_name)
	{
		if (is_dir($this->path . $data_name))
		{
			$this->recursionDelete($this->path . $data_name);
		}
		else if (is_file($this->path . $data_name)) unlink($this->path . $data_name);
		
		if (isset($this->data[$data_name]))
		{
			unset($this->data[$data_name]);
		}
	}
	private function recursionDelete($path)
	{
		if (is_dir($path))
		{
			$path = rtrim($path, '/\\') . '/';
			$dirs = scandir($path);
			foreach($dirs as $file)
			{
				if ($file{0} == '.') continue;
				if (is_dir($path . $file))
				{
					$this->recursionDelete($path . $file);
					rmdir($path . $file);
				}
				else
					unlink($path . $file);
			}
			rmdir($path);
		}
		else
			unlink($path);
	}
	public function loadDatas()
	{
		$datas = array();
		$dirs = $this->getDataDirs();
		foreach($dirs as $name => $dir)
		{
			$this->data[$name] = array(
				'path' => $dir,
				'date_add' => filectime($dir),
				'count' => '',
				'files' => '' 
			);
			if (strlen(trim(strtolower($dir), '.csv')) != strlen($dir))
			{
			}
			else if (is_dir($dir))
			{
				$files = glob($dir . '/*.txt');
				sort($files);
				
				$this->data[$name]['count'] = count($files);
				$this->data[$name]['files'] = $files;
			}
		}
		return $this->data;
	}
	public function getDataDirs()
	{
		$dirs = scandir($this->path);
		$result = array();
		foreach($dirs as $dir)
		{
			if ($dir{0} == '.') continue;
			if (is_dir($this->path . $dir) || strlen(trim(strtolower($dir), '.csv')) != strlen($dir)) $result[$dir] = $this->path . $dir;
		}
		natcasesort($result);
		return $result;
	}
	
	/**
	 * update seo_reviews enable product
	 * 
	 * @param number $count
	 *        	max product count
	 * @param bool $random
	 *        	random enable products
	 */
	public function updateToProduct($count = 100, $random = true)
	{
		$count = (int)$count <= 0 ? 100 : (int)$count;
		
		$sql_seo_reviews = $this->db->Execute('SELECT COUNT(*) as `total` FROM `seo_reviews` WHERE `products_id` = 0;');
		$seo_not_use_total = (int)$sql_seo_reviews->fields['total'];
		
		if ($seo_not_use_total <= 0)
		{
			$this->msg_stack[] = sprintf('Not more reviews.');
			return;
		}
		$count = min($count, $seo_not_use_total);
		
		if (count($this->product_data) == 0) $this->builder();
		
		$level = $this->findLevel();
		$product_ids = $this->getProductsForData($count, $level);
		
		$this->updateToSeoReviews($product_ids);
		
		$this->saveData($this->product_file, $this->product_data);
	}
	public function updateProduct($count = 100, $level = 0)
	{
		$sql = 'SELECT p.`products_id`, s.`seo_reviews_id`
			FROM `' . TABLE_PRODUCTS . '` p LEFT JOIN `seo_reviews` s ON (p.`products_id` = s.`products_id`)
			';
		if ($level == 0) $sql .= 's.`products_id` IS NULL';
		$usage_product = $this->db->Execute('SELECT COUNT(*) as `total`
			FROM `' . TABLE_PRODUCTS . '` p INNER JOIN `seo_reviews` s ON (p.`products_id` = s.`products_id` AND s.`products_id` > 0)
			WHERE p.`products_status` = 1;');
		$usage_product_total = (int)$usage_product->fields['total'];
		
		$all_product = $this->db->Execute('SELECT COUNT(`products_id`) as `total` FROM `' . TABLE_PRODUCTS . '` WHERE `products_status`=1;');
		$all_product_total = (int)$all_product->fields['total'];
		
		if ($usage_product_total >= $all_product_total)
		{
			// secound build
			// product have seo reviews > 0
		}
		else
		{
			// first
			$this->firstUpdate($count);
		}
	}
	private function firstUpdate($count)
	{
		$sql = 'SELECT p.`products_id`, s.`seo_reviews_id`
			FROM `' . TABLE_PRODUCTS . '` p LEFT JOIN `seo_reviews` s ON (p.`products_id` = s.`products_id`)
			WHERE s.`seo_reviews_id` IS NULL
			ORDER BY RAND()
			limit ' . $count;
		$result = $this->db->Execute($sql);
		
		$product_ids = array();
		while(!$result->EOF)
		{
			$product_ids[] = (int)$result->fields['products_id'];
			$result->MoveNext();
		}
		
		$this->updateToSeoReviews($product_ids);
	}
	private function updateToSeoReviews($product_ids = array())
	{
		if (count($product_ids) == 0) return;
		
		shuffle($product_ids);
		
		$seo_reviews = $this->db->Execute('SELECT `seo_reviews_id` FROM `seo_reviews` WHERE `products_id` = 0 ORDER BY RAND() LIMIT ' . count($product_ids));
		while(!$seo_reviews->EOF)
		{
			$p_id = array_shift($product_ids);
			$this->db->Execute('UPDATE `seo_reviews` SET `status`=1, `products_id` = ' . (int)$p_id . ' WHERE `seo_reviews_id` = ' . (int)$seo_reviews->fields['seo_reviews_id'] . ';');
			$this->msg_stack[] = sprintf('Update product:' . (int)$p_id . ' to seo_review:' . (int)$seo_reviews->fields['seo_reviews_id']);
			
			$seo_reviews->MoveNext();
		}
	}
	private function builder()
	{
		$this->product_data = array();
		
		$sql = 'SELECT p.`products_id`, s.`seo_reviews_id`
			FROM `' . TABLE_PRODUCTS . '` p LEFT JOIN `seo_reviews` s ON (p.`products_id` = s.`products_id`)
			;';
		$result = $this->db->Execute($sql);
		while(!$result->EOF)
		{
			$p_id = (int)$result->fields['products_id'];
			$s_id = (int)$result->fields['seo_reviews_id'];
			if (isset($this->product_data[$p_id]))
			{
				if (isset($this->product_data[$p_id]['count'])) $this->product_data[$p_id]['count'] = (int)$this->product_data[$p_id]['count'] + 1;
				else
					$this->product_data[$p_id]['count'] = 1;
				
				if (isset($this->product_data[$p_id]['seo_reviews'])) $this->product_data[$p_id]['seo_reviews'] = array_merge($this->product_data[$p_id]['seo_reviews'], array(
					$s_id 
				));
				else
					$this->product_data[$p_id]['seo_reviews'] = array(
						$s_id 
					);
			}
			else
			{
				if ($s_id > 0) $this->product_data[$p_id] = array(
					'count' => 1,
					'seo_reviews' => array(
						$s_id 
					) 
				);
				else
					$this->product_data[$p_id] = array(
						'count' => 0,
						'seo_reviews' => array() 
					);
			}
			$result->MoveNext();
		}
		
		$this->saveData($this->product_file, $this->product_data);
	}
	private function findLevel()
	{
		$level = 100;
		if (count($this->product_data) == 0) return $level;
		foreach($this->product_data as $p_id => $data)
		{
			$level = min($data['count'], $level);
			if ($level == 0) break;
		}
		return $level;
	}
	private function getProductsForData($count = 100, $level = 0)
	{
		if (count($this->product_data) == 0) return array();
		
		$result = array();
		$total = 0;
		$max_level = 0;
		foreach($this->product_data as $p_id => &$data)
		{
			if ($data['count'] == $level)
			{
				$result[] = $p_id;
				$data['count'] = (int)$data['count'] + 1;
				++$total;
			}
			$max_level = max($max_level, $data['count']);
			if ($total == $count) break;
		}
		
		if ($total < $count && $max_level > $level) $result = array_merge($result, $this->getProductsForData($count - $total, ++$level));
		
		return $result;
	}
	/**
	 * delete seo_reviews
	 * <p>If $seo_reviews is array, so need $seo_reviews=array(id,id)</p>
	 * 
	 * @param mix $seo_reviews        	
	 */
	public function delete($seo_reviews)
	{
		if (!is_array($seo_reviews)) $seo_reviews = array(
			$seo_reviews 
		);
		
		$filter = array();
		foreach($seo_reviews as $id)
		{
			if ((int)$id > 0) $filter[] = (int)$id;
		}
		if (count($filter) > 0) $this->db->Execute('DELETE FROM `seo_reviews` WHERE `seo_reviews_id` IN (' . implode(',', $filter) . ');');
	}
	public function getMessages()
	{
		if (count($this->msg_stack) == 0) return '';
		return implode('<br/>', $this->msg_stack);
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
.seo_reviews {
	width: 800px;
	border: 1px solid #CCCCCC;
	padding: 6px;
}

.seo_reviews td {
	border-bottom: 1px solid #CCC;
	padding: 6px;
}

.list .item {
	float: left;
	width: 180px;
	padding: 5px;
}

.list .list-cnt {
	border: 1px solid #A7C5FF;
	padding: 5px 0;
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
				<div style=""><?php echo isset($_POST['update'])? $seoReviews->getMessages():'';?></div>


				<div class="seo_reviews">
					<form id="from_name" enctype="multipart/form-data"
						action="seo_reviews.php" method="post">
						<div class="seo_list">
					<?php
					$seo_reviews_query_number = '';
					$seo_reviews_query = 'select * from `seo_reviews` s join `seo_reviews_desc` sd 
							ON (s.`seo_reviews_id`=sd.`seo_reviews_id` and sd.`languages_id`=' . (int)$_SESSION['languages_id'] . ')';
					
					$seo_reviews_split = new splitPageResults($_GET['page'], MAX_DISPLAY_RESULTS_CATEGORIES, $seo_reviews_query, $seo_reviews_query_number);
					$seo_reviews_result = $db->Execute($seo_reviews_query);
					if ($seo_reviews_result->RecordCount() > 0)
					:
						
						?>
					<table>
								<tr>
									<th width="50"></th>
									<th width="50">ID</th>
									<th width="50">Product ID</th>
									<th width="200">Add Date</th>
									<th width="500">Text</th>
									<th width="50">Status</th>
								</tr>
								<tr>
									<td colspan="6"></td>
								</tr>
					<?php while (!$seo_reviews_result->EOF):?>
						<tr>
									<th width="50"><input type="checkbox"
										name="selectBox[<?php echo $seo_reviews_result->fields['seo_reviews_id'];?>]"></th>
									<td><?php echo $seo_reviews_result->fields['seo_reviews_id'];?></td>
									<td><?php echo $seo_reviews_result->fields['products_id'];?></td>
									<td><?php echo $seo_reviews_result->fields['date_add'];?></td>
									<td style="width: 500px; overflow: hidden;"><?php echo $seo_reviews_result->fields['text'];?></td>
									<td>
							<?php if($seo_reviews_result->fields['status']):?>
								<img src="images/icon_green_on.gif" alt="" />
							<?php else:?>
								<img src="images/icon_red_on.gif" alt="" />
							<?php endif;?>
							</td>
								</tr>
						<?php $seo_reviews_result->MoveNext();?>
					<?php endwhile;?>
					<tr>
									<td colspan="6"><?php echo $seo_reviews_split->display_count($seo_reviews_query_number, MAX_DISPLAY_RESULTS_CATEGORIES, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_PRODUCTS);?>
						<?php echo $seo_reviews_split->display_links($seo_reviews_query_number, MAX_DISPLAY_RESULTS_CATEGORIES, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], zen_get_all_get_params(array('page', 'info', 'x', 'y', 'pID')));?>
						&nbsp;<input type="submit" name="delSelect" value="delete select">
									</td>
								</tr>
							</table>
					<?php endif;?>
					
				</div>

						<div style="text-align: right; margin-top: 10px;">
							<input type="submit" name="update"
								value="Update products to seo reviews" />
						</div>
						<input type="hidden" id="data_name" name="data_name" />
						<table width="100%" cellspacing="0" cellpadding="0">
							<thead>
								<tr>
									<td width="180">Name</td>
									<td width="100">Count</td>
									<td width="100">Create Date</td>
									<td width="100">OPT</td>
								</tr>
							</thead>
							<tbody>
						<?php $datas = $seoReviews->loadDatas();?>
						<?php if (count($datas) > 0):?>
							<?php foreach ($datas as $filename => $data):?>
								<tr>
									<td><?php echo $filename;?></td>
									<td><?php echo $data['count'];?></td>
									<td><?php echo date("Y-m-d H:i:s", $data['date_add']);?></td>
									<td><input type="submit" name="action"
										onclick="init_submit('<?php echo $filename;?>')"
										value="Import" /> <!-- <input type="submit" name="action" onclick="init_submit('<?php echo $filename;?>')" value="Update"/> -->
										<input type="submit" name="action"
										onclick="init_submit('<?php echo $filename;?>')"
										value="Delete" /></td>
								</tr>
							<?php endforeach;?>
						<?php else:?>
							<tr>
									<td colspan="4" style="text-align: center; color: red;">No
										data.</td>
								</tr>
						<?php endif;?>
						</tbody>
						</table>
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
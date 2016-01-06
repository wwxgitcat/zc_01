<?php
/**
 * 
 * export data to wp,ps,zc
 * eg.
 * <p>
 * export.php?f=wp&l=lang_id
 * </p>
 * @var unknown
 */
define('CRON_NOT_LOGIN_YES', true); // CSV
require_once ('includes/application_top.php');

@set_time_limit(0);
@ini_set('max_input_time', '9999');
$host = (isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : $_SERVER['HTTP_HOST']);
if (strpos($host, ':') !== false)
	$host = substr($host, 0, strpos($host, ':'));

//$_GET['f'] = isset($_GET['f']) ? $_GET['f'] : 'wp';
$_GET['min'] = isset($_GET['min']) ? (int)$_GET['min'] : null;
$_GET['max'] = isset($_GET['max']) ? (int)$_GET['max'] : null;
$limit = '';
if ($_GET['max'] !== null && $_GET['min'] !== null && $_GET['max'] > $_GET['min'])
	$limit = " LIMIT ".(int)$_GET['min'].", ".(int)$_GET['max'];

if (isset($_GET['f']))
{
	$lang_id = isset($_GET['l']) ? (int)$_GET['l'] : 3;
	$name = $host.date('Y-m-d-H-i-s').'.csv';
	
	require (DIR_WS_CLASSES . 'currencies.php');
	$currencies = new currencies();
	
	$filed_format = '"v_products_model","v_products_image","v_products_name_1","v_products_description_1","v_products_url_1","v_specials_price",'.
		'"v_specials_last_modified","v_specials_expires_date","v_products_price","v_products_weight","v_last_modified","v_date_added","v_products_quantity",'.
		'"v_manufacturers_name","v_categories_name_1","v_categories_name_2","v_categories_name_3","v_categories_name_4","v_categories_name_5",'.
		'"v_categories_name_6","v_categories_name_7","v_tax_class_title","v_status","v_metatags_products_name_status","v_metatags_title_status",'.
		'"v_metatags_model_status","v_metatags_price_status","v_metatags_title_tagline_status","v_metatags_title_1","v_metatags_keywords_1",'.
		'"v_metatags_description_1","v_cate_meta_title_1_1","v_cate_meta_keywords_1_1","v_cate_meta_description_1_1","v_cate_meta_title_2_1",'.
		'"v_cate_meta_keywords_2_1","v_cate_meta_description_2_1","v_cate_meta_title_3_1","v_cate_meta_keywords_3_1","v_cate_meta_description_3_1",'.
		'"v_cate_meta_title_4_1","v_cate_meta_keywords_4_1","v_cate_meta_description_4_1","v_cate_meta_title_5_1","v_cate_meta_keywords_5_1",'.
		'"v_cate_meta_description_5_1","v_cate_meta_title_6_1","v_cate_meta_keywords_6_1","v_cate_meta_description_6_1","v_cate_meta_title_7_1",'.
		'"v_cate_meta_keywords_7_1","v_cate_meta_description_7_1","v_property_1"'."\n";
	
	
	
// 	header("Pragma: public");
// 	header("Expires: 0");
// 	header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
// 	header("Content-Type:application/force-download");
// 	header("Content-Type:application/vnd.ms-execl");
// 	header("Content-Type:application/octet-stream");
// 	header("Content-Type:application/download");;
// 	header('Content-Disposition:attachment;filename="'.$name.'"');
// 	header("Content-Transfer-Encoding:binary");
//	$handle = fopen('php://output', 'w+');

	$csv_path = DIR_FS_CATALOG.''.$name;
	$handle = fopen(DIR_FS_CATALOG.''.$name, 'w+');
	
	switch ($_GET['f'])
	{
		case 'zc':
			$filed_format = '"v_products_model","v_products_image","v_products_name_3","v_products_description_3","v_products_url_3","v_specials_price",'.
				'"v_specials_last_modified","v_specials_expires_date","v_products_price","v_products_weight","v_last_modified","v_date_added","v_products_quantity",'.
				'"v_manufacturers_name","v_categories_name_1","v_categories_name_2","v_categories_name_3","v_categories_name_4","v_categories_name_5",'.
				'"v_categories_name_6","v_categories_name_7","v_tax_class_title","v_status","v_metatags_products_name_status","v_metatags_title_status",'.
				'"v_metatags_model_status","v_metatags_price_status","v_metatags_title_tagline_status","v_metatags_title_3","v_metatags_keywords_3",'.
				'"v_metatags_description_3","v_property_1"'."\n";
			fwrite($handle, $filed_format);
			break;
		case 'wp':
			$filed_format = 'csv_post_title,csv_post_post,csv_post_categories,csv_post_tags,csv_post_excerpt,csv_post_date,csv_post_author,csv_post_slug'."\n";
			fwrite($handle, $filed_format);
			break;
	}
	
	
	$products = $db->Execute("
	SELECT *
	FROM ".TABLE_PRODUCTS." p JOIN ".TABLE_PRODUCTS_DESCRIPTION." pd ON (p.products_id=pd.products_id AND pd.language_id=$lang_id)
	ORDER BY p.products_id ASC
	".$limit);
	
	while (!$products->EOF)
	{
		//$r = $products->fields;
		
		$meta = getMetatags($products->fields['products_id'], $lang_id);
		$categores = getCategorys($products->fields['master_categories_id'], $lang_id);
		
		$image = $products->fields['products_image'];
		
		switch ($_GET['f'])
		{
			case 'zc':
				$fields = array(
					$products->fields['products_model'],
					$image,
					$products->fields['products_name'],
					jtrim_desc($products->fields['products_description']),
					$products->fields['products_url'],
					//special price
					//$products->fields[''],
					zen_get_products_special_price($products->fields['products_id'], true),
					//special last modified
					date('Y-m-d H:i:s'),
					//special expires
					'2035-12-21 12:35:21',
					$products->fields['products_price'],
					$products->fields['products_weight'],
					$products->fields['products_last_modified'],
					$products->fields['products_date_added'],
					$products->fields['products_quantity'],
					//manufacturere name
					//$products->fields[''],
					'',
					//categories1-7
					jtrim($categores[0]['name']),
					jtrim($categores[1]['name']),
					jtrim($categores[2]['name']),
					jtrim($categores[3]['name']),
					jtrim($categores[4]['name']),
					jtrim($categores[5]['name']),
					jtrim($categores[6]['name']),
					//tax_class
					'--なし--',
					$products->fields['products_status'],
					$products->fields['metatags_products_name_status'],
					$products->fields['metatags_title_status'],
					$products->fields['metatags_model_status'],
					$products->fields['metatags_price_status'],
					$products->fields['metatags_title_tagline_status'],
					//product metatags
					$meta['metatag_title'],
					$meta['metatag_key'],
					$meta['metatag_desc'],
				);
				//v_property_1
				$fields[] = getProperty($products->fields['products_id'], $lang_id);
				
				break;
			case 'wp':
				$description = jtrim_desc($products->fields['products_description']);
// 				$images = array(
// 					getImagePath($products->fields['products_image'])
// 				);
				
// 				if (preg_match_all('~src=["\'](.+?)["\']~i', $description, $matchImages))
// 				{
// 					if ($matchImages[1])
// 						foreach ($matchImages[1] as $mI)
// 						{
// 							$mI = trim($mI, '"\' ');
// 							$mI = ltrim($mI, '/');
// 							$images[] = getImagePath($mI);
// 						}
// 				}
// 				$images = array_unique($images);
				$property = getProperty($products->fields['products_id'], $lang_id, true);
				
				$str_py = '';
				foreach ($property as $k => $o)
				{
					$str_py .= '<ul>';
					$str_py .= '<li>'.$k.'<ul>';
					
					foreach ($o as $v)
					{
						$str_py .= $v;
					}
					$str_py .= '</ul></li>';
					$str_py .= '</ul>';
				}
				
				$description .= $str_py;
				$description .= $currencies->format(zen_get_products_special_price($products->fields['products_id'], true));
				
				$description .= sprintf('{{%s:%s}}', $host, $products->fields['products_id']);
				
				
				$wp_category = array();
				foreach ($categores as $c)
				{
					if (!empty($c['name']))
						$wp_category[] = $c['name'];
				}
				$wp_category = implode('>', $wp_category);
				
				$fields = array(
					$products->fields['products_name'] . ' ' . $products->fields['products_model'],
					$description,
					//categories cate1>cate2>cate3
					$wp_category,
					str_replace('>', ',', $wp_category),
					"",
					"",
					"",
					""
				);
				
				
				break;
		}
		
		
		
		
		$str = '"'.implode('","', $fields)."\"\n";
		fwrite($handle, $str);
		
		
		$products->MoveNext();
	}
	
	
	
	
	
	fflush($handle);
	fclose($handle);
	
	if (class_exists('ZipArchive'))
	{
		$zip = new ZipArchive();
		$zip_path = $csv_path.'.zip';
		if ($zip->open($zip_path, ZipArchive::OVERWRITE|ZipArchive::CREATE) === true){
			$zip->addFile($csv_path, $name);
			$zip->close();
		}
	}
	
	//exit;
}

function getProducts()
{
	global $db;
	
}
function jtrim_desc($content)
{
	global $folder;
	$content = preg_replace('/\s+/', ' ', $content);
	$imgs = array();
	if (preg_match_all('#src\s*=\s*(?:[\"\'\s])?(?(1)(.*?)\1|([^"\'\s\>]+))#iu', $content, $imgs))
	{
		if(isset($imgs[2]) && count($imgs[2]) > 0)
			$imgs = $imgs[2];
	}
	else
		$imgs = array();

	if (!empty($folder))
	{
		foreach ($imgs as $i){
			$n = str_replace($folder.'/', '', $i);
			$n = 'images/'.$folder.substr($n, 6);
			$content = str_ireplace($i, $n, $content);
		}
	}

	return str_replace('"', '""', $content);
}
function jtrim($content)
{
	return str_replace('"', '""', $content);
}

function getCategorys($cid, $lang_id = 1)
{
	global $db;
	static $category = array();

	if (isset($category[$cid]))
		return $category[$cid];

	zen_get_parent_categories($tmp, $cid);

	if (empty($tmp))
		$tmp = array();
	$tmp = array_reverse($tmp);
	$tmp[] = $cid;

	$i=0;
	foreach ($tmp as $id){
		$r = $db->Execute('SELECT * FROM '.TABLE_CATEGORIES_DESCRIPTION.' WHERE categories_id='.$id.' AND language_id='.$lang_id);
		$category[$cid][$i]['name'] = $r->fields['categories_name'];
		$category[$cid][$i]['desc'] = $r->fields['categories_description'];
		$r = $db->Execute('SELECT * FROM '.TABLE_METATAGS_CATEGORIES_DESCRIPTION.' WHERE categories_id='.$id.' AND language_id='.$lang_id);
		$category[$cid][$i]['meta_title'] = $r->fields['metatags_title'];
		$category[$cid][$i]['meta_key'] = $r->fields['metatags_keywords'];
		$category[$cid][$i]['meta_desc'] = $r->fields['metatags_description'];
		++$i;
	}

	for ($i = count($category[$cid]); $i < 7; ++$i){
		$category[$cid][$i] = array(
			'name' => '',
			'desc' => '',
			'meta_title' => '',
			'meta_key' => '',
			'meta_desc' => ''
		);
	}


	return $category[$cid];
}
function getMetatags($product_id, $lang_id = 1)
{
	global $db;
	$meta = $db->Execute('SELECT * FROM '.TABLE_META_TAGS_PRODUCTS_DESCRIPTION.' WHERE products_id='.$product_id.' AND language_id='.$lang_id);

	$m = array(
		'metatag_title' => $meta->fields['metatags_title'],
		'metatag_key' => $meta->fields['metatags_keywords'],
		'metatag_desc' => $meta->fields['metatags_description']
	);
	return $m;
}
function getOption($option_id, $lang_id = 1)
{
	global $db;
	static $options = array();
	if (isset($options[$option_id]))
		return $options[$option_id];

	$o = $db->Execute('SELECT products_options_name,products_options_type FROM '.TABLE_PRODUCTS_OPTIONS.' WHERE products_options_id='.$option_id.' AND language_id='.$lang_id);
	$options[$option_id] = array(
		'name' => $o->fields['products_options_name'],
		'type' => $o->fields['products_options_type']
	);
	return $options[$option_id];
}
function getOptionValue($v_id, $lang_id = 1)
{
	global $db;
	static $values = array();
	if (isset($values[$v_id]))
		return $values[$v_id];

	$v = $db->Execute('SELECT products_options_values_name FROM '.TABLE_PRODUCTS_OPTIONS_VALUES.' WHERE products_options_values_id='.$v_id.' AND language_id='.$lang_id);
	$values[$v_id] = $v->fields['products_options_values_name'];
	return $values[$v_id];
}
function getProperty($p_id, $lang_id = 1, $isArray = false)
{
	global $db;
	static $attrs = array(), $oid = array();

	$property = array();

	$p = $db->Execute('SELECT options_id, options_values_id FROM '.TABLE_PRODUCTS_ATTRIBUTES.' WHERE products_id='.$p_id);
	while (!$p->EOF)
	{
		$o = getOption($p->fields['options_id'], $lang_id);
		if (!isset($oid[$o['name']]))
			$oid[$o['name']] = $o['type'];

		$property[$o['name']][] = getOptionValue($p->fields['options_values_id'], $lang_id);

		$p->MoveNext();
	}
	if ($isArray)
		return $property;
	
	$py = '';
	foreach ($property as $k => $v){
		$py .= "{$k}-{$oid[$k]}:".implode('|', $v).';';
	}
	return $py;
}
function getImagePath($img)
{
	if (strpos($img, 'images') === false)
		$img = 'images/'.ltrim($img);
	return rtrim(HTTP_SERVER, '/').'/'.$img;
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
			<?php $csvs = glob(DIR_FS_CATALOG.'*.csv*'); natcasesort($csvs);foreach ($csvs as $file){?>
			<div><a href="<?php echo DIR_WS_CATALOG.''.basename($file);?>"><?php echo $file;?></a></div>
			<?php }//foreach?>
		</td>
		
		<td width="30%">
		
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
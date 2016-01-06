<?php
/**
 * date: 2014/4/16
 * @author QQ:46231996
 * 
 */
function get_modules_file($file, $current_template = '', $area = ''){
	$filename = '';
	if (!strstr($file, '.php')) $file .= '.php';
	
	if (file_exists(DIR_WS_MODULES.$area.'/'.$current_template.'/'.$file))
		$filename = DIR_WS_MODULES.$area.'/'.$current_template.'/'.$file;
	else if (file_exists(DIR_WS_MODULES.$area.'/'.$file))
		$filename = DIR_WS_MODULES.$area.'/'.$file;
	else if (file_exists(DIR_WS_MODULES.'/'.$file))
		$filename = DIR_WS_MODULES.'/'.$file;
	return $filename;
}
function display_template($template_file, $area = 'templates'){
	global $template, $current_page_base;
	if (!strstr($template_file, '.php')) $template_file .= '.php';
	return $template->get_template_dir($template_file,DIR_WS_TEMPLATE, $current_page_base,$area). '/'.$template_file;
}
function display_tpl($template_file, $area = 'templates'){
	return display_template($template_file, $area);
}
function display_tpl_common($template_file)
{
	return display_tpl($template_file, 'common');
}

function display_message($args){
	global $messageStack;
	$args = func_get_args();
	$content = '';
	foreach ($args as $a){
		if ($messageStack->size($a) > 0)
			$content .= $messageStack->output($a);
	}
	echo $content;
}
function zhlink(){
	global $request_type;
	
	if ($request_type == 'SSL')
		return HTTPS_SERVER . DIR_WS_HTTPS_CATALOG;
	else
		return HTTP_SERVER . DIR_WS_CATALOG;
}
function zlink($page = '', $parameters = '', $connection = 'NONSSL', $add_session_id = true, $search_engine_safe = true, $static = false, $use_dir_ws_catalog = true){
	echo zen_href_link($page, $parameters, $connection, $add_session_id, $search_engine_safe, $static, $use_dir_ws_catalog);
}
function ztimg($n){
	echo DIR_WS_TEMPLATE_IMAGES.$n;
}
function display_html($file)
{
	$html = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', $file, 'false');
	include($html);
}
function zproduct_add_btn($a1, $a2){
	echo zen_get_products_quantity_min_units_display((int)$_GET['products_id']) . zen_draw_hidden_field('products_id', (int)$_GET['products_id']) . zen_image_submit($a1, $a2);
}
function getHttpHost($hostname = true, $http = false, $entities = false, $ignore_port = true)
{
	$host = (isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : $_SERVER['HTTP_HOST']);
	if ($ignore_port && $pos = strpos($host, ':'))
		$host = substr($host, 0, $pos);
	if ($entities)
		$host = htmlspecialchars($host, ENT_COMPAT, 'UTF-8');
	if ($hostname)
	{
		if (stripos($host, 'www.') !== false)
			$host = str_ireplace('www.', '', $host);
		if (strpos($host, '.') !== false)
			$host = substr($host, 0, strrpos($host, '.'));
	}
	if ($http)
		$host = 'http://'.$host;

	return $host;
}
/**
 * Return banner array('title','url','image','text','new_window','no_ssl','sort_order')
 * @param string $group_name
 */
function jget_banners($group_name)
{
	global $db;
	$sql = 'SELECT `banners_id`, `banners_title`, `banners_url`,`banners_image`,`banners_html_text`,`banners_open_new_windows`,
		`banners_on_ssl`,`banners_sort_order` FROM '.TABLE_BANNERS.' WHERE status=1 AND `banners_group`=\''.$group_name.'\'
		ORDER BY `banners_sort_order` DESC';
	$result = $db->Execute($sql, null, true, CACHE_TIMELIFT);
	$banners = array();
	while (!$result->EOF)
	{
		if (empty($result->fields['banners_url']) || $result->fields['banners_url'] == '/')
			$href = zhlink();
		else if (strpos($result->fields['banners_url'], 'http') !== 0)
			$href = zen_href_link($result->fields['banners_url']);
		else
			$href = $result->fields['banners_url'];;

		if (empty($result->fields['banners_image']))
			$image = DIR_WS_IMAGES.'no_picture.gif';
		else
			$image = DIR_WS_IMAGES.$result->fields['banners_image'];

		$banners[] = array(
			'title' => $result->fields['banners_title'],
			'href' => $href,
			'image' => $image,
			'text' => $result->fields['banners_html_text'],
			'new_window' => $result->fields['banners_open_new_windows'],
			'no_ssl' => $result->fields['banners_on_ssl'],
			'sort_order' => $result->fields['banners_sort_order']
		);
		$result->MoveNext();
	}
	return $banners;
}


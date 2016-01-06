<?php
/**
 * languages sidebox - allows customer to select from available languages installed on your site
 *
 * @package templateSystem
 * @author JunsGo@msn.com
 * @copyright Copyright 2013 SL Development Team
 * @copyright Portions Copyright 2003 osCommerce
 */

// test if box should display
$show_languages = false;

// don't display on checkout page:
if (substr($current_page, 0, 8) != 'checkout')
{
	$show_languages = true;
}

if ($show_languages == true)
{
	if (!isset($lng) || (isset($lng) && !is_object($lng)))
	{
		$lng = new language();
	}
	
	reset($lng->catalog_languages);
	$tpl_language_array = array();
	while(list($key, $value) = each($lng->catalog_languages))
	{
		$tpl_language_array[] = array(
			'id' => $value['id'],
			'name' => $value['name'],
			'image' => $value['image'],
			'code' => $value['code'],
			'directory' => $value['directory'],
			'href' => zen_href_link($_GET['main_page'], zen_get_all_get_params(array(
				'language',
				'currency' 
			)) . 'language=' . $key, $request_type) 
		);
	}
	
	require ($template->get_template_dir('tpl_languages.php', DIR_WS_TEMPLATE, $current_page_base, 'sideboxes') . '/tpl_languages.php');
}
?>
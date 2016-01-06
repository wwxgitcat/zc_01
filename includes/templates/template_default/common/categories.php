<?php
/**
 * categories sidebox - prepares content for the main categories sidebox
 *
 * @package templateSystem
 * @author JunsGo@msn.com
 * @copyright Copyright 2013 SL Development Team
 * @copyright Portions Copyright 2003 osCommerce
 */
if (is_null($main_category_tree) || !is_object($main_category_tree))
	$main_category_tree = new category_tree();
$box_categories_array = array();
$box_categories_arr = array();
$tpl_categories = array();
$categoriesortvalue = array();

// don't build a tree when no categories
$check_categories = $db->Execute("select categories_id from " . TABLE_CATEGORIES . " where categories_status=1
	AND shop_id=".(int)$_SESSION['shop_id']." limit 1", false, true, CACHE_TIMELIFT);
if ($check_categories->RecordCount() > 0)
{
	$box_categories_array = $main_category_tree->zen_category_tree();
}
$idx = 0;

foreach ($box_categories_array as $category)
{
	if ($category['parent_id'] != 0)
	{
		$box_categories_arr[$category['parent_id']]['children'][$category['categories_id']] = $category;
		if ($category['has_sub_cat'] == 1)
		{
			$box_categories_arr[$category['categories_id']] = $category;
		}
	}
	else
	{
		foreach ($category as $key => $cate)
		{
			$box_categories_arr[$category['categories_id']][$key] = $cate;
		}
	}
}

foreach ($box_categories_arr as $category)
{
	$tmp = array(
		'id' => $category['categories_id'],
		'parent_id' => $category['parent_id'],
		'name' => $category['name'],
		'href' => zen_href_link(FILENAME_DEFAULT, $category['path']),
		'top' => $category['top'] == 'true' ? true : false,
		'current' => $category['current'],
		'has_children' => $category['has_sub_cat'],
		'image' => $category['image'],
		'type' => zen_get_product_types_to_category($category['path']),
		'selected' => $category['categories_id'] == $current_category_id,
		'children' => array()
	);
	if (!empty($category['children']))
	{
		foreach ($category['children'] as $cate)
		{
			$tmp['children'][$cate['categories_id']] = array(
				'id' => $cate['categories_id'],
				'parent_id' => $cate['parent_id'],
				'name' => $cate['name'],
				'href' => zen_href_link(FILENAME_DEFAULT, $cate['path']),
				'top' => $cate['top'] == 'true' ? true : false,
				'current' => $cate['current'],
				'has_children' => $cate['has_sub_cat'],
				'image' => $cate['image'],
				'type' => zen_get_product_types_to_category($cate['path']),
				'selected' => $cate['categories_id'] == $current_category_id,
				'children' => array()
			);
		}
	}
	if (isset($category['count']) && ((CATEGORIES_COUNT_ZERO == '1' && $category['count'] == 0) || $category['count'] > 0))
		$tmp['count'] = $category['count'];
		// if (array_key_exists($category['parent_id'], $tpl_categories))
	
	if ($category['top'] == 'true')
	{
		$tpl_categories[$category['categories_id']] = $tmp;
	}
	else
		$tpl_categories[$category['parent_id']]['children'][$category['categories_id']] = $tmp;
}
foreach ($tpl_categories as $key111 => $tcategories)
{
	if (empty($tcategories['id']))
	{
		unset($tpl_categories[$key111]);
	}
}
//usort($tpl_categories, 'asort_sortorder');
// var_dump($tpl_categories);exit;
unset($idx, $category);
//require(display_tpl('tpl_categories', 'sideboxes'));
//require ($template->get_template_dir('tpl_categories.php', DIR_WS_TEMPLATE, $current_page_base, 'sideboxes') . '/tpl_categories.php');
function asort_sortorder($a1, $a2)
{
	if ($a1['sort_order'] == $a2['sort_order'])
		return 0;
	if ($a1['sort_order'] > $a2['sort_order'])
		return 1;
	return -1;
}
function asort_categories($a1, $a2)
{
	if ($a1['id'] == $a2['id'])
		return 0;
	if ($a1['id'] > $a2['id'])
		return 1;
	return -1;
}



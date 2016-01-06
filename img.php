<?php
/**
 *
 *
 * @ By KIRA
 * @ QQ: 6171718
 * @ Email: kira@kpa7.net
 * @ Blog: http://ImKIRA.Net
 *
 */
?>
<?php

require ('includes/application_top.php');
?>
<?php

$infos = array();
$count = 0;
$img_string = '';
$size = isset($_GET['size']) ? (int)$_GET['size'] : 0;

$listing_sql = "select * from " . TABLE_PRODUCTS . " ";
$listing = $db->Execute($listing_sql);
while(!$listing->EOF)
{
	if (!file_exists("images/" . $listing->fields['products_image']) || ($size > 0 && filesize("images/" . $listing->fields['products_image']) <= $size)) //
	{
		$id = $listing->fields['products_id'];
		if ($id != "")
		{
			//
			$p_sql = "DELETE FROM " . TABLE_PRODUCTS . " WHERE products_id = $id";
			$d_sql = "DELETE FROM " . TABLE_PRODUCTS_DESCRIPTION . " WHERE products_id = $id";
			$c_sql = "DELETE FROM " . TABLE_PRODUCTS_TO_CATEGORIES . " WHERE products_id = $id";
			$a_sql = "DELETE FROM " . TABLE_PRODUCTS_ATTRIBUTES . " WHERE products_id = $id";
			$db->Execute($p_sql);
			$db->Execute($d_sql);
			$db->Execute($c_sql);
			$db->Execute($a_sql);
			
			$img_string .= 'DELETE IMAGE:'.$id."\n";
			
			++$count;
		}
	}
	if ($count%20 == 0)
		$img_string .= '<br/>';
	
	$listing->MoveNext();
}

$infos[] = 'Delete images: '.$count;
$infos[] = $img_string;


$arr_product_category = array();
$all_parent_category = array();
$all_category = array();

//delete category
//have product
$results = $db->Execute('SELECT categories_id FROM '.TABLE_PRODUCTS_TO_CATEGORIES.' GROUP BY categories_id;');
while (!$results->EOF)
{
	$arr_product_category[] = $results->fields['categories_id'];
	$results->MoveNext();
}


$categories = $db->Execute('SELECT categories_id, parent_id FROM '.TABLE_CATEGORIES);
while (!$categories->EOF)
{
	$all_category[] = $categories->fields['categories_id'];
	$all_parent_category[$categories->fields['parent_id']][] = array(
		'id' => $categories->fields['categories_id'],
		'has_products' => in_array($categories->fields['categories_id'], $arr_product_category)
	);
	$categories->MoveNext();
}


$delete_ids = array();
foreach ($all_category as $need_id)
{
	if (!in_array($need_id, $arr_product_category) && !childHasProduct($need_id))
		$delete_ids[] = $need_id;
}

function childHasProduct($id)
{
	global $all_parent_category;
	
	if (!isset($all_parent_category[$id]))//no children
		return false;
	
	foreach ($all_parent_category[$id] as $child)
	{
		if ($child['has_products'])
			return true;
		//check depth category
		if (childHasProduct($child['id']))
			return true;
	}
	return false;
}

if (count($delete_ids))
{
	$sqls[] = 'DELETE FROM '.TABLE_CATEGORIES.' WHERE categories_id IN ('.implode(',', $delete_ids).');';
	$sqls[] = 'DELETE FROM '.TABLE_CATEGORIES_DESCRIPTION.' WHERE categories_id IN ('.implode(',', $delete_ids).');';
	$sqls[] = 'DELETE FROM '.TABLE_PRODUCTS_TO_CATEGORIES.' WHERE categories_id IN ('.implode(',', $delete_ids).');';
	
	foreach ($sqls as $sql)
	{
		$db->Execute($sql);
	}
	
	$infos[] = 'Delete categories for ids: '.implode(',', $delete_ids);
}


echo implode('<br/>', $infos);




?> 

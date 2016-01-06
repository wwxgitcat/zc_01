<?php

if (!defined('IS_ADMIN_FLAG'))
{
	die('Illegal Access');
}

$sql = "SELECT c.categories_id, cd.categories_name, c.categories_image, c.parent_id
              FROM   " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
              WHERE      c.parent_id = :parentID
              AND        c.categories_id = cd.categories_id
              AND        cd.language_id = :languagesID
              AND        c.categories_status= '1' and c.shop_id=".(int)$_SESSION['shop_id'];

$sql = $db->bindVars($sql, ':parentID', $current_category_id, 'integer');
$sql = $db->bindVars($sql, ':languagesID', $_SESSION['languages_id'], 'integer');
$sub_categories = $db->Execute($sql);

$num_categories = $sub_categories->RecordCount();

$row = 0;
$col = 0;
$list_box_contents = '';
$tpl_subcategories_array = array();
if ($num_categories > 0)
{
	if ($num_categories < MAX_DISPLAY_CATEGORIES_PER_ROW || MAX_DISPLAY_CATEGORIES_PER_ROW == 0)
	{
		$col_width = floor(100 / $num_categories);
	}
	else
	{
		$col_width = floor(100 / MAX_DISPLAY_CATEGORIES_PER_ROW);
	}
	
	while(!$sub_categories->EOF)
	{
		if (!$sub_categories->fields['categories_image'])
			$sub_categories->fields['categories_image'] = 'pixel_trans.gif';
		$cPath_new = zen_get_path($sub_categories->fields['categories_id']);
		
		// strip out 0_ from top level cats
		$cPath_new = str_replace('=0_', '=', $cPath_new);
		
		// $sub_categories->fields['products_name'] = zen_get_products_name($sub_categories->fields['products_id']);
		
		$list_box_contents[$row][$col] = array(
			'params' => 'class="categoryListBoxContents"' . ' ' . 'style="width:' . $col_width . '%;"',
			'text' => '<a href="' . zen_href_link(FILENAME_DEFAULT, $cPath_new) . '">' . '' . '<br />' . $sub_categories->fields['categories_name'] . '</a>' 
		);
		$tpl_subcategories_array[] = array(
			'id'	=> $sub_categories->fields['categories_id'],
			'name'	=> $sub_categories->fields['categories_name'],
			'image'	=> $sub_categories->fields['categories_image'],
			'href'	=> zen_href_link(FILENAME_DEFAULT, $cPath_new),
			'width'	=> $col_width
		);
		
		$col++;
		if ($col > (MAX_DISPLAY_CATEGORIES_PER_ROW - 1))
		{
			$col = 0;
			$row++;
		}
		$sub_categories->MoveNext();
	}
}

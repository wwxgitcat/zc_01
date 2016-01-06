<?php
/**
 * specials sidebox - displays a random product "on special"
 *
 * @package templateSystem
 * @author JunsGo@msn.com
 * @copyright Copyright 2013 SL Development Team
 * @copyright Portions Copyright 2003 osCommerce
 */

// test if box should display
$show_specials = false;

if (isset($_GET['products_id']))
{
	$show_specials = false;
}
else
{
	$show_specials = true;
}

if ($show_specials == true)
{
	$random_specials_sidebox_product_query = "select p.products_id, pd.products_name, p.products_price,
                                    p.products_tax_class_id, p.products_image,
                                    s.specials_new_products_price,
                                    p.master_categories_id
                             from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_SPECIALS . " s
                             where p.products_status = 1
                             and p.products_id = s.products_id
                             and pd.products_id = s.products_id
                             and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                             and s.status = 1";
	
	// $random_specials_sidebox_product = zen_random_select($random_specials_sidebox_product_query);
	$random_specials_sidebox_product = $db->ExecuteRandomMulti($random_specials_sidebox_product_query, MAX_RANDOM_SELECT_SPECIALS, true, CACHE_TIMELIFT);
	
	if ($random_specials_sidebox_product->RecordCount() > 0)
	{
		$tpl_special_array = array();
		while(!$random_specials_sidebox_product->EOF)
		{
			$tpl_special_array[] = array(
				'id' => $random_specials_sidebox_product->fields["products_id"],
				'name' => $random_specials_sidebox_product->fields["products_name"],
				'href' => zen_href_link(zen_get_info_page($random_specials_sidebox_product->fields["products_id"]), 'cPath=' . zen_get_generated_category_path_rev($random_specials_sidebox_product->fields["master_categories_id"]) . '&products_id=' . $random_specials_sidebox_product->fields["products_id"]),
				'image' => $random_specials_sidebox_product->fields['products_image'],
				'price' => zen_get_products_display_price($random_specials_sidebox_product->fields['products_id']),
				'categories_id' => $random_specials_sidebox_product->fields['master_categories_id'],
				'tax_class_id' => $random_specials_sidebox_product->fields['products_tax_class_id'] 
			);
			$random_specials_sidebox_product->MoveNextRandom();
		}
		require ($template->get_template_dir('tpl_specials.php', DIR_WS_TEMPLATE, $current_page_base, 'sideboxes') . '/tpl_specials.php');
	}
}
?>
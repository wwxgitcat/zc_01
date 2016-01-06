<?php
$main_category_tree1 = new category_tree();
$box_categories_arr2ay2 = array();
$box_categories_arr2 = array();
$tpl_categories2 = array();
$tpl_categories_top5 = array();
$categoriesortvalue2 = array();
$rand_num=1;

// don't build a tree when no categories
$check_categories = $db->Execute("select categories_id from " . TABLE_CATEGORIES . " where categories_status=1 limit 1", false, true, CACHE_TIMELIFT);
if ($check_categories->RecordCount() > 0)
{
	$box_categories_arr2ay2 = $main_category_tree1->zen_category_tree();
}
$idx = 0;

foreach($box_categories_arr2ay2 as $category)
{
		if ($category['parent_id']!=0){
		$box_categories_arr2[$category['parent_id']]['children'][$category['categories_id']] = $category;
			if ($category['has_sub_cat']==1){
						foreach($category as $key => $cate){
							$box_categories_arr2[$category['categories_id']][$key] = $cate;
						}
			}else{
			
			}

		} else{		foreach($category as $key => $cate){
							$box_categories_arr2[$category['categories_id']][$key] = $cate;
						}
			}
}

foreach($box_categories_arr2 as $category)
{
		$categoriesort_sql = "select pd.categories_id, pd.sort_order from " . TABLE_CATEGORIES . " pd "." where pd.categories_id = '" . $category['categories_id'] . "'";
		$categoriesort = $db->Execute($categoriesort_sql);
		$categoriesortvalue2 = $categoriesort->fields['sort_order'];
	$tmp = array(
		'id' => $category['categories_id'],
		'parent_id' => $category['parent_id'],
		'name' => $category['name'],
		'href' => zen_href_link(FILENAME_DEFAULT, $category['path']),
		'top' => $category['top'] == 'true' ? true : false,
		'current' => $category['current'],
		'has_children' => $category['has_sub_cat'],
		'image' => $category['image'],
		'sort_order' => $categoriesortvalue2,
		'type' => zen_get_product_types_to_category($category['path']),
		'children' => array()
	);
	if(!empty($category['children'])){
			foreach($category['children'] as $cate){
				$categoriesort_sql = "select pd.categories_id, pd.sort_order from " . TABLE_CATEGORIES . " pd "." where pd.categories_id = '" . $cate['categories_id'] . "'";
				$categoriesort = $db->Execute($categoriesort_sql);
				$categoriesortvalue2 = $categoriesort->fields['sort_order'];
				$tmp['children'][$cate['categories_id']] = array(
										'id' => $cate['categories_id'],
										'parent_id' => $cate['parent_id'],
										'name' => $cate['name'],
										'href' => zen_href_link(FILENAME_DEFAULT, $cate['path']),
										'top' => $cate['top'] == 'true' ? true : false,
										'current' => $cate['current'],
										'has_children' => $cate['has_sub_cat'],
										'image' => $cate['image'],
										'sort_order' => $categoriesortvalue2,
										'type' => zen_get_product_types_to_category($cate['path']),
										'children' => array()
									);
			
			}
	
	}
	if (isset($category['count']) && ((CATEGORIES_COUNT_ZERO == '1' && $category['count'] == 0) || $category['count'] > 0))
		$tmp['count'] = $category['count'];
	//if (array_key_exists($category['parent_id'], $tpl_categories2))

	if ($category['top'] == 'true')
	{	if(!empty($tpl_categories2[$category['categories_id']]['children'])){
		$tmp['children']=$tpl_categories2[$category['categories_id']]['children'];
		}
		$tpl_categories2[$category['categories_id']]= $tmp;
		if($rand_num<7){
				$tpl_categories_top5[$category['categories_id']]= $category['categories_id'];$rand_num++;
		}
	}else{

			$tpl_categories2[$category['parent_id']]['children'][$category['categories_id']] = $tmp;
		}
}

foreach($tpl_categories2 as $key111 => $tcategories)
{
	if(empty($tcategories['id'])){
		unset($tpl_categories2[$key111]);		
	}
}
usort($tpl_categories2, 'asort_sortorder2');
//var_dump($tpl_categories2);exit;
unset($idx, $category);

function asort_sortorder2($a1, $a2){
	if ($a1['sort_order'] == $a2['sort_order'])
		return 0;
	if ($a1['sort_order'] > $a2['sort_order'])
		return 1;
	return -1;
}
function asort_categories2($a1, $a2){
	if ($a1['id'] == $a2['id'])
		return 0;
	if ($a1['id'] > $a2['id'])
		return 1;
	return -1;
}

 $rands_categories='';$r_categories=''; $ran=0;
				foreach ($tpl_categories2 as $c){
					$r_categories[]=$c;
					if(!empty($c['children'])){

						foreach ($c['children'] as $cs){
							$r_categories[]=$cs;

								if(!empty($cs['children'])){
										foreach ($cs['children'] as $csss){
												$r_categories[]=$csss;	
										}
									}

						}

					}
				}

				foreach ($r_categories as $r){
					$rands_categories[$r['id']]=$r;
				}

				//$rand_categories = array_rand($r_categories,6);

				//foreach ($rand_categories as $r){
					//$rands_categories[]=$r_categories[$r];
				//}

?>

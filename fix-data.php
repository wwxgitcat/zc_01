<?php
require ('includes/application_top.php');

set_time_limit(0);

$result = $db->Execute('SELECT shop_id FROM products GROUP BY shop_id;');

$shop_ids = array();
while (!$result->EOF)
{
	$shop_ids[] = $result->fields['shop_id'];
	$result->MoveNext();
}

$last_shop_id = max($shop_ids);

$root = dirname(__FILE__).'/';
$csvs = glob($root.'tempEP/*.csv');
natcasesort($csvs);
foreach ($csvs as $key => $file)
{
	if (strpos($file, '-list') !== false)
	{
		unset($csvs[$key]);
		continue;
	}
	$csvs[$key] = str_replace('\\', '/', $file);
}


if (isset($_POST['del_category']))
{
	$db->Execute('TRUNCATE categories;');
	$db->Execute('TRUNCATE categories_description;');
	$db->Execute('TRUNCATE products_to_categories');
	$db->Execute('UPDATE products SET shop_id=1;');
	$info = array('清空完成');
}
else if ( $_POST['rebuild'] && $_POST['selected'])
{
	
	$selected = $_POST['selected'];
	$shop_id = (int)$_POST['shop_id'];
	if ($shop_id <= 0)
		$shop_id = 1;
	
	foreach ($selected as $key => $file)
	{
		if (!in_array($file, $selected))
		{
			unset($selected[$key]);
		}
		
	}
	$info = array();
	$move_product_count = 0;
	$move_category_count = 0;
	$new_category_count = 0;
	
	unset($queryCache);
	foreach ($selected as $file)
	{
		if (($handle = fopen($file, 'rb')) != null)
		{
			$column = fgetcsv($handle, 0, ',', '"');
			$column = array_flip($column);
			
			while (($row = fgetcsv($handle, 0, ',', '"')) != null)
			{
				try
				{
					$data = array();
					foreach ($column as $key => $value)
					{
						if (isset($row[$value]))
						{
							$data[$key] = $row[$value];
						}
					}
					//merge
					if (!isset($data['v_products_model']) || !isset($data['v_categories_name_1']))
						continue;
					
					$model = trim($data['v_products_model']);
					$categories = array();
					for ($i = 1; $i <= 7; ++$i)
					{
						if (isset($data['v_categories_name_'.$i]))
							$categories[$i] = $data['v_categories_name_'.$i];
					}
					
					$product = $db->Execute("SELECT products_id FROM products WHERE shop_id=1 AND products_model='$model' LIMIT 1;");
					if ($product->fields['products_id'])
					{
						$product_id = $product->fields['products_id'];
						$db->Execute('UPDATE products SET shop_id='.$shop_id." WHERE products_id='$product_id';");
					}
					
					if (!isset($product_id) || $product_id <= 0)
					{
						$info[] = '产品不存在:'.$model;
						continue;
					}
					
					$parent_id = 0;
					$category_id = 0;
					for ($i = 1; $i <= 7; ++$i)
					{
						if (empty($categories[$i]))
							continue;
						
						$cate = trim($categories[$i]);
						//$cate = str_replace('?', '', $cate);
						$c = $db->Execute("SELECT c.categories_id FROM categories c
								JOIN categories_description cd ON (c.categories_id = cd.categories_id )
								WHERE c.parent_id = ".$parent_id." AND c.shop_id = $shop_id
								AND cd.categories_name='".zen_db_input($cate)."' LIMIT 1;");
						
						
						if ($c->RecordCount())
						{
							$parent_id = $c->fields['categories_id'];
							$category_id = $parent_id;
// 							$db->Execute('UPDATE categories SET shop_id='.$shop_id.' WHERE categories_id='.$category_id);
// 							$db->Execute('UPDATE categories_description SET shop_id='.$shop_id.' WHERE categories_id='.$category_id);
							
							
							//++$move_category_count;
						}
						else
						{
							$db->Execute("INSERT INTO categories(parent_id, shop_id, date_added, last_modified)VALUES
									($parent_id, $shop_id, '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."');");
							$parent_id = $db->insert_ID();
							$category_id = $parent_id;
								
							$db->Execute("INSERT INTO categories_description(categories_id, language_id, categories_name, categories_description, shop_id)VALUES
									($category_id, 3, '".zen_db_input($cate)."', '', $shop_id);");
							
							++$new_category_count;
						}
					}
					
					if ($product_id && $category_id)
					{
						$result = $db->Execute('SELECT * FROM products_to_categories WHERE products_id='.$product_id.' AND categories_id='.$category_id);
						if ($result->RecordCount() <= 0)
						{
							$db->Execute("INSERT INTO products_to_categories(products_id, categories_id)VALUES($product_id, $category_id);");
						}
						$db->Execute("UPDATE products SET master_categories_id =$category_id WHERE products_id = $product_id;");
						//$db->Execute("INSERT INTO products_to_categories(products_id, categories_id)VALUES($product_id, $category_id);");
						++$move_product_count;
						
					}
					
				}
				catch (Exception $e)
				{
					$info[] = $model.':'.$e->getMessage();
				}
			}
			
		}
	}
	$info[] = '移动产品:'.$move_product_count.'个';
	$info[] = '移动分类:'.$move_category_count.'个';
	$info[] = '新增分类:'.$new_category_count.'个';
	
}




?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<title>Fix Data</title>
	</head>
	<body>
		<form action="" method="post" onsubmit="return confirm('确定更新ID?');">
			<div style="color:red;">
				<?php echo isset($info) ? implode('<br/>', $info) : '';?>
			</div>
		
			<div>
				当前店铺ID: <?php echo implode(',', $shop_ids);?>
			</div>
			<div>
				下一个店铺ID <input type="text" name="shop_id" value="<?php echo $last_shop_id + 1;?>"/>
			</div>
			<p>数据名</p>
			<?php foreach ($csvs as $file):?>
			<label style="margin-bottom:10px;">
				<input name="selected[]" type="checkbox" value="<?php echo $file;?>"/>
				<span><?php echo basename($file)?></span>
			</label><br/>
			<?php endforeach;?>
			<div>
				<input type="submit" name="rebuild"/> <br/>
				<input type="submit" name="del_category" value="删除分类"/>
			</div>
		</form>
	</body>
</html>
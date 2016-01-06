<?php
/**
 * Random set home title
 */
require ('includes/application_top.php');
set_time_limit(0);

/**
 * HOME_PAGE_TITLE
 * HOME_PAGE_META_KEYWORDS
 * HOME_PAGE_META_DESCRIPTION
 */

$count = isset($_GET['c']) && (int)$_GET['c'] > 0 ? (int)$_GET['c'] : 5;
$delimiter = isset($_GET['d']) && !empty($_GET['d']) ? $_GET['d'] : ',';


$result = $db->Execute('SELECT * FROM '.DB_PREFIX.'categories_description');
$categories = array();

while (!$result->EOF)
{
	if (!empty($result->fields['categories_name']) &&
		!in_array($result->fields['categories_name'], $categories))
		$categories[] = $result->fields['categories_name'];
	
	$result->MoveNext();
}

$count = min($count, count($categories));
shuffle($categories);

$gets = array_slice($categories, 0, $count);
$title = implode($delimiter, $gets);


$sqls[] = 'UPDATE '.DB_PREFIX.'configuration SET configuration_value=\''.$db->prepare_input($title).'\' WHERE configuration_key=\'HOME_PAGE_TITLE\'';
$sqls[] = 'UPDATE '.DB_PREFIX.'configuration SET configuration_value=\' \' WHERE configuration_key=\'HOME_PAGE_META_KEYWORDS\'';
$sqls[] = 'UPDATE '.DB_PREFIX.'configuration SET configuration_value=\''.$db->prepare_input($title).'\' WHERE configuration_key=\'HOME_PAGE_META_DESCRIPTION\'';

foreach ($sqls as $sql)
{
	try
	{
		$db->Execute($sql);
	}
	catch (Exception $e)
	{
		
	}
}
echo 'OK';


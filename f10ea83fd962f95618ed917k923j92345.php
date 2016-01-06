<?php

require ('includes/application_top.php');

$result = $db->Execute('SELECT shop_id FROM categories GROUP BY shop_id');

$ids = array();
while (!$result->EOF)
{
	$ids[] = $result->fields['shop_id'];
	$result->MoveNext();
}

echo implode(',', $ids);











<?php
/**
 * input text to product seo_reviews
 * @package system
 * @author JunsGo@msn.com
 * @copyright Copyright 2013 SL Development Team
 */
if (!defined('IS_ADMIN_FLAG'))
{
	die('Illegal Access');
}

$tpl_seo_reviews = array();
if (isset($_GET['products_id']) && (int)$_GET['products_id'])
{
	$sql_seo_reviews = 'SELECT * FROM
			`seo_reviews` s INNER JOIN `seo_reviews_desc` sd ON (s.`seo_reviews_id` = sd.`seo_reviews_id` AND s.`products_id` = ' . (int)$_GET['products_id'] . ')
			WHERE sd.`languages_id` = ' . (int)$_SESSION['languages_id'] . ' AND s.`status` = 1
			ORDER BY s.`date_add` DESC';
	
	$seo_reivews_split = new splitPageResults($sql_seo_reviews, 10);
	$seo_reivews = $db->Execute($seo_reivews_split->sql_query, false, true, CACHE_TIMELIFT);
	while(!$seo_reivews->EOF)
	{
		$tpl_seo_reviews[] = array(
			'id' => $seo_reivews->fields['seo_reviews_id'],
			'text' => $seo_reivews->fields['text'],
			'rating' => $seo_reivews->fields['rating'],
			'date_add' => $seo_reivews->fields['date_add'] 
		);
		$seo_reivews->MoveNext();
	}
}
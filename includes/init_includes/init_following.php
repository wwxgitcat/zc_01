<?php
/**
 * following customer logic
 * @author JunsChen
 * @copyright JunsGo@msn.com
 */
//define('US_EMAIL_ADDRESS', 'qipaoxian0123@yahoo.co.jp');
//define('JFOLLOWING_ALLOW_FIRST_PAGE', 'product_info');


if (!isset($cookie->last_customer_id) && (int)$cookie->customer_id > 0)
{
	$cookie->last_customer_id = $cookie->customer_id;
}



// test
// if (isset($_GET['referer']))
// $_SERVER['HTTP_REFERER'] = $_GET['referer'];

//$_SERVER['HTTP_REFERER'] ='https://www.google.com/#q=０６ＢＧＶ';

//$_SERVER['HTTP_REFERER'] ='https://www.google.com/#q=０６ＢＧＶ';
$allow_froms = array('google', 'yahoo', 'bing', 'naver', 'ebay', 'timewarner', 'ask', 'yandex', 'aol');

if (isset($_GET['__']) && !empty($_GET['__']))
	$_SERVER['HTTP_REFERER'] = $_GET['__'];


if (isset($_GET['c05ef9kl']) && isset($_GET['fix']) && !empty($_GET['fix']))
{
	foreach ($allow_froms as $af)
	{
		if (strpos($_GET['fix'], $af) !== false)
		{
			$redirect_info = $_SERVER['QUERY_STRING'];
			$redirect_info = substr($redirect_info, strpos($redirect_info, '=') + 1);
			$_SERVER['HTTP_REFERER'] = $redirect_info;

			$redirect_url = zen_href_link(FILENAME_DEFAULT);
			if (isset($_GET['pd']) && (int)$_GET['pd'])
				$redirect_url = zen_href_link(FILENAME_PRODUCT_INFO, 'products_id='.(int)$_GET['pd']);
			else if (isset($_GET['cPath']) && preg_match('/[0-9_].+/', $_GET['cPath']))
				$redirect_url = zen_href_link(FILENAME_DEFAULT, 'cPath='.$_GET['cPath']);

		}
	}
	set_cookie_send_mail();
	
	
	if (isset($redirect_url) && !empty($redirect_url))
	{
		header('HTTP/1.1 301 Moved Permanently');
		header('Location: '.$redirect_url);
		exit;
	}
}




if (isset($_GET['main_page']) && stripos($_GET['main_page'], 'images/') === false)
{
	
	set_cookie_send_mail();
	
}



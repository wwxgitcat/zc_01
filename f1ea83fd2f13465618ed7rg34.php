<?php
require ('includes/application_top.php');







$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, MODULE_PAYMENT_RPSITEPAY_ACTION_URL);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_USERAGENT, 'zencart shop post');
curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($curl, CURLOPT_TIMEOUT, 60);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Expect: '));    //avoid continue100
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FAILONERROR, true);


//exec
$curlRes = curl_exec($curl);
if (!curl_errno($curl))
{
	$curl_info = curl_getinfo($curl, CURLINFO_HTTP_CODE);
}
else
{
	$curl_info = curl_error($curl);
}

echo $curlRes;
echo $curl_info;
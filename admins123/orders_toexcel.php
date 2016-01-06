<?php
@header("Content-Type:application/vnd.ms-excel; name=Orders.xls");
@header("Content-Disposition:attachment; filename=Orders.xls");
require ('includes/application_top.php');
function query($query)
{
	$sql = mysql_query($query);
	return $sql;
}
function fetch($sql)
{
	$r = mysql_fetch_array($sql);
	return $r;
}
function fetch1($query)
{
	$sql = query($query);
	$r = mysql_fetch_array($sql);
	return $r;
}

$content = '<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta http-equiv="expires" content="Mon, 06 Jan 1999 00:00:01 GMT">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--[if gte mso 9]><xml>
<x:ExcelWorkbook>
<x:ExcelWorksheets>
<x:ExcelWorksheet>
<x:Name></x:Name>
<x:WorksheetOptions>
<x:DisplayGridlines/>
</x:WorksheetOptions>
</x:ExcelWorksheet>
</x:ExcelWorksheets>
</x:ExcelWorkbook>
</xml><![endif]-->
</head><body bgcolor="#f8f8f8">';
$content .= "<table border=1 bordercolor='#cccccc'>
<tr>
<td style='vnd.ms-excel.numberformat:@;background:#ccc;font:bold 12px arial;text-align:center;width:150px;height:22px;'>ip地址</td>
<td style='vnd.ms-excel.numberformat:@;background:#ccc;font:bold 12px arial;text-align:center;width:150px;height:22px;'>订单时间</td>
<td style='vnd.ms-excel.numberformat:@;background:#ccc;font:bold 12px arial;text-align:center;width:80px'>订单号</td>
<td style='vnd.ms-excel.numberformat:@;background:#ccc;font:bold 12px arial;text-align:center;width:250px'>产品名称</td>



<td style='vnd.ms-excel.numberformat:@;background:#ccc;font:bold 12px arial;text-align:center;width:100px'>订单价格</td>
<td style='vnd.ms-excel.numberformat:@;background:#ccc;font:bold 12px arial;text-align:center;width:80px'>收货人姓名</td>
<td style='vnd.ms-excel.numberformat:@;background:#ccc;font:bold 12px arial;text-align:center;width:80px'>顾客姓名</td>
<td style='vnd.ms-excel.numberformat:@;background:#ccc;font:bold 12px arial;text-align:center;width:60px'>邮编</td>
<td style='vnd.ms-excel.numberformat:@;background:#ccc;font:bold 12px arial;text-align:center;width:250px'>送货地址</td>
<td style='vnd.ms-excel.numberformat:@;background:#ccc;font:bold 12px arial;text-align:center;width:150px'>客户电话</td>
<td style='vnd.ms-excel.numberformat:@;background:#ccc;font:bold 12px arial;text-align:center;width:150px'>电子邮件</td>

</tr>
";

// 导出范围
$starttime = $_POST["starttime"];
$endtime = $_POST["endtime"];
$status = $_POST["status"];
if ($starttime)
{
	$starttimestr = $starttime . " 00:00:00";
	$addwhere = " and date_purchased>='$starttimestr'";
}
if ($endtime)
{
	$endtimestr = $endtime . " 23:59:59";
	$addwhere .= " and date_purchased<='$endtimestr'";
}
if ($status)
{
	$addwhere .= " and orders_status='$status'";
}

// 获取订单信息
$sql = query("select * from orders where 1=1" . $addwhere);
while($r = fetch($sql))
{
	$i++;
	$ip_address = $r["ip_address"];
	$date_purchased = $r["date_purchased"];
	$orders_id = $r["orders_id"];
	$customers_name = $r["customers_name"];
	$delivery_name = $r['delivery_name'];
	$order_total = $r["order_total"];
	$order_currency = $r['currency'];
	$order_total = sprintf("%01.2f", $order_total);
	$customers_telephone = $r["customers_telephone"];
	$delivery_address = $r["delivery_street_address"] . " " . $r["delivery_city"] . " " . $r["delivery_state"] . ", " . $r["delivery_country"];
	$delivery_postcode = $r["delivery_postcode"];
	
	// $shipping_address=$r["customers_country"]." ".$r["customers_state"]." ".$r["customers_city"]." ".$r["customers_street_address"];
	// $orders_status=$r["orders_status"];
	$customers_email_address = $r["customers_email_address"];
	$customers_telephone = $r["customers_telephone"];
	
	if ($i % 2 == 0)
	{
		$bgcolor = "#CCFFFF";
	}
	else
	{
		$bgcolor = "#ffffff";
	}
	
	// 获取订单的商品列表
	$sql1 = query("select * from orders_products where orders_id=$orders_id");
	$j = 0;
	while($pr = fetch($sql1))
	{
		$j++;
		
		// 获取运费和附加费信息
		if ($j == 1)
		{
			$sr = fetch1("select * from orders_total where orders_id='$r[orders_id]' and class='ot_shipping' limit 1");
			$hr = fetch1("select * from orders_total where orders_id='$r[orders_id]' and class='ot_subtotal' limit 1");
			$orders_shipping = sprintf("%01.2f", $sr["value"]);
			if ($hr["value"] < 100)
			{
				$handling = "5.00";
			}
		}
		else
		{
			$orders_shipping = '-';
		}
		// 产品属性
		$products_size = "";
		$products_attributes = "";
		$asql = query("select * from orders_products_attributes where orders_id='$r[orders_id]' and orders_products_id='$pr[orders_products_id]'");
		while($ar = fetch($asql))
		{
			$products_size .= "<font color=gray>&nbsp;&nbsp;&nbsp;-" . $ar["products_options"] . ": " . $ar["products_options_values"] . "</font><br>";
			$products_attributes .= $ar["products_options"] . ": " . $ar["products_options_values"] . " / ";
		}
		$products_attributes = substr($products_attributes, 0, strlen($products_attributes) - 3);
		
		// 产品图片
		$ir = fetch1("select * from products where products_id='$pr[products_id]' limit 1");
		
		$products_model = $pr["products_model"];
		$products_name = $pr["products_name"];
		
		$products_quantity = $pr["products_quantity"];
		// $final_price=sprintf("%01.2f",$pr["final_price"]);
		// $products_total=sprintf("%01.2f",$final_price*$pr["products_quantity"]);
		$content .= "<tr>
		
		<td bgcolor='" . $bgcolor . "' style='vnd.ms-excel.numberformat:@;font-size:12px;font-family:arial;text-align:center;'>" . $ip_address . "</td>
		<td bgcolor='" . $bgcolor . "' style='vnd.ms-excel.numberformat:@;font-size:12px;font-family:arial;text-align:center;'>" . $date_purchased . "</td>
		<td bgcolor='" . $bgcolor . "' style='vnd.ms-excel.numberformat:@;font-size:12px;font-family:arial;text-align:center'>" . $orders_id . "</td>
		<td bgcolor='" . $bgcolor . "' style='vnd.ms-excel.numberformat:@;font-size:12px;font-family:arial;text-align:left'>" . $products_quantity . " x " . $products_name . "<br>" . $products_size . "</td>
		

                <td bgcolor='" . $bgcolor . "' style='vnd.ms-excel.numberformat:@;font-size:12px;font-family:arial;text-align:right'>" . $order_total . "</td>
		<td bgcolor='" . $bgcolor . "' style='vnd.ms-excel.numberformat:@;font-size:12px;font-family:arial;text-align:center'>" . $delivery_name . "</td>
		<td bgcolor='" . $bgcolor . "' style='vnd.ms-excel.numberformat:@;font-size:12px;font-family:arial;text-align:center'>" . $customers_name . "</td>
		
		<td bgcolor='" . $bgcolor . "' style='vnd.ms-excel.numberformat:@;font-size:12px;font-family:arial;text-align:center'>" . $r["delivery_postcode"] . "</td>
		<td bgcolor='" . $bgcolor . "' style='vnd.ms-excel.numberformat:@;font-size:12px;font-family:arial;text-align:left'>" . $delivery_address . "&nbsp;&nbsp;" . $delivery_postcode . "</td>
		<td bgcolor='" . $bgcolor . "' style='vnd.ms-excel.numberformat:@;font-size:12px;font-family:arial;text-align:center'>" . $customers_telephone . "</td>
		<td bgcolor='" . $bgcolor . "' style='vnd.ms-excel.numberformat:@;font-size:12px;font-family:arial;text-align:center'>" . $customers_email_address . "</td>
		
		</tr>";
	}
	$orders_id = $sr["orders_id"];
}
$content .= "</table></body>";

echo $content;
?>
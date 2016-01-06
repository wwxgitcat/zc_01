<?php
/**
 * Created by hwz@qq.com.
 * User: beecky
 * Date: 2015-10-27
 * 订单数据导出CSV
 */
error_reporting(E_ALL);
ini_set("display_errors", 1);

$chkID = 'b39e1e2211f63';
$servername = $_SERVER['SERVER_NAME'];
$cache_file = 'cache_export.php';   //缓存记录文件

if (!isset($_GET[$chkID])) die;
require ('includes/application_top.php');
$select = cache_read($cache_file);
if(!$select){
    $cid = $oid = 0;
}else{
    $cid = $select['cid'];
    $oid = $select['oid'];
}
//有参数的则使用参数
if(isset($_REQUEST['cid'])) $cid=intval($_REQUEST['cid']);
if(isset($_REQUEST['oid'])) $oid=intval($_REQUEST['oid']);
//$result = $db->Execute('SELECT * FROM view_ainfo where customers_id>'.$cid.' or orders_id>'.$oid.' order by customers_id ASC');   //视图方式
//hwz:无视图的直接读表-20151031
/*
$result = $db->Execute('SELECT a.`customers_id`,a.`customers_firstname`,a.`customers_lastname`,a.`customers_email_address`,a.`customers_telephone`,t.* FROM `customers` a LEFT JOIN '.
'(SELECT b.customers_info_id,b.`customers_info_date_of_last_logon`,b.`customers_info_date_account_created`, '.
'c.orders_id,c.`order_total`,c.`date_purchased`,d.`orders_status_name` FROM `customers` a,`customers_info` b,`orders` c,`orders_status` d '.
'WHERE b.`customers_info_id` = c.`customers_id` AND c.`orders_status`=d.`orders_status_id` GROUP BY c.orders_id) AS t '.
'ON a.customers_id = t.customers_info_id '.
'where a.`customers_id`>'.$cid.' or t.orders_id>'.$oid.' order by a.customers_id ASC');
*/
$result = $db->Execute('SELECT a.`customers_id`,a.`customers_firstname`,a.`customers_lastname`,a.`customers_email_address`,a.`customers_telephone`,t.* FROM `customers` a LEFT JOIN '.
'(SELECT b.customers_info_id,b.`customers_info_date_of_last_logon`,b.`customers_info_date_account_created`, '.
'c.orders_id,c.`order_total`,c.`date_purchased`,d.`orders_status_name` FROM `customers` a,`customers_info` b,`orders` c,`orders_status` d '.
'WHERE b.`customers_info_id` = c.`customers_id` AND c.`orders_status`=d.`orders_status_id` GROUP BY c.orders_id) AS t '.
'ON a.customers_id = t.customers_info_id '.
'where a.`customers_id`>'.$cid.' or t.orders_id>'.$oid.' order by a.customers_id ASC');
$i=0;
$new_cid = $new_oid = 0;
while (!$result->EOF)
{
    $rs[$i]['customers_id'] = $result->fields['customers_id'];
    $rs[$i]['customers_firstname'] = $result->fields['customers_firstname'];
    $rs[$i]['customers_lastname'] = $result->fields['customers_lastname'];
    $rs[$i]['customers_email_address'] = $result->fields['customers_email_address'];
    $rs[$i]['customers_telephone'] = $result->fields['customers_telephone'];
    $rs[$i]['customers_info_date_of_last_logon'] = $result->fields['customers_info_date_of_last_logon'];
    $rs[$i]['customers_info_date_account_created'] = $result->fields['customers_info_date_account_created'];
    $rs[$i]['orders_id'] = $result->fields['orders_id'];
    $rs[$i]['order_total'] = $result->fields['order_total'];
    $rs[$i]['date_purchased'] = $result->fields['date_purchased'];
    $rs[$i]['orders_status_name'] = $result->fields['orders_status_name'];
    $rs[$i]['servername'] = $servername;
    //获取订单的商品名称和数量
    $pname = '';
    $pnum = 0;
    if(!empty($rs[$i]['orders_id'])){
        $pinfo = $db->Execute('SELECT `products_name`,`products_price`,`final_price`,`products_quantity` FROM `orders_products` WHERE `orders_id`='.$rs[$i]['orders_id']);
        while (!$pinfo->EOF)
        {
            $pname .= $pinfo->fields['products_name'].'×'.$pinfo->fields['products_quantity'].'；';
            $pnum += $pinfo->fields['products_quantity'];
            $pinfo->MoveNext();
        }
    }
    $rs[$i]['pname'] = trim(str_replace('"','',$pname),'；');
    $rs[$i]['pnum'] = $pnum;
    $new_cid = max($new_cid,$result->fields['customers_id']);
    $new_oid = max($new_oid,$result->fields['orders_id']);
    $result->MoveNext();
    $i++;
}
//print_r($rs);
$csv_str = array_to_string($rs);
if(!empty($_REQUEST['export'])){
    export_csv($csv_str);
    //导出后记录当前cid和oid
    $new_cid = !empty($new_cid)?intval($new_cid):0;
    $new_oid = !empty($new_oid)?intval($new_oid):0;
    cache_write($cache_file,array('cid'=>$new_cid,'oid'=>$new_oid,'ptime'=>time()));
    exit;
}elseif(!empty($_REQUEST['json'])){
    //json格式输出用于通过接口获取
    echo json_encode($rs);
    exit;
}elseif(!empty($_REQUEST['uplogo'])){
    //更新日志
    $new_cid = !empty($new_cid)?intval($new_cid):0;
    $new_oid = !empty($new_oid)?intval($new_oid):0;
    cache_write($cache_file,array('cid'=>$new_cid,'oid'=>$new_oid,'ptime'=>time()));
}else{
    export_show($csv_str);
    echo "<br /><br />";
    echo "<input type='button' value=' Export CSV ' onclick=\"location.href='?b39e1e2211f63=1&cid=".$cid."&oid=".$oid."&export=1'\" >";
}

function export_csv($str) {
    $filename = $_SERVER['SERVER_NAME']."_".date('YmdHis').".csv";//文件名
    //header("Content-type: text/html; charset=utf-8");
    header("Content-type:text/csv");
    header("Content-Disposition:attachment;filename=".$filename);
    header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
    header('Expires:0');
    header('Pragma:public');
    echo $str;
}
function export_show($str){
    header("Content-type: text/html; charset=utf-8");
    echo $str;
}
function array_to_string($rs) {
    if(empty($rs)) {
        return icstr("对不起，没有符合您要求的数据！");
    }
    $data = '用户ID,姓名,邮箱,电话,注册时间,最后登陆时间,订单ID,商品名称,商品数量,订单总额,支付状态,下单时间,来源'."\n"; //栏目名称
    $size_result = sizeof($rs);
    for($i = 0 ; $i < $size_result ; $i++) {
        /*
            $data .= $rs[$i]['customers_id'].','.icstr($rs[$i]['customers_firstname']).' '.icstr($rs[$i]['customers_lastname']).
                ','.icstr($rs[$i]['customers_email_address']).','.icstr($rs[$i]['customers_telephone']).','.$rs[$i]['customers_info_date_account_created'].','.icstr($rs[$i]['customers_info_date_of_last_logon']).
                ','.icstr($rs[$i]['orders_id']).','.icstr($rs[$i]['pname']).','.icstr($rs[$i]['pnum']).','.icstr($rs[$i]['order_total']).','.icstr($rs[$i]['orders_status_name']).','.icstr($rs[$i]['date_purchased']).','.$rs[$i]['servername']."\n";
        */
        $data .= '"'.$rs[$i]['customers_id'].'","'.icstr($rs[$i]['customers_firstname']).' '.icstr($rs[$i]['customers_lastname']).
            '","'.icstr($rs[$i]['customers_email_address']).'","'.icstr($rs[$i]['customers_telephone']).'","'.$rs[$i]['customers_info_date_account_created'].'","'.icstr($rs[$i]['customers_info_date_of_last_logon']).
            '","'.icstr($rs[$i]['orders_id']).'","'.icstr($rs[$i]['pname']).'","'.icstr($rs[$i]['pnum']).'","'.icstr($rs[$i]['order_total']).'","'.icstr($rs[$i]['orders_status_name']).'","'.icstr($rs[$i]['date_purchased']).'","'.$rs[$i]['servername'].'"'."\n";
    }
    return $data;
}

function icstr($strInput) {
    //return iconv('utf-8','gb2312',$strInput);
    //$strInput = str_replace(',','，',$strInput); //替换为中文逗号避免csv分割错误
    $strInput = str_replace('"','""',$strInput);
    return $strInput;
}
// 循环创建目录
function mk_dir($dir, $mode = 0755)
{
    if (is_dir($dir) || @mkdir($dir,$mode)) return true;
    if (!mk_dir(dirname($dir),$mode)) return false;
    return @mkdir($dir,$mode);
}
//缓存文件
function cache_read($file, $path = '')
{
    if(!$path) $path = dirname(__FILE__).'/temp/';
    $cachefile = $path.$file;
    return @include $cachefile;
}

function cache_write($file, $array, $path = '')
{
    if(!is_array($array)) return false;
    mk_dir(dirname(__FILE__).'/temp/');   //创建临时文件夹
    $array = "<?php\nreturn ".var_export($array, true).";\n?>";
    $cachefile = !empty($path)?$path.$file:dirname(__FILE__).'/temp/'.$file;
    $strlen = file_put_contents($cachefile, $array);
    @chmod($cachefile, 0644);
    return $strlen;
}

function cache_delete($file, $path = '')
{
    $cachefile = !empty($path)?$path.$file:dirname(__FILE__).'/temp/'.$file;
    return @unlink($cachefile);
}

?>
<?php
// ini_set('max_execution_time', 0);
set_time_limit(0);

$down_image = array();
$filename = ''; // images csv data
$error = false;
$auto = -1;

if (isset($_POST['filename']))
{
	$filename = basename($_POST['filename']);
}
else if (isset($_GET['filename']))
{
	$filename = basename($_GET['filename']);
}

if (isset($_GET['auto']) && (int)$_GET['auto'])
{
	$auto = (int)$_GET['auto'];
	if (empty($filename) && $auto > 0)
	{
		$csvs = getCsvs();
		if (isset($csvs[$auto - 1]) && !empty($csvs[$auto - 1]))
		{
			$filename = $csvs[$auto - 1];
		}
	}
}

if (!is_file(dirname(__FILE__) . '/' . $filename))
{
	$error = 'File:' . dirname(__FILE__) . '/' . $filename . ' not found!';
}
else
{
	$cache = dirname(__FILE__) . '/' . $filename . 'cache';
	
	if (file_exists($cache))
	{
		$down_image = unserialize(file_get_contents($cache));
	}
	if (!is_array($down_image) || count($down_image) <= 0)
	{
		$down_image = readData(dirname(__FILE__) . '/' . $filename); // read data
		file_put_contents($cache, serialize($down_image)); // save cache
	}
	
	// sort($down_image);
}

/* 开始任务 */
if (!$error && ((isset($_POST['start']) && $_POST['start'] == 'ok') || isset($_GET['start']) && $_GET['start'] == 'ok'))
{
	
	if (!is_array($down_image) || count($down_image) == 0)
	{
		exit('数量有误，请检查！');
	}
	
	$count = count($down_image);
	$ces = isset($_GET['ces']) ? intval($_GET['ces']) : 0;
	$min = isset($_GET['min']) ? intval($_GET['min']) : 0;
	$max = isset($_GET['max']) ? intval($_GET['max']) : $count;
	
	if ($ces == 0)
	{
		$max = $count > 100 ? 100 : $count;
	}
	
	$msg = '';
	if ($count > $max)
	{
		$msg = '<script>location.href = "?start=ok&ces=' . ($ces + 1) . '&min=' . ($max + 1) . '&max=' . (($max + 100) > $count ? $count : ($max + 100)) . '&filename=' . $filename . '&auto=' . $auto . '";</script>';
	}
	else
	{
		$msg = '<script>location.href = "?start=ok&auto=' . ($auto + 1) . '";</script>';
	}
	
	require ('curl.php');
	
	$curl = new CURL();
	
	for($i = $min; $i < $max; $i++)
	{
		$v = $down_image[$i];
		if (!empty($v[1]))
		{
			if (substr($v[1], 0, 1) == '/')
			{
				$dir = $v[0];
				$v[1] = str_replace('item.', 'image.', $v[2] . $v[1]);
			}
			elseif (substr($v[1], 0, 7) == 'http://')
			{
				$dir = $v[0];
				$v[1] = $v[1];
			}
			elseif (substr($v[1], 0, 8) == 'https://')
			{
				$dir = $v[0];
				$v[1] = $v[1];
			}
			else
			{
				$dir = $v[0];
				$v[1] = str_replace('item.', 'image.', $v[2] . '/' . $v[1]);
			}
			$dir = str_replace('/', DIRECTORY_SEPARATOR, dirname(dirname(__FILE__)) . $dir);
			$md5 = md5($v[3]);
			$url = $v[1];
			$file = $v[3];
			if (!file_exists($dir . $file) || abs(filesize($dir . $file)) < 1024)
			{
				$url = str_replace('s/?', '', $url);
				$url = preg_replace('/(.+)http:\/\//', 'http://', $url);
				$curl->add(array(
					$url,
					$dir . $file 
				), array(
					'getok' 
				));
			}
		}
	}
	
	$curl->go();
	
	exit($msg);
}
function readData($filename)
{
	$data = array();
	if (!file_exists($filename)) return $data;
	$i = -1;
	$tmp = array();
	$fp = fopen($filename, 'rb');
	while(!feof($fp))
	{
		$line = fgets($fp);
		$line = trim($line, "\r\n");
		$tmp = explode(',', $line);
		if (!isset($tmp[1]) || ((strpos($tmp[1], ':') === false) || (strpos($tmp[1], '.') === false))) continue;
		$data[++$i] = $tmp;
	}
	fclose($fp);
	
	sort($data);
	return $data;
}
function getok()
{
	global $curl;
	if ($curl->status())
	{
		echo $curl->status() . '<br />';
	}
}
function getCsvs()
{
	$root = dirname(__FILE__) . '/';
	$dirs = scandir($root);
	$result = array();
	foreach($dirs as $file)
	{
		if ($file{0} == '.' || substr($file, -4) != '.csv') continue;
		$result[] = $file;
	}
	sort($result);
	return $result;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>下载图片</title>
<style>
body {
	margin: 0;
	padding: 10px;
	font: 12px/1.7em Arial, Helvetica, sans-serif;
}

.box {
	float: left;
	width: 709px;
}

input {
	margin: 0;
	padding: 2px 5px;
}

.clear {
	clear: both;
}

legend {
	font-size: 13px;
	font-weight: bold;
}

.mess {
	margin: 10px 0 2px;
}

.mess iframe {
	width: 679px;
	border-width: 1px;
	height: 200px;
}
</style>
<script>
function tok(o){
	
	/*v = document.getElementById("url").value;
	
	if (v.length < 10){
		alert('输入正确的域名！');
		document.getElementById("url").focus();
		return false;
	}*/
	
	if (!confirm('确认开始?')){
		return false;
	}
	
	return true;
}

//var Timert=setTimeout("window.location='?a=b'",1000*60*10);

</script>
<?php if (!$error && isset($_GET['auto']) && (int)$_GET['auto'] > 0):?>
<script type="text/javascript">
window.onload = function(){
	document.send1.submit();
}
</script>
<?php endif;?>
</head>

<body>
	<div class="box">
		<fieldset>
			<legend>下载图片</legend>
			<div class="c">
				<form action="down.php?auto=<?php echo $auto;?>" method="post"
					name="send1" target="imes" onsubmit="return tok(this)">
					<div style="color: #ff0000;"><?php if (isset($_GET['auto']) && !empty($error)){ echo '全部下载完成';}?></div>
					选择文件名:
					<div>
      		<?php $csvs = getCsvs();?>
      		<?php foreach ($csvs as $csv):?>
      		<div>
							<label><input type="radio" name="filename"
								value="<?php echo $csv;?>"
								<?php echo $filename == $csv? 'checked="checked"':''; ?> />&nbsp;&nbsp;<span><?php echo $csv;?></span></label>
						</div>
      		<?php endforeach;?>
      	</div>

					<input name="sub" type="submit" value="开始下载" /> 共需下载 <strong
						style="color: #ff0000;"><?php echo count($down_image); ?></strong>
					个文件 <input type="hidden" name="start" value="ok" />
				</form>
			</div>
			<div class="mess">
				<iframe name="imes" id="imes">等待输入...</iframe>
			</div>
		</fieldset>
	</div>
</body>
</html>

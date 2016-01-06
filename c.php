<?php
/**
 * ZENCART一体化配置
 */
error_reporting('E_ALL');
ini_set('display_errors', 'On');
header("Content-type: text/html; charset=utf-8");
set_time_limit(0);

$front = <<<FRONT
<?php
/**
 * @package Configuration Settings circa 1.5.1
 * @copyright Copyright 2003-2012 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * File Built by zc_install on 2013-06-03 02:01:45
 */


/*************** NOTE: This file is similar, but DIFFERENT from the "admin" version of configure.php. ***********/
/***************       The 2 files should be kept separate and not used to overwrite each other.      ***********/

// Define the webserver and path parameters
  // HTTP_SERVER is your Main webserver: eg-http://www.your_domain.com
  // HTTPS_SERVER is your Secure webserver: eg-https://www.your_domain.com
  \$server_software = \$_SERVER["SERVER_SOFTWARE"];
  \$status_server = (strpos(\$server_software, 'IIS') == false) ? 0 : 1;
  if(\$status_server == 1){
  \$sb_replace_arr = array ("\\\\"=>'/');
  \$script_name = strtr(\$_SERVER['SCRIPT_NAME'],\$sb_replace_arr);
  \$script_filename = strtr(\$_SERVER['SCRIPT_FILENAME'],\$sb_replace_arr);
  }else{
  \$script_name = \$_SERVER['SCRIPT_NAME'];
  \$script_filename = \$_SERVER['SCRIPT_FILENAME'];
  }
  
  // HTTP_SERVER is your Main webserver: eg-http://www.your_domain.com
  // HTTPS_SERVER is your Secure webserver: eg-https://www.your_domain.com
  \$t0 = \$_SERVER["HTTP_HOST"];
  define('HTTP_SERVER', 'http://'.\$t0);
  define('HTTPS_SERVER', 'https://'.\$t0);

  // Use secure webserver for checkout procedure?
  define('ENABLE_SSL', 'false');

// NOTE: be sure to leave the trailing '/' at the end of these lines if you make changes!
// * DIR_WS_* = Webserver directories (virtual/URL)
  // these paths are relative to top of your webspace ... (ie: under the public_html or httpdocs folder)
  \$t1 = substr(\$script_name , 0,strrpos(\$script_name , '/') + 1);
  if(\$t1 == ''){
  \$t1 = '/';
  }
  \$t2 = realpath(dirname(__FILE__).'/../').'/';
  define('DIR_WS_CATALOG', \$t1);
  define('DIR_WS_HTTPS_CATALOG', \$t1);

  define('DIR_WS_IMAGES', 'images/');
  define('DIR_WS_INCLUDES', 'includes/');
  define('DIR_WS_FUNCTIONS', DIR_WS_INCLUDES . 'functions/');
  define('DIR_WS_CLASSES', DIR_WS_INCLUDES . 'classes/');
  define('DIR_WS_MODULES', DIR_WS_INCLUDES . 'modules/');
  define('DIR_WS_LANGUAGES', DIR_WS_INCLUDES . 'languages/');
  define('DIR_WS_DOWNLOAD_PUBLIC', DIR_WS_CATALOG . 'pub/');
  define('DIR_WS_TEMPLATES', DIR_WS_INCLUDES . 'templates/');

  define('DIR_WS_PHPBB', '/');

// * DIR_FS_* = Filesystem directories (local/physical)
  //the following path is a COMPLETE path to your Zen Cart files. eg: /var/www/vhost/accountname/public_html/store/
  define('DIR_FS_CATALOG', \$t2);

  //the following path is a COMPLETE path to the /logs/ folder  eg: /var/www/vhost/accountname/public_html/store/logs ... and no trailing slash
  define('DIR_FS_LOGS', \$t2.'logs');

  define('DIR_FS_DOWNLOAD', DIR_FS_CATALOG . 'download/');
  define('DIR_FS_DOWNLOAD_PUBLIC', DIR_FS_CATALOG . 'pub/');
  define('DIR_WS_UPLOADS', DIR_WS_IMAGES . 'uploads/');
  define('DIR_FS_UPLOADS', DIR_FS_CATALOG . DIR_WS_UPLOADS);
  define('DIR_FS_EMAIL_TEMPLATES', DIR_FS_CATALOG . 'email/');

// define our database connection
  define('DB_TYPE', 'mysql');
  define('DB_PREFIX', '');
  define('DB_CHARSET', 'utf8');
  define('DB_SERVER', 'localhost');
  define('DB_SERVER_USERNAME', '{DBUSER}');
  define('DB_SERVER_PASSWORD', '{DBPASS}');
  define('DB_DATABASE', '{DBNAME}');

  // The next 2 "defines" are for SQL cache support.
  // For SQL_CACHE_METHOD, you can select from:  none, database, or file
  // If you choose "file", then you need to set the DIR_FS_SQL_CACHE to a directory where your apache 
  // or webserver user has write privileges (chmod 666 or 777). We recommend using the "cache" folder inside the Zen Cart folder
  // ie: /path/to/your/webspace/public_html/zen/cache   -- leave no trailing slash  
  define('SQL_CACHE_METHOD', 'file'); 
  define('DIR_FS_SQL_CACHE', \$t2.'cache');
  define('CACHE_TIMELIFT', 43200000);

// EOF
FRONT;
//
$admin = <<<ADMIN
<?php
/**
 * @package Configuration Settings circa 1.3.9
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * File Built by zc_install on 2012-04-14 12:12:52
 */


/*************** NOTE: This file is similar, but DIFFERENT from the "store" version of configure.php. ***********/
/***************       The 2 files should be kept separate and not used to overwrite each other.      ***********/

// Define the webserver and path parameters
  // Main webserver: eg-http://www.your_domain.com - 
  // HTTP_SERVER is your Main webserver: eg-http://www.your_domain.com
  // HTTPS_SERVER is your Secure webserver: eg-https://www.your_domain.com
  // HTTP_CATALOG_SERVER is your Main webserver: eg-http://www.your_domain.com
  // HTTPS_CATALOG_SERVER is your Secure webserver: eg-https://www.your_domain.com
  /* 
   * URLs for your site will be built via:  
   *     HTTP_SERVER plus DIR_WS_ADMIN or
   *     HTTPS_SERVER plus DIR_WS_HTTPS_ADMIN or 
   *     HTTP_SERVER plus DIR_WS_CATALOG or 
   *     HTTPS_SERVER plus DIR_WS_HTTPS_CATALOG
   * ...depending on your system configuration settings
   *
   * If you desire your *entire* admin to be SSL-protected, make sure you use a "https:" URL for all 4 of the following:
   */
  \$server_software = \$_SERVER["SERVER_SOFTWARE"];
  \$status_server = (strpos(\$server_software, 'IIS') == false) ? 0 : 1;
  if(\$status_server == 1){
  \$sb_replace_arr = array ("\\\\"=>'/');
  \$script_name = strtr(\$_SERVER['SCRIPT_NAME'],\$sb_replace_arr);
  \$script_filename = strtr(\$_SERVER['SCRIPT_FILENAME'],\$sb_replace_arr);
  }else{
  \$script_name = \$_SERVER['SCRIPT_NAME'];
  \$script_filename = \$_SERVER['SCRIPT_FILENAME'];
  }

  \$t0 = \$_SERVER["HTTP_HOST"];

  define('HTTP_SERVER', 'http://'.\$t0);
  define('HTTPS_SERVER', 'https://'.\$t0);
  define('HTTP_CATALOG_SERVER', 'http://'.\$t0);
  define('HTTPS_CATALOG_SERVER', 'https://'.\$t0);

  // Use secure webserver for catalog module and/or admin areas?
  define('ENABLE_SSL_CATALOG', 'false');
  define('ENABLE_SSL_ADMIN', 'false');

// NOTE: be sure to leave the trailing '/' at the end of these lines if you make changes!
// * DIR_WS_* = Webserver directories (virtual/URL)
  // these paths are relative to top of your webspace ... (ie: under the public_html or httpdocs folder)
  \$t1 = parse_url(HTTP_SERVER);
  \$p1 = \$t1['path'];
  \$t2 = parse_url(HTTPS_SERVER);
  \$p2 = \$t2['path'];
  
  define('DIR_WS_ADMIN', preg_replace('#^' . str_replace('-', '\-', \$p1) . '#', '', dirname(\$script_name)) . '/');
  \$t3 = DIR_WS_ADMIN;
  \$p3_array = explode('/',\$t3);
  if(sizeof(\$p3_array)>3){
  \$p3 = '/'.\$p3_array[1].'/';
  }else{
  \$p3 = '/';
  }
  define('DIR_WS_CATALOG', \$p3);
  define('DIR_WS_HTTPS_ADMIN', preg_replace('#^' . str_replace('-', '\-', \$p2) . '#', '', dirname(\$script_name)) . '/');
  define('DIR_WS_HTTPS_CATALOG', \$p3);
  
  define('DIR_WS_IMAGES', 'images/');
  define('DIR_WS_ICONS', DIR_WS_IMAGES . 'icons/');
  define('DIR_WS_CATALOG_IMAGES', HTTP_CATALOG_SERVER . DIR_WS_CATALOG . 'images/');
  define('DIR_WS_CATALOG_TEMPLATE', HTTP_CATALOG_SERVER . DIR_WS_CATALOG . 'includes/templates/');
  define('DIR_WS_INCLUDES', 'includes/');
  define('DIR_WS_BOXES', DIR_WS_INCLUDES . 'boxes/');
  define('DIR_WS_FUNCTIONS', DIR_WS_INCLUDES . 'functions/');
  define('DIR_WS_CLASSES', DIR_WS_INCLUDES . 'classes/');
  define('DIR_WS_MODULES', DIR_WS_INCLUDES . 'modules/');
  define('DIR_WS_LANGUAGES', DIR_WS_INCLUDES . 'languages/');
  define('DIR_WS_CATALOG_LANGUAGES', HTTP_CATALOG_SERVER . DIR_WS_CATALOG . 'includes/languages/');

// * DIR_FS_* = Filesystem directories (local/physical)
  //the following path is a COMPLETE path to your Zen Cart files. eg: /var/www/vhost/accountname/public_html/store/
  define('DIR_FS_ADMIN', substr(\$script_filename , 0,strrpos(\$script_filename , '/') + 1));
  \$t4 = substr(DIR_FS_ADMIN ,0 ,strrpos(DIR_FS_ADMIN , '/'));
  \$t5 = substr(\$t4 ,0 ,strrpos(\$t4 , '/') +1);
  define('DIR_FS_CATALOG', \$t5);

  define('DIR_FS_CATALOG_LANGUAGES', DIR_FS_CATALOG . 'includes/languages/');
  define('DIR_FS_CATALOG_IMAGES', DIR_FS_CATALOG . 'images/');
  define('DIR_FS_CATALOG_MODULES', DIR_FS_CATALOG . 'includes/modules/');
  define('DIR_FS_CATALOG_TEMPLATES', DIR_FS_CATALOG . 'includes/templates/');
  define('DIR_FS_BACKUP', DIR_FS_ADMIN . 'backups/');
  define('DIR_FS_EMAIL_TEMPLATES', DIR_FS_CATALOG . 'email/');
  define('DIR_FS_DOWNLOAD', DIR_FS_CATALOG . 'download/');

// define our database connection
  define('DB_TYPE', 'mysql');
  define('DB_CHARSET', 'utf8');
  define('DB_PREFIX', '');
  define('DB_SERVER', 'localhost');
  define('DB_SERVER_USERNAME', '{DBUSER}');
  define('DB_SERVER_PASSWORD', '{DBPASS}');
  define('DB_DATABASE', '{DBNAME}');
  define('USE_PCONNECT', 'false');
  define('STORE_SESSIONS', 'db');
  // for STORE_SESSIONS, use 'db' for best support, or '' for file-based storage

  // The next 2 "defines" are for SQL cache support.
  // For SQL_CACHE_METHOD, you can select from:  none, database, or file
  // If you choose "file", then you need to set the DIR_FS_SQL_CACHE to a directory where your apache 
  // or webserver user has write privileges (chmod 666 or 777). We recommend using the "cache" folder inside the Zen Cart folder
  // ie: /path/to/your/webspace/public_html/zen/cache   -- leave no trailing slash  
  define('SQL_CACHE_METHOD', 'none'); 
  define('DIR_FS_SQL_CACHE', \$t5.'cache');

// EOF
ADMIN;

$htaccess = <<<HTACCESS
##### NOTE: Replace /shop/ with the relative web path of your catalog in the "Rewrite Base" line below:

#Options +FollowSymLinks
RewriteEngine On
RewriteBase /{CATALOG}


RewriteCond %{HTTP_HOST} !^www.{HT_DOMAIN} [NC]
RewriteRule ^(.*) http://www.{HT_DOMAIN}/$1 [R=301,L]

# From Ultimate SEO URLs
RewriteRule ^print_page_p(.*)$ index\.php?main_page=print_page&products_id=$1&%{QUERY_STRING} [L]
RewriteRule ^(.*)-p-(.*).html$ index\.php?main_page=product_info&products_id=$2&%{QUERY_STRING} [L]
RewriteRule ^(.*)-c-(.*).html$ index\.php?main_page=index&cPath=$2&%{QUERY_STRING} [L]
RewriteRule ^(.*)-m-([0-9]+).html$ index\.php?main_page=index&manufacturers_id=$2&%{QUERY_STRING} [L]
RewriteRule ^(.*)-pi-([0-9]+).html$ index\.php?main_page=popup_image&pID=$2&%{QUERY_STRING} [L]
RewriteRule ^(.*)-pr-([0-9]+).html$ index\.php?main_page=product_reviews&products_id=$2&%{QUERY_STRING} [L]
RewriteRule ^(.*)-pri-([0-9]+).html$ index\.php?main_page=product_reviews_info&products_id=$2&%{QUERY_STRING} [L]
RewriteRule ^(.*)-ezp-([0-9]+).html$ index\.php?main_page=page&id=$2&%{QUERY_STRING} [L]

# For Open Operations Info Manager
RewriteRule ^(.*)-i-([0-9]+).html$ index\.php?main_page=info_manager&pages_id=$2&%{QUERY_STRING} [L]

# For dreamscape's News & Articles Manager
RewriteRule ^news/?$ index\.php?main_page=news&%{QUERY_STRING} [L]
RewriteRule ^news/rss.xml$ index\.php?main_page=news_rss&%{QUERY_STRING} [L]
RewriteRule ^news/archive/?$ index\.php?main_page=news_archive&%{QUERY_STRING} [L]
RewriteRule ^news/([0-9]{4})-([0-9]{2})-([0-9]{2}).html$ index\.php?main_page=news&date=$1-$2-$3&%{QUERY_STRING} [L]
RewriteRule ^news/archive/([0-9]{4})-([0-9]{2}).html$ index\.php?main_page=news_archive&date=$1-$2&%{QUERY_STRING} [L]
RewriteRule ^news/(.*)-a-([0-9]+)-comments.html$ index\.php?main_page=news_comments&article_id=$2&%{QUERY_STRING} [L]
RewriteRule ^news/(.*)-a-([0-9]+).html$ index\.php?main_page=news_article&article_id=$2&%{QUERY_STRING} [L]

RewriteRule ^producttags\/([-\w]+)\/$ index\.php?main_page=producttags&letter=$1&%{QUERY_STRING} [L]
RewriteRule ^producttags\/([\w])\/([0-9]+).html$ index\.php?main_page=producttags&letter=$1&page=$2&%{QUERY_STRING} [L]
RewriteRule ^wishlist/$ index\.php?main_page=wishlist [L]
RewriteRule ^wishlist/([\w])/$ index\.php?main_page=wishlist&letter=$1&%{QUERY_STRING} [L]
RewriteRule ^wishlist/([\w])/([0-9]+).html$ index\.php?main_page=wishlist&letter=$1&page=$2&%{QUERY_STRING} [L]
# For Open Operations Info Manager
RewriteRule ^(.*)-i-([0-9]+).html$ index\.php?main_page=info_manager&pages_id=$2&%{QUERY_STRING} [L]

# All other pages
# Don't rewrite real files or directories
RewriteCond %{REQUEST_FILENAME} !-f [NC] 
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*).html$ index\.php?main_page=$1&%{QUERY_STRING} [L]

HTACCESS;

// $domain = $_POST['domain'];
$domain = $_SERVER['HTTP_HOST'];
$suffix = $domain;
if (strpos($domain, 'www.') !== false) $suffix = substr($domain, 4);
if (strpos($suffix, ':') > 0) $suffix = substr($suffix, 0, strpos($suffix, ':'));

$short_host = $suffix;
if (strrpos($suffix, '.') > 0) $short_host = substr($suffix, 0, strrpos($suffix, '.'));

$ht_domain = $suffix;
// $root_dir = $_POST['root_dir'];
$root_dir = realpath(dirname(__FILE__)) . '/';

$catalog = $_POST['catalog'];
$db_user = '';
$db_name = '';
$db_pass = '';
$admin_folder = 'admins123';

if (isset($_POST['db_user']) && !empty($_POST['db_user'])) $db_user = $_POST['db_user'];

if (isset($_POST['db_name']) && !empty($_POST['db_name'])) $db_name = $_POST['db_name'];

if (isset($_POST['db_pass']) && !empty($_POST['db_pass'])) $db_pass = $_POST['db_pass'];

if (isset($_POST['admin_folder']) && !empty($_POST['admin_folder'])) $admin_folder = $_POST['admin_folder'];

if (isset($_GET['auto']) && (int)$_GET['auto'])
{
	$db_user = $short_host;
	$db_name = str_replace('-', '_', $short_host);
	$db_pass = 'qipaoxian007';
	$admin_folder = 'admins123';
}

$info_c = array();

if (!empty($domain) && !empty($root_dir) && !empty($db_name) && !empty($db_user))
{
	
	if (!empty($catalog))
	{
		$catalog = rtrim($catalog, '/\\') . '/';
	}
	if (!empty($root_dir))
	{
		$root_dir = rtrim($root_dir, '/\\') . '/';
	}
	if (!empty($admin_folder))
	{
		$admin_folder = rtrim($admin_folder, '/\\') . '/';
	}
	
	/*
	 * $vars = array( '{DOMAIN}' => $domain, '{ROOT_DIR}' => $root_dir, '{CATALOG}' => $catalog, '{DBUSER}' => $db_user, '{DBNAME}' => $db_name, '{DBPASS}' => $db_pass );
	 */
	
	$vars = array(
		'{DOMAIN}',
		'{ROOT_DIR}',
		'{CATALOG}',
		'{DBUSER}',
		'{DBNAME}',
		'{DBPASS}',
		'{HT_DOMAIN}' 
	);
	$vals = array(
		$domain,
		$root_dir,
		$catalog,
		$db_user,
		$db_name,
		$db_pass,
		$ht_domain 
	);
	$front = str_replace($vars, $vals, $front);
	
	$admin = str_replace($vars, $vals, $admin);
	
	$access = str_replace($vars, $vals, $htaccess);
	
	$front_config = $root_dir . 'includes/configure.php';
	if (file_exists($front_config))
	{
		rename($front_config, $front_config . '.bak');
		unlink($front_config);
	}
	file_put_contents($front_config, $front);
	
	$admin_config = $root_dir . $admin_folder . 'includes/configure.php';
	if (file_exists($admin_config))
	{
		rename($admin_config, $admin_config . '.bak');
		unlink($admin_config);
		;
	}
	file_put_contents($admin_config, $admin);
	
	$ht_config = $root_dir . '.htaccess';
	if (file_exists($ht_config))
	{
		unlink($ht_config);
	}
	file_put_contents($ht_config, $access);
	
	$info_c[] = '修改完成';
	if (isset($_GET['auto']) && (int)$_GET['auto'])
	{
		require_once 'includes/application_top.php';
		$no_need = 1;
		if (isset($db))
		{
			$select = $db->Execute('SELECT COUNT(*) as total FROM ' . TABLE_PRODUCTS);
			$info_c[] = '数据库连接成功.';
			$info_c[] = '产品总数:' . $select->fields['total'];
			$info_c[] = '正在运行em.php';
			include 'em.php';
			$info_c[] = 'em.php运行完成.';
			
		}
		else
		{
			$info_c[] = '配置不正确';
		}
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
label {
	width: 150px;
	display: inline-block;
}

input {
	width: 200px;
}

input[type=submit] {
	width: auto;
}
</style>
</head>
<body>
	<form action="c.php" name="config" method="post"
		enctype="multipart/form-data">
		<div class="config">
			<dl>
				<dt>
					<strong>ZENCART一体化配置</strong><i><?php echo implode('<br/>', $info_c);?></i>
				</dt>
					<?php if (!isset($db)):?>
					<dd>
					<label for="admin_folder">后台文件夹名称：</label><input type="text"
						name="admin_folder" id="admin_folder"
						value="<?php echo $_POST['admin_folder'];?>" />
				</dd>

				<dd>
					<label for="catalog">网站文件夹：</label><input type="text"
						name="catalog" id="catalog"
						value="<?php echo $_POST['catalog'];?>" />
				</dd>
				<dd>
					<label for="db_user">数据库用户：</label><input type="text"
						name="db_user" id="db_user"
						value="<?php echo $_POST['db_user'];?>" />
				</dd>
				<dd>
					<label for="db_name">数据库名称：</label><input type="text"
						name="db_name" id="db_name"
						value="<?php echo $_POST['db_name'];?>" />
				</dd>
				<dd>
					<label for="db_pass">数据库密码：</label><input type="text"
						name="db_pass" id="db_pass"
						value="<?php echo $_POST['db_pass'];?>" />
				</dd>
				<dd>
					<input type="submit" name="submit" value="提交" />
				</dd>
					<?php endif;?>
				</dl>

		</div>
	</form>
</body>
</html>
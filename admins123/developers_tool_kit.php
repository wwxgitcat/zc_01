<?php
/**
 * @package admin
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: developers_tool_kit.php 18695 2011-05-04 05:24:19Z drbyte $
 */
require ('includes/application_top.php');

require (DIR_WS_CLASSES . 'currencies.php');
$currencies = new currencies();

$languages = zen_get_languages();

$configuration_key_lookup = zen_db_prepare_input($_POST['configuration_key'], false);
if (isset($_GET['configuration_key_lookup']) && $_GET['configuration_key_lookup'] != '')
{
	$configuration_key_lookup = zen_db_prepare_input(strtoupper($_GET['configuration_key_lookup']), false);
	$_POST['configuration_key'] = strtoupper($_GET['configuration_key_lookup']);
	$_POST['zv_files'] = 1;
	$_POST['zv_filestype'] = $_POST['zv_filestype'];
	$_POST['case_sensitive'] = $_POST['case_sensitive'];
}
function getDirList($dirName, $filetypes = 1)
{
	global $directory_array, $sub_dir_files;
	// add directory name to the sub_dir_files list;
	$sub_dir_files[] = $dirName;
	$d = @dir($dirName);
	$file_extension = '.php';
	if ($d)
	{
		while($entry = $d->read())
		{
			if ($entry != "." && $entry != "..")
			{
				if (is_dir($dirName . "/" . $entry))
				{
					if ($entry == 'CVS')
					{
						// skip
					}
					else
					{
						getDirList($dirName . "/" . $entry);
					}
				}
				else
				{
					if (preg_match('/\\' . $file_extension . '$/', $entry) > 0)
					{
						// echo 'I AM HERE 2 ' . $dirName."/".$entry . '<br>';
						// $directory_array[] .= $dirName."/".$entry;
					}
					else
					{
						// echo 'I AM HERE 3 ' . $dirName."/".$entry . '<br>';
					}
				}
			}
		}
		$d->close();
		unset($d);
	}
	
	return $sub_dir_files;
}
function zen_display_files($include_root = false, $filetypesincluded = 1)
{
	global $check_directory, $found, $configuration_key_lookup;
	global $db;
	$directory_array = array();
	for($i = 0, $n = sizeof($check_directory); $i < $n; $i++)
	{
		// echo 'I SEE ' . $check_directory[$i] . '<br>';
		
		$dir_check = $check_directory[$i];
		
		switch($filetypesincluded)
		{
			case (1):
				$file_extensions = array(
					'.php' 
				);
				break;
			case (2):
				$file_extensions = array(
					'.php',
					'.css' 
				);
				break;
			case (3):
				$file_extensions = array(
					'.css' 
				);
				break;
			case (4):
				$file_extensions = array(
					'.html',
					'.txt' 
				);
				break;
			case (5):
				$file_extensions = array(
					'.js' 
				);
				break;
			default:
				$file_extensions = array(
					'.php',
					'.css' 
				);
				break;
		}
		
		if ($dir = @dir($dir_check))
		{
			while($file = $dir->read())
			{
				if (!is_dir($dir_check . $file))
				{
					foreach($file_extensions as $extension)
					{
						if (preg_match('/\\' . $extension . '$/', $file) > 0)
						{
							$directory_array[] = $dir_check . $file;
						}
					}
				}
			}
			if (sizeof($directory_array))
			{
				sort($directory_array);
			}
			$dir->close();
			unset($dir);
		}
	}
	
	if ($include_root == true)
	{
		$original_array = $directory_array;
		$root_array = array();
		// if not html/txt
		if ($filetypesincluded != 3 && $filetypesincluded != 4 && $filetypesincluded != 5)
		{
			$root_array[] = DIR_FS_CATALOG . 'index.php';
			$root_array[] = DIR_FS_CATALOG . 'ipn_main_handler.php';
			$root_array[] = DIR_FS_CATALOG . 'page_not_found.php';
		}
		
		$root_array[] = DIR_FS_CATALOG . 'nddbc.html';
		$new_array = array_merge($root_array, $original_array);
		$directory_array = $new_array;
	}
	
	// show path and filename
	if (strtoupper($configuration_key_lookup) == $configuration_key_lookup)
	{
		while(strstr($configuration_key_lookup, '"'))
			$configuration_key_lookup = str_replace('"', '', $configuration_key_lookup);
		while(strstr($configuration_key_lookup, "'"))
			$configuration_key_lookup = str_replace("'", '', $configuration_key_lookup);
			
			// if appears to be a constant ask about configuration table
		$check_database = true;
		$sql = "select * from " . TABLE_CONFIGURATION . " where configuration_key=:zcconfigkey:";
		$sql = $db->BindVars($sql, ':zcconfigkey:', strtoupper($configuration_key_lookup), 'string');
		$check_configure = $db->Execute($sql);
		if ($check_configure->RecordCount() < 1)
		{
			$sql = "select * from " . TABLE_PRODUCT_TYPE_LAYOUT . " where configuration_key=:zcconfigkey:";
			$sql = $db->BindVars($sql, ':zcconfigkey:', strtoupper($configuration_key_lookup), 'string');
			$check_configure = $db->Execute($sql);
		}
		if ($check_configure->RecordCount() >= 1)
		{
			$links = '<strong><span class="alert">' . TEXT_SEARCH_DATABASE_TABLES . '</span></strong> ' . '<a href="' . zen_href_link(FILENAME_DEVELOPERS_TOOL_KIT, 'action=' . 'locate_configuration' . '&configuration_key_lookup=' . $configuration_key_lookup) . '">' . $configuration_key_lookup . '</a><br /><br />';
		}
		else
		{
			// do nothing
		}
	}
	else
	{
		// don't ask about configuration table
	}
	// die('I SEE ' . $check_configure->RecordCount() . ' vs ' . $check_database);
	echo '<table border="0" width="100%" cellspacing="2" cellpadding="1" align="center">' . "\n";
	if (isset($check_database) && ($check_database == true && $check_configure->RecordCount() >= 1))
	{
		// only ask if found
		echo '<tr><td>' . $links . '</td></tr>';
	}
	echo '<tr class="infoBoxContent"><td class="dataTableHeadingContent">' . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . TEXT_INFO_SEARCHING . sizeof($directory_array) . TEXT_INFO_FILES_FOR . $configuration_key_lookup . '</td></tr></table>' . "\n\n";
	echo '<tr><td>&nbsp;</td></tr>';
	
	// check all files located
	$file_cnt = 0;
	$cnt_found = 0;
	for($i = 0, $n = sizeof($directory_array); $i < $n; $i++)
	{
		// build file content of matching lines
		$file_cnt++;
		$file = $directory_array[$i];
		// echo 'I SEE ' . $directory_array[$i] . '<br>';
		// clean path name
		while(strstr($file, '//'))
			$file = str_replace('//', '/', $file);
		
		$show_file = '';
		if (file_exists($file))
		{
			$show_file .= "\n" . '<table border="2" width="95%" cellspacing="2" cellpadding="1" align="center"><tr><td class="main">' . "\n";
			$show_file .= '<tr class="infoBoxContent"><td class="dataTableHeadingContent">';
			$show_file .= '<strong>' . $file . '</strong>';
			$show_file .= '</td></tr>';
			$show_file .= '<tr><td class="main">';
			
			// put file into an array to be scanned
			$lines = file($file);
			$found_line = 'false';
			// loop through the array, show line and line numbers
			$cnt_lines = 0;
			foreach($lines as $line_num => $line)
			{
				$cnt_lines++;
				if (isset($_POST['case_sensitive']) && $_POST['case_sensitive'])
				{
					$check_case = strstr($line, $configuration_key_lookup);
				}
				else
				{
					// BOM by zen-cart.cn
					$check_case = strstr(GBcase($line, "upper"), GBcase($configuration_key_lookup, "upper"));
					// EOM by zen-cart.cn
				}
				if ($check_case)
				{
					$found_line = 'true';
					$found = 'true';
					$cnt_found++;
					$show_file .= "<br />Line #<strong>{$line_num}</strong> : ";
					// prevent db pwd from being displayed, for sake of security
					$show_file .= (substr_count($line, "'DB_SERVER_PASSWORD'")) ? '***HIDDEN***' : htmlspecialchars($line, ENT_QUOTES, CHARSET);
					$show_file .= "<br />\n";
				}
				else
				{
					if ($cnt_lines >= 5)
					{
						// $show_file .= ' .';
						$cnt_lines = 0;
					}
				}
			}
		}
		$show_file .= '</td></tr></table>' . "\n";
		
		// if there was a match, show lines
		if ($found_line == 'true')
		{
			echo $show_file . '<table><tr><td>&nbsp;</td></tr></table>';
		} // show file
	}
	echo '<table border="0" width="100%" cellspacing="2" cellpadding="1" align="center"><tr class="infoBoxContent"><td class="dataTableHeadingContent">' . TEXT_INFO_MATCHES_FOUND . $cnt_found . '</td></tr></table>';
} // zen_display_files

$products_filter = (isset($_GET['products_filter']) ? $_GET['products_filter'] : (isset($products_filter) ? $products_filter : ''));

$action = (isset($_GET['action']) ? $_GET['action'] : '');
// don't do any 'action' if clicked on the Check for Updates button
if (isset($_GET['vcheck']) && $_GET['vcheck'] == 'yes') $action = '';

$current_category_id = (isset($_GET['current_category_id']) ? (int)$_GET['current_category_id'] : (int)$current_category_id);
$found = 'true';

switch($action)
{
	case ('locate_configuration'):
		if ($configuration_key_lookup == '')
		{
			$messageStack->add_session(ERROR_CONFIGURATION_KEY_NOT_ENTERED, 'caution');
			zen_redirect(zen_href_link(FILENAME_DEVELOPERS_TOOL_KIT));
		}
		$found = 'false';
		$zv_files_group = $_POST['zv_files'];
		
		$sql = "select * from " . TABLE_CONFIGURATION . " where configuration_key=:zcconfigkey:";
		$sql = $db->BindVars($sql, ':zcconfigkey:', $_POST['configuration_key'], 'string');
		$check_configure = $db->Execute($sql);
		if ($check_configure->RecordCount() < 1)
		{
			$sql = "select * from " . TABLE_PRODUCT_TYPE_LAYOUT . " where configuration_key=:zcconfigkey:";
			$sql = $db->BindVars($sql, ':zcconfigkey:', $_POST['configuration_key'], 'string');
			$check_configure = $db->Execute($sql);
			if ($check_configure->RecordCount() < 1)
			{
				// build filenames to search
				switch($zv_files_group)
				{
					case (0): // none
						$filename_listing = '';
						break;
					case (1): // all english.php files
						$check_directory = array();
						$check_directory[] = DIR_FS_CATALOG_LANGUAGES;
						$check_directory[] = DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/';
						$check_directory[] = DIR_FS_CATALOG_LANGUAGES . $template_dir . '/' . $_SESSION['language'] . '/';
						$check_directory[] = DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/';
						$check_directory[] = DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/extra_definitions/';
						$check_directory[] = DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/extra_definitions/' . $template_dir . '/';
						$check_directory[] = DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/payment/';
						$check_directory[] = DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/shipping/';
						$check_directory[] = DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/order_total/';
						$check_directory[] = DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/product_types/';
						$check_directory[] = DIR_FS_ADMIN . DIR_WS_LANGUAGES;
						$check_directory[] = DIR_FS_ADMIN . DIR_WS_LANGUAGES . $_SESSION['language'] . '/';
						$check_directory[] = DIR_FS_ADMIN . DIR_WS_LANGUAGES . $_SESSION['language'] . '/modules/newsletters/';
						break;
					case (2): // all catalog /language/*.php
						$check_directory = array();
						$check_directory[] = DIR_FS_CATALOG_LANGUAGES;
						break;
					case (3): // all catalog /language/english/*.php
						$check_directory = array();
						$check_directory[] = DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/';
						break;
					case (4): // all admin /language/*.php
						$check_directory = array();
						$check_directory[] = DIR_FS_ADMIN . DIR_WS_LANGUAGES;
						break;
					case (5): // all admin /language/english/*.php
					          // set directories and files names
						$check_directory = array();
						$check_directory[] = DIR_FS_ADMIN . DIR_WS_LANGUAGES . $_SESSION['language'] . '/';
						break;
				} // eof: switch
				  
				// Check for new databases and filename in extra_datafiles directory
				
				zen_display_files();
			}
			else
			{
				$show_products_type_layout = 'true';
				$show_configuration_info = 'true';
				$found = 'true';
			}
		}
		else
		{
			$show_products_type_layout = 'false';
			$show_configuration_info = 'true';
			$found = 'true';
		}
		
		break;
	
	case ('locate_function'):
		if ($configuration_key_lookup == '')
		{
			$messageStack->add_session(ERROR_CONFIGURATION_KEY_NOT_ENTERED, 'caution');
			zen_redirect(zen_href_link(FILENAME_DEVELOPERS_TOOL_KIT));
		}
		$found = 'false';
		$zv_files_group = $_POST['zv_files'];
		
		// build filenames to search
		switch($zv_files_group)
		{
			case (0): // none
				$filename_listing = '';
				break;
			case (1): // all admin/catalog function files
				$check_directory = array();
				$check_directory[] = DIR_FS_CATALOG . DIR_WS_FUNCTIONS;
				$check_directory[] = DIR_FS_CATALOG . DIR_WS_FUNCTIONS . 'extra_functions/';
				$check_directory[] = DIR_FS_ADMIN . DIR_WS_FUNCTIONS;
				$check_directory[] = DIR_FS_ADMIN . DIR_WS_FUNCTIONS . 'extra_functions/';
				break;
			case (2): // all catalog function files
				$check_directory = array();
				$check_directory[] = DIR_FS_CATALOG . DIR_WS_FUNCTIONS;
				$check_directory[] = DIR_FS_CATALOG . DIR_WS_FUNCTIONS . 'extra_functions/';
				break;
			case (3): // all admin function files
				$check_directory = array();
				$check_directory[] = DIR_FS_ADMIN . DIR_WS_FUNCTIONS;
				$check_directory[] = DIR_FS_ADMIN . DIR_WS_FUNCTIONS . 'extra_functions/';
				break;
		} // eof: switch
		  
		// Check for new databases and filename in extra_datafiles directory
		
		zen_display_files();
		
		break;
	
	case ('locate_class'):
		if ($configuration_key_lookup == '')
		{
			$messageStack->add_session(ERROR_CONFIGURATION_KEY_NOT_ENTERED, 'caution');
			zen_redirect(zen_href_link(FILENAME_DEVELOPERS_TOOL_KIT));
		}
		$found = 'false';
		$zv_files_group = $_POST['zv_files'];
		
		// build filenames to search
		switch($zv_files_group)
		{
			case (0): // none
				$filename_listing = '';
				break;
			case (1): // all admin/catalog classes files
				$check_directory = array();
				$check_directory[] = DIR_FS_CATALOG . DIR_WS_CLASSES;
				$check_directory[] = DIR_FS_ADMIN . DIR_WS_CLASSES;
				break;
			case (2): // all catalog classes files
				$check_directory = array();
				$check_directory[] = DIR_FS_CATALOG . DIR_WS_CLASSES;
				break;
			case (3): // all admin function files
				$check_directory = array();
				$check_directory[] = DIR_FS_ADMIN . DIR_WS_CLASSES;
				break;
		} // eof: switch
		  
		// Check for new databases and filename in extra_datafiles directory
		
		zen_display_files();
		
		break;
	
	case ('locate_template'):
		if ($configuration_key_lookup == '')
		{
			$messageStack->add_session(ERROR_CONFIGURATION_KEY_NOT_ENTERED, 'caution');
			zen_redirect(zen_href_link(FILENAME_DEVELOPERS_TOOL_KIT));
		}
		$found = 'false';
		$zv_files_group = $_POST['zv_files'];
		
		// build filenames to search
		switch($zv_files_group)
		{
			case (0): // none
				$filename_listing = '';
				break;
			case (1): // all template files
				$check_directory = array();
				$check_directory[] = DIR_FS_CATALOG_TEMPLATES . 'template_default/templates' . '/';
				$check_directory[] = DIR_FS_CATALOG_TEMPLATES . 'template_default/sideboxes' . '/';
				$check_directory[] = DIR_FS_CATALOG_MODULES;
				$check_directory[] = DIR_FS_CATALOG_MODULES . 'sideboxes/';
				
				$check_directory[] = DIR_FS_CATALOG_TEMPLATES . $template_dir . '/templates' . '/';
				$check_directory[] = DIR_FS_CATALOG_TEMPLATES . $template_dir . '/sideboxes' . '/';
				
				$sub_dir_files = array();
				getDirList(DIR_FS_CATALOG_MODULES . 'pages');
				
				$check_dir = array_merge($check_directory, $sub_dir_files);
				for($i = 0, $n = sizeof($check_dir); $i < $n; $i++)
				{
					$check_directory[] = $check_dir[$i] . '/';
				}
				
				break;
			case (2): // all /templates files
				$check_directory = array();
				$check_directory[] = DIR_FS_CATALOG_TEMPLATES . 'template_default/templates' . '/';
				$check_directory[] = DIR_FS_CATALOG_TEMPLATES . $template_dir . '/templates' . '/';
				break;
			case (3): // all sideboxes files
				$check_directory = array();
				$check_directory[] = DIR_FS_CATALOG_TEMPLATES . 'template_default/sideboxes' . '/';
				$check_directory[] = DIR_FS_CATALOG_MODULES . 'sideboxes/';
				$check_directory[] = DIR_FS_CATALOG_TEMPLATES . $template_dir . '/sideboxes' . '/';
				break;
			case (4): // all /pages files
				$check_directory = array();
				// $check_directory[] = DIR_FS_CATALOG_MODULES . 'pages/';
				$sub_dir_files = array();
				getDirList(DIR_FS_CATALOG_MODULES . 'pages');
				
				$check_dir = array_merge($check_directory, $sub_dir_files);
				for($i = 0, $n = sizeof($check_dir); $i < $n; $i++)
				{
					$check_directory[] = $check_dir[$i] . '/';
				}
				
				break;
		} // eof: switch
		  
		// Check for new databases and filename in extra_datafiles directory
		
		zen_display_files();
		
		break;
	
	// / all files
	case ('locate_all_files'):
		$zv_check_root = false;
		if ($configuration_key_lookup == '')
		{
			$messageStack->add_session(ERROR_CONFIGURATION_KEY_NOT_ENTERED, 'caution');
			zen_redirect(zen_href_link(FILENAME_DEVELOPERS_TOOL_KIT));
		}
		$found = 'false';
		$zv_files_group = $_POST['zv_files'];
		$zv_filestype_group = $_POST['zv_filestype'];
		// echo 'settings: ' . '$zv_files_group: ' . $zv_files_group . '$zv_filestype_group: ' . $zv_filestype_group . '<br>';
		// echo 'Who am I template ' . $template_dir . ' sess lang ' . $_SESSION['language'];
		switch($zv_files_group)
		{
			case (0): // none
				$filename_listing = '';
				break;
			case (1): // all
				$zv_check_root = true;
				$filename_listing = '';
				
				$check_directory = array();
				
				// get includes
				$sub_dir_files = array();
				getDirList(DIR_FS_CATALOG . DIR_WS_INCLUDES, $zv_filestype_group);
				$sub_dir_files_catalog = $sub_dir_files;
				
				// get email
				$sub_dir_files = array();
				getDirList(DIR_FS_EMAIL_TEMPLATES, $zv_filestype_group);
				$sub_dir_files_email = $sub_dir_files;
				
				// get admin
				$sub_dir_files = array();
				getDirList(DIR_FS_ADMIN, $zv_filestype_group);
				$sub_dir_files_admin = $sub_dir_files;
				
				$check_dir = array_merge($sub_dir_files_catalog, $sub_dir_files_email, $sub_dir_files_admin);
				for($i = 0, $n = sizeof($check_dir); $i < $n; $i++)
				{
					$check_directory[] = $check_dir[$i] . '/';
				}
				break;
			
			case (2): // all catalog
				$zv_check_root = true;
				$filename_listing = '';
				
				$check_directory = array();
				
				$sub_dir_files = array();
				getDirList(DIR_FS_CATALOG . DIR_WS_INCLUDES, $zv_filestype_group);
				$sub_dir_files_catalog = $sub_dir_files;
				
				// get email
				$sub_dir_files = array();
				getDirList(DIR_FS_EMAIL_TEMPLATES, $zv_filestype_group);
				$sub_dir_files_email = $sub_dir_files;
				
				$check_dir = array_merge($sub_dir_files_catalog, $sub_dir_files_email);
				for($i = 0, $n = sizeof($check_dir); $i < $n; $i++)
				{
					$zv_add_dir = str_replace('//', '/', $check_dir[$i] . '/');
					if (strstr($zv_add_dir, DIR_WS_ADMIN) == '')
					{
						$check_directory[] = $zv_add_dir;
					}
				}
				break;
			
			case (3): // all admin
				$zv_check_root = false;
				$filename_listing = '';
				
				$check_directory = array();
				
				$sub_dir_files = array();
				getDirList(DIR_FS_ADMIN, $zv_filestype_group);
				$sub_dir_files_admin = $sub_dir_files;
				
				$check_dir = array_merge($sub_dir_files_admin);
				for($i = 0, $n = sizeof($check_dir); $i < $n; $i++)
				{
					$check_directory[] = $check_dir[$i] . '/';
				}
				break;
		}
		zen_display_files($zv_check_root, $zv_filestype_group);
		
		break;
} // eof: action
  
// if no matches in either databases or selected language directory give an error
if ($found == 'false')
{
	$messageStack->add(ERROR_CONFIGURATION_KEY_NOT_FOUND . ' ' . $configuration_key_lookup, 'caution');
}
elseif ($action != '')
{
	echo '<table width="90%" align="center"><tr><td>' . zen_draw_separator('pixel_black.gif', '100%', '2') . '</td></tr><tr><td>&nbsp;</td></tr></table>' . "\n";
}

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type"
	content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css"
	href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>

<script type="text/javascript">
  <!--
  function init()
  {
    cssjsmenu('navbar');
    if (document.getElementById)
    {
      var kill = document.getElementById('hoverJS');
      kill.disabled = true;
    }
  }
  // -->
</script>
</head>
<body onLoad="init()">
	<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

	<!-- body //-->
	<table border="0" width="100%" cellspacing="2" cellpadding="2">
		<tr>
			<!-- body_text //-->
			<td width="100%" valign="top"><table border="0" width="100%"
					cellspacing="0" cellpadding="0">
					<tr>
						<td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
						<td class="pageHeading" align="right"><?php echo zen_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
					</tr>

<?php
if (isset($show_configuration_info) && $show_configuration_info == 'true')
{
	$show_configuration_info = 'false';
	?>
      <tr>
						<td colspan="2">
							<table border="3" cellspacing="4" cellpadding="4">
								<tr class="infoBoxContent">
									<td colspan="2" class="pageHeading" align="center"><?php echo TABLE_CONFIGURATION_TABLE; ?></td>
								</tr>
								<tr>
									<td class="infoBoxHeading"><?php echo TABLE_TITLE_KEY; ?></td>
									<td class="dataTableHeadingContentWhois"><?php echo $check_configure->fields['configuration_key']; ?></td>
								</tr>
								<tr>
									<td class="infoBoxHeading"><?php echo TABLE_TITLE_TITLE; ?></td>
									<td class="dataTableHeadingContentWhois"><?php echo $check_configure->fields['configuration_title']; ?></td>
								</tr>
								<tr>
									<td class="infoBoxHeading"><?php echo TABLE_TITLE_DESCRIPTION; ?></td>
									<td class="dataTableHeadingContentWhois"><?php echo $check_configure->fields['configuration_description']; ?></td>
								</tr>
<?php
	if ($show_products_type_layout == 'true')
	{
		$check_configure_group = $db->Execute("select * from " . TABLE_PRODUCT_TYPES . " where type_id='" . (int)$check_configure->fields['product_type_id'] . "'");
	}
	else
	{
		$check_configure_group = $db->Execute("select * from " . TABLE_CONFIGURATION_GROUP . " where configuration_group_id='" . (int)$check_configure->fields['configuration_group_id'] . "'");
	}
	?>

<?php
	if ($show_products_type_layout == 'true')
	{
		?>
          <tr>
									<td class="infoBoxHeading"><?php echo TABLE_TITLE_GROUP; ?></td>
									<td class="dataTableHeadingContentWhois"><?php echo 'Product Type Layout'; ?></td>
								</tr>
<?php } else { ?>
          <tr>
									<td class="infoBoxHeading"><?php echo TABLE_TITLE_VALUE; ?></td>
									<td class="dataTableHeadingContentWhois"><?php echo $check_configure->fields['configuration_value']; ?></td>
								</tr>
								<tr>
									<td class="infoBoxHeading"><?php echo TABLE_TITLE_GROUP; ?></td>
									<td class="dataTableHeadingContentWhois">
            <?php
		if ($check_configure_group->fields['configuration_group_id'] == '6')
		{
			$id_note = TEXT_INFO_CONFIGURATION_HIDDEN;
		}
		else
		{
			$id_note = '';
		}
		echo 'ID#' . $check_configure_group->fields['configuration_group_id'] . ' ' . $check_configure_group->fields['configuration_group_title'] . $id_note;
		?>
            </td>
								</tr>
<?php } ?>
          <tr>
									<td class="main" align="center" valign="middle">
              <?php
	if ($show_products_type_layout == 'false' and ($check_configure->fields['configuration_id'] != 0 and $check_configure->fields['configuration_group_id'] != 6))
	{
		echo '<a href="' . zen_href_link(FILENAME_CONFIGURATION, 'gID=' . $check_configure_group->fields['configuration_group_id'] . '&cID=' . $check_configure->fields['configuration_id']) . '">' . zen_image_button('button_edit.gif', IMAGE_EDIT) . '</a>';
	}
	else
	{
		$page = '';
		if (strstr($check_configure->fields['configuration_key'], 'MODULE_SHIPPING')) $page .= 'shipping';
		if (strstr($check_configure->fields['configuration_key'], 'MODULE_PAYMENT')) $page .= 'payment';
		if (strstr($check_configure->fields['configuration_key'], 'MODULE_ORDER_TOTAL')) $page .= 'ordertotal';
		
		if ($show_products_type_layout == 'true')
		{
			echo '<a href="' . zen_href_link(FILENAME_PRODUCT_TYPES) . '">' . zen_image_button('button_edit.gif', IMAGE_EDIT) . '</a>';
		}
		else
		{
			if ($page != '')
			{
				echo '<a href="' . zen_href_link(FILENAME_MODULES, 'set=' . $page) . '">' . zen_image_button('button_edit.gif', IMAGE_EDIT) . '</a>';
			}
			else
			{
				echo TEXT_INFO_NO_EDIT_AVAILABLE . '<br />';
			}
		}
	}
	?>
              </td>
									<td class="main" align="center" valign="middle"><?php echo '<a href="' . zen_href_link(FILENAME_DEVELOPERS_TOOL_KIT) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>'; ?></td>
								</tr>
								<tr class="infoBoxContent">
									<td colspan="2" class="pageHeading" align="center">
<?php
	$links = '<br /><strong><span class="alert">' . TEXT_SEARCH_ALL_FILES . '</span></strong> ' . '<a href="' . zen_href_link(FILENAME_DEVELOPERS_TOOL_KIT, 'action=' . 'locate_all_files' . '&configuration_key_lookup=' . $configuration_key_lookup . '&zv_files=1') . '">' . $configuration_key_lookup . '</a><br />';
	echo $links;
	?>
            </td>
								</tr>
							</table>
						</td>
					</tr>
<?php
}
else
{
	?>

<?php
	// disabled and here for an example
	if (false)
	{
		?>
<!-- bof: update all products price sorter -->
					<tr>
						<td colspan="2"><br />
						<table border="0" cellspacing="0" cellpadding="2">
								<tr>
									<td class="main" align="left" valign="top"><?php echo TEXT_INFO_PRODUCTS_PRICE_SORTER_UPDATE; ?></td>
									<td class="main" align="right" valign="middle"><?php echo '<a href="' . zen_href_link(FILENAME_DEVELOPERS_TOOL_KIT, 'action=update_all_products_price_sorter') . '">' . zen_image_button('button_update.gif', IMAGE_UPDATE) . '</a>'; ?></td>
								</tr>
							</table></td>
					</tr>
					<!-- eof: update all products price sorter -->
<?php } ?>

<!-- bof: Locate a configuration constant -->
					<tr>
						<td colspan="2"><br />
						<table border="0" cellspacing="0" cellpadding="2">
								<tr>
									<td colspan="3" class="main" align="left" valign="middle"><?php echo TEXT_CONFIGURATION_CONSTANT; ?></td>
								</tr>

								<tr>
									<form name="locate_configure"
										action="<?php echo zen_href_link(FILENAME_DEVELOPERS_TOOL_KIT, 'action=locate_configuration', 'NONSSL'); ?>"
										method="post"><?php echo zen_draw_hidden_field('securityToken', $_SESSION['securityToken']); ?>
            <td class="main" align="left" valign="bottom"><?php echo '<strong>' . TEXT_CONFIGURATION_KEY . '</strong>' . '<br />' . zen_draw_input_field('configuration_key', '', ' size="40" '); ?></td>
										<td class="main" align="left" valign="middle">
              <?php
	$za_lookup = array(
		array(
			'id' => '0',
			'text' => TEXT_LOOKUP_NONE 
		),
		array(
			'id' => '1',
			'text' => TEXT_LANGUAGE_LOOKUP_CURRENT_LANGUAGE 
		),
		array(
			'id' => '2',
			'text' => TEXT_LANGUAGE_LOOKUP_CURRENT_CATALOG 
		),
		array(
			'id' => '3',
			'text' => TEXT_LANGUAGE_LOOKUP_CURRENT_CATALOG_TEMPLATE 
		),
		array(
			'id' => '4',
			'text' => TEXT_LANGUAGE_LOOKUP_CURRENT_ADMIN 
		),
		array(
			'id' => '5',
			'text' => TEXT_LANGUAGE_LOOKUP_CURRENT_ADMIN_LANGUAGE 
		) 
	);
	// array('id' => '6', 'text' => TEXT_LANGUAGE_LOOKUP_CURRENT_ALL)
	
	echo '<strong>' . TEXT_LANGUAGE_LOOKUPS . '</strong>' . '<br />' . zen_draw_pull_down_menu('zv_files', $za_lookup, '0');
	?>
            </td>
										<td class="main" align="right" valign="bottom"><?php echo zen_image_submit('button_search.gif', IMAGE_SEARCH); ?></td>
									</form>
								</tr>
								<tr>
									<td colspan="4" class="main" align="left" valign="top"><?php echo TEXT_INFO_CONFIGURATION_UPDATE; ?></td>
								</tr>
							</table></td>
					</tr>
					<!-- eof: Locate a configuration constant -->


					<!-- bof: Locate a function -->
					<tr>
						<td colspan="2"><br />
						<table border="0" cellspacing="0" cellpadding="2">
								<tr>
									<td colspan="3" class="main" align="left" valign="middle"><?php echo TEXT_FUNCTION_CONSTANT; ?></td>
								</tr>

								<tr>
									<form name="locate_function"
										action="<?php echo zen_href_link(FILENAME_DEVELOPERS_TOOL_KIT, 'action=locate_function', 'NONSSL'); ?>"
										' method="post"><?php echo zen_draw_hidden_field('securityToken', $_SESSION['securityToken']); ?>
            <td class="main" align="left" valign="bottom"><?php echo '<strong>' . TEXT_CONFIGURATION_KEY . '</strong>' . '<br />' . zen_draw_input_field('configuration_key', '', ' size="40" '); ?></td>
										<td class="main" align="left" valign="middle">
              <?php
	$za_lookup = array(
		array(
			'id' => '0',
			'text' => TEXT_LOOKUP_NONE 
		),
		array(
			'id' => '1',
			'text' => TEXT_FUNCTION_LOOKUP_CURRENT 
		),
		array(
			'id' => '2',
			'text' => TEXT_FUNCTION_LOOKUP_CURRENT_CATALOG 
		),
		array(
			'id' => '3',
			'text' => TEXT_FUNCTION_LOOKUP_CURRENT_ADMIN 
		) 
	);
	// array('id' => '6', 'text' => TEXT_LANGUAGE_LOOKUP_CURRENT_ALL)
	
	echo '<strong>' . TEXT_FUNCTION_LOOKUPS . '</strong>' . '<br />' . zen_draw_pull_down_menu('zv_files', $za_lookup, '0');
	?>
            </td>
										<td class="main" align="right" valign="bottom"><?php echo zen_image_submit('button_search.gif', IMAGE_SEARCH); ?></td>
									</form>
								</tr>
								<tr>
									<td colspan="4" class="main" align="left" valign="top"><?php echo TEXT_INFO_CONFIGURATION_UPDATE; ?></td>
								</tr>
							</table></td>
					</tr>
					<!-- eof: Locate a function -->

					<!-- bof: Locate a class -->
					<tr>
						<td colspan="2"><br />
						<table border="0" cellspacing="0" cellpadding="2">
								<tr>
									<td colspan="3" class="main" align="left" valign="middle"><?php echo TEXT_CLASS_CONSTANT; ?></td>
								</tr>

								<tr>
									<form name="locate_class"
										action="<?php echo zen_href_link(FILENAME_DEVELOPERS_TOOL_KIT, 'action=locate_class', 'NONSSL'); ?>"
										' method="post"><?php echo zen_draw_hidden_field('securityToken', $_SESSION['securityToken']); ?>
            <td class="main" align="left" valign="bottom"><?php echo '<strong>' . TEXT_CONFIGURATION_KEY . '</strong>' . '<br />' . zen_draw_input_field('configuration_key', '', ' size="40" '); ?></td>
										<td class="main" align="left" valign="middle">
              <?php
	$za_lookup = array(
		array(
			'id' => '0',
			'text' => TEXT_LOOKUP_NONE 
		),
		array(
			'id' => '1',
			'text' => TEXT_CLASS_LOOKUP_CURRENT 
		),
		array(
			'id' => '2',
			'text' => TEXT_CLASS_LOOKUP_CURRENT_CATALOG 
		),
		array(
			'id' => '3',
			'text' => TEXT_CLASS_LOOKUP_CURRENT_ADMIN 
		) 
	);
	// array('id' => '6', 'text' => TEXT_LANGUAGE_LOOKUP_CURRENT_ALL)
	
	echo '<strong>' . TEXT_CLASS_LOOKUPS . '</strong>' . '<br />' . zen_draw_pull_down_menu('zv_files', $za_lookup, '0');
	?>
            </td>
										<td class="main" align="right" valign="bottom"><?php echo zen_image_submit('button_search.gif', IMAGE_SEARCH); ?></td>
									</form>
								</tr>
								<tr>
									<td colspan="4" class="main" align="left" valign="top"><?php echo TEXT_INFO_CONFIGURATION_UPDATE; ?></td>
								</tr>
							</table></td>
					</tr>
					<!-- eof: Locate a class -->

					<!-- bof: Locate a template files -->
					<tr>
						<td colspan="2"><br />
						<table border="0" cellspacing="0" cellpadding="2">
								<tr>
									<td colspan="3" class="main" align="left" valign="middle"><?php echo TEXT_TEMPLATE_CONSTANT; ?></td>
								</tr>

								<tr>
									<form name="locate_template"
										action="<?php echo zen_href_link(FILENAME_DEVELOPERS_TOOL_KIT, 'action=locate_template', 'NONSSL'); ?>"
										' method="post"><?php echo zen_draw_hidden_field('securityToken', $_SESSION['securityToken']); ?>
            <td class="main" align="left" valign="bottom"><?php echo '<strong>' . TEXT_CONFIGURATION_KEY . '</strong>' . '<br />' . zen_draw_input_field('configuration_key', '', ' size="40" '); ?></td>
										<td class="main" align="left" valign="middle">
              <?php
	$za_lookup = array(
		array(
			'id' => '0',
			'text' => TEXT_LOOKUP_NONE 
		),
		array(
			'id' => '1',
			'text' => TEXT_TEMPLATE_LOOKUP_CURRENT 
		),
		array(
			'id' => '2',
			'text' => TEXT_TEMPLATE_LOOKUP_CURRENT_TEMPLATES 
		),
		array(
			'id' => '3',
			'text' => TEXT_TEMPLATE_LOOKUP_CURRENT_SIDEBOXES 
		),
		array(
			'id' => '4',
			'text' => TEXT_TEMPLATE_LOOKUP_CURRENT_PAGES 
		) 
	);
	// array('id' => '6', 'text' => TEXT_LANGUAGE_LOOKUP_CURRENT_ALL)
	
	echo '<strong>' . TEXT_TEMPLATE_LOOKUPS . '</strong>' . '<br />' . zen_draw_pull_down_menu('zv_files', $za_lookup, '0');
	?>
            </td>
										<td class="main" align="right" valign="bottom"><?php echo zen_image_submit('button_search.gif', IMAGE_SEARCH); ?></td>
									</form>
								</tr>
								<tr>
									<td colspan="4" class="main" align="left" valign="top"><?php echo TEXT_INFO_CONFIGURATION_UPDATE; ?></td>
								</tr>
							</table></td>
					</tr>
					<!-- eof: Locate template Files -->


					<!-- bof: Locate all files -->
					<tr>
						<td colspan="2"><br />
						<table border="0" cellspacing="0" cellpadding="2">
								<tr>
									<td colspan="4" class="main" align="left" valign="middle"><?php echo TEXT_ALL_FILES_CONSTANT; ?></td>
								</tr>

								<tr>
									<form name="locate_all_files"
										action="<?php echo zen_href_link(FILENAME_DEVELOPERS_TOOL_KIT, 'action=locate_all_files', 'NONSSL'); ?>"
										method="post"><?php echo zen_draw_hidden_field('securityToken', $_SESSION['securityToken']); ?>
            <td class="main" align="left" valign="bottom"><?php echo '<strong>' . TEXT_CONFIGURATION_KEY . '</strong>' . '<br />' . zen_draw_input_field('configuration_key', '', ' size="40" '); ?></td>
										<td class="main" align="left" valign="middle">
              <?php
	$za_lookup = array(
		array(
			'id' => '0',
			'text' => TEXT_LOOKUP_NONE 
		),
		array(
			'id' => '1',
			'text' => TEXT_ALL_FILES_LOOKUP_CURRENT 
		),
		array(
			'id' => '2',
			'text' => TEXT_ALL_FILES_LOOKUP_CURRENT_CATALOG 
		),
		array(
			'id' => '3',
			'text' => TEXT_ALL_FILES_LOOKUP_CURRENT_ADMIN 
		) 
	);
	
	echo '<strong>' . TEXT_ALL_FILES_LOOKUPS . '</strong>' . '<br />' . zen_draw_pull_down_menu('zv_files', $za_lookup, '0');
	?>
            </td>
										<td class="main" align="left" valign="middle">
              <?php
	$za_lookup_filetype = array(
		array(
			'id' => '1',
			'text' => TEXT_ALL_FILES_LOOKUP_PHP 
		),
		array(
			'id' => '2',
			'text' => TEXT_ALL_FILES_LOOKUP_PHPCSS 
		),
		array(
			'id' => '3',
			'text' => TEXT_ALL_FILES_LOOKUP_CSS 
		),
		array(
			'id' => '4',
			'text' => TEXT_ALL_FILES_LOOKUP_HTMLTXT 
		),
		array(
			'id' => '5',
			'text' => TEXT_ALL_FILES_LOOKUP_JS 
		) 
	);
	
	echo '<strong>' . TEXT_ALL_FILESTYPE_LOOKUPS . '</strong>' . '<br />' . zen_draw_pull_down_menu('zv_filestype', $za_lookup_filetype, '0');
	echo '<strong>' . TEXT_CASE_SENSITIVE . '</strong>' . zen_draw_checkbox_field('case_sensitive', true);
	?>
            </td>
										<td class="main" align="right" valign="bottom"><?php echo zen_image_submit('button_search.gif', IMAGE_SEARCH); ?></td>
									</form>
								</tr>
								<tr>
									<td colspan="4" class="main" align="left" valign="top"><?php echo TEXT_INFO_CONFIGURATION_UPDATE; ?></td>
								</tr>
							</table></td>
					</tr>
					<!-- eof: Locate all files -->

<?php
} // eof configure
?>
      <tr>
						<td colspan="2"><?php echo '<br />' . zen_draw_separator('pixel_black.gif', '100%', '2'); ?></td>
					</tr>


				</table></td>
			<!-- body_text_eof //-->
		</tr>
	</table>
	<!-- body_eof //-->

	<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
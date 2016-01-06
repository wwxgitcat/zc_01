<?php
/**
 * initialise template system variables
 * see {@link  http://www.zen-cart.com/wiki/index.php/Developers_API_Tutorials#InitSystem wikitutorials} for more details.
 *
 * Determines current template name for current language, from database<br />
 * Then loads template-specific language file, followed by master/default language file<br />
 * ie: includes/languages/classic/english.php followed by includes/languages/english.php
 *
 * @package initSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: init_templates.php 3123 2006-03-06 23:36:46Z drbyte $
 */
if (!defined('IS_ADMIN_FLAG'))
{
	die('Illegal Access');
}

/*
 * Determine the active template name
 */
$template_dir = "";
$sql = "select template_dir
            from " . TABLE_TEMPLATE_SELECT . "
            where template_language = 0";
$template_query = $db->Execute($sql);
$template_dir = $template_query->fields['template_dir'];

$sql = "select template_dir
            from " . TABLE_TEMPLATE_SELECT . "
            where template_language = '" . $_SESSION['languages_id'] . "'";
$template_query = $db->Execute($sql);
if ($template_query->RecordCount() > 0)
{
	$template_dir = $template_query->fields['template_dir'];
}




if (defined('TEMPLATE_DIR_LAST_CHANGE') && TEMPLATE_DIR_LAST_CHANGE != '')
	$template_dir = TEMPLATE_DIR_LAST_CHANGE;


// detect mobile use moblie tamplate
if (file_exists(DIR_FS_CATALOG.DIR_WS_CLASSES.'mobile_detect.php'))
{
	include (DIR_FS_CATALOG.DIR_WS_CLASSES.'mobile_detect.php');
	$mobile_detect = new Mobile_Detect();
	if ($mobile_detect->isMobile() || $mobile_detect->isTablet())
	{
		//$template_dir = 'mobile';
		define('IS_MOBILE', true);
	}
}

if (!defined('IS_MOBILE'))
	define('IS_MOBILE', false);


/**
 * The actual template directory to use
 */
define('DIR_WS_TEMPLATE', DIR_WS_TEMPLATES . $template_dir . '/');
/**
 * The actual template images directory to use
 */
define('DIR_WS_TEMPLATE_IMAGES', DIR_WS_TEMPLATE . 'images/');
/**
 * The actual template icons directory to use
 */
define('DIR_WS_TEMPLATE_ICONS', DIR_WS_TEMPLATE_IMAGES . 'icons/');

/**
 * Load the appropriate Language files, based on the currently-selected template
 */

if (file_exists(DIR_WS_LANGUAGES . $template_dir . '/' . $_SESSION['language'] . '.php'))
{
	$template_dir_select = $template_dir . '/';
	/**
	 * include the template language overrides
	 */
	include_once (DIR_WS_LANGUAGES . $template_dir_select . $_SESSION['language'] . '.php');
}
else
{
	$template_dir_select = '';
	// include_once(DIR_WS_LANGUAGES . $template_dir_select . $_SESSION['language'] . '.php');
}
/**
 * include the template language master (to catch all items not defined in the override file).
 * The intent here is to: load the override version to catch preferencial changes;
 * then load the original/master version to catch any defines that didn't get set into the override version during upgrades, etc.
 */
// THE FOLLOWING MIGHT NEED TO BE DISABLED DUE TO THE EXISTENCE OF function() DECLARATIONS IN MASTER ENGLISH.PHP FILE
// THE FOLLOWING MAY ALSO SEND NUMEROUS ERRORS IF YOU HAVE ERROR_REPORTING ENABLED, DUE TO REPETITION OF SEVERAL DEFINE STATEMENTS
include_once (DIR_WS_LANGUAGES . $_SESSION['language'] . '.php');

/**
 * send the content charset "now" so that all content is impacted by it
 */
header("Content-Type: text/html; charset=" . CHARSET);

/**
 * include the extra language definitions
 */
include (DIR_WS_MODULES . 'extra_definitions.php');


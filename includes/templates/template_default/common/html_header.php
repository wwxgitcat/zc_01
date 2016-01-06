<?php
/**
 * @author QQ46231996
 * @copyright QQ46231996
 */
?>



<?php require (DIR_WS_MODULES . zen_get_module_directory('meta_tags.php'));?>
<!DOCTYPE html>
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta charset="<?php echo CHARSET; ?>">
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>" />
<title><?php echo META_TAG_TITLE; ?></title>
<meta name="keywords" content="<?php echo META_TAG_KEYWORDS; ?>" />
<meta name="description" content="<?php echo META_TAG_DESCRIPTION; ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="imagetoolbar" content="no" />

<meta name="apple-mobile-web-app-capable" content="yes">
<?php if (defined('FAVICON')) { ?>
<link rel="icon" href="<?php echo FAVICON; ?>" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo FAVICON; ?>" type="image/x-icon" />
<?php } //endif FAVICON ?>
<base href="<?php echo zhlink();?>" />
<?php if (isset($canonicalLink) && $canonicalLink != '') { ?>
<link rel="canonical" href="<?php echo $canonicalLink; ?>" />
<?php } ?>
<!-- <link rel="stylesheet" type="text/css" href="http://cdn.amazeui.org/amazeui/2.5.0/css/amazeui.min.css"> -->
<link rel="stylesheet" type="text/css" href="<?php echo DIR_WS_TEMPLATE;?>css/normalize.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo DIR_WS_TEMPLATE;?>css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo DIR_WS_TEMPLATE;?>css/amazeui.min.css"/>
<!-- <link rel="stylesheet" type="text/css" href="<?php echo DIR_WS_TEMPLATE;?>css/bootstrap-theme.min.css"/> -->
<link rel="stylesheet" type="text/css" href="<?php echo DIR_WS_TEMPLATE;?>css/style.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo DIR_WS_TEMPLATE;?>css/style_responsive.css"/>
<!-- <link rel="stylesheet" type="text/css" href="<?php echo DIR_WS_TEMPLATE;?>css/zzsc.css"/> -->
<script type="text/javascript" src="<?php echo DIR_WS_TEMPLATE;?>js/jquery-1.9.1.min.js"></script>

<!-- <script type="text/javascript" src="http://cdn.amazeui.org/amazeui/2.5.0/js/amazeui.min.js"></script> -->

<!-- [if IE 6]>
<![endif]-->
<!-- [if lte IE 7]>
<![endif]-->
<!-- [if lte IE 8]>
<![endif]-->
<?php

$directory_array = $template->get_template_part($template->get_template_dir('.css', DIR_WS_TEMPLATE, $current_page_base, 'css'), '/^style/', '.css');
while(list($key, $value) = each($directory_array))
{
	//echo '<link rel="stylesheet" type="text/css" href="' . $template->get_template_dir('.css', DIR_WS_TEMPLATE, $current_page_base, 'css') . '/' . $value . '" />' . "\n";
}

/**
 * load all site-wide jscript_*.php files from includes/templates/YOURTEMPLATE/jscript, alphabetically
 */
$directory_array = $template->get_template_part($template->get_template_dir('.php', DIR_WS_TEMPLATE, $current_page_base, 'js'), '/^js_/', '.php');
while(list($key, $value) = each($directory_array))
{
	/**
	 * include content from all site-wide jscript_*.php files from includes/templates/YOURTEMPLATE/jscript, alphabetically.
	 * These .PHP files can be manipulated by PHP when they're called, and are copied in-full to the browser page
	 */
	require ($template->get_template_dir('.php', DIR_WS_TEMPLATE, $current_page_base, 'js') . '/' . $value);
	echo "\n";
}
$directory_array = $template->get_template_part($page_directory, '/^jscript_/');
while(list($key, $value) = each($directory_array))
{
	/**
	 * include content from all page-specific jscript_*.php files from includes/modules/pages/PAGENAME, alphabetically.
	 * These .PHP files can be manipulated by PHP when they're called, and are copied in-full to the browser page
	 */
	require ($page_directory . '/' . $value);
	echo "\n";
}
?>
<?php if ($_GET['main_page'] == 'checkout_confirmation'){?>
<!-- //code -->
<?php }?>
</head>
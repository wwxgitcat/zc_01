<?php
if (!defined('IS_ADMIN_FLAG'))
{
	die('Illegal Access');
}
if (function_exists('zen_register_admin_page'))
{
	if (!zen_page_key_exists('Quick Updates'))
	{
		zen_register_admin_page('Quick Updates', 'BOX_CATALOG_QUICK_UPDATES', 'FILENAME_QUICK_UPDATES', '', 'catalog', 'Y', 103);
	}
}
?>
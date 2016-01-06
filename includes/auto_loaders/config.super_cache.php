<?php
/**
 * Super cache configuration
 * @author QQ46231996
 * @create 2015/2/12
 * @modify  2015/2/12
 */
if (!defined('IS_ADMIN_FLAG'))
{
	die('Illegal Access');
}

$autoLoadConfig[73][] = array(
	'autoType' => 'class',
	'loadFile' => 'super_cache.php'
);
$autoLoadConfig[73][] = array(
	'autoType' => 'classInstantiate',
	'className' => 'JSuperCache',
	'objectName' => 'jsuperCache'
);
$autoLoadConfig[73][] = array(
	'autoType' => 'init_script',
	'loadFile' => 'init_super_cache.php'
);
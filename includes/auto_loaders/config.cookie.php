<?php
if (!defined('IS_ADMIN_FLAG'))
{
	die('Illegal Access');
}

$autoLoadConfig[71][] = array(
	'autoType' => 'class',
	'loadFile' => 'cookie.php' 
);
$autoLoadConfig[71][] = array(
	'autoType' => 'classInstantiate',
	'className' => 'Cookie',
	'objectName' => 'cookie' 
);
$autoLoadConfig[72][] = array(
	'autoType' => 'init_script',
	'loadFile' => 'init_following.php' 
);

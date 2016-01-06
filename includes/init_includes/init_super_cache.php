<?php
/**
 * Init super cache
 * @author QQ46231996
 * @create 2015/2/12
 * @modify  2015/2/12
 */

/**
 * @var JSuperCache $jsuperCache
 */

if ($jscnt = $jsuperCache->exists())
{
	echo $jscnt;
	exit;
}



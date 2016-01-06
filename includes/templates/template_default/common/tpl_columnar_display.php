<?php
/**
 * Common Template - tpl_columnar_display.php
 *
 * This file is used for generating tabular output where needed, based on the supplied array of table-cell contents.
 *
 * @package templateSystem
 * @author JunsGo@msn.com
 * @copyright Copyright 2013 SL Development Team
 * @copyright Portions Copyright 2003 osCommerce
 */
?>
<?php

if ($title)
{
	?>
<?php echo $title; ?>
<?php
}
?>


<?php



if (is_array($list_box_contents) > 0)
{
	for($row = 0; $row < sizeof($list_box_contents); $row++)
	{
		$params = "";
		// if (isset($list_box_contents[$row]['params'])) $params .= ' ' . $list_box_contents[$row]['params'];
		?>

<?php
		for($col = 0; $col < sizeof($list_box_contents[$row]); $col++)
		{
			$r_params = "";
			if (isset($list_box_contents[$row][$col]['params'])) $r_params .= ' ' . (string)$list_box_contents[$row][$col]['params'];
			if (isset($list_box_contents[$row][$col]['text']))
			{
				?>


    <?php echo '<div class="small_img" ' . $r_params . '>' . $list_box_contents[$row][$col]['text'] .  '</div>' . "\n"; ?>
   
<?php
			}
		}
		?>

<?php
	}
}
?>



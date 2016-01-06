<?php
/**
 * Common Template - tpl_tabular_display.php
 *
 * This file is used for generating tabular output where needed, based on the supplied array of table-cell contents.
 *
 * @package templateSystem
 * @author JunsGo@msn.com
 * @copyright Copyright 2013 SL Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * 
 */

// print_r($list_box_contents);
$cell_scope = (!isset($cell_scope) || empty($cell_scope)) ? 'col' : $cell_scope;
$cell_title = (!isset($cell_title) || empty($cell_title)) ? 'list' : $cell_title;

?>
<?php

for($row = 1; $row < sizeof($list_box_contents); $row++)
{
	$r_params = "";
	$c_params = "";
	if (isset($list_box_contents[$row]['params'])) $r_params .= ' ' . $list_box_contents[$row]['params'];
	?>
<div class="goodsItem" style="">
	<div class="peolistwq">
<?php
	for($col = 0; $col < sizeof($list_box_contents[$row]); $col++)
	{
		$c_params = "";
		
		if (isset($list_box_contents[$row][$col]['text']))
		{
			?>
   <?php echo $list_box_contents[$row][$col]['text']?>
<?php
		}
	}
	?></div>
</div>
<?php
}
?> 






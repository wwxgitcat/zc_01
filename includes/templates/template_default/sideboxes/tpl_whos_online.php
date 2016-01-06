<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @author JunsGo@msn.com
 * @copyright Copyright 2013 SL Development Team
 * @copyright Portions Copyright 2003 osCommerce
 */
$content = '';
$content .= '<div id="' . str_replace('_', '-', $box_id . 'Content') . '" class="sideBoxContent centeredContent">';
for($i = 0; $i < sizeof($whos_online); $i++)
{
	$content .= $whos_online[$i];
}
$content .= '</div>';
$content .= '';
?>
<div class="menu_block border_block" id="<?php echo str_replace('_', '-', $box_id ); ?>" style="width: <?php echo $column_width; ?>">
	<div class="block-title"
		id="<?php echo str_replace('_', '-', $box_id) . 'Heading'; ?>">
		<div class="welcomes">
			<?php echo BOX_HEADING_WHOS_ONLINE; ?>
		</div>
	</div>
	<div class="sectionTabCont">
		<div id="<?php echo str_replace('_', '-', $box_id . 'Content');?>"
			class="sideBoxContent centeredContent">
			<?php foreach ($whos_online as $whos):?>
			<?php echo $whos;?>
			<?php endforeach;?>
		</div>
	</div>
</div>
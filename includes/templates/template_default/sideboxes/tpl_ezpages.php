<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @author JunsGo@msn.com
 * @copyright Copyright 2013 SL Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @var $tpl_ezpage_array = array('id','name','altURL','link')
 */
?>
<div class="menu_block border_block" id="<?php echo str_replace('_', '-', $box_id ); ?>" style="width: <?php echo $column_width; ?>">
	<div class="block-title"
		id="<?php echo str_replace('_', '-', $box_id) . 'Heading'; ?>">
		<div class="welcomes">
			<?php echo BOX_HEADING_MORE_INFORMATION; ?>
		</div>
	</div>
	<div class="sectionTabCont">
		<div id="<?php echo str_replace('_', '-', $box_id . 'Content');?>"
			class="sideBoxContent">
			<ul style="margin: 0; padding: 0; list-style-type: none;">
				<?php foreach ($tpl_ezpage_array as $page):?>
				<li><a href="<?php echo $page['link'];?>"><?php echo $page['name']?></a></li>
				<?php endforeach;?>
			</ul>
		</div>
	</div>
</div>

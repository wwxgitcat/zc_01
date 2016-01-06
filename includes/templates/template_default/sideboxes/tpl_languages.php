<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @author JunsGo@msn.com
 * @copyright Copyright 2013 SL Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @var $tpl_language_array = array('id','name','image','code','directory','href')
 */
?>
<div class="menu_block border_block" id="<?php echo str_replace('_', '-', $box_id ); ?>" style="width: <?php echo $column_width; ?>">
	<div class="block-title"
		id="<?php echo str_replace('_', '-', $box_id) . 'Heading'; ?>">
		<div class="welcomes">
			<?php echo BOX_HEADING_LANGUAGES; ?>
		</div>
	</div>
	<div class="sectionTabCont">
		<div id="<?php echo str_replace('_', '-', $box_id . 'Content');?>"
			class="sideBoxContent centeredContent">
			<?php $lng_cnt = 0;?>
			<?php foreach ($tpl_language_array as $value):?>
				<?php ++$lng_cnt;?>
				<a href="<?php echo $value['href'];?>">
					<?php echo zen_image(DIR_WS_LANGUAGES .  $value['directory'] . '/images/' . $value['image'], $value['name']);?>
				</a>&nbsp;&nbsp;
				<?php if ($lng_cnt >= MAX_LANGUAGE_FLAGS_COLUMNS):?>
					<?php $lng_cnt = 0;?><br />
				<?php endif;?>
			<?php endforeach;?>
		</div>
	</div>
</div>
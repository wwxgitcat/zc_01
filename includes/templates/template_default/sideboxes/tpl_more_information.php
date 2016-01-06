<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @author JunsGo@msn.com
 * @copyright Copyright 2013 SL Development Team
 * @copyright Portions Copyright 2003 osCommerce
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
				<?php if (DEFINE_PAGE_2_STATUS <= 1):?>
				<li><a href="<?php echo zen_href_link(FILENAME_PAGE_2);?>"><?php echo BOX_INFORMATION_PAGE_2;?></a></li>
				<?php endif;?>
				<?php if (DEFINE_PAGE_3_STATUS <= 1):?>
				<li><a href="<?php echo zen_href_link(FILENAME_PAGE_3);?>"><?php echo BOX_INFORMATION_PAGE_3;?></a></li>
				<?php endif;?>
				<?php if (DEFINE_PAGE_4_STATUS <= 1):?>
				<li><a href="<?php echo zen_href_link(FILENAME_PAGE_4);?>"><?php echo BOX_INFORMATION_PAGE_4;?></a></li>
				<?php endif;?>
			</ul>
		</div>
	</div>
</div>
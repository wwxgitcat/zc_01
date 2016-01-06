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
			<?php echo BOX_HEADING_INFORMATION; ?>
		</div>
	</div>
	<div class="sectionTabCont">
		<div id="<?php echo str_replace('_', '-', $box_id . 'Content');?>"
			class="sideBoxContent">
			<ul style="margin: 0; padding: 0; list-style-type: none;">
				<?php if (DEFINE_SHIPPINGINFO_STATUS <= 1):?>
				<li><a href="<?php echo zen_href_link(FILENAME_SHIPPING);?>"><?php echo BOX_INFORMATION_SHIPPING;?></a></li>
				<?php endif;?>
				<?php if (DEFINE_PRIVACY_STATUS <= 1):?>
				<li><a href="<?php echo zen_href_link(FILENAME_PRIVACY);?>"><?php echo BOX_INFORMATION_PRIVACY;?></a></li>
				<?php endif;?>
				<?php if (DEFINE_CONDITIONS_STATUS <= 1):?>
				<li><a href="<?php echo zen_href_link(FILENAME_CONDITIONS);?>"><?php echo BOX_INFORMATION_CONDITIONS;?></a></li>
				<?php endif;?>
				<?php if (DEFINE_CONTACT_US_STATUS <= 1):?>
				<li><a href="<?php echo zen_href_link(FILENAME_CONTACT_US);?>"><?php echo BOX_INFORMATION_CONTACT;?></a></li>
				<?php endif;?>
				<?php if (DEFINE_SITE_MAP_STATUS <= 1):?>
				<li><a href="<?php echo zen_href_link('about_us');?>">会社概要</a></li>
				<?php endif;?>
				<?php if (MODULE_ORDER_TOTAL_GV_STATUS == 'true'):?>
				<li><a href="<?php echo zen_href_link('pay');?>">お支払情報</a></li>
				<?php endif;?>
			</ul>
		</div>
	</div>
</div>
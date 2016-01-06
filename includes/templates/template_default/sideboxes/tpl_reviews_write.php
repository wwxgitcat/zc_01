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
			<a href="<?php echo zen_href_link(FILENAME_REVIEWS);?>"><?php echo BOX_HEADING_REVIEWS; ?></a>
		</div>
	</div>
	<div class="sectionTabCont">
		<div id="<?php echo str_replace('_', '-', $box_id . 'Content');?>"
			class="sideBoxContent centeredContent">
			<a
				href="<?php echo zen_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, 'products_id=' . $_GET['products_id']);?>">
				<?php echo zen_image(DIR_WS_TEMPLATE_IMAGES . OTHER_IMAGE_BOX_WRITE_REVIEW, OTHER_BOX_WRITE_REVIEW_ALT);?><br />
				<?php echo BOX_REVIEWS_WRITE_REVIEW;?>
			</a>
		</div>
	</div>
</div>
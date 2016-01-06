<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @author JunsGo@msn.com
 * @copyright Copyright 2013 SL Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @var $tpl_review_array = array('products_id','name','image','reviews_id','rating','text','href')
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
		<?php foreach ($tpl_review_array as $review):?>
		<div id="<?php echo str_replace('_', '-', $box_id . 'Content');?>"
			class="sideBoxContent centeredContent">
			<a href="<?php echo $review['href'];?>">
				<?php echo zen_image(DIR_WS_IMAGES . $review['image'], $review['name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);?><br />
				<?php echo zen_trunc_string(nl2br(zen_output_string_protected(stripslashes($review['text']))), 60);?>
			</a><br />
			<br />
			<?php echo zen_image(DIR_WS_TEMPLATE_IMAGES . 'stars_' . $review['rating'] . '.gif' , sprintf(BOX_REVIEWS_TEXT_OF_5_STARS, $review['rating']));?>
		</div>
		<?php endforeach;?>
	</div>
</div>
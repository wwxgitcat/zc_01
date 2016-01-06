<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @author JunsGo@msn.com
 * @copyright Copyright 2013 SL Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @var $tpl_special_array = array('id','name','href','image','price','categories_id','tax_class_id')
 */
?>
<div class="menu_block border_block" id="<?php echo str_replace('_', '-', $box_id ); ?>" style="width: <?php echo $column_width; ?>">
	<div class="block-title"
		id="<?php echo str_replace('_', '-', $box_id) . 'Heading'; ?>">
		<div class="welcomes">
			<a href="<?php echo zen_href_link(FILENAME_SPECIALS);?>"><?php echo BOX_HEADING_SPECIALS; ?></a>
		</div>
	</div>
	<div class="sectionTabCont">
		<?php foreach ($tpl_special_array as $special):?>
		<div class="sideBoxContent centeredContent">
			<a title="<?php echo $special['name'];?>"
				href="<?php echo $special['href'];?>">
				<?php echo zen_image(DIR_WS_IMAGES . $special['image'], $special['name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);?>
			</a> <a class="sidebox-products"
				href="<?php echo $special['href'];?>">
				<?php echo zen_trunc_string($special['name'], 35, '...');?>
			</a>
			<div>
				<img alt="" src="<?php echo DIR_WS_TEMPLATE_IMAGES.'stars_5.gif'?>">
			</div>
		</div>
		<?php endforeach;?>
	</div>
</div>
<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @author JunsGo@msn.com
 * @copyright Copyright 2013 SL Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @var $tpl_banner_array=array(banner,...)
 */
?>

<div class="menu_block border_block" id="<?php echo str_replace('_', '-', $box_id); ?>" style="width: <?php echo $column_width; ?>">
	<div class="block-title"
		id="<?php echo str_replace('_', '-', $box_id) . 'Heading'; ?>">
		<div class="welcomes"><?php echo BOX_HEADING_BANNER_BOX_ALL; ?></div>
	</div>
	<div id="<?php echo str_replace('_', '-', $box_id.'Content')?>"
		class="sideBoxContent centeredContent">
		<div class="index-sidebar">
			<div>
				<img alt=""
					src="<?php echo DIR_WS_TEMPLATE_IMAGES;?>top_right_hd.jpg">
			</div>
			<div class="side_faq">
				<a href="<?php echo zen_href_link('page_4', '', 'NONSSL'); ?>"
					rel="nofollow"> <img border="0"
					src="<?php echo DIR_WS_TEMPLATE_IMAGES;?>side_aq.jpg" />
				</a>
			</div>
		</div>
		<img src="<?php echo DIR_WS_TEMPLATE_IMAGES;?>shopping_mart.png">
		<?php foreach ($tpl_banner_array as $banner):?>
		<?php echo $banner;?>
		<?php endforeach;?>
	</div>
</div>
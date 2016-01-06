<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @author JunsGo@msn.com
 * @copyright Copyright 2013 SL Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @var $tpl_feature_array = array('id','name','href','image','price','categories_id','is_free','display_normal_price','display_special_price','display_sale_price')
 */
?>
<div class="lualiajapltured border_block" id="<?php echo str_replace('_', '-', $box_id ); ?>" style="width: <?php echo $column_width; ?>">
	<div class="lualiajapltured-title" id="<?php echo str_replace('_', '-', $box_id) . 'Heading'; ?>">
			<a href="<?php echo zen_href_link(FILENAME_FEATURED_PRODUCTS);?>"><?php echo BOX_HEADING_FEATURED_PRODUCTS; ?></a>
	</div>
		<div class="lualiajaplontent centeredContent">
			<?php foreach ($tpl_feature_array as $product):?>
			<div class="lualiajaplentitem">
				<div class="lualiajaplonimg">
					<a class="lualiajaplonimage" title="<?php echo $product['name'];?>"
						href="<?php echo $product['href'];?>">
						<?php echo zen_image(DIR_WS_IMAGES . $product['image'], $product['name'], 160, 160);?>
					</a>
				</div>
				<div class="lualiajaplontitle">
					<span> <a href="<?php echo $product['href'];?>"
						title="<?php echo $product['name'];?>"><?php echo safe_cut_str($product['name'] ,40,'...');?></a>
					</span>
				</div>
				<div>
						<?php if (!empty($product['display_special_price'])):?>
									<div class="lualiajaplonprisale">
													<div style=" text-align: center;">販売価格:<?php echo $product['display_special_price'];?></div>
									<?php if (!empty($product['display_sale_price'])):?>
										<span class="productSalePrice"><?php echo $product['display_sale_price'];?>（税込）</span>
										<?php endif;?>
									</div>
						<?php endif;?>
					<div style="text-decoration: line-through; color: #000000; font-size: 12px; text-align: center;">
						<?php if (!empty($product['display_normal_price'])):?>
									<span>定価:
									<?php echo $product['display_normal_price'];?></span>
	
						<?php endif;?>
					</div>

					<?php if ($product['is_free']):?>
						<?php if (OTHER_IMAGE_PRICE_IS_FREE_ON == '0'):?>
							<?php echo PRODUCTS_PRICE_IS_FREE_TEXT;?>
						<?php else:?>
							<?php echo zen_image(DIR_WS_TEMPLATE_IMAGES . OTHER_IMAGE_PRICE_IS_FREE, PRODUCTS_PRICE_IS_FREE_TEXT);?>
						<?php endif;?>
					<?php endif;?>
				</div>
			</div>
			<?php endforeach;?>
			<br class="clear"/>
		</div>
</div>
<br class="clear"/>

<?php if (count($tpl_what_new)):?>
<div id="whats_new" class=" block whats-new">
	<h4 class="block-title"><?php echo BOX_HEADING_WHATS_NEW;?></h4>
	<div class="block-cnt">

		<ul>
			<?php foreach ($tpl_what_new as $product):?>
			<li>
				<a href="<?php echo $product['href'];?>">
					<?php echo zen_image(DIR_WS_IMAGES.$product['image'], $product['name'], 200, 200);?>
				</a>
				<!-- <span class="price-save">
					<?php echo $product['display_sale_price'];?>
				</span> -->
				<a href="<?php echo $product['href'];?>"><p><?php echo $product['name']?></p></a>
				<?php if (!empty($product['display_special_price'])):?>
					<del class="price-old"><?php echo $product['display_normal_price'];?></del>
					<span class="price-new"><?php echo $product['display_special_price'];?></span>
				<?php else://have special?>
					<span class="price-new"><?php echo $product['display_normal_price'];?></span>
				<?php endif;//no special?>
				<?php if (!empty($product['display_sale_price'])):?>
				
				<?php endif;?>
			</li>


			<?php endforeach;//end categories?>
		</ul>
	</div>
</div>
<?php endif;?>

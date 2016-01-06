<?php if (count($tpl_best_sellers_products)):?>
<div id="whats_new" class="block best_-sellers">
	<h4 class="block-title"><?php echo BOX_HEADING_BESTSELLERS;?></h4>
	<div class="block-cnt">
		<ul>
			<?php foreach ($tpl_best_sellers_products as $product):?>
			<li>
				<a href="<?php echo $product['href'];?>">
					<?php echo zen_image(DIR_WS_IMAGES.$product['image'], $product['name'], 200, 200);?>
				</a>
				<p><?php echo $product['name'];?></p>
			</li>
			<?php endforeach;//end categories?>
		</ul>
	</div>
</div>
<?php endif;?>

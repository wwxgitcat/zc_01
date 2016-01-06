<?php if (!is_null($products_new_split) && is_object($products_new_split)) $listing_split = $products_new_split;?>
<?php if (!is_null($products_all_split) && is_object($products_all_split)) $listing_split = $products_all_split;?>
<div class="product-list cat_demo">
	<?php if (is_object($listing_split)):?>
	<?php if(($listing_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3'))):?>
		<div class=" pagination clearfix">
			<div id="productsListingTopNumber" class="pagination-info pull-left">
				<?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?>
			</div>
			<div id="productsListingListingTopLinks" class="pagination-items pull-right">
				<?php echo TEXT_RESULT_PAGE . ' ' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y'))); ?>
			</div>
		</div>
		<?php endif;//top pagination?>
	<?php endif;?>
	<?php if (!$this_is_home_page):?> 
		<?php if (is_object($listing_split)):?>
		<?php if(($listing_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '2'))):?>
			<div class="pagination clearfix">
				<div id="productsListingTopNumber" class="col-xs-12 col-sm-12 col-md-12 pagination-info pull-left">
					<?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></div>
				<div id=" productsListingListingTopLinks" class="col-xs-12 col-sm-12 col-md-12 pagination-items pull-right page_num">
					<?php //echo TEXT_RESULT_PAGE . ' ' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y'))); ?>
				</div>
			</div>
			<?php endif;//bottom pagination?>
		<?php endif;?>
		<?php $i=0; ?>
	<div class=" <?php if ($this_is_home_page):?><?php endif;?> product-body clearfix cate_produce">
		<?php foreach ($tpl_products['products'] as $product):?>
					<div class="col-xs-6 <?php if ($this_is_home_page):?>col-sm-4<?php else:?>col-sm-6<?php endif;?> col-md-3 border_demo detail_products_demo">
					<?php  $i++; ?>
					<?php 
						// if($i<8){
						// 	//echo '<div class="new_demo">NEW</div >';
						// }
						// else{
						// 	// echo '<div class="">   </div >';
						// }
					 ?>
					<div class="new_demo">NEW</div >
					<dl class="<?php if ($this_is_home_page):?> product-home<?php endif;?> product-item" >
						<dt class="product-img" >

							<a onclick="change_click()"  href="<?php echo (!empty($product['out_link']) && strpos($product['out_link'], 'http') === 0 ? $product['out_link'] : $product['href']);?>" <?php if ($product['out_link']):?><?php endif;?> title="<?php echo $product['name'];?>">
								<img onclick="click_demo()"  src="<?php echo zen_image(DIR_WS_IMAGES.$product['image'], $product['name'], IMAGE_PRODUCT_LISTING_WIDTH, '', '', true);?>" alt="<?php echo $product['name'];?>"/>
							</a>
						</dt>

						<!-- <div class="detalis_all"> -->
							<!-- <div class="details"> -->
								<dd class="product-name">
								<span class="price-save">
									<?php echo $product['display_sale_price'];?>
								</span>
								<h5><a href="<?php echo (!empty($product['out_link']) && strpos($product['out_link'], 'http') === 0 ? $product['out_link'] : $product['href']);?>" <?php if ($product['out_link']):?><?php endif;?> title="<?php echo $product['name'];?>"><?php echo safe_cut_str($product['name'],155,'...');?></a></h5>
								</dd>
							<!-- </div> -->
							<dd class="product-price">
								<?php if (!empty($product['display_special_price'])):?>
									<del class="price-old"><?php echo $product['display_normal_price'];?></del>
									<span class="price-new"><?php echo $product['display_special_price'];?></span>
								<?php else://have special?>
									<span class="price-new"><?php echo $product['display_normal_price'];?></span>
								<?php endif;//no special?>
								<?php if (!empty($product['display_sale_price'])):?>
								
								<?php endif;?>
							</dd>
						<!-- </div> -->
					</dl>
				</div>
		<?php endforeach;//end product for?>
	</div>
	<?php endif; ?>
	<?php if ($this_is_home_page):?> 
		<div class=" <?php if (!$this_is_home_page):?><?php endif;?> product-body clearfix cate_produce">
			<?php foreach ($tpl_products['products'] as $product):?>
		<div class="col-xs-6  col-sm-4 col-md-4 border_demo">
			<dl class=" product-home product-item" >
			<div class="sale_demo">SALE	</div class="sale_demo">
				<dt class="product-img" >
					<a onclick="change_click()"  href="<?php echo (!empty($product['out_link']) && strpos($product['out_link'], 'http') === 0 ? $product['out_link'] : $product['href']);?>" <?php if ($product['out_link']):?><?php endif;?> title="<?php echo $product['name'];?>">
						<img onclick="click_demo()"  src="<?php echo zen_image(DIR_WS_IMAGES.$product['image'], $product['name'], IMAGE_PRODUCT_LISTING_WIDTH, '', '', true);?>" alt="<?php echo $product['name'];?>"/>
					</a>
				</dt>
			<!-- <div class="detalis_all"> -->
				<!-- <div class="details"> -->
					<dd class="product-name">

					<h5>
							<span class="price-save">
								<?php echo $product['display_sale_price'];?>
							</span>
							<a href="<?php echo (!empty($product['out_link']) && strpos($product['out_link'], 'http') === 0 ? $product['out_link'] : $product['href']);?>" <?php if ($product['out_link']):?><?php endif;?> title="<?php echo $product['name'];?>"><?php echo safe_cut_str($product['name'],155,'...');?></a>
					</h5>
					</dd>
				<!-- </div> -->
				<dd class="product-price">
					<?php if (!empty($product['display_special_price'])):?>
						<del class="price-old"><?php echo $product['display_normal_price'];?></del>
						<span class="price-new"><?php echo $product['display_special_price'];?></span>
					<?php else://have special?>
						<span class="price-new"><?php echo $product['display_normal_price'];?></span>
					<?php endif;//no special?>
					<?php if (!empty($product['display_sale_price'])):?>
					<!-- <span class="price-save">
						<?php echo $product['display_sale_price'];?>
					</span> -->
					<?php endif;?>
				</dd>
				<!-- </div> -->
			</dl>
		</div>
		<?php endforeach;//end product for?>
		</div>
	<?php endif; ?>
	
	<script type="text/javascript">
	// function change_white(){
	// 	$(".product-item").mouseover(function(){
	// 			$(this).find('h5>a').css('color','white');
	// 			$(this).find('.price-new').css('color','#EA5F00');
	// 		});
	// }
	// function change_black(){
	// 	$(".product-item").mouseout(function(){
	// 			$(this).find('h5>a').css('color','black');
	// 			$(this).find('.price-new').css('color','#FF0000');
	// 		});
	// }
	// function change_click(){
	// 	$(".product-item").onclick(function(){
	// 		alert("asdasd");
	// 			$(this).find('h5>a').css('color','#fff');
	// 		});
	// }

	</script>
	<?php if (is_object($listing_split)):?>
	<?php if(($listing_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '2'))):?>
		<div class="pagination clearfix">
			<div id="productsListingTopNumber" class="col-xs-12 col-sm-12 col-md-12 pagination-info pull-left">
				<?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></div>
			<div id=" productsListingListingTopLinks" class="col-xs-12 col-sm-12 col-md-12 pagination-items pull-right page_num">
				<?php echo TEXT_RESULT_PAGE . ' ' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y'))); ?>
			</div>
		</div>
		<?php endif;//bottom pagination?>
	<?php endif;?>
</div>

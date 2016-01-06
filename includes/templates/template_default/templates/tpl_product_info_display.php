
<div class="panel product-info">
<form method="post" name="cart_quantity" id="cart_quantity" enctype="multipart/form-data" action="<?php echo zen_href_link(zen_get_info_page($_GET['products_id']), zen_get_all_get_params(array('action')) . 'action=add_product', $request_type);?>">

	<div class="all_cat">	
<?php foreach ($tpl_categories as $c):?>
<li class="level0  level-top <?php if (count($c['children'])>0){echo "parent";}?>">
	<!-- <a class="level-top" title="<?php echo $c['name'];?>"  href="<?php echo $c['href'];?>">
		<span><?php //echo $c['name'];?></span>
	</a> -->
	<?php if (count($c['children'])>0):?>
	
				<ul class="level01 ">
					<?php foreach ($c['children'] as $cs):?>
						<div class="col-xs-6">
							<li class="level1_nav" ><a title="<?php echo $cs['name'];?>" href="<?php echo $cs['href'];?>">▪&nbsp;<?php echo $cs['name'];?></a></li>
						</div>
					<?php endforeach;?>
				</ul>
		
	<strong class="opened">	</strong>
	<?php endif;?>
</li>
<?php endforeach;?>
</div>
	<h1 class="panel-heading  ">
		<!-- <span class="pro_2">1<em class="em1"></em></span>&nbsp;<?php echo $breadcrumb->last(); ?> -->
		<?php echo $breadcrumb->last(); ?>
	</h1>
	<div class="panel-body">
		<?php display_message('product_info'); ?>
		<?php // require(display_template('tpl_products_next_previous'));?>
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 product-info-img">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 product-img-master">
						<?php if (zen_not_null($products_image)):?>
							<?php require(display_template('tpl_modules_main_product_image'));?>
						<?php endif;?>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 product-img-additional">
						<?php if (zen_not_null($products_image)):?>
							<?php require(display_tpl('tpl_modules_additional_images'));?>
						<?php endif;?>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6">
				<dl class="product-info-detail">
					<dt class="product-model"><?php echo TEXT_PRODUCT_MODEL;?><span class="product-model-num"><?php echo $products_model;?></span></dt>
					<dd class="product-price">
						<?php if (!empty($display_special_price)):?>
							<del class="price-old"><?php echo $display_normal_price;?></del>
							<span class="price-new"><?php echo $display_special_price;?></span>
						<?php else://have special?>
							<span class="price-new"><?php echo $display_normal_price;?></span>
						<?php endif;//no special?>
						<?php if (!empty($display_sale_price)):?>
							<br/>
							<span class="price-save">
							<?php echo $display_sale_price;?>
							</span>
						<?php endif;?>
					</dd>
					<dd>
						<div class="product-attributes">
							<?php require(display_tpl('tpl_modules_attributes'));?>
						</div>
					</dd>
					<dd class="product-quantity">
						<div class="form-inline">
							<div class="form-group">
								<label for="qty"><?php echo PRODUCTS_ORDER_QTY_TEXT;?></label>
								<input  id="qty" class="form-control" type="text" name="cart_quantity" value="<?php echo zen_get_buy_now_qty($_GET['products_id']);?>" maxlength="12" size="5"/>
								<?php echo zen_get_products_quantity_min_units_display((int)$_GET['products_id']) . zen_draw_hidden_field('products_id', (int)$_GET['products_id']);?>
								<input type="submit" name="add_to_cart" class="btn btn-danger" value="<?php echo BUTTON_IN_CART_ALT;?>"/>
							</div>
						</div>
						
						
					</dd>
				</dl>
			</div>
		</div>
	
	</div>
</form>
</div>
<div class="panel rea_detail">
	<h1 class="panel-heading pro_relation">
		<?php echo TEXT_PRODUCT_RELATED ?>
	</h1>
	<div class="panel-body pro_relation">
		<?php require(get_modules_file('product_related'));?>
		<?php require(display_tpl_common('tpl_grid_display'));?>
	</div>
</div>



<div class="row ">

			<div class="col-xs-16 col-sm-12 col-md-12 ">
				<div class="product-info-cnt pro_info">
					<h2 class="panel-heading"><?php echo  TEXT_PRODUCT_DETAIL;?></h2>

					<div class="product-info-detail">
						 <?php echo stripslashes($products_description); ?>
					</div>
				</div>
			</div>
		</div>

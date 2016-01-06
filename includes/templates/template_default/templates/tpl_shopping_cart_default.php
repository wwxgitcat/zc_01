<div class="panel cart">
	<h1 class="panel-heading cart-heading">
		<?php if ($flagHasCartContents){?>
			<?php echo HEADING_TITLE; ?>
		<?php }else{?>
			<?php echo TEXT_CART_EMPTY;?>
		<?php }?>
		
	</h1>
	<div class="panel-body">
		<?php if ($flagHasCartContents){?>
			<?php if ($_SESSION['cart']->count_contents() > 0){?>
			<!-- <div class="cart-help"><?php echo TEXT_VISITORS_CART; ?></div> -->
			<?php }?>
			<?php display_message('shopping_cart'); ?>
			<form name="cart_quantity" id="cart_quantity" method="post" action="<?php echo zen_href_link(FILENAME_SHOPPING_CART, 'action=update_product', $request_type);?>">
				<?php if (!empty($totalsDisplay)) { ?>
					
				<?php } ?>
				<?php if ($flagAnyOutOfStock) { ?>
				<?php if (STOCK_ALLOW_CHECKOUT == 'true') {  ?>
				
				<div class="messageStackError"><?php echo OUT_OF_STOCK_CAN_CHECKOUT; ?></div>
				
				<?php    } else { ?>
				<div class="messageStackError"><?php echo OUT_OF_STOCK_CANT_CHECKOUT; ?></div>
				
				<?php    } //endif STOCK_ALLOW_CHECKOUT ?>
				<?php  } //endif flagAnyOutOfStock ?>
				<table id="cartContents" cellspacing="0" class="table table-striped table-bordered table-hover">
					<tbody>
						<tr class="tableHeading">
							<th width="311"><?php echo TABLE_HEADING_PRODUCTS; ?>
							
							</th>
							<th width="73"><?php echo TABLE_HEADING_QUANTITY; ?>
							
							</th>
							<th width="70"><?php echo TABLE_HEADING_PRICE; ?>
							
							</th>
							<th width="70"><?php echo TABLE_HEADING_TOTAL; ?>
							
							</th>
			
						</tr>
					<!-- Loop through all products /-->
					<?php foreach($productArray as $product){?>
					<tr class="<?php echo $product['rowClass']; ?>">
						<td>
							<div class="row cart-name">
								<div class="col-xs-12 col-sm-2 col-md-2">
									<a href="<?php echo $product['linkProductsName']; ?>">
										<span id="cartImage"><?php echo $product['productsImage']; ?></span>
									</a>
								</div>
								<div class="col-xs-12 col-sm-10 col-md-10">
									<a href="<?php echo $product['linkProductsName']; ?>">
										<span id="cartProdTitle" style="padding:0 5px;"><?php echo $product['productsName'];?>
											<span class="alert bold"><?php echo $product['flagStockCheck'];?></span>
										</span>
									</a>
									<?php echo $product['attributeHiddenField'];
									if (isset($product['attributes']) && is_array($product['attributes']))
									{
									?>
										<div class="cartAttribsList">
											<ul>
									<?php
										reset($product['attributes']);
										foreach($product['attributes'] as $option => $value)
										{
									?>
											<li><i><?php echo nl2br($value['products_options_values_name']); ?></i></li>
									<?php
										}
									?>
											</ul>
										</div>
									<?php }//end if attribute?>
								</div>
							</div>
							
						
				       </td>
				<td>
					<div class="form-inline">
						<div class="form-group">
<?php
		if ($product['flagShowFixedQuantity'])
		{
			echo $product['showFixedQuantityAmount'] . $product['showMinUnits'];
		}
		else
		{
			echo $product['quantityField'] . $product['showMinUnits'];
		}
		?>
<?php
		if ($product['buttonDelete'])
		{
?>
			<a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART, 'action=remove_product&product_id=' . $product['id']); ?>"><?php echo zen_image($template->get_template_dir(ICON_IMAGE_TRASH, DIR_WS_TEMPLATE, $current_page_base,'images/icons'). '/' . ICON_IMAGE_TRASH, ICON_TRASH_ALT); ?></a>
<?php
		}
?>
		<span class="alert bold"><?php echo $product['flagStockCheck'];?></span>
<?php
		if ($product['checkBoxDelete'])
		{
			// echo zen_draw_checkbox_field('cart_delete[]', $product['id']);
		}
?>
						</div>
					</div>
       </td>
				<td><?php echo $product['productsPriceEach']; ?></td>
				<td><?php echo $product['productsPrice']; ?></td>

			</tr>
<?php
	} // end foreach ($productArray as $product)
	?>
       <!-- Finished loop through all products /-->
		</tbody>
	</table>
			
				<div id="cartSubTotal" style=" text-align: right;font-size: 20px;padding:5px;"><?php echo SUB_TITLE_SUB_TOTAL; ?> <?php echo $cartShowTotal; ?></div>
				
			
			<!--bof shopping cart buttons-->
			<div class="row cart-control">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<a class="btn btn-warning" href="<?php echo zen_back_link(true);?>" title="<?php echo BUTTON_CONTINUE_SHOPPING_ALT;?>"><?php echo BUTTON_CONTINUE_SHOPPING_ALT;?></a>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-inline">
						<div class="form-group pull-right">
							<?php if (SHOW_SHIPPING_ESTIMATOR_BUTTON == '1'){?>
							
							<?php }?>
							
							<!-- ** BEGIN PAYPAL EXPRESS CHECKOUT ** -->
							<?php 
							// the tpl_ec_button template only displays EC option if cart contents >0 and value >0
								if (defined('MODULE_PAYMENT_PAYPALWPP_STATUS') && MODULE_PAYMENT_PAYPALWPP_STATUS == 'True')
								{
									include (DIR_FS_CATALOG . DIR_WS_MODULES . 'payment/paypal/tpl_ec_button.php');
								}
							?>
							<!-- ** END PAYPAL EXPRESS CHECKOUT ** -->
							<?php
								// show update cart button
								if (SHOW_SHOPPING_CART_UPDATE == 2 or SHOW_SHOPPING_CART_UPDATE == 3){
							?>
							<?php if (SHOW_SHIPPING_ESTIMATOR_BUTTON == '2'){//load the shipping estimator code if needed ?>
							      <?php require(DIR_WS_MODULES . zen_get_module_directory('shipping_estimator.php')); ?>
							<?php }?>
							<?php echo zen_draw_hidden_field('securityToken', $_SESSION['securityToken']); ?>
							<input type="submit" class="btn btn-success form-control cart-update" title="<?php echo ICON_UPDATE_ALT;?>" value="<?php echo BUTTON_UPDATE_ALT;?>"/>
							<?php }//end show update cart button?>
							<a class="btn btn-warning form-control" href="<?php echo zen_href_link('checkout_confirmation', '', 'SSL');?>" title="<?php echo BUTTON_CHECKOUT_ALT;?>"><?php echo BUTTON_CHECKOUT_ALT;?></a>
						</div>
						
					</div>
				</div>
			</div>
			<!--eof shopping cart buttons-->
		</form>
		<?php }else{//no product in cart?>
		<?php
		$show_display_shopping_cart_empty = $db->Execute(SQL_SHOW_SHOPPING_CART_EMPTY);
		while(!$show_display_shopping_cart_empty->EOF)
		{
			if ($show_display_shopping_cart_empty->fields['configuration_key'] == 'SHOW_SHOPPING_CART_EMPTY_FEATURED_PRODUCTS')
			{
				require(display_template('tpl_modules_featured_products'));
			}
			if ($show_display_shopping_cart_empty->fields['configuration_key'] == 'SHOW_SHOPPING_CART_EMPTY_SPECIALS_PRODUCTS')
			{
			}
		
			if ($show_display_shopping_cart_empty->fields['configuration_key'] == 'SHOW_SHOPPING_CART_EMPTY_NEW_PRODUCTS')
			{
			}
			if ($show_display_shopping_cart_empty->fields['configuration_key'] == 'SHOW_SHOPPING_CART_EMPTY_UPCOMING')
			{
				include (DIR_WS_MODULES . zen_get_module_directory(FILENAME_UPCOMING_PRODUCTS));
			}
		
			$show_display_shopping_cart_empty->MoveNext();
		} // !EOF
		?>
		
		<?php }//end?>
		
	</div>
</div>

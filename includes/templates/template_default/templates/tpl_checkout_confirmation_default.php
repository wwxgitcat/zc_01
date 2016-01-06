<div class="panel">
	<h1 class="panel-heading"><?php echo NAVBAR_TITLE_2;?></h1>
	<div class="panel-body">
		<form id="checkout_confirmation" name="checkout_confirmation" class="form-horizontal" method="post" action="<?php echo $form_action_url;?>" onsubmit="submitonce();">
			<?php display_message('redemptions');?>
			<?php display_message('checkout_confirmation');?>
			<?php display_message('checkout');?>
			<?php display_message('checkout_address');?>
			<?php display_message('checkout_payment');?>
			<?php echo zen_draw_hidden_field('securityToken', $_SESSION['securityToken']); ?>
			<?php if($COWOA) {?>
		    <div id="order_steps">
		
				<div class="order_steps_line_2">
					<span class="progressbar_active_COWOA">&nbsp;</span><span
						class="progressbar_active_COWOA">&nbsp;</span><span
						class="progressbar_active_COWOA">&nbsp;</span><span
						class="progressbar_active_COWOA">&nbsp;</span><span
						class="progressbar_inactive_COWOA">&nbsp;</span>
				</div>
			</div>
			<?php } else {?>
		    <div id="order_steps">
		
				<div class="order_steps_line_2">
					<span class="progressbar_active">&nbsp;</span><span
						class="progressbar_active">&nbsp;</span><span
						class="progressbar_active">&nbsp;</span><span
						class="progressbar_inactive">&nbsp;</span>
				</div>
			</div>
			<?php } ?>
			<!-- eof Order Steps (tableless) -->
			<div class="">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<h4 id="checkoutConfirmDefaultBillingAddress"><?php echo HEADING_BILLING_ADDRESS; ?></h4>
					<address><?php echo zen_address_format($order->billing['format_id'], $order->billing, 1, ' ', '<br />'); ?></address>
					<?php if (!$flagDisablePaymentAddressChange) { ?>
					<a class="btn btn-default" href="<?php echo zen_href_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS, '', 'SSL');?>"><?php echo BUTTON_EDIT_SMALL_ALT;?></a>
					<?php } ?>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<h4 id="checkoutConfirmDefaultShippingAddress"><?php echo HEADING_DELIVERY_ADDRESS; ?></h4>
					<address><?php echo zen_address_format($order->delivery['format_id'], $order->delivery, 1, ' ', '<br />'); ?></address>
					<a class="btn btn-default" href="<?php echo $editShippingButtonLink;?>"><?php echo BUTTON_EDIT_SMALL_ALT;?></a>
					
				</div>
			</div>
			
			<div class="">
				<div class="col-xs-12 col-sm-6 col-md-6 payment-method">
					<h4 id="checkoutConfirmDefaultPayment"><?php echo HEADING_PAYMENT_METHOD; ?></h4>
					<p id="checkoutConfirmDefaultPaymentTitle"><?php //echo $GLOBALS[$class]->title; ?></p>
					<?php if (SHOW_ACCEPTED_CREDIT_CARDS != '0'){?>
					<?php if (SHOW_ACCEPTED_CREDIT_CARDS == '1'){
						echo TEXT_ACCEPTED_CREDIT_CARDS . zen_get_cc_enabled();
					}
					if (SHOW_ACCEPTED_CREDIT_CARDS == '2'){
						echo TEXT_ACCEPTED_CREDIT_CARDS . zen_get_cc_enabled('IMAGE_');
					}?>
					<br class="clearBoth" />
					<?php } ?>
					
					<?php
					$selection = $payment_modules->selection();
					if (sizeof($selection) > 1){
					?>
						<p class="important"><strong><?php echo TEXT_SELECT_PAYMENT_METHOD; ?></strong></p>
					<?php }elseif (sizeof($selection) == 0){?>
						<p class="important"><strong><?php echo TEXT_NO_PAYMENT_OPTIONS_AVAILABLE; ?></strong></p>
					<?php }?>
					<div class="form">
					<?php $radio_buttons = 0;for($i = 0, $n = sizeof($selection); $i < $n; $i++){?>
						
						<div class="checkbox">
							<label for="pmt-<?php echo $selection[$i]['id']; ?>" class="radioButtonLabel">
								<?php if (sizeof($selection) > 1){?>
									<?php if (empty($selection[$i]['noradio'])){?>
										<?php echo zen_draw_radio_field('payment', $selection[$i]['id'], ($selection[$i]['id'] == $_SESSION['payment'] ? true : false), 'id="pmt-'.$selection[$i]['id'].'"'); ?>
									<?php } ?>
								<?php }else{?>
									<?php echo zen_draw_hidden_field('payment', $selection[$i]['id']); ?>
								<?php } ?>
								<?php echo $selection[$i]['module']; ?>
								
							</label>
							<?php if (defined('MODULE_ORDER_TOTAL_COD_STATUS') && MODULE_ORDER_TOTAL_COD_STATUS == 'true' and $selection[$i]['id'] == 'cod'){?>
							<div class="alert"><?php echo TEXT_INFO_COD_FEES; ?></div>
							<?php }else{// echo 'WRONG ' . $selection[$i]['id'];?>
							<?php }?>
							
							<?php if (isset($selection[$i]['error'])){?>
							<div><?php echo $selection[$i]['error']; ?></div>
							<?php }elseif (isset($selection[$i]['fields']) && is_array($selection[$i]['fields'])){?>
								<div class="ccinfo">
								<?php for($j = 0, $n2 = sizeof($selection[$i]['fields']); $j < $n2; $j++){?>
									<label <?php echo (isset($selection[$i]['fields'][$j]['tag']) ? 'for="'.$selection[$i]['fields'][$j]['tag'] . '" ' : ''); ?> class="inputLabelPayment">
										<?php echo $selection[$i]['fields'][$j]['title']; ?>
									</label>
									<?php echo $selection[$i]['fields'][$j]['field']; ?>
								<?php }?>
								</div>
							<?php } $radio_buttons++;?>
						</div>
						
					<?php }//end for?>
					</div>
					
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 shipping-method">
					<?php if (is_array($payment_modules->modules)){?>
						<?php if ($confirmation = $payment_modules->confirmation()){?>
							<div class="important"><?php echo $confirmation['title']; ?></div>
						<?php }?>
						<div class="important">
						<?php for($i = 0, $n = sizeof($confirmation['fields']); $i < $n; $i++){?>
							<div class="back">
								<?php echo $confirmation['fields'][$i]['title']; ?>
							</div>
							<div><?php echo $confirmation['fields'][$i]['field']; ?></div>
						<?php }?>
						</div>
					<?php }?>
					<div class="form">
					<?php if (zen_count_shipping_modules() > 0){?>
						<h4 id="checkoutShippingHeadingMethod"><?php echo HEADING_SHIPPING_METHOD; ?></h4>
						<?php if (sizeof($quotes) > 1 && sizeof($quotes[0]) > 1){?>
							<div id="checkoutShippingContentChoose" class="important"><?php echo TEXT_CHOOSE_SHIPPING_METHOD; ?></div>
						<?php }elseif ($free_shipping == false){?>
							<div id="checkoutShippingContentChoose" class="important"><?php echo TEXT_ENTER_SHIPPING_INFORMATION; ?></div>
						<?php }?>
						<?php if ($free_shipping == true){?>
							<div id="freeShip" class="important">
								<?php echo FREE_SHIPPING_TITLE; ?>&nbsp;<?php echo $quotes[$i]['icon']; ?>
							</div>
							<div id="defaultSelected">
								<?php echo sprintf(FREE_SHIPPING_DESCRIPTION, $currencies->format(MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER))
								.zen_draw_hidden_field('shipping', 'free_free'); ?>
							</div>
						<?php } else{$radio_buttons = 0;for($i = 0, $n = sizeof($quotes); $i < $n; $i++){?>
							<div class="checkbox clearfix">
							
							<?php if (isset($quotes[$i]['error'])){?>
								<div><?php echo $quotes[$i]['error']; ?></div>
							<?php } else {?>
								<?php for($j = 0, $n2 = sizeof($quotes[$i]['methods']); $j < $n2; $j++){// set the radio button to be checked if it is the method chosen
									$checked = (($quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'] == $_SESSION['shipping']['id']) ? true : false);
									if (($checked == true) || ($n == 1 && $n2 == 1)){
													// echo ' <div id="defaultSelected" class="moduleRowSelected">' . "\n";
													// } else {
													// echo ' <div class="moduleRow">' . "\n";
									}?>
									<label for="ship-<?php echo $quotes[$i]['id'] . '-' . $quotes[$i]['methods'][$j]['id']; ?>" class="checkboxLabel">
										<?php echo zen_draw_radio_field('shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'], $checked, 'id="ship-'.$quotes[$i]['id'] . '-' . $quotes[$i]['methods'][$j]['id'].'"'); ?>
										<?php echo $quotes[$i]['module']; ?>&nbsp;<?php if (isset($quotes[$i]['icon']) && zen_not_null($quotes[$i]['icon'])) { echo $quotes[$i]['icon']; } ?>
										<?php //echo $quotes[$i]['methods'][$j]['title']; ?>
										
										
									</label>
									<?php if (($n > 1) || ($n2 > 1)){?>
										<span class="important pull-right">
											<?php echo $currencies->format(zen_add_tax($quotes[$i]['methods'][$j]['cost'], (isset($quotes[$i]['tax']) ? $quotes[$i]['tax'] : 0))); ?>
										</span>
									<?php }else{?>
										<span class="important pull-right">
											<?php echo $currencies->format(zen_add_tax($quotes[$i]['methods'][$j]['cost'], $quotes[$i]['tax']))
											.zen_draw_hidden_field('shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id']); ?>
										</span>
									<?php }?>
									<!--</div>-->
								<?php $radio_buttons++; }?>
							<?php }//end if no error?>
							</div>
							
							
							<?php }//end for ?>
						<?php }//end if shipping ?>
						
					<?php }else{//single shipping method?>
						<h2 id="checkoutShippingHeadingMethod"><?php echo TITLE_NO_SHIPPING_AVAILABLE; ?></h2>
						<div id="checkoutShippingContentChoose" class="important"><?php echo TEXT_NO_SHIPPING_AVAILABLE; ?></div>
						
					<?php }//end shipping method?>
					</div>
				</div>
				
			</div><!-- row -->
			<?php /*
			<?php if ($order->info['comments']) {?>
			<div class="row">
				<h4 id="checkoutConfirmDefaultHeadingComments" class="page-title"><?php echo HEADING_ORDER_COMMENTS; ?></h4>
				<div class="buttonRow forward"><?php echo  '<a href="' . zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_EDIT_SMALL, BUTTON_EDIT_SMALL_ALT) . '</a>'; ?></div>
				<div><?php echo (empty($order->info['comments']) ? NO_COMMENTS_TEXT : nl2br(zen_output_string_protected($order->info['comments'])) . zen_draw_hidden_field('comments', $order->info['comments'])); ?></div>
			</div>
			<?php }//if comments?>
			*/?>
			
			<div class="">
				<h4 id="checkoutConfirmDefaultHeadingCart"><?php echo HEADING_PRODUCTS; ?></h4>
				<?php if ($flagAnyOutOfStock) { ?>
					<?php if (STOCK_ALLOW_CHECKOUT == 'true') {  ?>
						<div class="messageStackError"><?php echo OUT_OF_STOCK_CAN_CHECKOUT; ?></div>
					<?php } else { ?>
						<div class="messageStackError"><?php echo OUT_OF_STOCK_CANT_CHECKOUT; ?></div>
					<?php } //endif STOCK_ALLOW_CHECKOUT ?>
				<?php } //endif flagAnyOutOfStock ?>
				
				<table id="cartContentsDisplay"  class="table table-striped table-bordered table-hover">
					<tr class="cartTableHeading">
						<th id="ccQuantityHeading" width="50"><?php echo TABLE_HEADING_QUANTITY; ?></th>
						<th id="ccProductsHeading"><?php echo TABLE_HEADING_PRODUCTS; ?></th>
						<?php if (sizeof($order->info['tax_groups']) > 1)/*If there are tax groups, display the tax columns for price breakdown*/{?>
						<th id="ccTaxHeading"><?php echo HEADING_TAX; ?></th>
						<?php }?>
						<th id="ccTotalHeading"><?php echo TABLE_HEADING_TOTAL; ?></th>
					</tr>
					<?php // now loop thru all products to display quantity and price ?>
					<?php for ($i=0, $n=sizeof($order->products); $i<$n; $i++) { ?>
			        <tr class="<?php echo $order->products[$i]['rowClass']; ?>">
						<td class="cartQuantity"><?php echo $order->products[$i]['qty']; ?>&nbsp;x</td>
						<td class="cartProductDisplay">
							<?php echo $order->products[$i]['name']; ?>
							<?php  echo $stock_check[$i]; ?>
							<?php if (isset($order->products[$i]['attributes']) && sizeof($order->products[$i]['attributes']) > 0)
							/*if there are attributes, loop thru them and display one per line*/{?>
							<ul class="cartAttribsList">
								<?php for($j = 0, $n2 = sizeof($order->products[$i]['attributes']); $j < $n2; $j++){?>
		      					<li><?php echo '' . ' ' . nl2br($order->products[$i]['attributes'][$j]['value']); ?></li>
								<?php } // end loop ?>
							</ul>
							<?php } // endif attribute-info	?>
						</td>
		
						<?php // display tax info if exists ?>
						<?php if (sizeof($order->info['tax_groups']) > 1)  { ?>
		        		<td class="cartTotalDisplay">
							<?php echo zen_display_tax_value($order->products[$i]['tax']); ?>%
						</td>
						<?php }  // endif tax info display  ?>
		        		<td class="cartTotalDisplay">
		   					<?php echo $currencies->display_price($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']);?>
		   					<?php if ($order->products[$i]['onetime_charges'] != 0)
		   						echo '<br /> ' . $currencies->display_price($order->products[$i]['onetime_charges'], $order->products[$i]['tax'], 1);
		   					?>
						</td>
					</tr>
					<?php }  // end for loopthru all products ?>
				</table>
				<?php if (MODULE_ORDER_TOTAL_INSTALLED){$order_totals = $order_total_modules->process();?>
					<div id="orderTotals"><?php $order_total_modules->output(); ?></div>
				<?php }?>
				<?php
if (is_array($payment_modules->modules))
{
	//echo $payment_modules->process_button();
}
?>
				<div class="form-inline">
					<a class="btn btn-default pull-right" href="<?php echo zen_href_link(FILENAME_SHOPPING_CART, '', 'SSL');?>"><?php echo BUTTON_EDIT_SMALL_ALT;?></a>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<br/><div class="form-inline">
						<input type="submit" name="btn_submit" id="btn_submit" class="btn btn-warning pull-right" value="<?php echo BUTTON_CONFIRM_ORDER_ALT;?>"/>
						<div><?php echo TITLE_CONTINUE_CHECKOUT_PROCEDURE . '<br />' . TEXT_CONTINUE_CHECKOUT_PROCEDURE; ?></div>
					</div>
				</div>
			</div>
			
		</form>
	</div>
</div>


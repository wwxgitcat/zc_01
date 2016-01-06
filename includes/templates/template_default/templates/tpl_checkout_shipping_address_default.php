<div class="panel">
	<h1 id="checkoutShipAddressDefaultHeading" class="panel-heading"><?php echo HEADING_TITLE; ?></h1>
	<div class="panel-body page-content">
		<form id="checkout_address" name="checkout_address" class="form-horizontal" method="post" action="<?php echo zen_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, '', 'SSL');?>" onsubmit="return check_form_optional(checkout_address);">
			<?php display_tpl('checkout_address');?>
			<?php echo zen_draw_hidden_field('securityToken', $_SESSION['securityToken']); ?>
			<?php if ($process == false || $error == true){?>
				<h3 id="checkoutShipAddressDefaultAddress"><?php echo TITLE_SHIPPING_ADDRESS; ?></h3>
				<address><?php echo zen_address_label($_SESSION['customer_id'], $_SESSION['sendto'], true, ' ', '<br />'); ?></address>
				<?php if ($addresses_count < MAX_ADDRESS_BOOK_ENTRIES){?>
					<?php require (display_tpl('tpl_modules_checkout_new_address'));?>
				<?php }?>
				
				<?php if ($addresses_count > 1){?>
				<div class="">
					<h2 class="panel-title"><?php echo TABLE_HEADING_ADDRESS_BOOK_ENTRIES; ?></h2>
					<?php require(display_tpl('tpl_modules_checkout_address_book'));?>
				</div>
				<?php }?>
				
				<div class="">
					<div class="form-inline">
						<?php echo zen_draw_hidden_field('action', 'submit');?>
						
						<?php if ($process == true){?>
						<a class="btn btn-default" href="<?php echo zen_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, '', 'SSL');?>"><?php echo BUTTON_BACK_ALT;?></a>
						<?php }?>
						
						<input type="submit" class="btn btn-warning" value="<?php echo BUTTON_CONTINUE_ALT;?>"/>
						<div>
							<?php echo TITLE_CONTINUE_CHECKOUT_PROCEDURE . '<br />' . TEXT_CONTINUE_CHECKOUT_PROCEDURE; ?>
						</div>
					</div>
					
					
				</div>
			<?php }?>
		</form>
		
	</div>
</div>
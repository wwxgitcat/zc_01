<div class="panel">
	<h1 class="panel-heading"><?php echo HEADING_TITLE; ?></h1>
	<div class="panel-body page-content">
		<form id="checkout_address" name="checkout_address" class="form-horizontal" method="post" action="<?php echo zen_href_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS, '', 'SSL');?>" onsubmit="return check_form_optional(checkout_address);">
			<?php display_message('checkout_address');?>
			<?php echo zen_draw_hidden_field('securityToken', $_SESSION['securityToken']); ?>
			
			<h3 id="checkoutPayAddressDefaultAddress"><?php echo TITLE_PAYMENT_ADDRESS; ?></h3>
			<address><?php echo zen_address_label($_SESSION['customer_id'], $_SESSION['billto'], true, ' ', '<br />'); ?></address>
			<div class="instructions"><?php echo TEXT_SELECTED_PAYMENT_DESTINATION; ?></div>
			
			<div class="">
			<?php if ($addresses_count < MAX_ADDRESS_BOOK_ENTRIES){?>
				<?php require(display_tpl('tpl_modules_checkout_new_address'));?>
			<?php }?>
			</div>
			
			<?php if ($addresses_count > 1){?>
			<div class="">
				<h2 class="panel-title"><?php echo TABLE_HEADING_NEW_PAYMENT_ADDRESS; ?></h2>
				<?php require(display_tpl('tpl_modules_checkout_address_book'));?>
			</div>
			<?php }?>
			
			<div class="">
				<div class="form-inline">
					<?php echo zen_draw_hidden_field('action', 'submit');?>
					
					<?php if ($process == true){?>
					<a class="btn btn-default" href="<?php echo zen_href_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS, '', 'SSL');?>"><?php echo BUTTON_BACK_ALT;?></a>
					<?php }?>
					
					<input type="submit" class="btn btn-default" value="<?php echo BUTTON_CONTINUE_ALT;?>"/>
					<div>
						<?php echo TITLE_CONTINUE_CHECKOUT_PROCEDURE . '<br />' . TEXT_CONTINUE_CHECKOUT_PROCEDURE; ?>
					</div>
				</div>
				
				
			</div>
			
		</form>
	</div>
</div>

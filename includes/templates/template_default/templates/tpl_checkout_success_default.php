<div class="panel">
	<h1 class="panel-heading"><?php echo HEADING_TITLE; ?></h1>
	<div class="panel-body page-content">
		<?php if ($customer_has_gv_balance){?>
		<div id="sendSpendWrapper">
		<?php require(display_tpl('tpl_modules_send_or_spend')); ?>
		</div>
		<?php }?>
		<!--eof -gift certificate- send or spend box-->
		
		<div id="checkoutSuccessOrderNumber"><?php echo TEXT_YOUR_ORDER_NUMBER . $zv_orders_id; ?></div>
		<?php if (DEFINE_CHECKOUT_SUCCESS_STATUS >= 1 and DEFINE_CHECKOUT_SUCCESS_STATUS <= 2) { ?>
			<?php require ($define_page);?>
		<?php }?>
		
		<!-- bof payment-method-alerts -->
		<?php if (isset($_SESSION['payment_method_messages']) && $_SESSION['payment_method_messages'] != ''){?>
			<div class="content">
			<?php echo $_SESSION['payment_method_messages']; ?>
			</div>
		<?php }?>
		<!-- eof payment-method-alerts -->
		
		<!--bof logoff-->
	<div id="checkoutSuccessLogoff">
<?php if (isset($_SESSION['customer_guest_id'])){
	echo TEXT_CHECKOUT_LOGOFF_GUEST;
}
elseif (isset($_SESSION['customer_id']))
{
	echo TEXT_CHECKOUT_LOGOFF_CUSTOMER;
}
?>
<div class="buttonRow forward">
			<a class="btn btn-default" href="<?php echo zen_href_link(FILENAME_LOGOFF, '', 'SSL'); ?>"><?php echo BUTTON_LOG_OFF_ALT; ?></a>
		</div>
	</div>
	<!--eof logoff-->
	
	<?php

if ($flag_show_products_notification == true)
{
	?>
<fieldset id="csNotifications">
		<legend><?php echo TEXT_NOTIFY_PRODUCTS; ?></legend>
<?php echo zen_draw_form('order', zen_href_link(FILENAME_CHECKOUT_SUCCESS, 'action=update', 'SSL')); ?>

<?php foreach ($notificationsArray as $notifications) { ?>
<?php echo zen_draw_checkbox_field('notify[]', $notifications['products_id'], true, 'id="notify-' . $notifications['counter'] . '"') ;?>
<label class="checkboxLabel"
			for="<?php echo 'notify-' . $notifications['counter']; ?>"><?php echo $notifications['products_name']; ?></label>
		<br />
<?php } ?>
<div class="buttonRow forward"><?php echo zen_image_submit(BUTTON_IMAGE_UPDATE, BUTTON_UPDATE_ALT); ?></div>
		</form>
	</fieldset>
<?php
}
?>
<!--eof -product notifications box-->
		<!--bof -product downloads module-->
<?php
if (DOWNLOAD_ENABLED == 'true') require ($template->get_template_dir('tpl_modules_downloads.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_downloads.php');
?>
<!--eof -product downloads module-->

	<div id="checkoutSuccessOrderLink"><?php echo TEXT_SEE_ORDERS;?></div>

	<div id="checkoutSuccessContactLink"><?php echo TEXT_CONTACT_STORE_OWNER;?></div>

	<h3 id="checkoutSuccessThanks" class="centeredContent"><?php echo TEXT_THANKS_FOR_SHOPPING; ?></h3>
	</div>
</div>


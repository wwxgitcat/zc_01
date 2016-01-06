<div class="panel">
	<h1 class="panel-heading"><?php echo HEADING_ORDER_DATE . ' ' . zen_date_long($order->info['date_purchased']); ?></h1>
	<div class="panel-body page-content">
		<table class="table table-striped table-bordered">
			<caption>
				<h2 id="orderHistoryDetailedOrder"><?php echo HEADING_TITLE . ORDER_HEADING_DIVIDER . sprintf(HEADING_ORDER_NUMBER, $_GET['order_id']); ?></h2>
			</caption>
			<tr class="tableHeading">
				<th id="myAccountQuantity"><?php echo HEADING_QUANTITY; ?></th>
				<th id="myAccountProducts"><?php echo HEADING_PRODUCTS; ?></th>
				<?php if (sizeof($order->info['tax_groups']) > 1){?>
				<th id="myAccountTax"><?php echo HEADING_TAX; ?></th>
				<?php } ?>
	        	<th id="myAccountTotal"><?php echo HEADING_TOTAL; ?></th>
			</tr>
			<?php for($i = 0, $n = sizeof($order->products); $i < $n; $i++){?>
			<tr>
				<td class="accountQuantityDisplay"><?php echo  $order->products[$i]['qty'] . QUANTITY_SUFFIX; ?></td>
				<td class="accountProductDisplay">
					<?php echo $order->products[$i]['name'];?>
					<?php if ((isset($order->products[$i]['attributes'])) && (sizeof($order->products[$i]['attributes']) > 0)){?>
						<ul id="orderAttribsList attrs">
						<?php for($j = 0, $n2 = sizeof($order->products[$i]['attributes']); $j < $n2; $j++){?>
						<li><?php echo $order->products[$i]['attributes'][$j]['option'] . TEXT_OPTION_DIVIDER . nl2br(zen_output_string_protected($order->products[$i]['attributes'][$j]['value']));?></li>
						<?php }//for?>
						</ul>
					<?php }	?>
	        	</td>
				<?php if (sizeof($order->info['tax_groups']) > 1){?>
				<td class="accountTaxDisplay"><?php echo zen_display_tax_value($order->products[$i]['tax']) . '%' ?></td>
				<?php }?>
	        	<td class="accountTotalDisplay"><?php echo $currencies->format(zen_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax']) * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . ($order->products[$i]['onetime_charges'] != 0 ? '<br />' . $currencies->format(zen_add_tax($order->products[$i]['onetime_charges'], $order->products[$i]['tax']), true, $order->info['currency'], $order->info['currency_value']) : '') ?></td>
			</tr>
		<?php }?>
		</table>

		<div id="orderTotals">
			<table class="table table-bordered">
				<?php for($i = 0, $n = sizeof($order->totals); $i < $n; $i++){?>
				<tr>
					<td style="text-align: right;"><?php echo $order->totals[$i]['title'] ?></td>
					<td><?php echo $order->totals[$i]['text'] ?></td>
				</tr>
				<?php }?>
			</table>
		</div>
		<?php
/**
 * Used to display any downloads associated with the cutomers account
 */
if (DOWNLOAD_ENABLED == 'true') require ($template->get_template_dir('tpl_modules_downloads.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_downloads.php');
?>

		<?php if (sizeof($statusArray)){//Used to loop thru and display order status information?>
		<table id="myAccountOrdersStatus" class="table table-striped table-bordered" >
			<caption>
				<h4 id="orderHistoryStatus"><?php echo HEADING_ORDER_HISTORY; ?></h4>
			</caption>
			<tr class="tableHeading">
				<th id="myAccountStatusDate"><?php echo TABLE_HEADING_STATUS_DATE; ?></th>
				<th id="myAccountStatus"><?php echo TABLE_HEADING_STATUS_ORDER_STATUS; ?></th>
				<th id="myAccountStatusComments"><?php echo TABLE_HEADING_STATUS_COMMENTS; ?></th>
			</tr>
			<?php foreach($statusArray as $statuses){?>
	    	<tr>
				<td><?php echo zen_date_short($statuses['date_added']); ?></td>
				<td><?php echo $statuses['orders_status_name']; ?></td>
				<td><?php echo (empty($statuses['comments']) ? '&nbsp;' : nl2br(zen_output_string_protected($statuses['comments']))); ?></td>
			</tr>
			<?php }?>
		</table>
		<?php } ?>
		
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6">
				<?php if (zen_not_null($order->info['shipping_method'])){?>
					<div class="block">
						<h4 class="block-title"><?php echo HEADING_SHIPPING_METHOD; ?></h4>
						<div class="block-cnt"><?php echo $order->info['shipping_method']; ?></div>
					</div>
				<?php }else{?>
					<div class="block">
						<h4 class="block-title"><?php echo HEADING_SHIPPING_METHOD; ?></h4>
						<div class="block-cnt">WARNING: Missing Shipping Information</div>
					</div>
				<?php }?>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6">
				<div class="block">
					<h4 class="block-title"><?php echo HEADING_PAYMENT_METHOD; ?></h4>
					<div class="block-cnt"><?php echo $order->info['payment_method']; ?></div>
				</div>
			</div>
		</div>
		<div class="row"></div>
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6">
				<?php if ($order->delivery != false){?>
					<div class="block">
						<h4 class="block-title"><?php echo HEADING_DELIVERY_ADDRESS; ?></h4>
						<div class="block-cnt">
							<address><?php echo zen_address_format($order->delivery['format_id'], $order->delivery, 1, ' ', '<br />'); ?></address>
						</div>
					</div>
					
				<?php }?>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6">
				<div class="block">
					<h4 class="block-title"><?php echo HEADING_BILLING_ADDRESS; ?></h4>
					<div class="block-cnt">
						<address><?php echo zen_address_format($order->billing['format_id'], $order->billing, 1, ' ', '<br />'); ?></address>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>



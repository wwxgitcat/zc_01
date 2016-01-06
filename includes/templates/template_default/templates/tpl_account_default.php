<div class="panel">
	<h1 class="panel-heading"><?php echo HEADING_TITLE; ?></h1>
	<div class="panel-body page-content">
		<?php display_message('account');?>
		<?php if (zen_count_customer_orders() > 0){?>
			<p>
				<a href="<?php echo zlink(FILENAME_ACCOUNT_HISTORY, '', 'SSL');?>"><?php echo OVERVIEW_SHOW_ALL_ORDERS;?></a>
			</p>
		<?php }?>
		<?php if (zen_count_customer_orders() > 0){?>
		<table id="prevOrders" class="table table-striped table-bordered">
			<caption>
				<h2><?php echo OVERVIEW_PREVIOUS_ORDERS; ?></h2>
			</caption>
			<tr class="tableHeading">
				<th><?php echo TABLE_HEADING_DATE; ?></th>
				<th><?php echo TABLE_HEADING_ORDER_NUMBER; ?></th>
				<th><?php echo TABLE_HEADING_SHIPPED_TO; ?></th>
				<th><?php echo TABLE_HEADING_STATUS; ?></th>
				<th><?php echo TABLE_HEADING_TOTAL; ?></th>
				<th><?php echo TABLE_HEADING_VIEW; ?></th>
			</tr>
			<?php foreach($ordersArray as $orders){?>
			<tr>
				<td><?php echo zen_date_short($orders['date_purchased']); ?></td>
				<td><?php echo TEXT_NUMBER_SYMBOL . $orders['orders_id']; ?></td>
				<td><address><?php echo zen_output_string_protected($orders['order_name']) . '<br />' . $orders['order_country']; ?></address></td>
				<td><?php echo $orders['orders_status_name']; ?></td>
				<td align="right"><?php echo $orders['order_total']; ?></td>
				<td align="right">
					<a class="btn btn-default" href="<?php echo zlink(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $orders['orders_id'], 'SSL');?>">
						<?php echo BUTTON_VIEW_SMALL_ALT;?>
					</a>
				</td>
			</tr>
			<?php }?>
		</table>
		<?php }?>
		
	</div>
</div>

<div class="panel">
	<h3 class="panel-heading"><?php echo MY_ACCOUNT_TITLE; ?></h3>
	<div class="panel-body page-content">
		<ul class="account-list">
			<li><a href="<?php echo zlink(FILENAME_ACCOUNT_EDIT, '', 'SSL');?>"><?php echo MY_ACCOUNT_INFORMATION;?></a></li>
			<li><a href="<?php echo zlink(FILENAME_ADDRESS_BOOK, '', 'SSL');?>"><?php echo MY_ACCOUNT_ADDRESS_BOOK;?></a></li>
			<li><a href="<?php echo zlink(FILENAME_ACCOUNT_PASSWORD, '', 'SSL');?>"><?php echo MY_ACCOUNT_PASSWORD;?></a></li>
		</ul>
		
	</div>
</div>
<?php if (SHOW_NEWSLETTER_UNSUBSCRIBE_LINK != 'false' or CUSTOMERS_PRODUCTS_NOTIFICATION_STATUS != '0'){?>
<div class="panel">
	<h3 class="panel-heading"><?php echo EMAIL_NOTIFICATIONS_TITLE; ?></h3>
	<div class="panel-body page-content">
		<ul class="account-list">
			<?php if (SHOW_NEWSLETTER_UNSUBSCRIBE_LINK == 'true'){?>
			<li><a href="<?php echo zlink(FILENAME_ACCOUNT_NEWSLETTERS, '', 'SSL');?>"><?php echo EMAIL_NOTIFICATIONS_NEWSLETTERS;?></a></li>
			<?php }?>
			<?php if (CUSTOMERS_PRODUCTS_NOTIFICATION_STATUS == '1'){?>
			<li><a href="<?php echo zlink(FILENAME_ACCOUNT_NOTIFICATIONS, '', 'SSL');?>"><?php echo EMAIL_NOTIFICATIONS_PRODUCTS;?></a></li>
			<?php }?>
			<?php if (CUSTOMERS_PRODUCTS_NOTIFICATION_STATUS == '1'){?>
			<li><a href="<?php echo zlink(FILENAME_ACCOUNT_NOTIFICATIONS, '', 'SSL');?>"><?php echo EMAIL_NOTIFICATIONS_PRODUCTS;?></a></li>
			<?php }?>
		</ul>
		
	</div>
</div>
<?php }?>

<?php if ($customer_has_gv_balance){// only show when there is a GV balance?>
<?php require(display_tpl('tpl_modules_send_or_spend')); ?>

<?php }?>
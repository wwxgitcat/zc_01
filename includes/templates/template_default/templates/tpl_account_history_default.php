<?php if ($accountHasHistory === true){?>
<div class="panel">
	<h1 class="panel-heading"><?php echo HEADING_TITLE; ?></h1>
	<div class="panel-body">
		<table id="prevOrders" class="table table-striped table-bordered">
			<tr class="tableHeading">
				<th><?php echo TEXT_ORDER_DATE; ?></th>
				<th><?php echo TEXT_ORDER_NUMBER; ?></th>
				<th><?php echo HEADING_ADDRESS_INFORMATION;?></th>
				<th><?php echo TEXT_ORDER_STATUS; ?></th>
				<th><?php echo TEXT_ORDER_PRODUCTS;?></th>
				<th><?php echo TABLE_HEADING_TOTAL; ?></th>
				<th></th>
			</tr>
			<?php foreach($accountHistory as $orders){?>
			<tr>
				<td><?php echo zen_date_short($orders['date_purchased']); ?></td>
				<td><?php echo TEXT_NUMBER_SYMBOL . $orders['orders_id']; ?></td>
				<td><?php echo $orders['order_type'];?><address><?php echo zen_output_string_protected($orders['order_name']) . '<br />' . $orders['order_country']; ?></address></td>
				<td><?php echo $orders['orders_status_name']; ?></td>
				<td><?php echo $orders['product_count'];?></td>
				<td><?php echo $orders['order_total']; ?></td>
				<td align="right">
					<a class="btn btn-default" href="<?php echo zlink(FILENAME_ACCOUNT_HISTORY_INFO, (isset($_GET['page']) ? 'page=' . $_GET['page'] . '&' : '').'order_id=' . $orders['orders_id'], 'SSL');?>">
						<?php echo BUTTON_VIEW_SMALL_ALT;?>
					</a>
				</td>
			</tr>
			<?php }?>
		</table>
		
		<div class="pagination clearfix">
			<div id="productsListingTopNumber" class="pagination-info pull-left">
				<?php echo $history_split->display_count(TEXT_DISPLAY_NUMBER_OF_ORDERS); ?>
			</div>
			<div id="productsListingListingTopLinks" class="pagination-items pull-right">
				<?php echo TEXT_RESULT_PAGE . ' ' . $history_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))); ?>
			</div>
		</div>
		
	</div>
</div>
<?php }else{?>
<div class="panel">
	<h1 class="panel-heading"><?php echo HEADING_TITLE; ?></h1>
	<div class="panel-body">
		
		<p><?php echo TEXT_NO_PURCHASES; ?></p>
	</div>
</div>

<?php }?>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12">
		<a class="btn btn-default" href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL');?>"><?php echo BUTTON_BACK_ALT;?></a>
	</div>
</div>



<div class="panel">
	<h1 class="panel-heading"><?php echo HEADING_TITLE; ?></h1>
	<div class="panel-body page-content">
		<?php display_message('addressbook');?>
		<h3 id="addressBookDefaultPrimary" class="panel-title"><?php echo PRIMARY_ADDRESS_TITLE; ?></h3>
		<address><?php echo zen_address_label($_SESSION['customer_id'], $_SESSION['customer_default_address_id'], true, ' ', '<br />'); ?></address>
		<p class="instructions">
			<?php echo PRIMARY_ADDRESS_DESCRIPTION; ?>
		</p>
		<h4 class="panel-title"><?php echo ADDRESS_BOOK_TITLE;?></h4>
		<div>
			<i><?php echo sprintf(TEXT_MAXIMUM_ENTRIES, MAX_ADDRESS_BOOK_ENTRIES); ?></i>
		</div>
		
		<div class="row">
		<?php foreach($addressArray as $addresses){//Used to loop thru and display address book entries?>
		<div class="col-xs-12 col-sm-6 col-md-6">
			<h4>
				<?php echo zen_output_string_protected($addresses['firstname'] . ' ' . $addresses['lastname']); ?>
				<?php if ($addresses['address_book_id'] == $_SESSION['customer_default_address_id']) echo '&nbsp;' . PRIMARY_ADDRESS ; ?>
			</h4>
			<address><?php echo zen_address_format($addresses['format_id'], $addresses['address'], true, ' ', '<br />'); ?></address>
			<div class="form-inline">
				<div class="form-group">
					<a class="btn btn-default" href="<?php echo zen_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'edit=' . $addresses['address_book_id'], 'SSL');?>"><?php echo BUTTON_EDIT_SMALL_ALT;?></a>
					<a class="btn btn-default" href="<?php echo zen_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'delete=' . $addresses['address_book_id'], 'SSL');?>"><?php echo BUTTON_DELETE_SMALL_ALT;?></a>
				</div>
			</div>
		</div>
		<?php }//end foreach?>
		</div>
		
		<div class="row box">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<a class="btn btn-default" href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL');?>"><?php echo BUTTON_BACK_ALT;?></a>
				<?php if (zen_count_customer_address_book_entries() < MAX_ADDRESS_BOOK_ENTRIES){?>
				<a class="btn btn-default" href="<?php echo zen_href_link(FILENAME_ADDRESS_BOOK_PROCESS, '', 'SSL');?>"><?php echo BUTTON_ADD_ADDRESS_ALT;?></a>
				<?php }?>
			</div>
		</div>
	</div>
</div>

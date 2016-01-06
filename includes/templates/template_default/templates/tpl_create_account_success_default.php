<div class="panel">
	<h1 class="panel-heading"><?php echo HEADING_TITLE; ?></h1>
	<div class="panel-body">
		<div id="createAcctSuccessMainContent" class="content"><?php echo TEXT_ACCOUNT_CREATED; ?></div>
		<div class="panel-title"><?php echo PRIMARY_ADDRESS_TITLE; ?></div>
		
		<div class="row">
		<?php foreach($addressArray as $addresses){?>
			<div class="col-xs-6 col-sm-6 col-md-6">
				<h3 class="addressBookDefaultName"><?php echo zen_output_string_protected($addresses['firstname'] . ' ' . $addresses['lastname']); ?></h3>
				<address><?php echo zen_address_format($addresses['format_id'], $addresses['address'], true, ' ', '<br />'); ?></address>
				<div class="form-inline">
					<a class="btn btn-default" href="<?php echo zen_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'edit=' . $addresses['address_book_id'], 'SSL');?>"><?php echo BUTTON_EDIT_SMALL_ALT;?></a>
					<a class="btn btn-default" href="<?php echo zen_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'delete=' . $addresses['address_book_id'], 'SSL');?>"><?php echo BUTTON_DELETE_ALT;?></a>
				</div>
		<?php }?>
			</div>
			
		</div>
		<div class="form-inline">
			<a class="btn btn-default" href="<?php echo $origin_href;?>"><?php echo BUTTON_CONTINUE_ALT;?></a>
		</div>
	</div>
</div>

<div class="panel">
	<h1 class="panel-heading">
		<?php if (isset($_GET['edit'])) {
			echo HEADING_TITLE_MODIFY_ENTRY;
		} elseif (isset($_GET['delete'])) {
			echo HEADING_TITLE_DELETE_ENTRY;
		} else { echo HEADING_TITLE_ADD_ENTRY; }
		?>
	</h1>
	<div class="panel-body page-content">
		<?php display_message('addressbook');?>
		<form id="addressbook" name="addressbook" method="post" class="form-horizontal" onsubmit="return check_form(addressbook);" action="<?php echo zlink(FILENAME_ADDRESS_BOOK_PROCESS, (isset($_GET['edit']) ? 'edit=' . $_GET['edit'] : ''), 'SSL');?>">
			<?php echo zen_draw_hidden_field('securityToken', $_SESSION['securityToken']); ?>
			<?php if (isset($_GET['delete'])){?>
			
				<h6><?php echo DELETE_ADDRESS_DESCRIPTION; ?></h6>
				<address><?php echo zen_address_label($_SESSION['customer_id'], $_GET['delete'], true, ' ', '<br />'); ?></address>
				<div class="">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div>
							<div class="form-group">
								<a class="btn btn-default" href="<?php echo zlink(FILENAME_ADDRESS_BOOK_PROCESS, 'delete=' . $_GET['delete'] . '&action=deleteconfirm', 'SSL');?>"><?php echo BUTTON_DELETE_ALT;?></a>
								<a class="btn btn-default" href="<?php echo zlink(FILENAME_ADDRESS_BOOK, '', 'SSL');?>"><?php echo BUTTON_BACK_ALT;?></a>
							</div>
						</div>
					</div>
				</div>
				
			<?php }else{?>
				<?php //Used to display address book entry form?>
				<?php require(display_tpl('tpl_modules_address_book_details'));?>
				<div class="">
					<div class="form-group">
						<label class="col-xs-12 col-sm-4 col-md-3 control-label">
							
						</label>
						<div class="col-xs-12 col-sm-8 col-md-9">
							<div class="form-group address_change">
								<?php if (isset($_GET['edit']) && is_numeric($_GET['edit'])){?>
									<?php echo zen_draw_hidden_field('action', 'update') . zen_draw_hidden_field('edit', $_GET['edit']);?>
									<a class="btn btn-default address_change" href="<?php echo zlink(FILENAME_ADDRESS_BOOK, '', 'SSL');?>"><?php echo BUTTON_BACK_ALT;?></a>
									<input type="submit" class="btn btn-default" value="<?php echo BUTTON_UPDATE_ALT;?>"/>
								<?php }else{?>
									<?php echo zen_draw_hidden_field('action', 'process');?>
									<a class="btn btn-default" href="<?php echo zen_back_link(true);?>"><?php echo BUTTON_BACK_ALT;?></a>
									<input type="submit" class="btn btn-default" value="<?php echo BUTTON_SUBMIT_ALT;?>"/>
								<?php }?>

							</div>
						</div>
					</div>
				</div>
				
			<?php }?>
		</form>
		
	</div>
</div>



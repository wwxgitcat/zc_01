<div class="panel">
	<h1 class="panel-heading"><?php echo HEADING_TITLE; ?></h1>
	<div class="panel-body page-content">
		<form id="contact_us" name="contact_us" class="form-horizontal" method="post" action="<?php echo zen_href_link(FILENAME_CONTACT_US, 'action=send');?>">
			<?php echo zen_draw_hidden_field('securityToken', $_SESSION['securityToken']); ?>
			<?php display_message('contact');?>
			<?php if (CONTACT_US_STORE_NAME_ADDRESS== '1') { ?>
			
			<?php } ?>
			<?php if (isset($_GET['action']) && ($_GET['action'] == 'success')){?>
				<div class="bg-success mainContent success"><?php echo TEXT_SUCCESS; ?></div>
				<a class="btn btn-default" href="<?php echo zen_back_link(true);?>"><?php echo BUTTON_BACK_ALT;?></a>
			<?php }else{?>
				<?php if (DEFINE_CONTACT_US_STATUS >= '1' and DEFINE_CONTACT_US_STATUS <= '2') { ?>
					<div class="">
						<?php require ($define_page);?>
					</div>
				<?php }//show define html content?>
				<div><em class="required"><?php echo FORM_REQUIRED_INFORMATION; ?></em></div>
				<?php if (CONTACT_US_LIST != ''){// show dropdown if set?>
				<div class="form-group">
					<label for="send_to" class="col-xs-12 col-sm-4 col-md-3 control-label"><?php echo SEND_TO_TEXT; ?>
						<span class="required"><?php echo ENTRY_REQUIRED_SYMBOL;?></span>
					</label>
					<div class="col-xs-12 col-sm-8 col-md-9">
						<?php echo zen_draw_pull_down_menu('send_to',  $send_to_array, 0, 'id="send-to" class="form-control"');?>
					</div>
				</div>
				<?php }?>
				<div class="form-group">
					<label for="contactname" class="col-xs-12 col-sm-4 col-md-3 control-label"><?php echo ENTRY_NAME; ?>
						<span class="required"><?php echo ENTRY_REQUIRED_SYMBOL;?></span>
					</label>
					<div class="col-xs-12 col-sm-8 col-md-9">
						<?php echo zen_draw_input_field('contactname', $name, ' size="40" id="contactname" class="form-control"');?>
					</div>
				</div>
				<div class="form-group">
					<label for="email-address" class="col-xs-12 col-sm-4 col-md-3 control-label"><?php echo ENTRY_EMAIL; ?>
						<span class="required"><?php echo ENTRY_REQUIRED_SYMBOL;?></span>
					</label>
					<div class="col-xs-12 col-sm-8 col-md-9">
						<?php echo zen_draw_input_field('email', ($email_address), ' size="40" id="email-address" class="form-control"');?>
					</div>
				</div>
				<div class="form-group">
					<label for="enquiry" class="col-xs-12 col-sm-4 col-md-3 control-label"><?php echo ENTRY_ENQUIRY; ?>
						<span class="required"><?php echo ENTRY_REQUIRED_SYMBOL;?></span>
					</label>
					<div class="col-xs-12 col-sm-8 col-md-9">
						<?php echo zen_draw_textarea_field('enquiry', '30', '7', $enquiry, 'id="enquiry" class="form-control"'); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="enquiry" class="col-xs-12 col-sm-4 col-md-3 control-label">
					</label>
					<div class="col-xs-12 col-sm-8 col-md-9">
						<a class="btn btn-default" href="<?php echo zen_back_link(true);?>"><?php echo BUTTON_BACK_ALT;?></a>
						<input type="submit" class="btn btn-default" value="<?php echo BUTTON_SEND_ALT;?>"/>
					</div>
				</div>
			<?php }?>
		</form>
	</div>
</div>

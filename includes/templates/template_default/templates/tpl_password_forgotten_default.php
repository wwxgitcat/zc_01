<div class="panel">
	<h1 class="panel-heading"><?php echo HEADING_TITLE; ?></h1>
	<div class="panel-body page-content">
		<?php display_message('password_forgotten');?>
		<form id="password_forgotten" name="password_forgotten" class="form-horizontal" method="post" action="<?php echo zen_href_link(FILENAME_PASSWORD_FORGOTTEN, 'action=process', 'SSL');?>">
			<?php echo zen_draw_hidden_field('securityToken', $_SESSION['securityToken']); ?>
			<div id="passwordForgottenMainContent" class="content"><?php echo TEXT_MAIN; ?></div>
			<div><em class="required"><?php echo FORM_REQUIRED_INFORMATION; ?></em></div>
			<div class="form-group">
				<label for="email_address" class="col-xs-12 col-sm-4 col-md-3 control-label"><?php echo ENTRY_EMAIL_ADDRESS; ?>
					<?php if (zen_not_null(ENTRY_EMAIL_ADDRESS_TEXT)){?><span class="required"><?php echo ENTRY_EMAIL_ADDRESS_TEXT;?></span><?php }?>
				</label>
				<div class="col-xs-12 col-sm-8 col-md-9">
					<?php echo zen_draw_input_field('email_address', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_email_address', '40') . ' id="email-address" class="form-control"');?>
					
				</div>
			</div>
			
			<div class="form-group">
				<label for="email_address" class="col-xs-12 col-sm-4 col-md-3 control-label">
				</label>
				<div class="col-xs-12 col-sm-8 col-md-9">
					<a class="btn btn-default" href="<?php echo zen_back_link(true);?>"><?php echo BUTTON_BACK_ALT;?></a>
					<input type="submit" class="btn btn-default" value="<?php echo BUTTON_SUBMIT_ALT;?>"/>
				</div>
			</div>
		</form>
		
	</div>
</div>

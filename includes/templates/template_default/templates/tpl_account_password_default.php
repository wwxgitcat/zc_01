<div class="panel">
	<h1 class="panel-heading"><?php echo HEADING_TITLE; ?></h1>
	<div class="pnael-body page-content">
		<form id="account_password" name="account_password" class="form-horizontal" method="post" action="<?php echo zen_href_link(FILENAME_ACCOUNT_PASSWORD, '', 'SSL');?>" onsubmit="return check_form(account_password);">
			<?php echo zen_draw_hidden_field('action', 'process');?>
			<?php echo zen_draw_hidden_field('securityToken', $_SESSION['securityToken']); ?>
			<?php display_message('account_password');?>
			<div><i class="required"><?php echo FORM_REQUIRED_INFORMATION; ?></i></div>
			
			<div class="form-group">
				<label for="password-current" class="col-xs-12 col-sm-4 col-md-3 control-label"><?php echo ENTRY_PASSWORD_CURRENT; ?>
					<?php if (zen_not_null(ENTRY_PASSWORD_CURRENT_TEXT)){?><span class="required"><?php echo ENTRY_PASSWORD_CURRENT_TEXT;?></span><?php }?>
				</label>
				<div class="col-xs-12 col-sm-8 col-md-9">
					<?php echo zen_draw_password_field('password_current','','id="password-current" class="form-control"');?>
				</div>
			</div>
			<div class="form-group">
				<label for="password-new" class="col-xs-12 col-sm-4 col-md-3 control-label"><?php echo ENTRY_PASSWORD_NEW; ?>
					<?php if (zen_not_null(ENTRY_PASSWORD_NEW_TEXT)){?><span class="required"><?php echo ENTRY_PASSWORD_NEW_TEXT;?></span><?php }?>
				</label>
				<div class="col-xs-12 col-sm-8 col-md-9">
					<?php echo zen_draw_password_field('password_new','','id="password-new" class="form-control"');?>
				</div>
			</div>
			<div class="form-group">
				<label for="password-confirm" class="col-xs-12 col-sm-4 col-md-3 control-label"><?php echo ENTRY_PASSWORD_CONFIRMATION; ?>
					<?php if (zen_not_null(ENTRY_PASSWORD_CONFIRMATION_TEXT)){?><span class="required"><?php echo ENTRY_PASSWORD_CONFIRMATION_TEXT;?></span><?php }?>
				</label>
				<div class="col-xs-12 col-sm-8 col-md-9">
					<?php echo zen_draw_password_field('password_confirmation','','id="password-confirm" class="form-control"');?>
				</div>
			</div>
			<div class="form-group">
				<label for="password-confirm" class="col-xs-12 col-sm-4 col-md-3 control-label"></label>
				<div class="col-xs-12 col-sm-8 col-md-9">
					<div class="form-inline change_password">
						<div class="form-group">
							<a class="btn btn-default" href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL');?>"><?php echo BUTTON_BACK_ALT;?></a>
							<input type="submit" class="btn btn-default" value="<?php echo BUTTON_SUBMIT_ALT;?>"/>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
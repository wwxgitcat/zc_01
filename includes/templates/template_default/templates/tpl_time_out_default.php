<?php if ($_SESSION['customer_id']){?>
<div class="panel page-time-out">
	<h1 class="panel-heading" id="timeoutDefaultHeading">
		<?php echo HEADING_TITLE_LOGGED_IN; ?>
	</h1>
	<div class="panel-body page-content">
		<?php echo TEXT_INFORMATION_LOGGED_IN; ?>
	</div>
</div>
<?php }else{?>
<div class="panel page-time-out">
	<h1 class="panel-heading" id="timeoutDefaultHeading">
		<?php echo HEADING_TITLE; ?>
	</h1>
	<div class="panel-body page-content">
		<p><?php echo TEXT_INFORMATION; ?></p>
		<form id="login" name="login" method="post" class="form-horizontal" action="<?php echo zlink(FILENAME_LOGIN, 'action=process', 'SSL');?>">
			<?php echo zen_draw_hidden_field('securityToken', $_SESSION['securityToken']); ?>
			<h4 class="form-title"><?php echo HEADING_RETURNING_CUSTOMER; ?></h4>
			<?php if (PROJECT_VERSION_MAJOR == '1' && substr(PROJECT_VERSION_MINOR, 0, 3) == '3.8'){
				echo zen_draw_hidden_field('securityToken', $_SESSION['securityToken']);
			}?>
			<div class="form-group">
				<label for="login-email-address" class="col-xs-12 col-sm-4 col-md-3 control-label"><?php echo ENTRY_EMAIL_ADDRESS; ?></label>
				<div class="col-xs-12 col-sm-8 col-md-9">
					<?php echo zen_draw_input_field('email_address', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_email_address', '40') . ' id="login-email-address" class="form-control"'); ?>
				</div>
			</div>
			<div class="form-group">
				<label for="login-password" class="col-xs-12 col-sm-4 col-md-3 control-label"><?php echo ENTRY_PASSWORD; ?></label>
				<div class="col-xs-12 col-sm-8 col-md-9">
					<?php echo zen_draw_password_field('password', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_password') . ' id="login-password" class="form-control"'); ?>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-xs-12 col-sm-4 col-md-3 control-label"></label>
				<div class="col-xs-12 col-sm-8 col-md-9">
					<input type="submit" class="btn btn-default" value="<?php echo BUTTON_SUBMIT_ALT;?>"/>
					<a href="<?php echo zlink(FILENAME_PASSWORD_FORGOTTEN, '', 'SSL');?>"><?php echo TEXT_PASSWORD_FORGOTTEN;?></a>
				</div>
			</div>
		</form>
	</div>
</div>
<?php }?>


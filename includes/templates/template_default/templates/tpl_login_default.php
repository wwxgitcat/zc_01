<div class="panel userlogin">
	<h1 class="panel-heading advisory">
		<?php echo NAVBAR_TITLE; ?>
	</h1>
	<div class="panel-body">
		<?php display_message('login');?>
		<?php display_message('create_account');?>
		
		<?php if ($_SESSION['cart']->count_contents() > 0){?>
		<div class="advisory"><?php echo TEXT_VISITORS_CART; ?></div>
		<?php }?>
		
		<div class="form-horizontal" role="form">
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
						<?php echo zen_draw_hidden_field('securityToken', $_SESSION['securityToken']); ?>
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
</div>

<div class="panel userlogin">
	<h4 class="panel-heading"><?php echo HEADING_NEW_CUSTOMER; ?><em class="required"><?php echo FORM_REQUIRED_INFORMATION; ?></em></h4>
	<div class="panel-body">
		<form class="form-horizontal" id="create_account" name="create_account" method="post" onsubmit="return check_form(create_account);" action="<?php echo zlink(FILENAME_CREATE_ACCOUNT, '', 'SSL');?>">
			<!-- <div class="information"><?php echo TEXT_NEW_CUSTOMER_INTRODUCTION; ?></div> -->
			<?php echo zen_draw_hidden_field('action', 'process');?>
			<?php echo zen_draw_hidden_field('email_pref_html', 'email_format');?>
			<?php echo zen_draw_hidden_field('securityToken', $_SESSION['securityToken']); ?>
			<?php require(display_tpl('tpl_modules_create_account'));?>
			<div class="form-group">
				<label for="" class="col-xs-12 col-sm-4 col-md-3 control-label"></label>
				<div class="col-xs-12 col-sm-8 col-md-9">
					<input type="submit" class="btn btn-default" value="<?php echo BUTTON_CREATE_ACCOUNT_ALT;?>"/>
				</div>
			</div>
			
		</form>
		
		
	</div>
</div>



<?php if (FEC_EASY_SIGNUP_STATUS == 'true') { ?>
  
<?php } elseif (USE_SPLIT_LOGIN_MODE == 'True' || $ec_button_enabled) { ?>
<!--BOF PPEC split login- DO NOT REMOVE-->
<fieldset class="floatingBox back">
	<legend><?php echo HEADING_NEW_CUSTOMER_SPLIT; ?></legend>
  <?php // ** BEGIN PAYPAL EXPRESS CHECKOUT ** ?>
  <?php if ($ec_button_enabled) { ?>
  <div class="information"><?php echo TEXT_NEW_CUSTOMER_INTRODUCTION_SPLIT; ?></div>

	<div class="center"><?php require(DIR_FS_CATALOG . DIR_WS_MODULES . 'payment/paypal/tpl_ec_button.php'); ?></div>
	<hr />
  <?php echo TEXT_NEW_CUSTOMER_POST_INTRODUCTION_DIVIDER; ?>
  <?php } ?>
  <?php // ** END PAYPAL EXPRESS CHECKOUT ** ?>
  <div class="information"><?php echo TEXT_NEW_CUSTOMER_POST_INTRODUCTION_SPLIT; ?></div>

  <?php echo zen_draw_form('create', zen_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL')); ?>
  <div class="buttonRow forward"><?php echo zen_image_submit(BUTTON_IMAGE_CREATE_ACCOUNT, BUTTON_CREATE_ACCOUNT_ALT); ?></div>
	</form>
</fieldset>

<fieldset class="floatingBox forward">
	<legend><?php echo HEADING_RETURNING_CUSTOMER_SPLIT; ?></legend>
	<div class="information"><?php echo TEXT_RETURNING_CUSTOMER_SPLIT; ?></div>

  <?php echo zen_draw_form('login', zen_href_link(FILENAME_LOGIN, 'action=process', 'SSL')); ?>
  <label class="inputLabel" for="login-email-address"><?php echo ENTRY_EMAIL_ADDRESS; ?></label>
  <?php echo zen_draw_input_field('email_address', '', 'size="18" id="login-email-address"'); ?>
  <br class="clearBoth" /> <label class="inputLabel"
		for="login-password"><?php echo ENTRY_PASSWORD; ?></label>
  <?php echo zen_draw_password_field('password', '', 'size="18" id="login-password"'); ?>
  <?php echo zen_draw_hidden_field('securityToken', $_SESSION['securityToken']); ?>
  <br class="clearBoth" />

	<div class="buttonRow forward"><?php echo zen_image_submit(BUTTON_IMAGE_LOGIN, BUTTON_LOGIN_ALT); ?></div>
	<div class="buttonRow back important"><?php echo '<a href="' . zen_href_link(FILENAME_PASSWORD_FORGOTTEN, '', 'SSL') . '">' . TEXT_PASSWORD_FORGOTTEN . '</a>'; ?></div>
	</form>
</fieldset>
<br class="clearBoth" />
<!--EOF PPEC split login- DO NOT REMOVE-->
<?php }?>


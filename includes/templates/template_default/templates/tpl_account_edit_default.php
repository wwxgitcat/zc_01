<div class="panel">
	<h1 class="panel-heading"><?php echo HEADING_TITLE; ?></h1>
	<div class="panel-body page-content">
		<?php display_message('account_edit');?>
		<div class="required"><?php echo FORM_REQUIRED_INFORMATION; ?></div>
		
		<form id="account_edit" name="account_edit" class="form-horizontal" method="post" action="<?php echo zen_href_link(FILENAME_ACCOUNT_EDIT, '', 'SSL');?>" onsubmit="return check_form(account_edit);">
			<?php echo zen_draw_hidden_field('action', 'process');?>
			<?php echo zen_draw_hidden_field('securityToken', $_SESSION['securityToken']); ?>
			<?php if (ACCOUNT_GENDER == 'true'){?>
			<div class="form-group">
				<label for="" class="col-xs-12 col-sm-4 col-md-3 control-label">
					<?php if (zen_not_null(ENTRY_GENDER_TEXT)){?><span class="required"><?php echo ENTRY_GENDER_TEXT;?></span><?php }?>
				</label>
				<div class="col-xs-12 col-sm-8 col-md-9">
					<label class="radio-inline">
						<?php echo zen_draw_radio_field('gender', 'm', $male, 'id="gender-male"');?>
						<?php echo MALE;?>
					</label>
					<label class="radio-inline">
						<?php echo zen_draw_radio_field('gender', 'f', $female, 'id="gender-female"');?>
						<?php echo FEMALE;?>
					</label>
					
				</div>
			</div>
			<?php }?>
			<div class="form-group">
				<label for="firstname" class="col-xs-12 col-sm-4 col-md-3 control-label">
					<?php echo ENTRY_FIRST_NAME; ?>
					<?php if (zen_not_null(ENTRY_FIRST_NAME_TEXT)){?><span class="required"><?php echo ENTRY_FIRST_NAME_TEXT;?></span><?php }?>
				</label>
				<div class="col-xs-12 col-sm-8 col-md-9">
					<?php echo zen_draw_input_field('firstname', $account->fields['customers_firstname'], zen_set_field_length(TABLE_CUSTOMERS, 'customers_firstname', '40') . ' id="firstname" class="form-control"');?>
					
				</div>
			</div>
			<div class="form-group">
				<label for="lastname" class="col-xs-12 col-sm-4 col-md-3 control-label"><?php echo ENTRY_LAST_NAME; ?>
					<?php if (zen_not_null(ENTRY_LAST_NAME_TEXT)){?><span class="required"><?php echo ENTRY_LAST_NAME_TEXT;?></span><?php }?>
				</label>
				<div class="col-xs-12 col-sm-8 col-md-9">
					<?php echo zen_draw_input_field('lastname', $account->fields['customers_lastname'], zen_set_field_length(TABLE_CUSTOMERS, 'customers_lastname', '40') . ' id="lastname" class="form-control"');?>
					
				</div>
			</div>
			<?php if (ACCOUNT_DOB == 'true'){?>
			<div class="form-group">
				<label for="dob" class="col-xs-12 col-sm-4 col-md-3 control-label"><?php echo ENTRY_DATE_OF_BIRTH; ?>
					<?php if (zen_not_null(ENTRY_DATE_OF_BIRTH_TEXT)){?><span class="required"><?php echo ENTRY_DATE_OF_BIRTH_TEXT;?></span><?php }?>
				</label>
				<div class="col-xs-12 col-sm-8 col-md-9">
					<?php echo zen_draw_input_field('dob','', 'id="dob" class="form-control"');?>
				</div>
			</div>
			<?php }?>
			<div class="form-group">
				<label for="email-address" class="col-xs-12 col-sm-4 col-md-3 control-label"><?php echo ENTRY_EMAIL_ADDRESS; ?>
					<?php if (zen_not_null(ENTRY_EMAIL_ADDRESS_TEXT)){?><span class="required"><?php echo ENTRY_EMAIL_ADDRESS_TEXT;?></span><?php }?>
				</label>
				<div class="col-xs-12 col-sm-8 col-md-9">
					<?php echo zen_draw_input_field('email_address', $account->fields['customers_email_address'], zen_set_field_length(TABLE_CUSTOMERS, 'customers_email_address', '40') . ' id="email-address" class="form-control"');?>
					
				</div>
			</div>
			<div class="form-group">
				<label for="telephone" class="col-xs-12 col-sm-4 col-md-3 control-label"><?php echo ENTRY_TELEPHONE_NUMBER; ?>
					<?php if (zen_not_null(ENTRY_TELEPHONE_NUMBER_TEXT)){?><span class="required"><?php echo ENTRY_TELEPHONE_NUMBER_TEXT;?></span><?php }?>
				</label>
				<div class="col-xs-12 col-sm-8 col-md-9">
					<?php echo zen_draw_input_field('telephone', $account->fields['customers_telephone'], zen_set_field_length(TABLE_CUSTOMERS, 'customers_telephone', '40') . ' id="telephone" class="form-control"');?>
					
				</div>
			</div>
			<?php if(ACCOUNT_FAX_NUMBER == 'true'){ ?>
			<div class="form-group">
				<label for="fax" class="col-xs-12 col-sm-4 col-md-3 control-label"><?php echo ENTRY_FAX_NUMBER; ?>
					<?php if (zen_not_null(ENTRY_FAX_NUMBER_TEXT)){?><span class="required"><?php echo ENTRY_FAX_NUMBER_TEXT;?></span><?php }?>
				</label>
				<div class="col-xs-12 col-sm-8 col-md-9">
					<?php echo zen_draw_input_field('fax', $account->fields['customers_fax'], 'id="fax" class="form-control"');?>
				</div>
			</div>
			<?php } ?>
			<?php if (CUSTOMERS_REFERRAL_STATUS == 2 && $customers_referral == ''){?>
			<div class="form-group">
				<label for="customers_referral" class="col-xs-12 col-sm-4 col-md-3 control-label"></label>
				<div class="col-xs-12 col-sm-8 col-md-9">
					<?php echo zen_draw_input_field('customers_referral', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_referral', '15') . ' id="customers_referral" class="form-control"'); ?>
				</div>
			</div>
			<?php }?>
			<div class="form-group">
				<label class="col-xs-12 col-sm-4 col-md-3 control-label"></label>
				<div class="col-xs-12 col-sm-8 col-md-9">
					<label class="radio-inline">
						<?php echo zen_draw_radio_field('email_format', 'HTML', $email_pref_html,'id="email-format-html"');?>
						<?php echo ENTRY_EMAIL_HTML_DISPLAY;?>
					</label>
					<label class="radio-inline">
						<?php echo zen_draw_radio_field('email_format', 'TEXT', $email_pref_text, 'id="email-format-text"');?>
						<?php echo ENTRY_EMAIL_TEXT_DISPLAY;?>
					</label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-4 col-md-3 control-label"></label>
				<div class="col-xs-12 col-sm-8 col-md-9">
					
					<a class="btn btn-default" href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL');?>"><?php echo BUTTON_BACK_ALT;?></a>
					<input type="submit" class="btn btn-default" value="<?php echo BUTTON_UPDATE_ALT;?>"/>
				</div>
			</div>
		</form>
	</div>
</div>

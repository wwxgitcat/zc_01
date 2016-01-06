<?php if ($messageStack->size('create_account') > 0) echo $messageStack->output('create_account'); ?>
<?php if (DISPLAY_PRIVACY_CONDITIONS == 'true'){?>
<div class="form-group">
	<label for="privacy_conditions" class="col-xs-12 col-sm-4 col-md-3 control-label"><?php echo TABLE_HEADING_PRIVACY_CONDITIONS; ?></label>
	<div class="col-xs-12 col-sm-8 col-md-9">
		<?php echo zen_draw_checkbox_field('privacy_conditions', '1', false, 'id="privacy"');?>
		<span class="information"><?php echo TEXT_PRIVACY_CONDITIONS_DESCRIPTION;?></span>
		<?php echo TEXT_PRIVACY_CONDITIONS_CONFIRM;?>
	</div>
</div>
<?php }?>

<?php if (ACCOUNT_COMPANY == 'true'){?>
<div class="form-group">
	<label for="company" class="col-xs-12 col-sm-4 col-md-3 control-label">
		<?php echo ENTRY_COMPANY; ?>
		<?php if (zen_not_null(ENTRY_COMPANY_TEXT)){?><span class="required"><?php echo ENTRY_COMPANY_TEXT;?></span><?php }?>
	</label>
	<div class="col-xs-12 col-sm-8 col-md-9">
		<?php echo zen_draw_input_field('company', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_company', '40') . ' id="company" class="form-control"')?>
		
	</div>
</div>
<?php }?>

<?php if (ACCOUNT_GENDER == 'true'){?>
<div class="form-group">
	<label for="" class="col-xs-12 col-sm-4 col-md-3 control-label">
		<?php if (zen_not_null(ENTRY_GENDER_TEXT)){?><span class="required"><?php echo ENTRY_GENDER_TEXT;?></span><?php }?>
	</label>
	<div class="col-xs-12 col-sm-8 col-md-9">
		<label class="radio-inline">
			<?php echo zen_draw_radio_field('gender', 'm', '', 'id="gender-male"');?>
			<?php echo MALE;?>
		</label>
		<label class="radio-inline">
			<?php echo zen_draw_radio_field('gender', 'f', '', 'id="gender-female"');?>
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
		<?php echo zen_draw_input_field('firstname', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_firstname', '40') . ' id="firstname" class="form-control"');?>
		
	</div>
</div>
<div class="form-group">
	<label for="lastname" class="col-xs-12 col-sm-4 col-md-3 control-label"><?php echo ENTRY_LAST_NAME; ?>
		<?php if (zen_not_null(ENTRY_LAST_NAME_TEXT)){?><span class="required"><?php echo ENTRY_LAST_NAME_TEXT;?></span><?php }?>
	</label>
	<div class="col-xs-12 col-sm-8 col-md-9">
		<?php echo zen_draw_input_field('lastname', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_lastname', '40') . ' id="lastname" class="form-control"');?>
		
	</div>
</div>
<div class="form-group">
	<label for="postcode" class="col-xs-12 col-sm-4 col-md-3 control-label"><?php echo ENTRY_POST_CODE; ?>
		<?php if (zen_not_null(ENTRY_POST_CODE_TEXT)){?><span class="required"><?php echo ENTRY_POST_CODE_TEXT;?></span><?php }?>
	</label>
	<div class="col-xs-12 col-sm-8 col-md-9">
		<?php echo zen_draw_input_field('postcode', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_postcode', '40') . ' id="postcode" class="form-control"');?>
		
	</div>
</div>

<div class="form-group<?php if ($disable_country):?> hidden<?php endif;?>">
	<label for="country" class="col-xs-12 col-sm-4 col-md-3 control-label"><?php echo ENTRY_COUNTRY; ?>
		<?php if (zen_not_null(ENTRY_COUNTRY_TEXT)){?><span class="required"><?php echo ENTRY_COUNTRY_TEXT;?></span><?php }?>
	</label>
	<div class="col-xs-12 col-sm-8 col-md-9">
		<?php echo zen_get_country_list('zone_country_id', $selected_country, 'id="country" class="form-control" ' . ($flag_show_pulldown_states == true ? 'onchange="update_zone(this.form);"' : ''));?>
		
	</div>
</div>

<?php if (ACCOUNT_STATE == 'true'){?>
	<?php if ($flag_show_pulldown_states == true){?>
	<div class="form-group">
		<label for="stateZone" id="zoneLabel" class="col-xs-12 col-sm-4 col-md-3 control-label"><?php echo ENTRY_STATE; ?>
			<?php if (zen_not_null(ENTRY_STATE_TEXT)){?><span class="required"><?php echo ENTRY_STATE_TEXT;?></span><?php }?>
		</label>
		<div class="col-xs-12 col-sm-8 col-md-9">
			<?php echo zen_draw_pull_down_menu('zone_id', zen_prepare_country_zones_pull_down($selected_country), $zone_id, 'id="stateZone" class="form-control"');?>
			
			<div id="stBreak"></div>
		</div>
	</div>
	<?php }?>
	
	<div class="form-group<?php if (!zen_not_null($state_field_label)){?> hidden<?php }?>">
		<label for="state" id="stateLabel" class="col-xs-12 col-sm-4 col-md-3 control-label">
			<?php echo $state_field_label; ?>
			<?php if (zen_not_null(ENTRY_STATE_TEXT)){?><span class="required"><?php echo ENTRY_STATE_TEXT;?></span><?php }?>
		</label>
		<div class="col-xs-12 col-sm-8 col-md-9">
			<?php echo zen_draw_input_field('state', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_state', '40') . ' id="state" class="form-control"');?>
			
			<?php if ($flag_show_pulldown_states == false){?>
				<?php echo zen_draw_hidden_field('zone_id', $zone_name, ' ');?>
			<?php }?>
		</div>
	</div>
	
	
<?php }?>

<div class="form-group">
	<label for="city" class="col-xs-12 col-sm-4 col-md-3 control-label"><?php echo ENTRY_CITY; ?>
		<?php if (zen_not_null(ENTRY_CITY_TEXT)){?><span class="required"><?php echo ENTRY_CITY_TEXT;?></span><?php }?>
	</label>
	<div class="col-xs-12 col-sm-8 col-md-9">
		<?php echo zen_draw_input_field('city', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_city', '40') . ' id="city" class="form-control"');?>
		
	</div>
</div>
<div class="form-group">
	<label for="street-address" class="col-xs-12 col-sm-4 col-md-3 control-label"><?php echo ENTRY_STREET_ADDRESS; ?>
		<?php if (zen_not_null(ENTRY_STREET_ADDRESS_TEXT)){?><span class="required"><?php echo ENTRY_STREET_ADDRESS_TEXT;?></span><?php }?>
	</label>
	<div class="col-xs-12 col-sm-8 col-md-9">
		<?php echo zen_draw_input_field('street_address', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_street_address', '40') . ' id="street-address" class="form-control"');?>
		
	</div>
</div>
<?php if (ACCOUNT_SUBURB == 'true'){?>
<div class="form-group">
	<label for="suburb" class="col-xs-12 col-sm-4 col-md-3 control-label"><?php echo ENTRY_SUBURB; ?>
		<?php if (zen_not_null(ENTRY_SUBURB_TEXT)){?><span class="required"><?php echo ENTRY_SUBURB_TEXT;?></span><?php }?>
	</label>
	<div class="col-xs-12 col-sm-8 col-md-9">
		<?php echo zen_draw_input_field('suburb', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_suburb', '40') . ' id="suburb" class="form-control"');?>
		
	</div>
</div>
<?php }?>

<?php if (enable_shippingAddressCheckbox()) { ?>
<div class="form-group">
	<label for="" class="col-xs-12 col-sm-4 col-md-3 control-label"><?php echo ENTRY_COPYBILLING;?>
		<?php if (zen_not_null(ENTRY_COPYBILLING_TEXT)){?><span class="required"><?php echo ENTRY_COPYBILLING_TEXT;?></span><?php }?>
	</label>
	<div class="col-xs-12 col-sm-8 col-md-9">
		<?php echo zen_draw_checkbox_field('shippingAddress', '1', $shippingAddress, 'id="shippingAddress-checkbox"');?>
		
	</div>
</div>
<?php }?>
<!-- begin shipping box -->
<!-- //for future releases -->
<?php if(enable_shippingAddressCheckbox()) { ?>
<fieldset id="shippingField" class="sidebysidefields">
	<legend><?php echo TABLE_HEADING_SHIPPING_ADDRESS; ?></legend>
	<br class="clearBoth" />
<?php
	if (ACCOUNT_GENDER == 'true')
	{
		?>
<?php echo zen_draw_radio_field('gender_shipping', 'm', '', 'id="gender-male_shipping"') . '<label class="radioButtonLabel" for="gender-male">' . MALE . '</label>' . zen_draw_radio_field('gender_shipping', 'f', '', 'id="gender-female_shipping"') . '<label class="radioButtonLabel" for="gender-female">' . FEMALE . '</label>' . (zen_not_null(ENTRY_GENDER_TEXT) ? '<span class="alert">' . ENTRY_GENDER_TEXT . '</span>': ''); ?>
<br class="clearBoth" />
<?php
	}
	?>

<label class="inputLabel" for="firstname_shipping"><?php echo ENTRY_FIRST_NAME; ?></label>
<?php echo zen_draw_input_field('firstname_shipping', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_firstname', '40') . ' id="firstname_shipping"') . (zen_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="alert">' . ENTRY_FIRST_NAME_TEXT . '</span>': ''); ?>
<br class="clearBoth" /> <label class="inputLabel"
		for="lastname_shipping"><?php echo ENTRY_LAST_NAME; ?></label>
<?php echo zen_draw_input_field('lastname_shipping', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_lastname', '40') . ' id="lastname_shipping"') . (zen_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="alert">' . ENTRY_LAST_NAME_TEXT . '</span>': ''); ?>
<br class="clearBoth" />


<?php if (ACCOUNT_COMPANY == 'true'){?>
<label class="inputLabel" for="company_shipping"><?php echo ENTRY_COMPANY; ?></label>
<?php echo zen_draw_input_field('company_shipping', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_company', '40') . ' id="company_shipping"') . (zen_not_null(ENTRY_COMPANY_TEXT) ? '<span class="alert">' . ENTRY_COMPANY_TEXT . '</span>': ''); ?>
<br class="clearBoth" />
<?php }?>

<label class="inputLabel" for="street-address_shipping"><?php echo ENTRY_STREET_ADDRESS; ?></label>
  <?php echo zen_draw_input_field('street_address_shipping', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_street_address', '40') . ' id="street-address_shipping"') . (zen_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="alert">' . ENTRY_STREET_ADDRESS_TEXT . '</span>': ''); ?>
<br class="clearBoth" />

<?php
	if (ACCOUNT_SUBURB == 'true')
	{
		?>
<label class="inputLabel" for="suburb_shipping"><?php echo ENTRY_SUBURB; ?></label>
<?php echo zen_draw_input_field('suburb_shipping', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_suburb', '40') . ' id="suburb_shipping"') . (zen_not_null(ENTRY_SUBURB_TEXT) ? '<span class="alert">' . ENTRY_SUBURB_TEXT . '</span>': ''); ?>
<br class="clearBoth" />
<?php
	}
	?>

<label class="inputLabel" for="city_shipping"><?php echo ENTRY_CITY; ?></label>
<?php echo zen_draw_input_field('city_shipping', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_city', '40') . ' id="city_shipping"') . (zen_not_null(ENTRY_CITY_TEXT) ? '<span class="alert">' . ENTRY_CITY_TEXT . '</span>': ''); ?>
<br class="clearBoth" />
<?php
	if ($disable_country == true)
	{
		$addclass = "hiddenField";
	}
	?>
<div class="<?php echo $addclass; ?>">
		<label class="inputLabel" for="country_shipping"><?php echo ENTRY_COUNTRY; ?></label>
<?php echo zen_get_country_list('zone_country_id_shipping', $selected_country_shipping, 'id="country_shipping" ' . ($flag_show_pulldown_states_shipping == true ? 'onchange="update_zone_shipping(this.form);"' : '')) . (zen_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="alert">' . ENTRY_COUNTRY_TEXT . '</span>': ''); ?>
<br class="clearBoth" />
	</div>

<?php
	if (ACCOUNT_STATE == 'true')
	{
		if ($flag_show_pulldown_states_shipping == true)
		{
			?>
<label class="inputLabel" for="stateZone_shipping" id="zoneLabel"><?php echo ENTRY_STATE; ?></label>
<?php
			echo zen_draw_pull_down_menu('zone_id_shipping', zen_prepare_country_zones_pull_down($selected_country_shipping), $zone_id_shipping, 'id="stateZone_shipping"');
			if (zen_not_null(ENTRY_STATE_TEXT))
				echo '&nbsp;<span class="alert">' . ENTRY_STATE_TEXT . '</span>';
		}
		?>

<?php if ($flag_show_pulldown_states_shipping == true) { ?>
<br class="clearBoth" id="stBreakShipping" />
<?php } ?>
<label class="inputLabel" for="state_shipping" id="stateLabelShipping"><?php echo $state_field_label_shipping; ?></label>
<?php
		echo zen_draw_input_field('state_shipping', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_state', '40') . ' id="state_shipping"');
		if (zen_not_null(ENTRY_STATE_TEXT))
			echo '&nbsp;<span class="alert" id="stTextShipping">' . ENTRY_STATE_TEXT . '</span>';
		if ($flag_show_pulldown_states_shipping == false)
		{
			echo zen_draw_hidden_field('zone_id_shipping', $zone_name_shipping, ' ');
		}
		?>
<br class="clearBoth" />
<?php
	}
	?>

<label class="inputLabel" for="postcode_shipping"><?php echo ENTRY_POST_CODE; ?></label>
<?php echo zen_draw_input_field('postcode_shipping', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_postcode', '40') . ' id="postcode_shipping"') . (zen_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="alert">' . ENTRY_POST_CODE_TEXT . '</span>': ''); ?>
<br class="clearBoth" />
</fieldset>
<?php } ?>
<!-- eof shipping -->


<div class="form-group">
	<label for="telephone" class="col-xs-12 col-sm-4 col-md-3 control-label"><?php echo ENTRY_TELEPHONE_NUMBER; ?>
		<?php if (zen_not_null(ENTRY_TELEPHONE_NUMBER_TEXT)){?><span class="required"><?php echo ENTRY_TELEPHONE_NUMBER_TEXT;?></span><?php }?>
	</label>
	<div class="col-xs-12 col-sm-8 col-md-9">
		<?php echo zen_draw_input_field('telephone', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_telephone', '40') . ' id="telephone" class="form-control"');?>
		
	</div>
</div>

<?php if(ACCOUNT_FAX_NUMBER == 'true'){ ?>
<div class="form-group">
	<label for="fax" class="col-xs-12 col-sm-4 col-md-3 control-label"><?php echo ENTRY_FAX_NUMBER; ?>
		<?php if (zen_not_null(ENTRY_FAX_NUMBER_TEXT)){?><span class="required"><?php echo ENTRY_FAX_NUMBER_TEXT;?></span><?php }?>
	</label>
	<div class="col-xs-12 col-sm-8 col-md-9">
		<?php echo zen_draw_input_field('fax', '', 'id="fax" class="form-control"');?>
	</div>
</div>
<?php } ?>

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
		<?php echo zen_draw_input_field('email_address', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_email_address', '40') . ' id="email-address" class="form-control"');?>
		
	</div>
</div>
<div class="form-group">
	<label for="password-new" class="col-xs-12 col-sm-4 col-md-3 control-label"><?php echo ENTRY_PASSWORD; ?>
		<?php if (zen_not_null(ENTRY_PASSWORD_TEXT)){?><span class="required"><?php echo ENTRY_PASSWORD_TEXT;?></span><?php }?>
	</label>
	<div class="col-xs-12 col-sm-8 col-md-9">
		<?php echo zen_draw_password_field('password', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_password', '20') . ' id="password-new" class="form-control"');?>
		
	</div>
</div>
<div class="form-group">
	<label for="password-confirm" class="col-xs-12 col-sm-4 col-md-3 control-label"><?php echo ENTRY_PASSWORD_CONFIRMATION; ?>
		<?php if (zen_not_null(ENTRY_PASSWORD_CONFIRMATION_TEXT)){?><span class="required"><?php echo ENTRY_PASSWORD_CONFIRMATION_TEXT;?></span><?php }?>
	</label>
	<div class="col-xs-12 col-sm-8 col-md-9">
		<?php echo zen_draw_password_field('confirmation', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_password', '20') . ' id="password-confirm" class="form-control"');?>
		
	</div>
</div>
<?php if (ACCOUNT_NEWSLETTER_STATUS != 0){?>
<div class="form-group">
	<label for="newsletter-checkbox" class="col-xs-12 col-sm-4 col-md-3 control-label">
		<?php if (zen_not_null(ENTRY_NEWSLETTER_TEXT)){?><span class="required"><?php echo ENTRY_NEWSLETTER_TEXT;?></span><?php }?>
	</label>
	<div class="col-xs-12 col-sm-8 col-md-9">
		<?php echo zen_draw_checkbox_field('newsletter', '1', $newsletter, 'id="newsletter-checkbox"');?>
	</div>
</div>
<?php }?>

<div class="form-group">
	<label class="col-xs-12 col-sm-4 col-md-3 control-label"></label>
	<div class="col-xs-12 col-sm-8 col-md-9">
		<label class="radio-inline">
			<?php echo zen_draw_radio_field('email_format', 'HTML', ($email_format == 'HTML' ? true : false),'id="email-format-html"');?>
			<?php echo ENTRY_EMAIL_HTML_DISPLAY;?>
		</label>
		<label class="radio-inline">
			<?php echo zen_draw_radio_field('email_format', 'TEXT', ($email_format == 'TEXT' ? true : false), 'id="email-format-text"');?>
			<?php echo ENTRY_EMAIL_TEXT_DISPLAY;?>
		</label>
	</div>
</div>
<?php if (CUSTOMERS_REFERRAL_STATUS == 2){?>
<div class="form-group">
	<label for="customers_referral" class="col-xs-12 col-sm-4 col-md-3 control-label"></label>
	<div class="col-xs-12 col-sm-8 col-md-9">
		<?php echo zen_draw_input_field('customers_referral', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_referral', '15') . ' id="customers_referral" class="form-control"'); ?>
	</div>
</div>
<?php }?>



<?php
// BOF Captcha
if (is_object($captcha))
{
	?>
<fieldset>
	<legend><?php echo TITLE_CAPTCHA; ?></legend>  
<?php echo $captcha->img(); ?>
<?php echo $captcha->redraw_button(BUTTON_IMAGE_CAPTCHA_REDRAW, BUTTON_IMAGE_CAPTCHA_REDRAW_ALT); ?>
<br class="clearBoth" /> <label for="captcha"><?php echo TITLE_CAPTCHA; ?></label>
<?php echo $captcha->input_field('captcha', 'id="captcha"') . '&nbsp;<span class="alert">' . TEXT_CAPTCHA . '</span>'; ?>
<br class="clearBoth" />
</fieldset>
<?php
}
// BOF Captcha
?>

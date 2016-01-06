
<h2 class="panel-title"><?php echo TITLE_PLEASE_SELECT; ?></h2>
<div><em class="required"><?php echo FORM_REQUIRED_INFORMATION; ?></em></div>
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
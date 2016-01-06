<div class="panel">
	<h1 class="panel-heading"><?php echo HEADING_TITLE; ?></h1>
	<div class="panel-body">
		<form id="create_account" name="create_account" class="form-horizontal" method="post" action="<?php echo zen_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL');?>" onsubmit="return check_form(create_account);">
			<?php echo zen_draw_hidden_field('action', 'process') . zen_draw_hidden_field('email_pref_html', 'email_format');?>
			<?php echo zen_draw_hidden_field('securityToken', $_SESSION['securityToken']); ?>
			<h5 id="createAcctDefaultLoginLink"><?php echo sprintf(TEXT_ORIGIN_LOGIN, zen_href_link(FILENAME_LOGIN, zen_get_all_get_params(array('action')), 'SSL')); ?></h5>
			<?php require(display_tpl('tpl_modules_create_account'));?>
			
			<div class="form-group">
				<label class="col-xs-12 col-sm-4 col-md-3 control-label"></label>
				<div class="col-xs-12 col-sm-8 col-md-9">
					<input type="submit" class="btn btn-default" value="<?php echo BUTTON_SUBMIT_ALT;?>"/>
				</div>
			</div>
		</form>
	</div>
</div>

<div class="panel">
	<h1 class="panel-heading"><?php echo HEADING_TITLE; ?></h1>
	<div class="panel-body page-content">
		<form id="account_newsletter" name="account_newsletter" class="form-horizontal" mehod="post" action="<?php echo zen_href_link(FILENAME_ACCOUNT_NEWSLETTERS, '', 'SSL');?>">
			<?php echo zen_draw_hidden_field('action', 'process');?>
			<?php echo zen_draw_hidden_field('securityToken', $_SESSION['securityToken']); ?>
			
			<div class="form-group">
				<label class="col-xs-12 col-sm-4 col-md-3 control-label">
				</label>
				<div class="col-xs-12 col-sm-8 col-md-9">
					<h3><?php echo MY_NEWSLETTERS_GENERAL_NEWSLETTER; ?></h3>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-4 col-md-3 control-label">
				</label>
				<div class="col-xs-12 col-sm-8 col-md-9">
					<div>
						<label class="checkbox-inline">
							<?php echo zen_draw_checkbox_field('newsletter_general', '1', (($newsletter->fields['customers_newsletter'] == '1') ? true : false), 'id="newsletter"'); ?>
							<?php echo MY_NEWSLETTERS_GENERAL_NEWSLETTER_DESCRIPTION; ?>
						</label>
					</div>
					
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-4 col-md-3 control-label">
				</label>
				<div class="col-xs-12 col-sm-8 col-md-9">
					<a class="btn btn-default" href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL');?>"><?php echo BUTTON_BACK_ALT;?></a>
					<input type="submit" class="btn btn-default" value="<?php echo BUTTON_UPDATE_ALT;?>"/>
				</div>
			</div>
		</form>
	</div>
</div>

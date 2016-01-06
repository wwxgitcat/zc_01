<div class="panel">
	<h1 class="panel-heading"><?php echo HEADING_TITLE; ?></h1>
	<div class="panel-body page-content">
		<?php if (DEFINE_PRIVACY_STATUS >= 1 and DEFINE_PRIVACY_STATUS <= 2) { ?>
		<div class="">
			<?php require ($define_page);?>
		</div>
		<?php }?>
		<div class="form-inline">
			<a class="btn btn-default" href="<?php echo zen_back_link(true);?>"><?php echo BUTTON_BACK_ALT;?></a>
		</div>
	</div>
</div>
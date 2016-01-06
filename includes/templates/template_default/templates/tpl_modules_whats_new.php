<?php require(get_modules_file(FILENAME_NEW_PRODUCTS));?>
<?php if ($this_is_home_page):?>
<div class="col-xs-12 col-sm-12 col-md-12">
<?php endif;?>
<div class="panel<?php if ($this_is_home_page):?> home<?php endif;?>">
	<h1 class="panel-heading">
	<!-- <span class="pro_2">3<em class="em1"></em></span>&nbsp; -->
	<!-- <span class="pro_2">3</span>&nbsp; -->
		<?php echo sprintf(TABLE_HEADING_NEW_PRODUCTS, strftime('%B')); ?>
	</h1>
	<div class="panel-body">
		<?php require(display_tpl_common('tpl_grid_display'));?>
		
	</div>
</div>
<?php if ($this_is_home_page):?>
</div>
<?php endif;?>
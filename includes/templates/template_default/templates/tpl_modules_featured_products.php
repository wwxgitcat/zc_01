<?php require(get_modules_file(FILENAME_FEATURED_PRODUCTS_MODULE));?>
<?php if ($this_is_home_page):?>
<div class="col-xs-12 col-sm-12 col-md-12">
<?php endif;?>
<div class="panel<?php if ($this_is_home_page):?> home<?php endif;?>">
	<h1 class="panel-heading">
		<!-- <span class="pro_2">1</span>&nbsp; -->
		<!-- <span class="pro_2">1<em class="em1"></em></span>&nbsp; -->
		<?php echo TABLE_HEADING_FEATURED_PRODUCTS ?>
	</h1>
	<div class="panel-body">

		<?php require(display_tpl_common('tpl_grid_display'));?>
		
	</div>
</div>
<?php if ($this_is_home_page):?>
</div>
<?php endif;?>
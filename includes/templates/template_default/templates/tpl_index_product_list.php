<div class="panel">

	<h1 class="panel-heading">
		<?php //echo $breadcrumb->last(); ?>
	</h1>
	<div class="panel-body">
		<div class="catdescription">
			<?php echo $current_categories_description;  ?>
		</div>
	
		<?php require(get_modules_file('category_row'));?>
		<?php if (count($tpl_subcategories_array) > 0):?>
		<div class="clearfix sub-categories">
			<ul>
				<?php foreach ($tpl_subcategories_array as $cate):?>
				<li class="col-xs-6 col-sm-6 col-md-3 sub-categories-item"><a href="<?php echo $cate['href'];?>" title="<?php echo $cate['name'];?>"><?php echo $cate['name'];?></a></li>
				<!-- <li class="col-xs-6 col-sm-12 col-md-4 sub-categories-item"><a href="<?php echo $cate['href'];?>" title="<?php echo $cate['name'];?>"><?php echo $cate['name'];?></a></li> -->
				<?php endforeach;?>
			</ul>
		</div>
		<?php endif;?>
		
		<?php require(get_modules_file(FILENAME_PRODUCT_LISTING));?>
		<?php if (count($tpl_products['products']) == 0):?>
			<div class="panel-heading"><?php echo TEXT_CATEGORIES_NO_PRODUCTS;?></div>
			<?php require(display_tpl('tpl_modules_whats_new'));?>
		<?php else:?>
			<?php require(display_tpl_common('tpl_grid_display'));?>
		<?php endif;?>
	</div>
</div>
<style type="text/css">
	.left_cat_a{display: block;}
</style>
<?php //require(display_template('tpl_modules_category_row'));?>
<?php //require(display_template('tpl_modules_product_listing')); ?>
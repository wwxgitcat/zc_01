
<?php if (count($tpl_products['products']) == 0):?>
<div><?php echo TEXT_NO_ALL_PRODUCTS;?></div>
<?php else:?>
<?php require(display_template('tpl_grid_display', 'common'));?>
<?php endif;?>

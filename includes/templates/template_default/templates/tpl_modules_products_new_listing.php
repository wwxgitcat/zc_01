
<?php if (count($tpl_products['products']) == 0):?>
<p><?php echo TEXT_NO_NEW_PRODUCTS;?></p>
<?php else:?>
<?php require(display_template('tpl_grid_display', 'common'));?>
<?php endif;?>

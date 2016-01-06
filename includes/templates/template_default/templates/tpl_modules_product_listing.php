<?php require(get_modules_file(FILENAME_PRODUCT_LISTING));?>



<?php if (count($tpl_products['products']) == 0):?>
	<p>ԓ��������Ʒ�Ϥ���ޤ���Ǥ�����</p>
	<?php require(display_template('tpl_modules_whats_new'));?>
<?php else:?>
	

	<div id="contents">
		<?php require(display_template('tpl_grid_display', 'common'));?>
	</div>


<br class="clearBoth">
<?php endif;?>

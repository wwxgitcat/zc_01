
<div id="sorter">
	<label for="disp-order-sorter"><?php echo TEXT_INFO_SORT_BY; ?></label>
	<form name="sorter_form"
		action="<?php zlink($_GET['main_page']);?>" method="get">
		<input type="hidden" name="main_page"
			value="<?php echo $_GET['main_page'];?>" />
		<?php echo zen_hide_session_id();?>
	    <select name="disp_order" onchange="this.form.submit();"
			id="disp-order-sorter">
			<?php if ($disp_order != $disp_order_default): ?>
			    <option value="<?php echo $disp_order_default; ?>"
				<?php echo ($disp_order == $disp_order_default ? 'selected="selected"' : ''); ?>><?php echo PULL_DOWN_ALL_RESET; ?></option>
			<?php endif;// reset to store default ?>
		    <option value="1"
				<?php echo ($disp_order == '1' ? 'selected="selected"' : ''); ?>><?php echo TEXT_INFO_SORT_BY_PRODUCTS_NAME; ?></option>
			<option value="2"
				<?php echo ($disp_order == '2' ? 'selected="selected"' : ''); ?>><?php echo TEXT_INFO_SORT_BY_PRODUCTS_NAME_DESC; ?></option>
			<option value="3"
				<?php echo ($disp_order == '3' ? 'selected="selected"' : ''); ?>><?php echo TEXT_INFO_SORT_BY_PRODUCTS_PRICE; ?></option>
			<option value="4"
				<?php echo ($disp_order == '4' ? 'selected="selected"' : ''); ?>><?php echo TEXT_INFO_SORT_BY_PRODUCTS_PRICE_DESC; ?></option>
			<option value="5"
				<?php echo ($disp_order == '5' ? 'selected="selected"' : ''); ?>><?php echo TEXT_INFO_SORT_BY_PRODUCTS_MODEL; ?></option>
			<option value="6"
				<?php echo ($disp_order == '6' ? 'selected="selected"' : ''); ?>><?php echo TEXT_INFO_SORT_BY_PRODUCTS_DATE_DESC; ?></option>
			<option value="7"
				<?php echo ($disp_order == '7' ? 'selected="selected"' : ''); ?>><?php echo TEXT_INFO_SORT_BY_PRODUCTS_DATE; ?></option>
		</select>
	</form>
</div>
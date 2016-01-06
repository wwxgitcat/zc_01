<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @author JunsGo@msn.com
 * @copyright Copyright 2013 SL Development Team
 * @copyright Portions Copyright 2003 osCommerce
 */
?>
<div class="menu_block border_block" id="<?php echo str_replace('_', '-', $box_id ); ?>" style="width: <?php echo $column_width; ?>">
	<div class="block-title"
		id="<?php echo str_replace('_', '-', $box_id) . 'Heading'; ?>">
		<div class="welcomes">
			<?php echo BOX_HEADING_CURRENCIES; ?>
		</div>
	</div>
	<div class="sectionTabCont">
		<div id="<?php echo str_replace('_', '-', $box_id . 'Content');?>"
			class="sideBoxContent centeredContent">
			<form
				action="<?php echo zen_href_link(basename(preg_replace('/.php/','', $PHP_SELF)), '', $request_type, false);?>"
				name="currencies_form" method="get">
				<?php echo zen_draw_pull_down_menu('currency', $currencies_array, $_SESSION['currency'], 'onchange="this.form.submit();"') . $hidden_get_variables . zen_hide_session_id();?>
			</form>
		</div>
	</div>
</div>
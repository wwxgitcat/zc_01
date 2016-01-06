<?php
/**
 * Common Template - tpl_box_default_left.php
 *
 * not need
 * @package templateSystem
 * @author JunsGo@msn.com
 * @copyright Copyright 2013 SL Development Team
 * @copyright Portions Copyright 2003 osCommerce
 */

// choose box images based on box position
if ($title_link)
{
	$title = '<a href="' . zen_href_link($title_link) . '">' . $title . BOX_HEADING_LINKS . '</a>';
}
//
?>
<!--// bof: <?php echo $box_id; ?> //-->
<div class="menu_block border_block" id="<?php echo str_replace('_', '-', $box_id ); ?>" style="width: <?php echo $column_width; ?>">
	<div class="block-title"
		id="<?php echo str_replace('_', '-', $box_id) . 'Heading'; ?>">
		<div class="welcomes"><?php echo $title; ?></div>
	</div>
<?php echo $content; ?>
</div>
<br />
<!--// eof: <?php echo $box_id; ?> //-->


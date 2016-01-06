<?php
// dgReviews
// Modified to work with version 3.0.2 of the zencart
// This is a quick down and dirty mod to add product reviews onto the product info page
// by MichaelDuvall.com
?>
<!-- bof: dgReviews-->

<?php require($template->get_template_dir('tpl_seo_reviews.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_seo_reviews.php');?>

<?php
// change this constant to change the title for the customer reviews
$review_title = 'Customer Reviews';

$review_status = " and r.status = '1'";
/* This is where you change the parameter value to output 1000 charaters or equivelent */
$reviews_query_raw = "select r.reviews_id, left(rd.reviews_text, 1000) as reviews_text,
                               r.reviews_rating, r.date_added, r.customers_name
                        from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd
                        where r.products_id = '" . (int)$_GET['products_id'] . "'
                        and r.reviews_id = rd.reviews_id
                        and rd.languages_id = '" . (int)$_SESSION['languages_id'] . "'" . $review_status . "
                        order by r.reviews_id desc";

$reviews_split = new splitPageResults($reviews_query_raw, MAX_DISPLAY_NEW_REVIEWS);

if ($reviews_split->number_of_rows > 0)
{
	if ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3'))
	{
		?>
<?php
	}
	
	$reviews = $db->Execute($reviews_split->sql_query);
	
	while(!$reviews->EOF)
	{
		?>
<div class="kuang">
	<div class="kuang1">
		<div class="thename">
	<?php echo sprintf(TEXT_REVIEW_BY, zen_output_string_protected($reviews->fields['customers_name'])); ?>
	</div>
		<div class="thedate">
	<?php echo sprintf(TEXT_REVIEW_DATE_ADDED, zen_date_short($reviews->fields['date_added'])); ?>
	</div>
	</div>
	<br class="clearBoth" />
	<div valign="top" class="main123" colspan="2">
		<div style="margin: 10px;"><?php echo zen_break_string(zen_output_string_protected(stripslashes($reviews->fields['reviews_text'])), 35, '<br />').'<br /><br />'. sprintf(TEXT_REVIEW_RATING, zen_image(DIR_WS_TEMPLATE_IMAGES . 'stars_' . $reviews->fields['reviews_rating'] . '.gif', sprintf('<a href="http://www.uslouisvuittononlineshop.com" title="Louis Vuitton Outlet Online">Louis Vuitton Outlet Online</a>', $reviews->fields['reviews_rating'])), sprintf('<a href="http://www.uslouisvuittononlineshop.com" title="Louis Vuitton Handbags">Louis Vuitton Handbags</a>', $reviews->fields['reviews_rating'])); ?>
	
	</div>
	</div>
</div>

<?php
		$reviews->MoveNext();
	}
	?>
<?php
}
else
{
	?>

<?php
}

if (($reviews_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3')))
{
	?>

    

<?php
}
?>
<!-- eof: also_purchased -->
<?php //this is the end of dgReview?>
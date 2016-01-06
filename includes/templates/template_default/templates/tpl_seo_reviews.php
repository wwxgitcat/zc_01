<?php
/**
 * Page Template
 * Displays details of a typical product
 *
 * @package templateSystem
 * @author JunsGo@msn.com
 * @copyright Copyright 2013 SL Development Team
 * @copyright Portions Copyright 2003 osCommerce
 */
include (DIR_WS_MODULES . zen_get_module_directory('seo_reviews'));

?>
<?php if (count($tpl_seo_reviews) > 0):?>
<div class="clearBoth"></div>
<span id="pro_rev_cl">詳細</span>
<style type="text/css">
.pro-rev {
	line-height: 24px;
}

.pro-rev dd {
	padding: 5px 10px;
	border-bottom: 1px solid #666;
}

.pro-rev dt em {
	font-size: 0.8em;
	font-weight: normal;
	font-style: italic;
}
</style>
<div id="pro_rev" class="pro-rev">
	<?php foreach ($tpl_seo_reviews as $reviews):?>
	<dl>
		<dt><?php echo $products_name;?></dt>
		<dt>
			<em><?php echo date('Y-m-d', strtotime($reviews['date_add']));?></em>
		</dt>
		<dd><?php echo $reviews['text'];?></dd>
	</dl>
	<?php endforeach;?>
</div>
<script type="text/javascript">

	$('#pro_rev_cl').click(function(){
		$('#pro_rev').toggle();
	});
	$('#pro_rev').show().css({'display':'none'});

</script>
<?php endif;?>

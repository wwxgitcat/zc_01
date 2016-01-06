<?php require(get_modules_file('additional_images'));?>
<?php if ($flag_show_product_info_additional_images != 0 && $num_images > 0) { ?>
<div id="productAdditionalImages" class="row small_img_all">

	<?php require(display_tpl_common('tpl_columnar_display')); ?>
</div>
<?php }?>

<?php require(get_modules_file('auto_banner_product', $template_dir)); ?>

<?php if (count($tpl_banner_product) > 0):?>
<?php $i=0; ?>
<div class="col-xs-12 col-sm-12 col-md-12">

	<div class="panel">
		<h2 class="panel-heading">&nbsp;<?php echo sprintf(TABLE_HEADING_FEATURED_POPULAR, strftime('%B')); ?></h2>
		<!-- <h2 class="panel-heading"><span class="pro_2">2<em class="em1"></em></span>&nbsp;<?php echo sprintf(TABLE_HEADING_FEATURED_POPULAR, strftime('%B')); ?></h2> -->
		<div class="panel-body">
			<?php foreach ($tpl_banner_product as $bann): ?>
			<div class="col-xs-6 col-sm-6 col-md-4 pro_main">
			<?php $i++; ?>
				<div class="banner-item" >
				<?php 
				switch ($i) {
					case 1:
						$fir =  DIR_WS_TEMPLATE_IMAGES."ico_rank01_s.gif";
						echo '<div class="new_sale"><img src='.$fir.' /></div>';
						break;
					case 2:
						$sec =  DIR_WS_TEMPLATE_IMAGES."ico_rank02_s.gif";
						echo '<div class="new_sale"><img src='.$sec.' /></div>';
						break;
					case 3:
						$thr =  DIR_WS_TEMPLATE_IMAGES."ico_rank03_s.gif";
						echo '<div class="new_sale"><img src='.$thr.' /></div>';
						break;
					default:
						echo '<div class="test_demo">'. $i .'</div>';
						break;
				}
				 ?>
				
				<div class="div_img_japan">	
					<a href="<?php echo $bann['href'];?>" title="<?php echo $bann['title'];?>">
						<img src="<?php echo zen_image($bann['image'], $bann['name'], 165, 190, '', true);?>" alt="<?php echo $bann['title'];?>" />
					</a>
				</div>
					<span class="price-save">
						<?php echo $bann['display_sale_price'];?>
					</span>
					<div class="pro_two">
						<a href="<?php echo $bann['href'];?>" title="<?php echo $bann['title'];?>" style="color:#000">
							<?php //echo safe_cut_str($product['name'], 10, '...');?>
							<?php echo $bann['title'];?>
						</a>
						<br/>
						<div class="div_japan">
							<?php if (!empty($bann['display_special_price'])):?>
								<del class="price-old"><?php echo $bann['display_normal_price'];?></del>
							
								<span class="price-new"><?php echo $bann['display_special_price'];?></span>
							<?php else://have special?>
								<span class="price-new"><?php echo $bann['display_normal_price'];?></span>
							<?php endif;//no special?>
							<?php if (!empty($bann['display_sale_price'])):?>
							
							<?php endif;?>

						</div>
						
					</div>
				</div>
			</div>
			<?php endforeach;?>
		</div>
	</div>

</div>

<?php endif;?>
<style>

</style>
<script type="text/javascript">
// function change_white1(){
// 	$(".banner-item").mouseover(function(){
// 			$(this).find('.pro_two .price-new').css('color','#EA5F00');
// 			$(this).find('.pro_two a').css('color','white');
// 			$(this).find('.pro_two .price-old').css('color','white');
// 			$(this).find('.pro_two .price-save').css('color','white');
// 			// $(this).find('.price-new').css('color','white');
// 		});
// }
// function change_black1(){
// 	$(".banner-item").mouseout(function(){
// 			// $(this).find('.pro_two .price-new').css('color','black');
// 			// $(this).find('.price-new .price-new').css('color','red');
// 			$(this).find('.pro_two .price-new').css('color','#ff0000');
// 			$(this).find('.pro_two a').css('color','black');
// 			$(this).find('.pro_two .price-old').css('color','black');
// 			$(this).find('.pro_two .price-save').css('color','black');
// 		});
// }

</script>
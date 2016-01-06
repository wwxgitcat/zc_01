<?php require(display_tpl('main_page_variable', 'common'));?>
<?php require(get_modules_file('categories', $template_dir, 'sideboxes'));?>

<body id="<?php echo $body_id.'Body'; ?>" <?php if($zv_onload !='') echo ' onload="'.$zv_onload.'"'; ?>>
	<div class="wrapper-container">
		<?php require(display_tpl_common('tpl_header'));?>
		<!-- main content -->
		<div class="container">
			<?php if ($messageStack->size('upload') > 0):?>
			<div class="row">
				<?php display_message('upload'); ?>
			</div>
			<?php endif;?>
			<?php if (!$this_is_home_page):?>
			<div class="row">
				<!-- <div class="col-xs-12 col-sm-12 col-md-12">
					<div class="breadcrumb hidden-xs">
						<?php echo $breadcrumb->trail('&nbsp;>&nbsp;'); ?>
					</div>
				</div> -->
			</div>
			<?php endif;?><?php //breadcrumbs?>
			<?php //if ($_SESSION['shop_id']==1):?>
			<?php //require(display_tpl_common('tpl_banner_top.php'));?>
			<?php //endif;?>
			<?php if (isset($_GET['show_x']) && $_GET['show_x'] && file_exists(DIR_WS_TEMPLATE.'common/'.$_SESSION['shop_id'].'/tpl_banner_top.php')):?>
			 <?php require(DIR_WS_TEMPLATE.'common/'.$_SESSION['shop_id'].'/tpl_banner_top.php');?>
			<?php endif;?>
			<div class=" row">
			<?php if($current_page_base!="product_info"){?>
							<div class="col-xs-3 col-sm-3 col-md-3 hidden-xs ">
								<div class="side hidden-xs">
								
									<?php //if ($_SESSION['shop_id']==1):?>
									<?php //require(display_tpl_common('tpl_banner_left_top.php'));?>
									<?php //endif;?>
									
									<?php if (isset($_GET['show_x']) && $_GET['show_x'] && file_exists(DIR_WS_TEMPLATE.'common/'.$_SESSION['shop_id'].'/tpl_banner_left_top.php')):?>
			            			 <?php require(DIR_WS_TEMPLATE.'common/'.$_SESSION['shop_id'].'/tpl_banner_left_top.php');?>
			            			<?php endif;?>
									
									<?php require (display_template('tpl_categories.php', 'sideboxes'));?>
									<?php //require(get_modules_file('categories', $template_dir, 'sideboxes'));?>
									<?php //require(get_modules_file('whats_new', $template_dir, 'sideboxes'));?>
									<?php  require(get_modules_file('featured', $template_dir, 'sideboxes'));?>
									<?php 
									// var_dump(get_modules_file('search', $template_dir, 'sideboxes'));exit;
									 ?>
									<?php  //require (get_modules_file('search', $template_dir, 'sideboxes'));?>
									
									<?php //require(display_tpl_common('tpl_banner_left_bottom.php'));?>
									<?php if (isset($_GET['show_x']) && $_GET['show_x'] && file_exists(DIR_WS_TEMPLATE.'common/'.$_SESSION['shop_id'].'/tpl_banner_left_bottom.php')):?>
			            			 <?php require(DIR_WS_TEMPLATE.'common/'.$_SESSION['shop_id'].'/tpl_banner_left_bottom.php');?>
			            			<?php endif;?>
			            			
								</div>
							</div>

			<?php  } ?>

				<!-- <div class="col-xs-6 col-sm-3 col-md-3 hidden-xs"> -->
				
		
				<?php if (!$this_is_home_page):?>
					<?php 
						if($current_page_base=="product_info"){
							echo '<div class="col-xs-12 col-sm-9 col-md-12 all_cate ">';
							echo ' <div class="breadcrumb hidden-xs">';
							 echo $breadcrumb->trail('&nbsp;>&nbsp;');
							 echo ' </div>';
							require($body_code);
							echo "</div>";
						}
						else{
							echo '<div class="col-xs-12 col-sm-9 col-md-9 all_cate ">';
							echo ' <div class="breadcrumb hidden-xs">';
							 echo $breadcrumb->trail('&nbsp;>&nbsp;');
							 echo ' </div>';
							require($body_code);
							echo "</div>";
						}
					 ?> 	
					
					<!-- <div class="col-xs-12 col-sm-9 col-md-9 all_cate "> -->
						<?php //require($body_code); ?>
					<!-- </div> -->
				<?php endif ?>
				<div class="col-xs-12 col-sm-9 col-md-6 all_cate " >
				<!-- <div class="col-xs-12 col-sm-9 col-md-9 container-main all_cate " > -->
					<div class="<?php if ($this_is_home_page):?>row<?php endif;?>">
					<!-- <span class='glyphicon glyphicon-list cate_more'></span> -->
					<?php if ($this_is_home_page):?>
						<?php if (isset($_GET['show_x']) && $_GET['show_x'] && file_exists(DIR_WS_TEMPLATE.'common/'.$_SESSION['shop_id'].'/tpl_banner_main.php')):?>
						<div class="col-xs-12 col-sm-12 col-md-12">
            			 <?php require(DIR_WS_TEMPLATE.'common/'.$_SESSION['shop_id'].'/tpl_banner_main.php');?>
            			 </div>

            			<?php endif;?>
						
						<?php $banner_home_flash = jget_banners('homeColumn');?>
						<?php if (count($banner_home_flash) > 0):?>
						<div class="">
							<?php foreach ($banner_home_flash as $bann):?>
							<div class="col-xs-12 col-sm-6 col-md-6">
								<div class="banner-item">
									
									<a href="<?php echo $bann['href'];?>" title="<?php echo $bann['title'];?>"<?php if ($bann['new_window']=='1'):?> target="_blank"<?php endif;?>>
										<img src="<?php echo $bann['image'];?>" alt="<?php echo $bann['title'];?>"/>
									</a>
								</div>
							</div>
							<?php endforeach;?>
						</div>

						<?php else: //banner?>
							
						<?php endif; //no banner?>
						
						<?php $banner_home_flash = jget_banners('globalFlash');?>
						<?php if (count($banner_home_flash) > 0):?>
						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="banners">
								<div class="slide">
									<ul class="items">

									<?php foreach ($banner_home_flash as $bann):?>
									<li><a href="<?php echo $bann['href'];?>" title="<?php echo $bann['title'];?>"<?php if ($bann['new_window']=='1'):?> target="_blank"<?php endif;?>><img src="<?php echo $bann['image'];?>" alt="<?php echo $bann['title'];?>"/></a></li>
									<?php endforeach;?>
									</ul>
								</div>
							</div>
						</div>
						
						<script type="text/javascript" src="<?php echo DIR_WS_TEMPLATE;?>js/jquery.slideBox.js"></script>
						<script type="text/javascript">
						jQuery(function($){
							$('.slide').slideBox({delay:6});
						});
						</script>
						<?php endif;?>
						
						<?php $banner_home_flash = jget_banners('global');?>
						<?php if (count($banner_home_flash) > 0):?>
						<div class="col-xs-12 col-sm-12 col-md-8">
							<div class="banners">
								<?php foreach ($banner_home_flash as $bann):?>
								<a href="<?php echo $bann['href'];?>" title="<?php echo $bann['title'];?>"<?php if ($bann['new_window']=='1'):?> target="_blank"<?php endif;?>><img src="<?php echo $bann['image'];?>" alt="<?php echo $bann['title'];?>"/></a>
								<?php endforeach;?>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-4" class="mid_right">

						<?php require(get_modules_file('whats_new', $template_dir, 'sideboxes'));?>
						</div>
						<?php endif;?>
						<?php require(display_tpl_common('tpl_index_banner'));?>
						<?php require(display_tpl('tpl_modules_featured_products'));?>
						<?php require(display_tpl_common('tpl_auto_banner'));?>
						<?php require(display_tpl('tpl_modules_whats_new'));?>
						
					<?php else:// home?>
						
						<?php //require($body_code); ?>
					<?php endif; // not index?>
					</div>
					
				</div>
					<?php if ($this_is_home_page):?>
						<div class="col-xs-12 col-sm-12 col-md-3 all_cate hidden-xs" >
						
						<?php require(get_modules_file('whats_new2', $template_dir, 'sideboxes'));?>
						<div   class="  hidden-xs">
							<?php //require(get_modules_file('whats_new2', $template_dir, 'sideboxes'));?>
							
							<?php require(get_modules_file('whats_new', $template_dir, 'sideboxes'));?>
						</div>
						</div>
					<?php 	endif ?>
				
				</div>
				<?php if (isset($_GET['show_x']) && $_GET['show_x'] && file_exists(DIR_WS_TEMPLATE.'common/'.$_SESSION['shop_id'].'/tpl_banner_bottom.php')):?>
				<div class="col-xs-12 col-sm-12 col-md-12">
    			 <?php require(DIR_WS_TEMPLATE.'common/'.$_SESSION['shop_id'].'/tpl_banner_bottom.php');?>
    			 </div>
    			<?php endif;?>
			</div>

		</div>
		
		<!-- footer -->
		<div class="col-xs-12 col-sm-12 col-md-12  demo2">
			<div class="container">
				<div class="row">
					<?php require(display_tpl_common('tpl_footer')); ?>
				</div>
				
			</div>
		</div>
		
	</div>
		<a href="" class="cd-top">
			<div class="scroll_top">
			^
			</div>
		</a>
<!--<script type="text/javascript" src="<?php echo DIR_WS_TEMPLATE;?>js/jquery.min.js"></script>-->
<script type="text/javascript" src="<?php echo DIR_WS_TEMPLATE;?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo DIR_WS_TEMPLATE;?>js/respond.min.js"></script>
<script type="text/javascript" src="<?php echo DIR_WS_TEMPLATE;?>js/amazeui.min.js"></script>
<script type="text/javascript" src="<?php echo DIR_WS_TEMPLATE;?>js/jquery.floatDiv.js"></script>

</body>
</html>
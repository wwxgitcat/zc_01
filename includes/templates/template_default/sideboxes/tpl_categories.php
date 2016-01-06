<div class="block categories">
	
	<h4 class="block-title" style="cursor:pointer;" onclick="jQuery('.categories-cnt').slideToggle(300);" >	<?php echo BOX_HEADING_CATEGORIES;?><span class='glyphicon glyphicon-list ' style="position: absolute; right:30px; margin-top:5px;"></span></h4>
	<div class="block-cnt categories-cnt"<?php if (!defined('IS_MOBILE') || IS_MOBILE != true):?> style="display:block;height:auto;"<?php endif;?>>
		<ul class="categories-list">
			<?php foreach ($tpl_categories as $c):?>
			<li class="categoreies-item<?php echo ($c['selected'] ? ' active1' : '');?>">
				<a href="<?php echo $c['href'];?>" title="<?php echo $c['name'];?>"<?php if (count($c['children'])):?>  class="glyphicon glyphicon-menu-right "<?php endif;?>><?php echo $c['name'];?></a>
				<?php if (count($c['children'])>0):?>
				<ul class="categories-item-sub pro_side">
					<?php foreach ($c['children'] as $cs):?>
					<li class="categories-item-sub-item<?php echo ($cs['selected'] ? ' active' : '');?>">
						<a href="<?php echo $cs['href'];?>" title="<?php echo $cs['name'];?>"><?php echo $cs['name'];?></a>
						<?php if (count($cs['children'])):?>
							<!-- <div class="demotest1"> -->
								<!-- <ul class="categories-item-sub3 ">
									<?php foreach ($cs['children'] as $cs3):?>
									<li class="categories-item-sub-item3<?php echo ($cs['selected'] ? ' active' : '');?>"><a href="<?php echo $cs3['href'];?>" title="<?php echo $cs3['name'];?>"><?php echo $cs3['name'];?></a></li>
									<?php endforeach;?>
								</ul> -->
							<!-- </div> -->
						
						<?php endif;?>
					</li>
					<?php endforeach;// end children?>
				</ul>
				<?php endif;//end sub categories?>
			</li>
			<?php endforeach;//end categories?>
		</ul>
	</div>
</div>

<script type="text/javascript">
	$(function(){
		$(this).addClass()
		
		$(".active1").css("background","#fff");
		$(".active1>a").css("font-weight","bold");
		// $(".active1").next(".glyphicon-menu-right").css("font-weight","bold");
		$(".active1").find("ul").css({"display":"block","position":"static","width":"auto","border":"0px","margin-top":"0px","box-shadow":"0px 0px"});
		$(".active1").find(".categoreies-item:hover").css({"background-color":"#000"});

		$(".active").parent().css({"display":"block","position":"static","width":"auto","border":"0px","margin-top":"0px","box-shadow":"0px 0px"});
		$(".active").parentsUntil(".categories-list").css({"background-color":"#fff"});
	
	})
</script>


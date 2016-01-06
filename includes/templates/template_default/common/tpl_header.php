<div class="header-global ">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<?php //display_message('header'); ?>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 row_demo">
						<ul class="header-info">
						<?php if ($_SESSION['customer_id']) { ?>
				<li class="pull-left  hidden-lg hidden-md hidden-sm"><a href="javascript:history.go(-1);" class=""><img class="img_left_small" src="<?php echo DIR_WS_TEMPLATE_IMAGES;?>left1.png" title="<?php echo STORE_NAME;?>" alt="<?php echo STORE_NAME;?>"/></a></li>
									<li class="more1  hidden-lg hidden-md hidden-sm" ><img class="img_left_small" src="<?php echo DIR_WS_TEMPLATE_IMAGES;?>more1.png" data-am-offcanvas="{target: '#doc-oc-demo3', effect: 'push'}" title="<?php echo STORE_NAME;?>" alt="<?php echo STORE_NAME;?>"/></li>
							<li><a class="margin_left_right" href="<?php zlink(FILENAME_CHECKOUT_CONFIRMATION); ?>" rel="nofollow"><?php echo HEADER_TITLE_CHECKOUT; ?></a></li>
							<li><a href="<?php zlink(FILENAME_ACCOUNT); ?>"><?php echo HEADER_TITLE_MY_ACCOUNT; ?></a></li>
							<li><a href="<?php zlink(FILENAME_LOGOFF); ?>" ><?php echo HEADER_TITLE_LOGOFF; ?></a></li>
						<?php } else { ?>
						<li class="pull-left  hidden-lg hidden-md hidden-sm "><a href="javascript:history.go(-1);" class=""><img class="img_left_small" src="<?php echo DIR_WS_TEMPLATE_IMAGES;?>left1.png" title="<?php echo STORE_NAME;?>" alt="<?php echo STORE_NAME;?>"/></a></li>
						<li class="more1  hidden-lg hidden-md hidden-sm" ><img class="img_left_small" src="<?php echo DIR_WS_TEMPLATE_IMAGES;?>more1.png" data-am-offcanvas="{target: '#doc-oc-demo3', effect: 'push'}" title="<?php echo STORE_NAME;?>" alt="<?php echo STORE_NAME;?>"/></li>
							<li><a class="margin_left_right" href="<?php zlink(FILENAME_CHECKOUT_CONFIRMATION); ?>" rel="nofollow"><?php echo HEADER_TITLE_CHECKOUT; ?></a></li>
							<li class="user-login"> <span class="glyphicon glyphicon-user"></span><a class="login" href="<?php zlink(FILENAME_LOGIN); ?>" rel="nofollow"><?php echo HEADER_TITLE_LOGIN; ?></a></li>
						<?php } ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="doc-oc-demo3" class="am-offcanvas">
  <div class="am-offcanvas-bar am-offcanvas-bar-flip">
    <div class="am-offcanvas-content">
    
      <div class="sf-menu-block">
      				<div id="menu-icon" >
      					<?php echo BOX_HEADING_CATEGORIES;?>
      				</div>
      				<ul class="sf-menu-phone">
      						<?php foreach ($tpl_categories as $c):?>
      						<li class="level0  level-top <?php if (count($c['children'])>0){echo "parent";}?>">
      							<a class="level-top" title="<?php echo $c['name'];?>"  href="<?php echo $c['href'];?>">
      								<span><?php echo $c['name'];?></span>
      							</a>
      							<?php if (count($c['children'])>0):?>
      							<ul class="level0 ">
      								<?php foreach ($c['children'] as $cs):?>
      								<li class="level1"><a title="<?php echo $cs['name'];?>" href="<?php echo $cs['href'];?>">▪&nbsp;<?php echo $cs['name'];?></a></li>
      								<?php endforeach;?>
      							</ul>
      							<strong class="opened">	</strong>
      							<?php endif;?>
      						</li>
      						<?php endforeach;?>
      				</ul>
      			</div>
    </div>
  </div>
</div>
<div class="demo1">
<div class="header"  >
	<div class="container" >
		<div class="row1  head_row1" style="margin-top:45px;">
			<div class="col-xs-12 col-sm-4 col-md-4">
				<div class=" logo">
					<a href="<?php echo zen_href_link(FILENAME_DEFAULT); ?>">
						<span class="store-name">
							<?php $logo_form_banner = jget_banners('logo'); $logo_form_banner = $logo_form_banner[0]?>
							<img src="<?php echo $logo_form_banner['image'];?>" title="<?php echo STORE_NAME;?>" alt="<?php echo STORE_NAME;?>"/>
						</span>
						
					</a>
				</div>
			</div>
			<div class="col-xs-12 col-sm-5 col-md-4 search_demo" >
				<div class="search-global">
					<form class="form-inline" role="form" action="<?php echo zlink(FILENAME_ADVANCED_SEARCH_RESULT, '', $request_type, false);?>" name="search" method="get">
						<input type="hidden" name="main_page" value="<?php echo FILENAME_ADVANCED_SEARCH_RESULT;?>" />
						<input type="hidden" name="search_in_description" value="1" />
						<?php echo zen_hide_session_id();?>
						<div class="form-group ">
							<input type="search" onblur="if (this.value == '') this.value = '<?php echo BOX_HEADING_SEARCH;?>';" onfocus="if (this.value == '<?php echo BOX_HEADING_SEARCH;?>') this.value = '';" value="<?php echo BOX_HEADING_SEARCH;?>" maxlength="100" id="searchText" class="form-control" name="keyword">
							<button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-search"></span></button>
						</div>
					</form>
				</div>
			</div>
			<!-- <div class="col-xs-12 col-sm-3 col-md-4" style="width:auto"> -->
			<div class="col-xs-12 col-sm-3 col-md-4">
				<?php require(get_modules_file('shopping_cart_info'));?>
				<div class="cart-info text-right">
					<a href="<?php echo zlink(FILENAME_SHOPPING_CART);?>">
						<span class="glyphicon glyphicon-shopping-cart icon-cart"></span>
						<span class="cart-info-tip"><?php echo CART_ITEMS;?></span>
						<span class="cart-infor-total" >
							<?php echo $tpl_shopping_cart['count'];?>
							<?php if ($tpl_shopping_cart['count'] > 0):?>
								 x <?php echo $tpl_shopping_cart['total'];?>
							<?php endif;?>
						</span>
					</a>
				</div>
			</div>
		</div>
		<!-- nav -->
		<div class="row nav_row">
			<div class="col-xs-12 col-sm-12 col-md-12 hidden-xs">
				<ul class="navbar">
			
					<li class="nav-item demo_nav"><a href="<?php echo zhlink();?>" title="<?php echo STORE_NAME;?>"><?php echo TEXT_HOME;?></a></li>
					<?php
					$main_category_tree = new category_tree();
					$main_category_tree->zen_category_tree();
					$nav_count = 0;
					foreach ((array)$main_category_tree->tree_parents[0] as $cate):?>
						<?php if (++$nav_count >= (int)HEADER_NAV_SHOW_TOTAL) break;?>
						<?php if ($cate['is_top']):?>
						<li class="nav-item demo_nav">
							<div class="">
							<a href="<?php echo zen_href_link(FILENAME_DEFAULT, 'cPath='.$cate['path']);?>" title="<?php echo $cate['name'];?>"><?php echo $cate['name'];?></a>
							</div>
							<?php if (isset($main_category_tree->tree_parents[$cate['path']])):?>
							<ul class="nav-item-sub">
								<?php foreach ($main_category_tree->tree_parents[$cate['path']] as $cate_sub):?>
								<li><a href="<?php echo zen_href_link(FILENAME_DEFAULT, 'cPath='.$cate_sub['path']);?>" title="<?php echo $cate_sub['name'];?>"><?php echo $cate_sub['name'];?></a></li>
								<?php endforeach;?>
							</ul>
							<?php endif;?>
						</li>
						<?php endif;//show top?>
					<?php endforeach;?>
				</ul>
			</div>
		</div>

	</div>
		
</div>
</div>
<style type="text/css">

	.demo_nav{list-style-image: url('<?php echo DIR_WS_TEMPLATE_IMAGES;?>nav_jt.png"?>');}
</style>

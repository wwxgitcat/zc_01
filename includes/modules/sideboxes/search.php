<?php
/**
 * search sidebox - displays keyword-search field for customer to initiate a search
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: search.php 2834 2006-01-11 22:16:37Z birdbrain $
 */

// require($template->get_template_dir('tpl_search.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_search.php');
?>


<div class="left_cat_a">
	
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr align="center">
				<td align="left"><br>
					<form class="clearfix"
						action="<?php echo zen_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', $request_type, false);?>"
						name="quick_find" method="get">
						<input type="hidden" name="main_page"
							value="<?php echo FILENAME_ADVANCED_SEARCH_RESULT;?>" /> <input
							type="hidden" name="search_in_description" value="1" /><?php echo zen_hide_session_id();?>
		<?php if (strtolower(IMAGE_USE_CSS_BUTTONS) == 'yes'):?>
			<input type="text"  name="keyword" size="18" maxlength="100" style="width:<?php echo ($column_width-30);?>px;" /><br />
			<?php echo zen_image_submit (BUTTON_IMAGE_SEARCH,HEADER_SEARCH_BUTTON);?><br />
						<a href="<?php echo zen_href_link(FILENAME_ADVANCED_SEARCH);?>"><?php echo BOX_SEARCH_ADVANCED_SEARCH;?></a>
		<?php else:?>
			<input style="background:url('<?php echo DIR_WS_TEMPLATE_IMAGES;?>search.jpg') no-repeat" class="input text_key_word" type="text" name="keyword"
							class="" maxlength="200"
							onfocus="if (this.value == '<?php echo HEADER_SEARCH_DEFAULT_TEXT;?>')this.value = '';"
							onblur="if (this.value == '') this.value = '<?php echo HEADER_SEARCH_DEFAULT_TEXT;?>';" />

						<input type="submit" value="<?php echo sprintf(TABLE_HEADING_FEATURED_POPULAR_KETWORD, strftime('%B')); ?>" class="button btn_key_word"/>
		<?php endif;?>
		</form></td>
			</tr>
		</tbody>
	</table>
	<br> 

	<h3 class=""><?php echo BOX_HEADING_CATEGORIES;?></h3>
	<div class="">
		<ul class="sf-menu-phone">
				<?php foreach ($tpl_categories as $c):?>
				<li class="level0  level-top <?php if (count($c['children'])>0){echo "parent";}?>">
					<a class="level-top" onclick="test2()" title="<?php echo $c['name'];?>"  href="javascript:void(0);">
						<span><?php echo $c['name'];?></span>
					</a>
					<?php if (count($c['children'])>0):?>
					<ul class="level0 test1">
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

<style type="text/css">
	.test1,.categories{display: none;}
	
</style>
<script type="text/javascript">
	// function test2() {
	// 	$(this).css("background","blue");
	// }
	$(function(){
		$(".level-top").click(function(){
			// alert("asdsd");
			// $(this).parent().find(".test1").css("display","none");
			$(this).next(".test1").toggle(300);
		})
	})
</script>
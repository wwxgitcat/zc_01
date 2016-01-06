<div class="xcb5fg">
	<b>商品検索</b>
</div>
<div class="eber6r">
	<form action="<?php echo zen_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', $request_type, false);?>" name="quick_find" method="get">
		<input type="hidden" name="main_page" value="<?php echo FILENAME_ADVANCED_SEARCH_RESULT;?>" />
		<input type="hidden" name="search_in_description" value="1" />
	  	<?php echo zen_hide_session_id();?>
	  <p class="cb7gb">
			<input type="text" name="keyword" id="orderNumber" class="yzgkbmof" size="25" maxlength="100" />
		</p>
		<div class="d8rt">
			<input class="wfkyswwg" type="submit" value="<?php echo BOX_HEADING_SEARCH; ?>" />
		</div>
	</form>
</div>

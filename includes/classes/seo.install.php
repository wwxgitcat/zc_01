<?php
/*
 * +----------------------------------------------------------------------+ |	Ultimate SEO URLs For Zen Cart, version 2.100 | +----------------------------------------------------------------------+ | | |	Derrived from Ultimate SEO URLs v2.1 for osCommerce by Chemo | | | |	Portions Copyright 2005, Joshua Dechant | | | |	Portions Copyright 2005, Bobby Easland | | | |	Portions Copyright 2003 The zen-cart developers | | | +----------------------------------------------------------------------+ | This source file is subject to version 2.0 of the GPL license, | | that is bundled with this package in the file LICENSE, and is | | available through the world-wide-web at the following url: | | http://www.zen-cart.com/license/2_0.txt. | | If you did not receive a copy of the zen-cart license and are unable | | to obtain it through the world-wide-web, please send a note to | | license@zen-cart.com so we can mail you a copy immediately. | +----------------------------------------------------------------------+
 */
class SEO_URL_INSTALLER
{
	var $default_config;
	var $db;
	var $attributes;
	function SEO_URL_INSTALLER()
	{
		$this->attributes = array();
		
		$x = 0;
		$this->default_config = array();
		
		$this->default_config['SEO_ENABLED'] = array(
			'DEFAULT' => 'true',
			'QUERY' => "INSERT INTO `" . TABLE_CONFIGURATION . "` VALUES (NULL, '启用网址优化吗?', 'SEO_ENABLED', 'false', '是否启用网址优化? 这是整站的开关。<br /><br />请将根目录下的文件htaccess_sample改名为 .htaccess，并修改其中的 /shop/ 为您的zen cart目录。如果Zen Cart安装在网页服务器的根目录下，就设置为 /。<br /><br />打开网址优化后，请执行一次下面的重置缓存(reset)操作。', GROUP_INSERT_ID, " . $x . ", NOW(), NOW(), NULL, 'zen_cfg_select_option(array(''true'', ''false''),')" 
		);
		$x++;
		
		$this->default_config['SEO_ADD_CPATH_TO_PRODUCT_URLS'] = array(
			'DEFAULT' => 'false',
			'QUERY' => "INSERT INTO `" . TABLE_CONFIGURATION . "` VALUES (NULL, '在商品的网址中添加cPath吗?', 'SEO_ADD_CPATH_TO_PRODUCT_URLS', 'false', '在商品的网址后添加cPath (例如: some-product-p-1.html?cPath=xx).', GROUP_INSERT_ID, " . $x . ", NOW(), NOW(), NULL, 'zen_cfg_select_option(array(''true'', ''false''),')" 
		);
		$x++;
		
		$this->default_config['SEO_ADD_CAT_PARENT'] = array(
			'DEFAULT' => 'true',
			'QUERY' => "INSERT INTO `" . TABLE_CONFIGURATION . "` VALUES (NULL, '商品分类的网址中包括上级分类名称吗?', 'SEO_ADD_CAT_PARENT', 'false', '在分类网址前增加上级分类名称 (例如: parent-category-c-1.html).', GROUP_INSERT_ID, " . $x . ", NOW(), NOW(), NULL, 'zen_cfg_select_option(array(''true'', ''false''),')" 
		);
		$x++;
		
		/*
		 * START SEO-ADD-PRODUCT-CAT PATCH Patched to use SEO_ADD_PRODUCT_CAT This allows the use of a directory structure for urls. @author Andrew Ballanger
		 */
		$this->default_config['SEO_ADD_PRODUCT_CAT'] = array(
			'DEFAULT' => 'true',
			'QUERY' => "INSERT INTO `" . TABLE_CONFIGURATION . "` VALUES (NULL, '商品的网址中包括上级分类名称吗?', 'SEO_ADD_PRODUCT_CAT', 'false', '在商品网址前加上级分类名称 (例如: category-c-1/product-p-1.html)。', GROUP_INSERT_ID, " . $x . ", NOW(), NOW(), NULL, 'zen_cfg_select_option(array(''true'', ''false''),')" 
		);
		$x++;
		// END SEO-ADD-PRODUCT-CAT PATCH
		
		$this->default_config['SEO_URLS_FILTER_SHORT_WORDS'] = array(
			'DEFAULT' => '0',
			'QUERY' => "INSERT INTO `" . TABLE_CONFIGURATION . "` VALUES (NULL, '过滤太短的单词', 'SEO_URLS_FILTER_SHORT_WORDS', '0', '该设置从网址中过滤少于指定值的单词。', GROUP_INSERT_ID, " . $x . ", NOW(), NOW(), NULL, NULL)" 
		);
		$x++;
		
		$this->default_config['SEO_URLS_USE_W3C_VALID'] = array(
			'DEFAULT' => 'true',
			'QUERY' => "INSERT INTO `" . TABLE_CONFIGURATION . "` VALUES (NULL, '输出兼容W3C的网址 (参数)?', 'SEO_URLS_USE_W3C_VALID', 'false', '该设置输出兼容W3C的网址。', GROUP_INSERT_ID, " . $x . ", NOW(), NOW(), NULL, 'zen_cfg_select_option(array(''true'', ''false''),')" 
		);
		$x++;
		
		$this->default_config['USE_SEO_CACHE_GLOBAL'] = array(
			'DEFAULT' => 'true',
			'QUERY' => "INSERT INTO `" . TABLE_CONFIGURATION . "` VALUES (NULL, '打开缓存以减少查询次数吗?', 'USE_SEO_CACHE_GLOBAL', 'true', '该设置可以完全关闭缓存。', GROUP_INSERT_ID, " . $x . ", NOW(), NOW(), NULL, 'zen_cfg_select_option(array(''true'', ''false''),')" 
		);
		$x++;
		
		$this->default_config['USE_SEO_CACHE_PRODUCTS'] = array(
			'DEFAULT' => 'true',
			'QUERY' => "INSERT INTO `" . TABLE_CONFIGURATION . "` VALUES (NULL, '打开商品缓存吗?', 'USE_SEO_CACHE_PRODUCTS', 'true', '该设置可以关闭商品缓存。', GROUP_INSERT_ID, " . $x . ", NOW(), NOW(), NULL, 'zen_cfg_select_option(array(''true'', ''false''),')" 
		);
		$x++;
		
		$this->default_config['USE_SEO_CACHE_CATEGORIES'] = array(
			'DEFAULT' => 'true',
			'QUERY' => "INSERT INTO `" . TABLE_CONFIGURATION . "` VALUES (NULL, '打开目录缓存吗?', 'USE_SEO_CACHE_CATEGORIES', 'true', '该设置可以关闭分类缓存。', GROUP_INSERT_ID, " . $x . ", NOW(), NOW(), NULL, 'zen_cfg_select_option(array(''true'', ''false''),')" 
		);
		$x++;
		
		$this->default_config['USE_SEO_CACHE_MANUFACTURERS'] = array(
			'DEFAULT' => 'true',
			'QUERY' => "INSERT INTO `" . TABLE_CONFIGURATION . "` VALUES (NULL, '打开厂家缓存吗?', 'USE_SEO_CACHE_MANUFACTURERS', 'true', '该设置可以关闭厂家缓存。', GROUP_INSERT_ID, " . $x . ", NOW(), NOW(), NULL, 'zen_cfg_select_option(array(''true'', ''false''),')" 
		);
		$x++;
		
		$this->default_config['USE_SEO_CACHE_ARTICLES'] = array(
			'DEFAULT' => 'true',
			'QUERY' => "INSERT INTO `" . TABLE_CONFIGURATION . "` VALUES (NULL, '打开文章缓存吗?', 'USE_SEO_CACHE_ARTICLES', 'true', '该设置可以关闭文章缓存。', GROUP_INSERT_ID, " . $x . ", NOW(), NOW(), NULL, 'zen_cfg_select_option(array(''true'', ''false''),')" 
		);
		$x++;
		
		$this->default_config['USE_SEO_CACHE_INFO_PAGES'] = array(
			'DEFAULT' => 'true',
			'QUERY' => "INSERT INTO `" . TABLE_CONFIGURATION . "` VALUES (NULL, '打开信息缓存吗?', 'USE_SEO_CACHE_INFO_PAGES', 'true', '该设置可以关闭信息缓存。', GROUP_INSERT_ID, " . $x . ", NOW(), NOW(), NULL, 'zen_cfg_select_option(array(''true'', ''false''),')" 
		);
		$x++;
		
		$this->default_config['USE_SEO_REDIRECT'] = array(
			'DEFAULT' => 'true',
			'QUERY' => "INSERT INTO `" . TABLE_CONFIGURATION . "` VALUES (NULL, '打开自动跳转吗?', 'USE_SEO_REDIRECT', 'true', '该设置实现自动跳转，发送301文件头实现旧网址转向新网址。', GROUP_INSERT_ID, " . $x . ", NOW(), NOW(), NULL, 'zen_cfg_select_option(array(''true'', ''false''),')" 
		);
		$x++;
		
		$this->default_config['SEO_REWRITE_TYPE'] = array(
			'DEFAULT' => 'Rewrite',
			'QUERY' => "INSERT INTO `" . TABLE_CONFIGURATION . "` VALUES (NULL, '选择网址重写类型', 'SEO_REWRITE_TYPE', 'Rewrite', '选择网址重写的格式。', GROUP_INSERT_ID, " . $x . ", NOW(), NOW(), NULL, 'zen_cfg_select_option(array(''Rewrite''),')" 
		);
		$x++;
		
		$this->default_config['SEO_CHAR_CONVERT_SET'] = array(
			'DEFAULT' => '',
			'QUERY' => "INSERT INTO `" . TABLE_CONFIGURATION . "` VALUES (NULL, '输入特殊字符转换', 'SEO_CHAR_CONVERT_SET', '', '该设置转换特殊字符。<br><br>格式<b>必须</b>为: <b>char=>conv,char2=>conv2</b>', GROUP_INSERT_ID, " . $x . ", NOW(), NOW(), NULL, NULL)" 
		);
		$x++;
		
		$this->default_config['SEO_REMOVE_ALL_SPEC_CHARS'] = array(
			'DEFAULT' => 'false',
			'QUERY' => "INSERT INTO `" . TABLE_CONFIGURATION . "` VALUES (NULL, '要删除字母数字外的所有字符吗?', 'SEO_REMOVE_ALL_SPEC_CHARS', 'false', '该设置可以删除所有除字母和数字外的字符。', GROUP_INSERT_ID, " . $x . ", NOW(), NOW(), NULL, 'zen_cfg_select_option(array(''true'', ''false''),')" 
		);
		$x++;
		
		// START SEO-URLS-FILTER-PCRE PATCH
		$this->default_config['SEO_URLS_FILTER_PCRE'] = array(
			'DEFAULT' => '',
			'QUERY' => "INSERT INTO `" . TABLE_CONFIGURATION . "` VALUES (NULL, '输入网址的 PCRE 过滤规则', 'SEO_URLS_FILTER_PCRE', '', '使用PCRE规则过滤生成的网址。<br><br>格式<b>必须</b>为: <b>find1=>replace1,find2=>replace2</b>. 在字符转换和删除特殊字符前运行。如果网址中要短横线 - ，可以使用空格。如果是反斜线，要输入两次', GROUP_INSERT_ID, " . $x . ", NOW(), NOW(), NULL, NULL)" 
		);
		$x++;
		// END SEO-URLS-FILTER-PCRE PATCH
		
		$this->default_config['SEO_URLS_CACHE_RESET'] = array(
			'DEFAULT' => 'false',
			'QUERY' => "INSERT INTO `" . TABLE_CONFIGURATION . "` VALUES (NULL, '重置缓存', 'SEO_URLS_CACHE_RESET', 'false', '该设置重置搜索引擎优化缓存的数据。', GROUP_INSERT_ID, " . $x . ", NOW(), NOW(), 'zen_reset_cache_data_seo_urls', 'zen_cfg_select_option(array(''reset'', ''false''),')" 
		);
		$x++;
		
		// IMAGINADW.COM
		$this->default_config['SEO_URLS_ONLY_IN'] = array(
			'DEFAULT' => 'index, product_info, products_new, products_all, featured_products, specials, contact_us, conditions, privacy, reviews, shippinginfo, faqs_all, site_map, gv_faq, discount_coupon, page, page_2, page_3, page_4',
			'QUERY' => "INSERT INTO `" . TABLE_CONFIGURATION . "` VALUES (NULL, '输入需要优化的页面', 'SEO_URLS_ONLY_IN', 'index, product_info, products_new, products_all, featured_products, specials, contact_us, conditions, privacy, reviews, shippinginfo, faqs_all, site_map, gv_faq, discount_coupon, page, page_2, page_3, page_4, login, account, create_account, advanced_search, product_free_shipping_info, product_music_info, document_product_info, document_general_info, shopping_cart, unsubscribe', '本设置指定需要网址重写的页面，如果为空，所有页面网址都重写。<br><br>默认页面为: <b>index, product_info, products_new, products_all, featured_products, specials, contact_us, conditions, privacy, reviews, shippinginfo, faqs_all, site_map, gv_faq, discount_coupon, page, page_2, page_3, page_4, login, account, create_account, advanced_search, product_free_shipping_info, product_music_info, document_product_info, document_general_info, shopping_cart, unsubscribe</b>', GROUP_INSERT_ID, " . $x . ", NOW(), NOW(), NULL, NULL)" 
		);
		$x++;
		
		$this->db = &$GLOBALS['db'];
		
		$this->init();
	}
	
	/**
	 * Initializer - if there are settings not defined the default config will be used and database settings installed.
	 * 
	 * @author Bobby Easland
	 * @version 1.1
	 */
	function init()
	{
		foreach($this->default_config as $key => $value)
		{
			$container[] = defined($key) ? 'true' : 'false';
		} // end foreach
		$this->attributes['IS_DEFINED'] = in_array('false', $container) ? false : true;
		switch(true)
		{
			case (!$this->attributes['IS_DEFINED']):
				$this->eval_defaults();
				$sql = "SELECT configuration_key, configuration_value
						FROM " . TABLE_CONFIGURATION . "
						WHERE configuration_key LIKE '%SEO%'";
				$result = $this->db->Execute($sql);
				$num_rows = $result->RecordCount();
				$this->attributes['IS_INSTALLED'] = (sizeof($container) == $num_rows) ? true : false;
				if (!$this->attributes['IS_INSTALLED'])
				{
					$this->install_settings();
				}
				break;
			default:
				$this->attributes['IS_INSTALLED'] = true;
				break;
		} // end switch
	} // end function
	
	/**
	 * This function evaluates the default settings into defined constants
	 * 
	 * @author Bobby Easland
	 * @version 1.0
	 */
	function eval_defaults()
	{
		foreach($this->default_config as $key => $value)
		{
			define($key, $value['DEFAULT']);
		} // end foreach
	} // end function
	
	/**
	 * This function removes the database settings (configuration and cache)
	 * 
	 * @author Bobby Easland
	 * @version 1.0
	 */
	function uninstall_settings()
	{
		$this->db->Execute("DELETE FROM `" . TABLE_CONFIGURATION_GROUP . "` WHERE `configuration_group_title` LIKE '%SEO%'");
		$this->db->Execute("DELETE FROM `" . TABLE_CONFIGURATION . "` WHERE `configuration_key` LIKE '%SEO%'");
		
		/*
		 * START SEO-1.5-COMPATIBILITY Patched for compatibility with Zen Cart 1.5 @author Andrew Ballanger
		 */
		$this->db->Execute("DELETE FROM `" . TABLE_ADMIN_PAGES . "` WHERE `page_key`='configUltimateSEO'");
		// END SEO-1.5-COMPATIBILITY
		
		// Version 2.200 is a branch off version 2.110 and does not use the same
		// keys to add the admin pages as version 2.150.
		// If the key used by version 2.150 is present remove the old key to
		// avoid potential issues later down the road.
		$this->db->Execute("DELETE FROM `" . TABLE_ADMIN_PAGES . "` WHERE `page_key`='UltimateSEO'");
		
		$this->db->Execute("DROP TABLE IF EXISTS " . TABLE_SEO_CACHE);
	} // end function
	
	/**
	 * This function installs the database settings
	 * 
	 * @author Bobby Easland
	 * @version 1.0
	 */
	function install_settings()
	{
		$this->uninstall_settings();
		$sort_order_query = "SELECT MAX(sort_order) as max_sort FROM `" . TABLE_CONFIGURATION_GROUP . "`";
		$next_sort = $this->db->Execute($sort_order_query);
		$next_sort = $next_sort->fields['max_sort'] + 1;
		$insert_group = "INSERT INTO `" . TABLE_CONFIGURATION_GROUP . "` VALUES (NULL, '网址优化', '网址优化模块的选项', '" . $next_sort . "', '1')";
		$this->db->Execute($insert_group);
		$group_id = $this->db->insert_ID();
		
		/*
		 * START SEO-1.5-COMPATIBILITY Patched for compatibility with Zen Cart 1.5 @author Andrew Ballanger
		 */
		$page_sort_query = "SELECT MAX(sort_order) as max_sort FROM `" . TABLE_ADMIN_PAGES . "` WHERE menu_key='configuration'";
		$page_sort = $this->db->Execute($page_sort_query);
		$page_sort = $page_sort->fields['max_sort'] + 1;
		$insert_page = "INSERT INTO `" . TABLE_ADMIN_PAGES . "` VALUES ('configUltimateSEO', 'BOX_CONFIGURATION_ULTIMATE_SEO', 'FILENAME_CONFIGURATION', 'gID=" . $group_id . "', 'configuration', 'Y', '" . $page_sort . "')";
		$this->db->Execute($insert_page);
		// END SEO-1.5-COMPATIBILITY
		
		foreach($this->default_config as $key => $value)
		{
			$sql = str_replace('GROUP_INSERT_ID', $group_id, $value['QUERY']);
			$this->db->Execute($sql);
		}
		
		$insert_cache_table = "CREATE TABLE " . TABLE_SEO_CACHE . " (
		  `cache_id` varchar(32) NOT NULL default '',
		  `cache_language_id` tinyint(1) NOT NULL default '0',
		  `cache_name` varchar(255) NOT NULL default '',
		  `cache_data` mediumtext NOT NULL,
		  `cache_global` tinyint(1) NOT NULL default '1',
		  `cache_gzip` tinyint(1) NOT NULL default '1',
		  `cache_method` varchar(20) NOT NULL default 'RETURN',
		  `cache_date` datetime NOT NULL default '0000-00-00 00:00:00',
		  `cache_expires` datetime NOT NULL default '0000-00-00 00:00:00',
		  PRIMARY KEY  (`cache_id`,`cache_language_id`),
		  KEY `cache_id` (`cache_id`),
		  KEY `cache_language_id` (`cache_language_id`),
		  KEY `cache_global` (`cache_global`)
		) CHARACTER SET utf8 COLLATE utf8_general_ci;";
		$this->db->Execute($insert_cache_table);
	} // end function
} // end class
?>
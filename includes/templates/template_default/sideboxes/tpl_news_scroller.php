<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce |
// +----------------------------------------------------------------------+
// | Copyright (c) 2004-2005 Joshua Dechant |
// | |
// | Portions Copyright (c) 2004 The zen-cart developers |
// | |
// | http://www.zen-cart.com/index.php |
// | |
// | Portions Copyright (c) 2003 osCommerce |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license, |
// | that is bundled with this package in the file LICENSE, and is |
// | available through the world-wide-web at the following url: |
// | http://www.zen-cart.com/license/2_0.txt. |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to |
// | license@zen-cart.com so we can mail you a copy immediately. |
// +----------------------------------------------------------------------+
// $Id: tpl_news_scroller.php v1.000 2005-02-04 dreamscape <dechantj@pop.belmont.edu>
//
$content = '';

$newsDisplay = new newsDisplay();

foreach($article_array as $articles)
{
	foreach($articles['articles'] as $article)
	{
		$newsDisplay->articleSummary($article['articleName'], $article['articleSummary'], $article['articleLink'], BOX_NEWS_SCROLLER_TEXT_READ_FULL_ARTICLE);
	}
}

$content .= '<div class="newsScrollerSideBox">' . "\n" . '  <script language="javascript" type="text/javascript" src="includes/newsScroller.js"></script>' . "\n" . '  <script language="javascript" type="text/javascript"><!--' . "\n" . '    var scroller_html = \'' . news_prepare_javascript_data($newsDisplay->displayNewsPage(false)) . '\';' . "\n" . '    newsScroller("news_scroller", ' . NEWS_SCROLLER_HEIGHT . ', ' . ((int)$column_width - 10) . ', ' . (int)NEWS_SCROLLER_AMOUNT . ', ' . (int)NEWS_SCROLLER_DELAY . ', scroller_html);' . "\n" . '    newsScroller_init();' . "\n" . '  //--></script>' . "\n" . '</div>' . "\n";
?>
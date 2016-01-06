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
// $Id: tpl_news_default.php v2.100 2005-02-01 dreamscape <dechantj@pop.belmont.edu>
//
?>
<?php
// Start the news display class
$newsDisplay = new newsDisplay();
// News header
$newsDisplay->newsHeader(HEADING_TITLE, $newsDate, $newsHeaderLinks);
// Did we find some articles to display?
if ($articlesNotFound == true)
{
	// Oh no, no articles were found
	$newsDisplay->articlesNotFound(sprintf(TEXT_NO_NEWS_ARTICLES, $newsCurrentDate));
	$newsDisplay->articleSplit();
}
else
{
	foreach($newsArticlesBlock as $newsArticle)
	{
		// Set article heading
		$newsDisplay->articleHeading($newsArticle['articleName']);
		// Set by line
		$newsDisplay->articleByLine(sprintf(TEXT_ARTICLE_BY_LINE, $newsArticle['articleAuthor']), $newsArticle['commentsURL'], (($newsArticle['comments'] > 0) ? sprintf(TEXT_POST_COMMENT_1, $newsArticle['comments']) : TEXT_POST_COMMENT_2));
		// Set article main text
		$newsDisplay->articleText(str_replace('&lt;', '<', str_replace('&gt;', '>', str_replace('&amp;', '&', str_replace('&nbsp;', '', str_replace('&quot;', '"', $newsArticle['articleText']))))), $newsArticle['articleImage']);
		// Set article links
		$newsDisplay->articleLinksBlock($newsArticle['links']);
		$newsDisplay->articleSplit();
	}
}
// News Footer
$newsDisplay->articleFooter(sprintf(TEXT_NEWS_FOOTER, $newsFooterDate), $newsFooter, $newsFooterDateURL);
// Recent News Footer
$newsDisplay->articleFooter(TEXT_RECENT_NEWS, $newsRecentFooter);
// Archive link
$newsDisplay->archiveLink(zen_href_link(FILENAME_NEWS_ARCHIVE), TEXT_NEWS_ARCHIVE_LINK);
// Display this news page
// New page content is output in valid XHTML
// You can change how it displays in the stylesheet_news.css file
$newsDisplay->displayNewsPage();
?>
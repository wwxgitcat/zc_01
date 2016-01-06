<?php
//
?>
<?php
// Start the news display class
$newsDisplay = new newsDisplay();
// News header
$newsDisplay->newsHeader(HEADING_TITLE, $newsDate, $newsHeaderLinks);
// Set article heading
$newsDisplay->articleHeading($articleName);
// Set by line
$newsDisplay->articleByLine(sprintf(TEXT_ARTICLE_BY_LINE, $articleAuthor), $commentsURL, (($comments > 0) ? sprintf(TEXT_POST_COMMENT_1, $comments) : TEXT_POST_COMMENT_2));
// Set article main text
$newsDisplay->articleText(str_replace('&lt;', '<', str_replace('&gt;', '>', str_replace('&nbsp;', ' ', str_replace('&quot;', '"', $articleText)))), $articleImage);
// Set article links
$newsDisplay->articleLinksBlock($articleLinks);
$newsDisplay->articleSplit();
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
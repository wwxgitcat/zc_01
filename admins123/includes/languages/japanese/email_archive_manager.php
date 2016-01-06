<?php
/*
 * ////////////////////////////////////////////////////////// // EMAIL ARCHIVE SEARCH // // Version 1.5 // // // // By Frank Koehl (PM: BlindSide) // // Support by DrByte // // // // Powered by Zen-Cart (www.zen-cart.com) // // Portions Copyright (c) 2005 The Zen-Cart Team // // // // Released under the GNU General Public License // // available at www.zen-cart.com/license/2_0.txt // // or see "license.txt" in the downloaded zip // //////////////////////////////////////////////////////////
 */
define('SUBJECT_SIZE_LIMIT', 25);
define('MESSAGE_SIZE_LIMIT', 550);
define('MESSAGE_LIMIT_BREAK', '...');

define('HEADING_TITLE', '邮件记录管理');
define('HEADING_SEARCH_INSTRUCT', '可以根据以下条件组合搜索 ...');

define('HEADING_MODULE_SELECT', '按模块过滤');
define('HEADING_SEARCH_TEXT', '搜索文字');
define('HEADING_SEARCH_TEXT_FILTER', '当前搜索条件: ');
define('HEADING_START_DATE', '开始日期');
define('HEADING_END_DATE', '结束日期');
define('HEADING_PRINT_FORMAT', '打印格式显示');
define('HEADING_TRIM_INSTRUCT', '删除旧的邮件...');

define('TABLE_HEADING_EMAIL_DATE', '发送日期');
define('TABLE_HEADING_CUSTOMERS_NAME', '客户姓名');
define('TABLE_HEADING_CUSTOMERS_EMAIL', '邮件地址');
define('TABLE_HEADING_EMAIL_FORMAT', '格式');
define('TABLE_HEADING_EMAIL_SUBJECT', '标题');
define('TABLE_FORMAT_TEXT', 'TEXT');
define('TABLE_FORMAT_HTML', 'HTML');

define('TEXT_TRIM_ARCHIVE', '整理邮件存档...');
define('TEXT_ARCHIVE_ID', '存档 #');
define('TEXT_ALL_MODULES', '所有模块');
define('TEXT_DISPLAY_NUMBER_OF_EMAILS', '显示从<b>%d</b>到<b>%d</b> (共<b>%d</b>封邮件)');
define('TEXT_EMAIL_MODULE', '模块: ');
define('TEXT_EMAIL_TO', '收件人: ');
define('TEXT_EMAIL_FROM', '发件人: ');
define('TEXT_EMAIL_DATE_SENT', '发送: ');
define('TEXT_EMAIL_SUBJECT', '标题: ');
define('TEXT_EMAIL_EXCERPT', '内容摘录:');
define('TEXT_EMAIL_NUMBER', '邮件 #');

define('RADIO_1_MONTH', ' 1个月');
define('RADIO_6_MONTHS', ' 6个月');
define('RADIO_1_YEAR', ' 12个月');
define('TRIM_CONFIRM_WARNING', '警告: 将彻底删除邮件存档。<br />确定吗?');
define('POPUP_CONFIRM_RESEND', '确定要重发这封邮件吗?');
define('POPUP_CONFIRM_DELETE', '确定要删除这封邮件吗?');
define('SUCCESS_TRIM_ARCHIVE', '成功: 早于<strong>%s</strong>的邮件已删除');
define('SUCCESS_EMAIL_RESENT', '成功: 邮件 #%s 已重发给 %s');

define('IMAGE_ICON_HTML', ' 查看 HTML 邮件 ');
define('IMAGE_ICON_TEXT', ' 查看 Text 邮件 ');
define('IMAGE_ICON_RESEND', ' 重发信息 ');
define('IMAGE_ICON_EMAIL', ' 邮件收据 ');
define('IMAGE_ICON_DELETE', ' 删除信息 ');

define('BUTTON_SEARCH', '搜索存档');
define('BUTTON_TRIM_CONFIRM', '删除邮件');
define('BUTTON_CANCEL', '取消');
?>

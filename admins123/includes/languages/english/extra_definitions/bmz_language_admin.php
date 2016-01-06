<?php
define(IH_RESIZE_TITLE, 'IH 调整图像大小');
define(IH_RESIZE_TEXT, 'Zen-Cart的缺省设置为 -no-，要打开自动调整图像大小，设置为 -yes-。--说明: 如果选择 -no-, 所有图像管理相关的设置会失效，包括: 图像文件类型选择、背景颜色、压缩、弹出图像和水印-- 如果要使用ImageMagick，请在<em>includes/extra_configures/bmz_image_handler_conf.php</em>中设定<strong>convert</strong>文件的路径。');

define(SMALL_IMAGE_FILETYPE_TITLE, 'IH 小图像文件类型');
define(SMALL_IMAGE_FILETYPE_TEXT, '可选择 -jpg-, -gif- 或 -png-。Internet Explorer v6.0 以下版本不能正常显示透明背景的 -png- 图像。虽然 -png- 非常适合透明背景的图片，但是如果要支持旧版的IE，最好设置为 -gif-。较大的图像请使用 -jpg- 或者 -png-。zen-cart的默认方式是 -no_change-，小图像采用与上传的图像相同的后缀。');

define(SMALL_IMAGE_BACKGROUND_TITLE, 'IH 小图像背景');
define(SMALL_IMAGE_BACKGROUND_TEXT, '如果上传的是透明背景图像，该颜色将替代图片的透明部分。保持透明设置为 -transparent-');

define(SMALL_IMAGE_QUALITY_TITLE, 'IH 小图像压缩质量');
define(SMALL_IMAGE_QUALITY_TEXT, '设定期望的JPG小图像质量，数字值从0到100。值越高图像质量越好，图像文件也越大。缺省为85，通常可以满足要求。');

define(WATERMARK_SMALL_IMAGES_TITLE, 'IH 小图像水印');
define(WATERMARK_SMALL_IMAGES_TEXT, '如果小图像要显示水印，设置为 -yes-');

define(ZOOM_SMALL_IMAGES_TITLE, 'IH 放大小图像');
define(ZOOM_SMALL_IMAGES_TEXT, '如果要在鼠标移动到小图像上时，显示放大的图像，设置为 -yes-');

define(ZOOM_IMAGE_SIZE_TITLE, 'IH 小图像放大尺寸');
define(ZOOM_IMAGE_SIZE_TEXT, '如果小图像放大为中图，设置为 -Medium-，如果要放大为大图，设置为 -Large-');

define(MEDIUM_IMAGE_FILETYPE_TITLE, 'IH 中图像文件类型');
define(MEDIUM_IMAGE_FILETYPE_TEXT, '可选择 -jpg-, -gif- 或 -png-。Internet Explorer v6.0 以下版本不能正常显示透明背景的 -png- 图像。虽然 -png- 非常适合透明背景的图片，但是如果要支持旧版的IE，最好设置为 -gif-。较大的图像请使用 -jpg- 或者 -png-。zen-cart的默认方式是 -no_change-，中图像采用与上传的图像相同的后缀。');

define(MEDIUM_IMAGE_BACKGROUND_TITLE, 'IH 中图像背景');
define(MEDIUM_IMAGE_BACKGROUND_TEXT, '如果上传的是透明背景图像，该颜色将替代图片的透明部分。保持透明设置为 -transparent-');

define(MEDIUM_IMAGE_QUALITY_TITLE, 'IH 中图像压缩质量');
define(MEDIUM_IMAGE_QUALITY_TEXT, '设定期望的JPG中图像质量，数字值从0到100。值越高图像质量越好，图像文件也越大。缺省为85，通常可以满足要求。');

define(WATERMARK_MEDIUM_IMAGES_TITLE, 'IH 中图像水印');
define(WATERMARK_MEDIUM_IMAGES_TEXT, '如果中图像要显示水印，设置为 -yes-');

define(LARGE_IMAGE_FILETYPE_TITLE, 'IH 大图像文件类型');
define(LARGE_IMAGE_FILETYPE_TEXT, '可选择 -jpg-, -gif- 或 -png-。Internet Explorer v6.0 以下版本不能正常显示透明背景的 -png- 图像。虽然 -png- 非常适合透明背景的图片，但是如果要支持旧版的IE，最好设置为 -gif-。较大的图像请使用 -jpg- 或者 -png-。zen-cart的默认方式是 -no_change-，大图像采用与上传的图像相同的后缀。');

define(LARGE_IMAGE_BACKGROUND_TITLE, 'IH 大图像背景');
define(LARGE_IMAGE_BACKGROUND_TEXT, '如果上传的是透明背景图像，该颜色将替代图片的透明部分。保持透明设置为 -transparent-');

define(LARGE_IMAGE_QUALITY_TITLE, 'IH 大图像压缩质量');
define(LARGE_IMAGE_QUALITY_TEXT, '设定期望的JPG大图像质量，数字值从0到100。值越高图像质量越好，图像文件也越大。缺省为85，通常可以满足要求。');

define(WATERMARK_LARGE_IMAGES_TITLE, 'IH 大图像水印');
define(WATERMARK_LARGE_IMAGES_TEXT, '如果大图像要显示水印，设置为 -yes-');

define(LARGE_IMAGE_MAX_WIDTH_TITLE, 'IH 大图像最大宽度');
define(LARGE_IMAGE_MAX_WIDTH_TEXT, '设置大图像的最大宽度。如果宽度和高度为空或0，将不会自动调整大图像的大小。');

define(LARGE_IMAGE_MAX_HEIGHT_TITLE, 'IH 大图像最大高度');
define(LARGE_IMAGE_MAX_HEIGHT_TEXT, '设置大图像的最大高度。如果宽度和高度为空或0，将不会自动调整大图像的大小。');

define(WATERMARK_GRAVITY_TITLE, 'IH 水印位置');
define(WATERMARK_GRAVITY_TEXT, '选择水印在图像中的位置，默认为 <strong>Center</Strong>.');

define(IH_VERSION_TITLE, '图像管理版本');
define(IH_VERSION_TEXT, '仅保存图像管理版本，但不显示在配置菜单中。');

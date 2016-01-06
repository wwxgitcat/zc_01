<?php require(get_modules_file('media_manager'));?>
<?php

if ($zv_product_has_media)
{
	?>


<h2 id="mediaManagerHeading"><?php echo TEXT_PRODUCT_COLLECTIONS; ?></h2>

<?php
	while(list($za_media_key, $za_media) = each($za_media_manager))
	{
		?>
<div class="rowWrapper">
	<div class="mediaTitle"><?php echo $za_media['text']; ?></div>
<?php
		$zv_counter1 = 0;
		while(list($za_clip_key, $za_clip) = each($za_media_manager[$za_media_key]['clips']))
		{
			?>
      <div class="mediaTypeLink">
		<a
			href="<?php echo zen_href_link(DIR_WS_MEDIA  . $za_clip['clip_filename'], '', 'NONSSL', false, true, true); ?>"
			target="_blank"><?php echo '<span class="mediaClipFilename">' . $za_clip['clip_filename'] . '</span>' . (!empty($za_clip['clip_type']) ? '<span class="mediaClipType"> (' . $za_clip['clip_type'] . ')</span>' : ''); ?></a>
	</div>

<?php
		}
		?>
    </div>
<?php
	}
  }
?>

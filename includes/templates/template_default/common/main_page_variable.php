<?php
$header_template = 'tpl_header.php';
$footer_template = 'tpl_footer.php';
$left_column_file = 'column_left.php';
$right_column_file = 'column_right.php';
$body_id = ($this_is_home_page) ? 'indexHome' : str_replace('_', '', $_GET['main_page']);
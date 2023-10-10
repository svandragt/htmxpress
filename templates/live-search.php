<?php
$template = get_search_template();
if (empty($template)) {
	$template = get_singular_template();
}
include($template);

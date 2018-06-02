<?php

function block_admin() {
	$file = basename($_SERVER['PHP_SELF']);
	if (is_user_logged_in() && is_admin() && !current_user_can('edit_posts') && $file != 'admin-ajax.php'){
			wp_redirect( home_url() );
			exit();
	}
}

add_action('init', 'block_admin');

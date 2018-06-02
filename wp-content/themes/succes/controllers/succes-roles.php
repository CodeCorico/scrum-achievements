<?php

function succes_clean_teamcontributor_menu() {
	$user_meta = get_userdata(get_current_user_id());
	$user_roles = $user_meta->roles;

	if (!in_array('teamcontributor', $user_roles)) {
		return;
	}

	remove_menu_page( 'edit.php' );
	remove_menu_page( 'edit-comments.php' );
	remove_menu_page( 'profile.php' );
	remove_menu_page( 'tools.php' );
	remove_submenu_page( 'badgeos_badgeos', 'edit.php?post_type=achievement-type' );
	remove_submenu_page( 'badgeos_badgeos', 'edit.php?post_type=submission' );
	remove_submenu_page( 'badgeos_badgeos', 'edit.php?post_type=nomination' );
	remove_submenu_page( 'badgeos_badgeos', 'edit.php?post_type=badgeos-log-entry' );
	remove_submenu_page( 'badgeos_badgeos', 'badgeos_settings' );
	remove_submenu_page( 'badgeos_badgeos', 'badgeos_sub_credly_integration' );
	remove_submenu_page( 'badgeos_badgeos', 'badgeos_sub_add_ons' );
	remove_submenu_page( 'badgeos_badgeos', 'badgeos_sub_help_support' );
}

add_action( 'admin_menu', 'succes_clean_teamcontributor_menu', 999 );

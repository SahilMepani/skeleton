<?php

// Remove menu item from admin
/* ========================================== */
function skel_remove_menu_item() {
	remove_menu_page('edit.php?post_type=simple-pay');
}
add_action('admin_menu', 'skel_remove_menu_item', 999);


// Remove menu item for non-admins
/* ========================================== */
function skel_remove_menu_item_non_admin() {
	/* check if the current user is not an administrator */
	if ( ! current_user_can('manage_options') ) {
		remove_menu_page('edit.php?post_type=simple-pay');
	}
}
add_action('admin_menu', 'skel_remove_menu_item_non_admin', 999);

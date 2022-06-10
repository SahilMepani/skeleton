<?php
// Remove menu item from admin
/* ========================================== */
function tse_remove_menu_item() {
	remove_menu_page('edit.php?post_type=simple-pay');
}
add_action('admin_menu', 'tse_remove_menu_item', 999);


// Remove menu item for non-admins
/* ========================================== */
function tse_remove_menu_item_non_admin() {
	if ( ! current_user_can('manage_options') ) { // check if the current user is not an administrator
		remove_menu_page('edit.php?post_type=simple-pay');
	}
}
add_action('admin_menu', 'tse_remove_menu_item_non_admin', 999);
?>

<?php
/**
 * Remove Admin Menu Item
 *
 * Remove specific menu items from the admin menu.
 *
 * @package WordPress
 * @subpackage Skeleton
 * @since 1.0.0
 */

/**
 * Remove menu item from the admin menu.
 *
 * This function removes a specific menu item from the admin menu.
 *
 * @return void
 */
function skel_remove_menu_item() {
	remove_menu_page( 'edit.php?post_type=simple-pay' );
}
add_action( 'admin_menu', 'skel_remove_menu_item', 999 );


/**
 * Remove menu item for non-admin users.
 *
 * This function removes a specific menu item from the admin menu for non-admin users.
 *
 * @return void
 */
function skel_remove_menu_item_non_admin() {
	// Check if the current user is not an administrator.
	if ( ! current_user_can( 'manage_options' ) ) {
		remove_menu_page( 'edit.php?post_type=simple-pay' );
	}
}
add_action( 'admin_menu', 'skel_remove_menu_item_non_admin', 999 );

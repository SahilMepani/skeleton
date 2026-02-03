<?php //phpcs:ignore file comment
/**
 * Disable the Customizer page and Theme Editor in the WordPress admin.
 *
 * This function removes the Customizer and Theme Editor submenu pages from the admin menu.
 *
 * @return void
 */

add_action(
	'admin_menu',
	function () {
		// Check if REQUEST_URI is set before using it.
		if ( isset( $_SERVER['REQUEST_URI'] ) ) {
			// Build the customizer URL to remove.
			$customizer_url = add_query_arg(
				'return',
				rawurlencode( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) ),
				'customize.php'
			);

			// Remove the Customizer and Theme Editor submenu pages.
			remove_submenu_page( 'themes.php', 'themes.php' );
			remove_submenu_page( 'themes.php', $customizer_url );
			remove_submenu_page( 'themes.php', 'theme-editor.php' );
		}
	},
	999
);

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
		// Get the current user info.
		$current_user = wp_get_current_user();

		// Check if the current user is NOT the specified user.
		if ( 'admin' !== $current_user->user_login ) {
			remove_menu_page( 'edit.php?post_type=simple-pay' );
		}
	}
}
add_action( 'admin_menu', 'skel_remove_menu_item_non_admin', 999 );

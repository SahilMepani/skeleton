<?php
/**
 * Description: Removes default Posts type since no blog.
 *
 * @package WordPress
 * @subpackage Skeleton
 * @since 1.0.0
 */

/**
 * Remove default Posts type since no blog.
 *
 * This function removes the default Posts type from the admin menu and top admin menu bar,
 * and also removes the Quick Draft Dashboard Widget.
 *
 * @return void
 */
function skel_remove_default_post_type() {
	remove_menu_page( 'edit.php' );
}
add_action( 'admin_menu', 'skel_remove_default_post_type' );

/**
 * Remove +New post in top Admin Menu Bar.
 *
 * @param object $wp_admin_bar The WP_Admin_Bar instance.
 * @return void
 */
function skel_remove_default_post_type_menu_bar( $wp_admin_bar ) {
	$wp_admin_bar->remove_node( 'new-post' );
}
add_action( 'admin_bar_menu', 'skel_remove_default_post_type_menu_bar', 999 );

/**
 * Remove Quick Draft Dashboard Widget.
 *
 * @return void
 */
function skel_remove_draft_widget() {
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
}
add_action( 'wp_dashboard_setup', 'skel_remove_draft_widget', 999 );

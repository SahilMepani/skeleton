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


/**
 * Removes the "Posts" and "Categories" meta boxes from Appearance → Menus.
 *
 * This function hooks into the `nav_menu_meta_box_object` filter and prevents
 * the default "Posts" and "Categories" sections from appearing in the Menus screen.
 * Returning `false` for specific objects hides them from the meta box list.
 *
 * @since 1.0.0
 *
 * @param object $items The current meta box object being processed in the Menus screen.
 * @return object|false The unmodified object, or false to remove the meta box.
 */
function skel_remove_menu_meta_boxes( $items ) {
	if ( isset( $items->name ) && ( 'post' === $items->name || 'category' === $items->name ) ) {
		return false; // Remove the metabox.
	}

	return $items;
}
add_filter( 'nav_menu_meta_box_object', 'skel_remove_menu_meta_boxes' );

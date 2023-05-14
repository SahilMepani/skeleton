<?php
/**
 * Cleans up default WordPress features and options.
 *
 * @package Core
 * @subpackage Cleanup
 * @since 1.0.0
 */

/**
 * Cleans up scripts and styles from the site's headers.
 *
 * @since 1.0.0
 * @internal
 */
function core_cleanup_head() {
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );
    remove_action( 'wp_head', 'adjacent_posts_rel_link', 10 );
    remove_action( 'wp_head', 'feed_links_extra', 3 );
    remove_action( 'wp_head', 'feed_links', 2 );
    remove_action( 'wp_head', 'index_rel_link' );
    remove_action( 'wp_head', 'parent_post_rel_link', 10 );
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_head', 'rel_canonical' );
    remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
    remove_action( 'wp_head', 'rsd_link' );
    remove_action( 'wp_head', 'start_post_rel_link', 10 );
    remove_action( 'wp_head', 'wlwmanifest_link' );
    remove_action( 'wp_head', 'wp_generator' );
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
    remove_action( 'wp_head', 'wp_oembed_add_host_js' );
    remove_action( 'wp_head', 'wp_resource_hints', 2 );
    remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
}

if ( ! is_admin_bar_showing() ) {
    add_action( 'after_setup_theme', 'core_cleanup_head' );
}

/**
 * Deregisters default WordPress scripts and styles.
 *
 * @since 1.0.0
 * @internal
 */
function core_cleanup_default_assets() {
	wp_deregister_script( 'jquery' );
}

add_action( 'wp_enqueue_scripts', 'core_cleanup_default_assets', 1 );

/**
 * Removes the Quick Draft meta box.
 *
 * @since 1.0.0
 * @internal
 */
function core_cleanup_draft() {
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
}

add_action( 'wp_dashboard_setup', 'core_cleanup_draft' );

/**
 * Removes the default post type from the admin bar.
 *
 * @since 1.0.0
 * @internal
 */
function core_cleanup_admin_bar_post( $wp_admin_bar ) {
	$wp_admin_bar->remove_node( 'new-post' );
}

add_action( 'admin_bar_menu', 'core_cleanup_admin_bar_post' );

/**
 * Removes the default post type from the side menu.
 *
 * @since 1.0.0
 * @internal
 */
function core_cleanup_side_menu_post() {
	remove_menu_page( 'edit.php' );
	remove_menu_page( 'edit-comments.php' );
}

add_action( 'admin_menu', 'core_cleanup_side_menu_post' );

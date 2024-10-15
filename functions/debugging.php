<?php
/**
 * This file contains functions useful for debugging
 *
 * @package WordPress
 * @subpackage Skeleton
 * @since 1.0.0
 */

/**
 * Configure error logging for local WordPress development environment.
 *
 * This conditional statement sets up custom error logging when:
 * 1. WP_DEBUG_LOG is defined and set to true
 * 2. The current environment is identified as 'local'
 *
 * When these conditions are met, it redirects error logs to a custom file
 * within the current theme's directory.
 *
 * @uses wp_get_environment_type() WordPress function to determine the current environment
 * @uses WP_CONTENT_DIR WordPress constant for the absolute path to the wp-content directory
 */
if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG && 'local' == wp_get_environment_type() ) {
	ini_set( 'error_log', WP_CONTENT_DIR . '/themes/skeleton/debug.log' );
}

/**
 * Get list of all registered blocks and modify allowed block types.
 *
 * This code retrieves all registered block types and outputs the
 * list of block slugs for debugging purposes.
 * It also filters the allowed block types for all contexts by calling
 * the 'skel_allowed_block_types' function.
 *
 * @return array
 */
function skel_list_block_types(): array {
	// Retrieve all registered block types.
	$block_types = array_keys( WP_Block_Type_Registry::get_instance()->get_all_registered() );

	// Output the list of registered block slugs for debugging purposes.
	return $block_types;
}


/**
 * Hooks into the 'wp_print_styles' action to list all enqueued styles,
 * but only when a specific query parameter (e.g., 'debug_styles') is present.
 *
 * @return void
 */
function skel_list_enqueued_styles() {
	if ( isset( $_GET['debug_styles'] ) && $_GET['debug_styles'] === 'true' ) {
		global $wp_styles;

		// Loop through the enqueued styles and output their handles.
		foreach ( $wp_styles->queue as $handle ) {
			echo $handle . '<br>';
		}
	}
}
add_action( 'wp_print_styles', 'skel_list_enqueued_styles' );


/**
 * Hooks into the 'wp_print_scripts' action to list all enqueued scripts,
 * but only when a specific query parameter (e.g., 'debug_scripts') is present.
 *
 * @return void
 */
function skel_list_enqueued_scripts() {
	if ( isset( $_GET['debug_scripts'] ) && $_GET['debug_scripts'] === 'true' ) {
		global $wp_scripts;

		// Loop through the enqueued scripts and output their handles.
		foreach ( $wp_scripts->queue as $handle ) {
			echo $handle . '<br>';
		}
	}
}
add_action( 'wp_print_scripts', 'skel_list_enqueued_scripts' );


/**
 * Debugging function to display all meta keys for the current post.
 */
function skel_show_meta_keys() {
	if ( is_singular() ) {
		$post_id   = get_the_ID();
		$meta_data = get_post_meta( $post_id );

		if ( ! empty( $meta_data ) ) {
			echo '<pre>';
			echo 'Meta keys for post ID ' . $post_id . ':<br>';
			foreach ( $meta_data as $meta_key => $meta_value ) {
				echo esc_html( $meta_key ) . '<br>';
			}
			echo '</pre>';
		} else {
			echo '<pre>No meta keys found for post ID ' . $post_id . '.</pre>';
		}
	}
}

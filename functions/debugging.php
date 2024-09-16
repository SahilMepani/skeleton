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
 * Hooks into the 'wp_print_styles' action to list all enqueued styles.
 *
 * This function outputs the handles of all currently enqueued styles on the page.
 * It is useful for debugging and identifying styles for dequeuing.
 *
 * @return void
 */
add_action( 'wp_print_styles', 'list_enqueued_styles' );

function skel_list_enqueued_styles() {
	global $wp_styles;

	// Loop through the enqueued styles and output their handles.
	foreach ( $wp_styles->queue as $handle ) {
		echo $handle . '<br>';
	}
}

/**
 * Hooks into the 'wp_print_scripts' action to list all enqueued scripts.
 *
 * This function outputs the handles of all currently enqueued scripts on the page.
 * It is useful for debugging and identifying scripts for dequeuing.
 *
 * @return void
 */
add_action( 'wp_print_scripts', 'list_enqueued_scripts' );

function skel_list_enqueued_scripts() {
	global $wp_scripts;

	// Loop through the enqueued scripts and output their handles.
	foreach ( $wp_scripts->queue as $handle ) {
		echo $handle . '<br>';
	}
}

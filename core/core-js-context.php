<?php
/**
 * Stores and prints the global JS context with the core configuration.
 *
 * @package Core
 * @subpackage JavaScript Context
 * @since 1.0.0
 */

/**
 * The JS context.
 *
 * @var array
 * @global
 */
global $core_js_context;
$core_js_context = [];

/**
 * Appends the specified attribute to the global JS context.
 *
 * @since 1.0.0
 *
 * @param string $attr_name
 * @param string $attr_value
 * @return bool Wether the attribute as successfully inserted.
 */
function core_insert_js_context( $attr_name, $attr_value ) {
	global $core_js_context;

	/**
	 * Check if the specified attribute name already exists.
	 *
	 * If it does, throw an error.
	 * This should not happen.
	 */
	if ( array_key_exists( $attr_name, $core_js_context ) ) {
		core_add_notice( 'error', sprintf(
			'Attribute "%s" already exists in JS context.',
			$attr_name
		));
	} else {
		$core_js_context[ $attr_name ] = $attr_value;
	}
}

/**
 * Localizes the JS context so it can be accessed in core JS files.
 *
 * The majority of the Core functionality only works in the backend.
 *
 * There is some functionality that works on the frontend, but only in
 * a development environment.
 *
 * @since 1.0.0
 * @internal
 */
function core_localize_js_context() {
	global $core_js_context;

	// Include additional data.
	$core_js_context = array_merge( $core_js_context, [
		'adminAjax' => admin_url( 'admin-ajax.php' ),
		'siteUrl' => home_url(),
		'isAdmin' => is_admin() ? '1' : '',
		'isLoggedIn' => is_user_logged_in() ? '1' : '',
		'env' => core_env()
	]);

	$base_script_name = is_admin() ? 'core-scripts' : 'core-scripts-globals';
	wp_localize_script( $base_script_name, 'themeCore', $core_js_context );
}

add_action( 'admin_enqueue_scripts', 'core_localize_js_context', 11 );
add_action( 'wp_enqueue_scripts', 'core_localize_js_context', 11 );

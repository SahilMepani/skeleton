<?php
/**
 * The main core setup file.
 *
 * - Includes other core files needed for theme setup.
 * - Checks if all required plugins are installed and active.
 * - Loads core configuration files.
 *
 * @package Core
 * @since 1.0.0
 */

/**
 * The list of required plugins.
 *
 * @var array[]
 */
global $core_required_plugins;
$core_required_plugins = [
	[
		'name' => 'ACF Pro',
		'file_path' => 'advanced-custom-fields-pro/acf.php',
		'slug' => 'advanced-custom-fields-pro'
	],
	[
		'name' => 'Regenerate Thumbnails',
		'file_path' => 'regenerate-thumbnails/regenerate-thumbnails.php',
		'slug' => 'regenerate-thumbnails'
	]
];

/**
 * The custom Core configuration.
 *
 * @var mixed[]
 */
global $core_custom_options;
$core_custom_options = [];

/**
 * Loads the main configuration file.
 *
 * @since 1.0.0
 * @since 2.16.0 Merged all configuration files into one.
 * @internal
 */
function core_load_config_file() {
	$file_path = PKG_PATH . '/config.php';

	if ( ! file_exists( $file_path ) ) {
		core_add_notice( 'error', 'Missing configuration file.', [
			"Required file not found: `{$file_path}`"
		]);
	}

	// Load the configuration file.
	$config = include_once $file_path;

	// Store each option in the database.
	global $core_custom_options;
	$core_custom_options = $config;

	// Add options to the JS context.
	core_insert_js_context( 'options', $config );
}

/**
 * Retrieves the specified option from the core configuration.
 *
 * @since 1.0.0
 *
 * @param string $option_name
 * @param mixed [$default_value=null]
 * @return mixed|null
 */
function core_get_option( $option_name, $default_value = null ) {
	global $core_custom_options;
	return core_default( $option_name, $core_custom_options, $default_value );
}

/**
 * Checks if all the required plugins are installed and active.
 *
 * @since 1.0.0
 * @internal
 *
 * @return boolean
 */
function core_check_required_plugins() {
	global $core_required_plugins;

	// Get the list of active plugins.
	$active_plugins = get_option( 'active_plugins' );

	$inactive_plugins = array_filter( $core_required_plugins, function( $plugin ) use( $active_plugins ) {
		return ! in_array( $plugin['file_path'], $active_plugins );
	});

	// Stop here if all the required plugins are installed and active.
	if ( empty( $inactive_plugins ) ) {
		return true;
	}

	$inactive_plugins_slugs = join( ',', array_map( function( $plugin ) {
		return $plugin['slug'];
	}, $inactive_plugins ));

	$plugins_path = "plugins.php?hlpl={$inactive_plugins_slugs}&core-notices=0";

	core_add_notice(
		'error',
		'Some required plugins are not installed or active. ' . core_admin( $plugins_path, 'Activate them here.' ),
		array_map( function( $plugin ) {
			return 'Missing required plugin: `'.$plugin['name'].'`';
		}, $inactive_plugins )
	);

	return false;
}

/**
 * Runs an initial setup for the theme. Only runs once.
 *
 * - Activates required plugins.
 *
 * @since 1.0.0
 * @internal
 */
function core_initial_setup() {
	$already_run = get_option( 'core_initial_setup' );
	if ( $already_run ) return;

	// Attempt to activate the required plugins.
	global $core_required_plugins;
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

	$activated_plugins = [];

	foreach ( $core_required_plugins as $plugin ) {
		$result = activate_plugin( $plugin['file_path'] );

		if ( ! is_wp_error( $result ) ) {
			$activated_plugins[] = $plugin['name'];
		}
	}

	// Inform the user about the activated plugins.
	if ( ! empty( $activated_plugins ) ) {
		core_add_notice(
			'info',
			count( $activated_plugins ).' plugins were activated.',
			array_map( function( $plugin ) {
				return 'New plugin activated: `'.$plugin.'`';
			}, $activated_plugins )
		);
	}

	// Inform the user about the front page.
	core_add_notice( 'info', 'Suggested action: *Update Front Page*', [
		'Every site needs a front page. Set one '.core_admin( 'options-reading.php', 'here' ).'.'
	]);

	// Finished.
	update_option( 'core_initial_setup', 1 );
}

/**
 * Initializes all the core functionality.
 *
 * - Loads initial utility and setup files.
 * - Loads core configuration files.
 * - Checks if all the required plugins are installed and active.
 * - Loads feature-specific utility and setup files.
 *
 * @since 1.0.0
 * @internal
 */
function core_setup() {

	// Load initial setup modules.
	// require_once CORE_PATH . '/core-dependencies.php';
	require_once CORE_PATH . '/core-cleanup.php';
	require_once CORE_PATH . '/core-notices.php';
	require_once CORE_PATH . '/core-js-context.php';
	require_once CORE_PATH . '/core-env.php';

	// Load core utility functions.
	require_once CORE_PATH . '/util/general.php';
	require_once CORE_PATH . '/util/post.php';

	// Load core configuration files.
	core_load_config_file();

	// Run initial setup.
	core_initial_setup();

	/**
	 * Check if required plugins are installed and active.
	 * If not, stop the setup process.
	 */
	if ( ! core_check_required_plugins() ) return;

	// Load feature-specific utility and setup files.
	require_once CORE_PATH . '/core-support.php';
	require_once CORE_PATH . '/core-acf.php';
	require_once CORE_PATH . '/core-cpt.php';

	// Content type configuration.
	require_once CORE_PATH . '/content-types/core-common-fields.php';
	require_once CORE_PATH . '/content-types/core-section-library.php';
	require_once CORE_PATH . '/content-types/core-page-templates.php';
	require_once CORE_PATH . '/content-types/core-post-types.php';
	require_once CORE_PATH . '/content-types/core-content-types.php';
	require_once CORE_PATH . '/content-types/core-options-pages.php';
	require_once CORE_PATH . '/content-types/core-standalone-fields.php';
	require_once CORE_PATH . '/content-types/core-taxonomies.php';

	require_once CORE_PATH . '/core-rest-api.php';

	require_once CORE_PATH . '/core-wp.php';
	require_once CORE_PATH . '/core-mce.php';

	// Run actions after setup.
	do_action( 'core_after_setup' );
}

add_action( 'after_setup_theme', 'core_setup', 999 );

// Disable the WordPress admin bar on the frontend by default.
add_filter( 'show_admin_bar', '__return_false' );

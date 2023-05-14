<?php
/**
 * Manages the current environment and env variables.
 *
 * @package Core
 * @subpackage Env
 * @since 1.0.0
 */

/**
 * Checks whether we're in a development, staging or production environment.
 *
 * Also checks for a simulated environment, used for testing purposes.
 *
 * @since 1.0.0
 * @internal
 *
 * @return array The current environment.
 */
function core_env() {

	/**
	 * The current env.
	 * Includes simulated env for testing.
	 *
	 * @var array
	 */
	$env = [
		'current' => $_ENV['ENV'] ?? 'prod',
		'sim_prod' => false
	];

	if ( $env['current'] !== 'dev' && $env['current'] !== 'prod' ) {
		$env['current'] = 'prod';
	}

	if ( array_key_exists( 'SIM_PROD', $_ENV ) ) {
		$env['sim_prod'] = $_ENV['SIM_PROD'] === 'true' || (int) $_ENV['SIM_PROD'] === 1;
	}

	return $env;
}

/**
 * Updates the status of simulated production site-wide.
 *
 * @since 1.0.0
 * @since 1.1.4 No longer requires the user to be logged in. Instead,
 * 				checks if the current environment is 'dev'.
 * @internal
 */
function core_update_sim_prod() {
	$_POST = json_decode( file_get_contents( 'php://input' ), true );
	if ( ! is_array( $_POST ) ) $_POST = [];
	$status = core_default( 'status', $_POST, 0 );

	// Check the current environment.
	$current_env = core_env();
	if ( $current_env['current'] !== 'dev' ) die();

	// Read the file.
	$file_path = TPL_PATH . '/.env';
	$file = file( $file_path );

	// Update the SIM_PROD value.
	$updated = false;

	foreach ( $file as $lineNumber => $line ) {
		if ( strpos( $line, 'SIM_PROD' ) !== false ) {
			$file[ $lineNumber ] = "SIM_PROD={$status}\n";
			$updated = true;
		}
	}

	// Add new SIM_PROD value, if none was found.
	if ( ! $updated ) $file[] = "SIM_PROD={$status}\n";

	// Remove duplicated.
	$file = array_unique( $file );
	sort( $file );

	// Update the file contents.
	file_put_contents( $file_path, implode( '', $file ) );

	die();
}

add_action( 'wp_ajax_core_update_sim_prod', 'core_update_sim_prod' );
add_action( 'wp_ajax_nopriv_core_update_sim_prod', 'core_update_sim_prod' );

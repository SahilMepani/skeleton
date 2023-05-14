<?php
/**
 * Manages the core notices system.
 * Displays core errors and warnings in the backend.
 *
 * @package Core
 * @subpackage Notices
 * @since 1.0.0
 */

/**
 * The list of notices for display.
 *
 * @var array[]
 * @global
 */
global $core_notices;
$core_notices = [];

/**
 * Adds a new notice to be displayed in the backend.
 *
 * @since 1.0.0
 *
 * @param string $type The notice type. Can be 'alert', 'error', 'info' or 'warning'.
 * @param string $message The notice message.
 * @param string|string[]|boolean $info=false Additional information for the notice.
 * @param boolean $dismissible Whether or not this notice is dismissible.
 */
function core_add_notice( $type, $message, $info=false, $dismissible=false ) {
	global $core_notices;

	/**
	 * The notice ID.
	 *
	 * @var string
	 */
	$notice_id = md5( core_sanitize_title_underscore( $message ) );

	// Stop the process if this notice is dismissed.
	if ( isset( $_COOKIE["core-notice-dismiss-{$notice_id}"] ) ) return;

	// If the notice is dismissible, it should only be added once.
	if ( isset( $core_notices[ $type ] ) && $dismissible !== false ) {
		$existing = array_filter( $core_notices[ $type ], function( $notice ) use( $notice_id ) {
			return $notice['id'] === $notice_id;
		});

		if ( ! empty( $existing ) ) return;
	}

	// Format the main message.
	$formatting_tags = [ 'code', 'strong' ];
	$message = core_format_text_tags( $message, $formatting_tags );

	// Format info array.
	if ( $info ) {
		if ( is_array( $info ) ) {
			$info = array_map( function( $item ) use( $formatting_tags ) {
				return '<li>' . core_format_text_tags( $item, $formatting_tags ) . '</li>';
			}, $info );

			$info = '<ul>' . join( "\n", $info ) . '</ul>';
		} else {
			$info = core_format_text_tags( $info, $formatting_tags );
		}
	}

	// Add "dismiss" button.
	$notice = [
		'id' => $notice_id,
		'message' => $message,
		'info' => $info,
		'dismissible' => $dismissible
	];

	if ( $type !== 'info' && $type !== 'alert' ) {
		$backtrace = array_chunk( debug_backtrace(), 5 )[0];
		$notice['backtrace'] = $backtrace;
	}

	$core_notices[ $type ][] = $notice;
}

/**
 * Localizes the notices list so it can be accessed in core scripts.
 *
 * @since 1.0.0
 * @internal
 */
function core_localize_notices() {
	global $core_notices;
	if ( empty( $core_notices ) ) return;

	wp_localize_script( 'core-scripts', 'themeNotices', $core_notices );
}

add_action( 'admin_enqueue_scripts', 'core_localize_notices', 11 );

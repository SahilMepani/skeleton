<?php
/**
 * Loads and initializes Core dependencies.
 *
 * @package Core
 * @subpackage Dependencies
 * @since 1.0.0
 */


/**
 * Initializes Timber.
 *
 * @since 1.0.0
 * @internal
 *
 * @return boolean Whether Timber was initialized or not.
 */
function core_init_timber() {
	$class_exists = class_exists( 'Timber\Timber' );

	if ( $class_exists ) {
		$timber = new Timber\Timber();
	} else {
		core_add_notice( 'error', 'Timber has not been activated within the theme.', [
			'Run `composer install` inside the theme folder to load Timber dependencies.',
			core_docs( 'configuration' )
		]);

		add_filter( 'template_include', function() {
			return CORE_PATH . '/static/no-timber.html';
		});
	}

	return $class_exists;
}

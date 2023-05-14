<?php
/**
 * Allows the creation of common field configurations.
 *
 * @package Core
 * @subpackage Common Fields
 * @since 1.0.5
 */

/**
 * The list of common fields.
 *
 * @var array[]
 * @global
 */
global $core_common_fields;
$core_common_fields = [];

/**
 * Retrieves the specified common field configuration.
 *
 * @since 1.0.5
 *
 * @param string $slug The common field slug.
 * @return array|null The common field configuration.
 */
function core_get_common_field( $slug ) {
	if ( ! $slug ) return null;
	global $core_common_fields;

	$common_field = core_default( $slug, $core_common_fields, null );

	return $common_field ? $common_field['fields'] : null;
}

/**
 * Finds and registers all common fields.
 *
 * @since 1.0.5
 * @internal
 */
function core_scan_common_fields() {
	global $core_common_fields;

	// Scan for configuration files and register common fields.
	$common_fields_list = core_scan_dir( PKG_CONTENT_PATH.'/common-fields', '*.php', function( $file ) {
		if ( $file['name'] === 'index.php' ) return null;
		$reg_data = include_once $file['path'];

		try {
			core_check_entity_integrity([
				'type' => 'file',
				'file' => $file,
				'data' => $reg_data,
				'required_options' => [
					'fields'
				]
			]);

			$reg_data['slug'] = explode( '.', $file['name'] )[0];
		} catch ( Exception $error ) {
			$error->data[] = core_docs( 'common-fields' );
			core_add_notice( 'error', $error->getMessage(), $error->data );
			$reg_data = null;
		}

		return $reg_data;
	});

	// Save common fields.
	foreach ( $common_fields_list as $common_fields ) {
		$core_common_fields[ $common_fields['slug'] ] = $common_fields;
	}

	// Run action.
	do_action( 'core_after_scan_common_fields', $core_common_fields );
}

add_action( 'core_after_setup', 'core_scan_common_fields', 1 );

<?php
/**
 * Registers and manages standalone field groups.
 *
 * @package Core
 * @subpackage Standalone Fields
 * @since 1.0.0
 */

/**
 * The list of standalone field groups.
 *
 * @var array[]
 * @global
 */
global $core_field_groups;
$core_field_groups = [];

/**
 * Finds and registers all standalone field groups.
 *
 * @since 1.0.0
 * @internal
 */
function core_scan_standalone_field_groups() {
	global $core_field_groups;

	// Scan for configuration files and register field groups.
	$field_groups_list = core_scan_dir( PKG_CONTENT_PATH.'/standalone-fields', '*.php', function( $file ) {
		if ( $file['name'] === 'index.php' ) return null;
		$reg_data = include_once $file['path'];

		try {
			core_check_entity_integrity([
				'type' => 'file',
				'file' => $file,
				'data' => $reg_data,
				'required_options' => [
					'name',
					'location'
				]
			], function( $entity ) {
				$data = $entity['data'];
				if ( ! array_key_exists( 'location', $data ) ) return;

				$error = 'Invalid location declaration.';

				// Check if all locations follow the required format.
				if ( ! core_is_assoc( $data['location'] ) ) return $error;
			});

			$reg_data['slug'] = explode( '.', $file['name'] )[0];

			// Set default args used for registering the field group.
			$reg_data['args'] = [
				'title' => $reg_data['name'],
				'slug' => "standalone-{$reg_data['slug']}",
				'menu_order' => core_default( 'menu_order', $reg_data, 0 ),
				'position' => core_default( 'position', $reg_data, 'side' ),
				'location' => $reg_data['location'],
				'fields' => $reg_data['fields']
			];

			// Register field group.
			core_register_field_group( $reg_data['args'] );
		} catch ( Exception $error ) {
			$error->data[] = core_docs( 'post-types' );
			core_add_notice( 'error', $error->getMessage(), $error->data );
			$reg_data = null;
		}

		return $reg_data;
	});

	// Save field groups.
	foreach ( $field_groups_list as $field_group ) {
		$core_field_groups[ $field_group['slug'] ] = $field_group;
	}

	// Run action.
	do_action( 'core_after_scan_standalone_field_groups', $core_field_groups );
}

add_action( 'core_after_setup', 'core_scan_standalone_field_groups', 2 );

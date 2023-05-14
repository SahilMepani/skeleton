<?php
/**
 * Prepares the environment for taxonomy registration.
 *
 * @package Core
 * @subpackage Taxonomies
 * @since 1.0.0
 */

/**
 * The list of taxonomies.
 *
 * @var array[]
 * @global
 */
global $core_taxonomies;
$core_taxonomies = [];

/**
 * Retrieves the list of taxonomies.
 *
 * @since 1.0.0
 * @internal
 *
 * @param string[] [$post_types=false]
 * @return
 */
function core_get_taxonomies( $post_types=false ) {
	global $core_taxonomies;

	$taxonomies_list = $core_taxonomies;

	if ( ! $post_types || ( is_array( $post_types ) && empty( $post_types ) ) ) {
		return $taxonomies_list;
	}

	$taxonomies_list = array_values(
		array_filter( $taxonomies_list, function( $taxonomy ) use( $post_types ) {
			$found = false;

			foreach ( $taxonomy['post_types'] as $post_type ) {
				if ( in_array( $post_type, (array) $post_types ) ) $found = true;
			}

			return $found;
		})
	);

	return $taxonomies_list;
}

/**
 * Retrieves the specified taxonomy.
 *
 * @since 1.0.0
 * @internal
 *
 * @param string $slug
 * @return array|null
 */
function core_get_taxonomy( $slug ) {
	global $core_taxonomies;

	return array_key_exists( $slug, $core_taxonomies ) ?
		$core_taxonomies[ $slug ] :
		null;
}

/**
 * Finds and registers all taxonomies.
 *
 * @since 1.0.0
 * @internal
 */
function core_scan_taxonomies() {
	global $core_taxonomies;

	// Scan for configuration files and register taxonomies.
	$taxonomies_list = core_scan_dir( PKG_CONTENT_PATH.'/taxonomies', '*.php', function( $file ) {
		if ( $file['name'] === 'index.php' ) return null;
		$reg_data = include_once $file['path'];

		try {
			core_check_entity_integrity([
				'type' => 'file',
				'file' => $file,
				'data' => $reg_data,
				'required_options' => [
					'plural_label',
					'singular_label',
					'post_types'
				]
			], function( $entity ) {
				$data = $entity['data'];
				if ( ! array_key_exists( 'location', $data ) ) return;

				$error = 'Invalid location declaration.';

				// Check if all locations follow the required format.
				if ( ! core_is_assoc( $data['location'] ) ) return $error;

				foreach ( $data['location'] as $location_type => $locations_list ) {
					if ( ! is_array( $locations_list ) ) return $error;
				}
			});

			$reg_data['slug'] = explode( '.', $file['name'] )[0];

			// Set default args used for registering the taxonomy.
			$singular_label = $reg_data['singular_label'];
			$plural_label = $reg_data['plural_label'];

			$reg_data['args'] = [
				'label' => $singular_label,
				'slug' => $reg_data['slug'],
				'id' => $reg_data['slug'],
				'public' => core_default( 'public', $reg_data, false ),
				'hierarchical' => core_default( 'hierarchical', $reg_data, true ),
				'show_ui' => core_default( 'show_ui', $reg_data, true ),
				'show_admin_column' => core_default( 'show_admin_column', $reg_data, true ),
				'show_in_rest' => true,
				'labels' => [
					'name' => $plural_label,
					'singular_name' => $plural_label,
					'search_items' => "Search {$plural_label}",
					'popular_items' => NULL,
					'all_items' => $plural_label,
					'parent_item' => "Parent {$singular_label}",
					'parent_item_colon' => "Parent {$singular_label}:",
					'edit_item' => "Edit {$singular_label}",
					'view_item' => "View {$singular_label}",
					'update_item' => "Update {$singular_label}",
					'add_new_item' => "Add New {$singular_label}",
					'new_item_name' => "New {$singular_label} Name",
					'separate_items_with_commas' => NULL,
					'add_or_remove_items' => NULL,
					'choose_from_most_used' => NULL,
					'not_found' => "No {$plural_label} Found",
					'no_terms' => "No {$plural_label}",
					'items_list_navigation' => "{$plural_label} List Navigation",
					'items_list' => "{$plural_label} List",
					'most_used' => "Most Used",
					'back_to_items' => "← Back To {$plural_label}",
					'menu_name' => $plural_label,
					'name_admin_bar' => $plural_label,
					'archives' => $plural_label
				]
			];

			// Register the taxonomy.
			register_taxonomy( $reg_data['args']['id'], $reg_data['post_types'], $reg_data['args'] );

			// Register custom fields.
			core_register_field_group([
				'title' => $singular_label,
				'slug' => 'taxonomy-'.$reg_data['slug'],
				'location' => [
					'taxonomy' => $reg_data['slug']
				],
				'fields' => core_default( 'fields', $reg_data, [] )
			]);
		} catch ( Exception $error ) {
			$error->data[] = core_docs( 'taxonomies' );
			core_add_notice( 'error', $error->getMessage(), $error->data );
			$reg_data = null;
		}

		return $reg_data;
	});

	// Save taxonomies.
	foreach ( $taxonomies_list as $taxonomy ) {
		$core_taxonomies[ $taxonomy['slug'] ] = $taxonomy;
	}

	// Run action.
	do_action( 'core_after_scan_taxonomies', $core_taxonomies );
}

add_action( 'core_after_setup', 'core_scan_taxonomies', 2 );

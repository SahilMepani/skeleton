<?php
/**
 * Prepares the environment for registering and managing
 * custom post types.
 *
 * @package Core
 * @subpackage Content Types - Post Types
 * @since 1.0.0
 */

/**
 * The list of custom post types.
 *
 * @var array[]
 * @global
 */
global $core_post_types;
$core_post_types = [
	'page' => [
		'name' => 'Pages',
		'slug' => 'page'
	]
];

/**
 * Retrieves the full list of post types.
 *
 * @since 1.0.0
 *
 * @param string[]|boolean [$filter=false]
 * @param boolean [$slug_only=false]
 * @return array
 */
function core_get_post_types( $filter=false, $slug_only=false ) {
	global $core_post_types;

	$post_types_list = array_values( $core_post_types );

	if ( $filter && is_array( $filter ) ) {
		$post_types_list = array_values(
			array_filter( $post_types_list, function( $post_type ) use( $filter ) {
				return in_array( $post_type['slug'], (array) $filter );
			})
		);
	}

	if ( $slug_only ) {
		$post_types_list = array_map( function( $post_type ) {
			return $post_type['slug'];
		}, $post_types_list );
	}

	return $post_types_list;
}

/**
 * Retrieves the post type for the specified post.
 *
 * @since 1.0.0
 *
 * @param string $slug
 * @return array|null
 */
function core_get_post_type( $slug ) {
	global $core_post_types;

	return array_key_exists( $slug, $core_post_types ) ?
		$core_post_types[ $slug ] :
		null;
}

/**
 * Finds and registers all custom post types.
 *
 * @since 1.0.0
 * @internal
 */
function core_scan_post_types() {
	global $core_post_types;

	// Scan for configuration files and register post types.
	$post_types_list = core_scan_dir( PKG_CONTENT_PATH.'/post-types', 'config.php', function( $file ) {
		$reg_data = include_once $file['path'];

		try {
			core_check_entity_integrity([
				'type' => 'dir',
				'file' => $file,
				'data' => $reg_data,
				'base' => 'post-types',
				'required_files' => [],
				'required_options' => [
					'name',
					'icon'
				]
			]);

			$reg_data['type'] = 'post-types';
			$reg_data['slug'] = $file['dirname'];
			$reg_data['location'] = $file['info']['dirname'];
			$reg_data['location_rel'] = $file['path_rel'];

			$reg_data['layout_base'] = core_default( 'layout_base', $reg_data, 'base.twig' );
			$reg_data['rewrite'] = core_default( 'rewrite', $reg_data, $reg_data['slug'] );

			// Set default args used for registering the post type.
			$reg_data['args'] = [
				'label' => $reg_data['name'],
				'can_export' => core_default( 'can_export', $reg_data, false ),
				'capability_type' => core_default( 'capability_type', $reg_data, 'page' ),
				'has_archive' => core_default( 'has_archive', $reg_data, false ),
				'menu_icon' => 'dashicons-'.$reg_data['icon'],
				'menu_position' => core_default( 'menu_position', $reg_data, 5 ),
				'publicly_queryable' => core_default('publicly_queryable', $reg_data, true),
				'public' => true,
				'rewrite' => [ 'slug' => $reg_data['rewrite'] ],
				'show_in_rest' => core_default( 'show_in_rest', $reg_data, true ),
				'slug' => $reg_data['slug'],
				'supports' => core_default( 'supports', $reg_data, [ 'title', 'editor' ] ),
				'show_in_menu' => core_default('show_in_menu', $reg_data, true)
			];

			// Check if the layout file exists.
			if ( ! is_file( PKG_LAYOUTS_PATH.'/'.$reg_data['layout_base'] ) ) {
				core_add_notice( 'warning', "Layout base file not found: *{$reg_data['layout_base']}*");
			}

			// Load the filters file, is there is one.
			if ( is_file( $reg_data['location'].'/filters.php' ) ) {
				$filters = include_once( $reg_data['location'].'/filters.php' );

				if ( $filters && core_is_assoc( $filters ) ) {
					foreach ( $filters as $filter_type => $filter_func ) {
						add_filter( "core/{$filter_type}/post-type={$reg_data['slug']}", $filter_func, 10 );
					}
				}
			}

			// Register post type.
			register_post_type( $reg_data['slug'], $reg_data['args'] );
		} catch ( Exception $error ) {
			$error->data[] = core_docs( 'post-types' );
			core_add_notice( 'error', $error->getMessage(), $error->data );
			$reg_data = null;
		}

		return $reg_data;
	});

	// Sort the list.
	usort( $post_types_list, function( $a, $b ) {
		if ( $a['slug'] > $b['slug'] ) return 1;
		if ( $a['slug'] < $b['slug'] ) return -1;
		return 1;
	});

	// Save post types.
	foreach ( $post_types_list as $post_type ) {
		$core_post_types[ $post_type['slug'] ] = $post_type;
	}

	// Update the list of post types in the database.
	core_update_post_types_registry();

	// Run action.
	do_action( 'core_after_scan_post_types', $core_post_types );
}

/**
 * Disables support for some default features in all post types.
 *
 * @since 2.11.0
 * @internal
 */
function core_disable_post_type_features() {
	global $core_post_types;

	foreach ( $core_post_types as $post_type ) {
		remove_post_type_support( $post_type['slug'], 'revisions' );
		remove_post_type_support( $post_type['slug'], 'comments' );
	}
}

add_action( 'admin_init', 'core_disable_post_type_features' );

/**
 * Registers post types' field groups.
 *
 * This needs to run after all custom content types are registered, because
 * some field types depend on it.
 *
 * @since 1.0.0
 * @since 2.11.0 No longer registers the Field Group if there are
 *               no fields to register.
 * @internal
 */
function core_register_post_types_fields() {
	global $core_post_types;

	// Register custom fields.
	foreach ( $core_post_types as $post_type ) {
		if ( $post_type['slug'] === 'page' ) continue;
		$post_type_fields = core_default( 'fields', $post_type, [] );

		if ( ! empty( $post_type_fields ) ) {
			core_register_field_group([
				'title' => 'Content',
				'slug' => 'post-type-'.$post_type['slug'],
				'location' => [
					'post_type' => $post_type['slug']
				],
				'fields' => $post_type_fields
			]);
		}
	}
}

add_action( 'core_after_scan_custom_content_types', 'core_register_post_types_fields' );

/**
 * Updates the list of Post Types in the database.
 *
 * This is useful to make sure we only flush rewrite rules
 * once a new Post Type is added.
 *
 * @since 1.0.0
 * @internal
 */
function core_update_post_types_registry() {
	global $core_post_types;

	$registry = get_option( 'core_post_types' );
	$new_registry = serialize( array_column( $core_post_types, 'slug' ) );

	if ( $new_registry !== $registry ) {
		update_option( 'core_post_types', $new_registry );
		core_flush_rewrite_rules();
	}
}

add_action( 'core_after_scan_post_types', 'core_update_post_types_registry' );

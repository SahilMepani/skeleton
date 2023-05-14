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

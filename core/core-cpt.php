<?php
/**
 * Prepares the environment for Custom Post Type registration.
 *
 * @since      1.0.0
 * @subpackage Custom Post Types
 * @package    Core
 */

/**
 * Registers a custom Post Type.
 *
 * @since 1.0.0
 *
 * @param array $args =[]
 *
 * @internal
 *
 */
function core_register_post_type($args = []) {
	if (isset($args['rewrite'])) {
		$rewrite_slug    = $args['rewrite'];
		$args['rewrite'] = [
			'slug' => $rewrite_slug,
		];
	}

	// Set defaults.
	$default_args = [
		'supports'        => ['title', 'thumbnail', 'editor'],
		'slug'            => sanitize_title($args['label']),
		'public'          => true,
		'hierarchical'    => false,
		'menu_position'   => 5,
		'can_export'      => false,
		'has_archive'     => false,
		'capability_type' => 'page',
		'show_in_rest'    => true,
	];

	foreach ($default_args as $key => $value) {
		$args[$key] = core_default($key, $args, $value);
	}

	register_post_type($args['slug'], $args);
}

/**
 * Registers a custom Taxonomy.
 *
 * @since 1.0.0
 *
 * @param array           $args
 * @param string|string[] $post_types
 *
 * @internal
 *
 */
function core_register_taxonomy($args = [], $post_types = []) {
	$labels = $args['labels'];
	unset($args['labels']);

	// Set the labels.
	$args['label']  = $labels['singular'];
	$args['labels'] = [
		'name'                       => $labels['plural'],
		'singular_name'              => $labels['plural'],
		'search_items'               => "Search {$labels['plural']}",
		'popular_items'              => null,
		'all_items'                  => $labels['plural'],
		'parent_item'                => "Parent {$labels['singular']}",
		'parent_item_colon'          => "Parent {$labels['singular']}:",
		'edit_item'                  => "Edit {$labels['singular']}",
		'view_item'                  => "View {$labels['singular']}",
		'update_item'                => "Update {$labels['singular']}",
		'add_new_item'               => "Add New {$labels['singular']}",
		'new_item_name'              => "New {$labels['singular']} Name",
		'separate_items_with_commas' => null,
		'add_or_remove_items'        => null,
		'choose_from_most_used'      => null,
		'not_found'                  => "No {$labels['plural']} found.",
		'no_terms'                   => "No {$labels['plural']}",
		'items_list_navigation'      => "{$labels['plural']} list navigation",
		'items_list'                 => "{$labels['plural']} list",
		'most_used'                  => "Most Used",
		'back_to_items'              => "← Back to {$labels['plural']}",
		'menu_name'                  => $labels['plural'],
		'name_admin_bar'             => $labels['plural'],
		'archives'                   => $labels['plural'],
	];

	// Set defaults.
	$default_args = [
		'slug'              => sanitize_title($labels['singular']),
		'id'                => sanitize_title($labels['singular']),
		'public'            => true,
		'hierarchical'      => true,
		'show_admin_column' => true,
	];

	foreach ($default_args as $key => $value) {
		$args[$key] = core_default($key, $args, $value);
	}

	/** Register the taxonomy. */
	register_taxonomy($args['id'], $post_types, $args);
}

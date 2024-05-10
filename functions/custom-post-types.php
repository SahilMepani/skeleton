<?php
/**
 * Creat custom post types and taxonomies
 *
 * @package WordPress
 * @subpackage Skeleton
 * @since 1.0.0
 */

/**
 * Create post type
 *
 * @return void
 */
function skel_create_post_type(): void {
	$cpt_project_labels = array(
		'name'               => __( 'Projects' ),
		'all_items'          => __( 'All Projects' ),
		'singular_name'      => __( 'Project' ),
		'add_new'            => __( 'Add New' ),
		'add_new_item'       => __( 'Add New Project' ),
		'edit_item'          => __( 'Edit Project' ),
		'new_item'           => __( 'New Project' ),
		'view_item'          => __( 'View Project' ),
		'search_items'       => __( 'Search Projects' ),
		'not_found'          => __( 'No Project found' ),
		'not_found_in_trash' => __( 'No Project found in Trash' ),
		'parent_item_colon'  => '',
	);

	$cpt_project_args = array(
		'labels'        => $cpt_project_labels,
		'public'        => true, // archive and single.
		'show_ui'       => true, // manage single post from backend.
		'hierarchical'  => true, // simple page ordering.
		'has_archive'   => true, // pagination & archive page.
		'menu_position' => 20, // below pages.
		'menu_icon'     => 'dashicons-welcome-view-site', // defaults to post icon.
		'supports'      => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'custom-fields' ),
		'show_in_rest'  => true, // enable gutenberg.
	);

	register_post_type( 'project', $cpt_project_args );
}

/*
Custom taxonomies
$reference_default_args = array(
'publicly_queryable' => true, // archive inherit from public
'show_ui'            => true, // manage terms, false if we want to set default terms and don't want to add/edit them, inherit from public
'show_in_menu'       => true, // hide from sidebar menu but accessible from URL, requires 'show_ui' true.
'show_in_nav_menus'  => true, // apprearance menu
'show_in_quick_edit' => true, // requires 'show_ui' true.
);
 */

/**
 * Register taxonomy
 *
 * @return void
 */
function skel_build_taxonomies(): void {

	/*----------  First Tax  ----------*/
	$category_labels = array(
		'name'                       => __( 'Categories' ),
		'all_items'                  => __( 'All Categories' ),
		'singular_name'              => __( 'Category' ),
		'search_items'               => __( 'Search Categories' ),
		'popular_items'              => __( 'Popular Categories' ),
		'parent_item'                => __( 'Parent Category' ),
		'parent_item_colon'          => __( 'Parent Category:' ),
		'edit_item'                  => __( 'Edit Category' ),
		'update_item'                => __( 'Update Category' ),
		'add_new_item'               => __( 'Add New Category' ),
		'new_item_name'              => __( 'New Category Name' ),
		'separate_items_with_commas' => __( 'Separate Categories with commas' ),
		'add_or_remove_items'        => __( 'Add or remove Categories' ),
		'choose_from_most_used'      => __( 'Choose from the most used Categories' ),
		'menu_name'                  => __( 'Categories' ),
	);

	register_taxonomy(
		'project-category', // taxonomy name.
		array( 'project' ), // post type.
		array(
			'labels'            => $category_labels,
			'public'            => false,
			'show_ui'           => true, // manage terms, false if we want to set default terms and don't want to addedit them.
			'hierarchical'      => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			// 'rewrite'    => array( 'slug' => 'custom_post_type', 'with_front' => false ) //this will enable the url to be custom_post_type/term instead of taxonomy/term.
		)
	);
}
add_action( 'init', 'skel_build_taxonomies', 0 );
add_action( 'init', 'skel_create_post_type' );

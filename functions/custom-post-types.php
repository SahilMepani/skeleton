<?php

/*=============================================
=            Post Type - Portfolio            =
=============================================*/
function skel_create_post_type() {
	$cpt_project_labels = array(
		'name'               => __( 'Projects' ),
		'all_items'          => __( 'All Projects' ),
		'singular_name'      => __( 'Project'  ),
		'add_new'            => __('Add New' ),
		'add_new_item'       => __('Add New Project' ),
		'edit_item'          => __('Edit Project' ),
		'new_item'           => __('New Project' ),
		'view_item'          => __('View Project' ),
		'search_items'       => __('Search Projects' ),
		'not_found'          =>  __('No Project found' ),
		'not_found_in_trash' => __('No Project found in Trash' ),
		'parent_item_colon'  => ''
	);

	$cpt_project_args = array(
		'labels'              => $cpt_project_labels,
		'public'              => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'query_var'           => true,
		'hierarchical'        => true, //simple page ordering
		'has_archive'         => true, //pagination & archive page
		'capability_type'     => 'post',
		'menu_position'       => 20, //below pages
		'menu_icon'           => 'dashicons-welcome-view-site', //defaults to post icon
		//Uncomment the following line to change the slug;
		//You must also save your permalink structure to prevent 404 errors
		//'rewrite'           => array( 'slug' => 'project/%skills%', 'with_front' => false ),
		'supports'            => array('title','editor','thumbnail','page-attributes', 'custom-fields'),
		// enable gutenberg
		// 'show_in_rest' => true,
		// 'supports' => array('editor')
	);

	register_post_type( 'project', $cpt_project_args );
	// flush_rewrite_rules();
}


/*================================
=            Taxonomy            =
================================*/
function skel_build_taxonomies() {

	/*----------  First Tax  ----------*/
	$tax_one_labels = array(
		'name'                       => __( 'Taxs One' ),
		'all_items'                  => __( 'All Taxs One' ),
		'singular_name'              => __( 'Tax One' ),
		'search_items'               => __( 'Search Taxs One' ),
		'popular_items'              => __( 'Popular Taxs One' ),
		'all_items'                  => __( 'All Taxs One' ),
		'parent_item'                => __( 'Parent Tax One' ),
		'parent_item_colon'          => __( 'Parent Tax One:' ),
		'edit_item'                  => __( 'Edit Tax One' ),
		'update_item'                => __( 'Update Tax One' ),
		'add_new_item'               => __( 'Add New Tax One' ),
		'new_item_name'              => __( 'New Tax One Name' ),
		'separate_items_with_commas' => __( 'Separate Taxs One with commas' ),
		'add_or_remove_items'        => __( 'Add or remove Taxs One' ),
		'choose_from_most_used'      => __( 'Choose from the most used Taxs One' ),
		'menu_name'                  => __( 'Taxs One' )
	);

	register_taxonomy(
		'tax-one', // taxonomy name
		array( 'project' ), // post type
		array(
			'labels'            => $tax_one_labels,
			'public'            => true,
			'show_ui'           => true,
			'hierarchical'      => true,
			'show_admin_column' => true,
			'show_in_rest' => true
			//'rewrite'    => array( 'slug' => 'custom_post_type', 'with_front' => false ) //this will enable the url to be custom_post_type/term instead of taxonomy/term
		)
	);

	/*----------  Second Tax  ----------*/
	$tax_two_labels = array(
		'name'                       => __( 'Taxs Two' ),
		'singular_name'              => __( 'Tax Two' ),
		'search_items'               => __( 'Search Taxs Two' ),
		'popular_items'              => __( 'Popular Taxs Two' ),
		'all_items'                  => __( 'All Taxs Two' ),
		'parent_item'                => __( 'Parent Tax Two' ),
		'parent_item_colon'          => __( 'Parent Tax Two:' ),
		'edit_item'                  => __( 'Edit Tax Two' ),
		'update_item'                => __( 'Update Tax Two' ),
		'add_new_item'               => __( 'Add New Tax Two' ),
		'new_item_name'              => __( 'New Tax Two Name' ),
		'separate_items_with_commas' => __( 'Separate Taxs Two with commas' ),
		'add_or_remove_items'        => __( 'Add or remove Taxs Two' ),
		'choose_from_most_used'      => __( 'Choose from the most used Taxs Two' ),
		'menu_name'                  => __( 'Taxs Two' )
	);

	register_taxonomy(
		'tax-two', // taxonomy name
		array( 'project' ), // post type
		array(
			'labels'            => $tax_two_labels,
			'public'            => true,
			'show_ui'           => true,
			'hierarchical'      => true,
			'show_admin_column' => true,
			'show_in_rest' => true
			//'rewrite'    => array( 'slug' => 'custom_post_type', 'with_front' => false ) //this will enable the url to be custom_post_type/term instead of taxonomy/term
		)
	);

}
add_action( 'init', 'skel_build_taxonomies', 0 );
add_action( 'init', 'skel_create_post_type' );
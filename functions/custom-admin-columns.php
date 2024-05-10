<?php
/**
 * Custom admin columns
 *
 * @package WordPress
 * @subpackage Skeleton
 * @since 1.0.0
 */

/**
 * Display a custom taxonomy dropdown in admin
 *
 * @return void
 */
function skel_filter_post_type_by_taxonomy(): void {
	global $typenow;
	$post_type = 'project'; // Change to your post type.
	$taxonomy  = 'tax-one'; // Change to your taxonomy.
	if ( $typenow === $post_type ) {
		$selected      = isset( $_GET[ $taxonomy ] ) ? $_GET[ $taxonomy ] : '';
		$info_taxonomy = get_taxonomy( $taxonomy );
		wp_dropdown_categories(
			array(
				'show_option_all' => __( "Show All {$info_taxonomy->label}" ),
				'taxonomy'        => $taxonomy,
				'name'            => $taxonomy,
				'orderby'         => 'name',
				'selected'        => $selected,
				'show_count'      => true,
				'hide_empty'      => true,
			)
		);
	}
}
// Add action.
add_action( 'restrict_manage_posts', 'skel_filter_post_type_by_taxonomy' );

/**
 * Filter posts by taxonomy in admin
 *
 * @param mixed $query
 * @return void
 */
function skel_convert_id_to_term_in_query( $query ): void {
	global $pagenow;
	$post_type = 'project'; // Change to your post type.
	$taxonomy  = 'tax-one'; // Change to your taxonomy.
	$q_vars    = &$query->query_vars;
	if ( $pagenow == 'edit.php' && isset( $q_vars['post_type'] ) && $q_vars['post_type'] == $post_type && isset( $q_vars[ $taxonomy ] ) && is_numeric( $q_vars[ $taxonomy ] ) && $q_vars[ $taxonomy ] != 0 ) {
		$term                = get_term_by( 'id', $q_vars[ $taxonomy ], $taxonomy );
		$q_vars[ $taxonomy ] = $term->slug;
	}
}
// Add filter.
add_filter( 'parse_query', 'skel_convert_id_to_term_in_query' );

// https://www.ractoon.com/wordpress-sortable-admin-columns-for-custom-posts/.
// Seminar CPT - Custom admin columns.

/**
 * Adding & Positoning columns
 *
 * @param [type] $columns
 * @return void
 */
function seminar_add_columns( $columns ) {
	remove
	unset( $columns['date'] );
	unset( $columns['taxonomy-seminar-type'] );
	unset( $columns['expirationdate'] );
	add
	$columns['location']       = 'Location';
	$columns['status']         = 'Status';
	$columns['custom_date']    = 'Date';
	$columns['expirationdate'] = 'Expires';
	return $columns;
}
// Add filter.
add_filter( 'manage_seminar_posts_columns', 'seminar_add_columns' );

/**
 * Add content to the columns
 *
 * @param [type] $column
 * @param [type] $post_id
 * @return void
 */
function seminar_add_column_content( $column, $post_id ): void {
	switch ( $column ) {
		case 'location':
			echo get_post_meta( $post_id, 'location', true );
			break;
		case 'status':
			echo get_post_meta( $post_id, 'label', true );
			break;
		case 'custom_date':
			echo get_post_meta( $post_id, 'date', true );
			break;
	}
}
// Add action.
add_action( 'manage_seminar_posts_custom_column', 'seminar_add_column_content', 10, 2 );

/**
 * Making custom columns sortable
 *
 * @param [type] $columns
 * @return void
 */
function seminar_enable_sort_column( $columns ): void {
	$columns['location']    = 'location';
	$columns['status']      = 'label';
	$columns['custom_date'] = 'date';
	return $columns;
}
// Add filter.
add_filter( 'manage_edit-seminar_sortable_columns', 'seminar_enable_sort_column' );

/**
 * Sort by meta value
 * use meta_value_num if value is numeric
 *
 * @param [type] $query
 * @return void
 */
function seminar_sort_column_meta_value( $query ): void {
	if ( ! is_admin() ) {
		return;
	}
	$orderby = $query->get( 'orderby' );
	switch ( $orderby ) {
		case 'location': // Meta_key.
			$query->set( 'meta_key', 'location' );
			$query->set( 'orderby', 'meta_value' );
			break;
		case 'label':
			$query->set( 'meta_key', 'label' );
			$query->set( 'orderby', 'meta_value' );
			break;
		case 'date':
			$query->set( 'meta_key', 'date' );
			$query->set( 'orderby', 'meta_value' );
			break;
	}
}
// Add action.
add_action( 'pre_get_posts', 'seminar_sort_column_meta_value' );

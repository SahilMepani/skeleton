<?php
/*===================================================================
=            Display a custom taxonomy dropdown in admin            =
===================================================================*/
// add_action('restrict_manage_posts', 'tse_filter_post_type_by_taxonomy');
// function tse_filter_post_type_by_taxonomy() {
// 	global $typenow;
// 	$post_type = 'project'; // change to your post type
// 	$taxonomy  = 'tax-one'; // change to your taxonomy
// 	if ($typenow == $post_type) {
// 		$selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
// 		$info_taxonomy = get_taxonomy($taxonomy);
// 		wp_dropdown_categories(array(
// 			'show_option_all' => __("Show All {$info_taxonomy->label}"),
// 			'taxonomy'        => $taxonomy,
// 			'name'            => $taxonomy,
// 			'orderby'         => 'name',
// 			'selected'        => $selected,
// 			'show_count'      => true,
// 			'hide_empty'      => true,
// 		));
// 	};
// }


/*=========================================================
=            Filter posts by taxonomy in admin            =
=========================================================*/
// add_filter('parse_query', 'tse_convert_id_to_term_in_query');
// function tse_convert_id_to_term_in_query($query) {
// 	global $pagenow;
// 	$post_type = 'project'; // change to your post type
// 	$taxonomy  = 'tax-one'; // change to your taxonomy
// 	$q_vars    = &$query->query_vars;
// 	if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
// 		$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
// 		$q_vars[$taxonomy] = $term->slug;
// 	}
// }


// https://www.ractoon.com/wordpress-sortable-admin-columns-for-custom-posts/

// Seminar CPT - Custom admin columns
////////////////////////////////////////////////

// Adding & Positoning columns
// function seminar_add_columns( $columns ) {
//   // remove
//   unset( $columns['date'] );
//   unset( $columns['taxonomy-seminar-type'] );
//   unset( $columns['expirationdate'] );
//   // add
//   $columns['location'] = 'Location';
//   $columns['status'] = 'Status';
//   $columns['custom_date'] = 'Date';
//   $columns['expirationdate'] = 'Expires';
//   return $columns;
// }
// add_filter( 'manage_seminar_posts_columns', 'seminar_add_columns' );

// Add content to the columns
// function seminar_add_column_content( $column, $post_id ) {
//   switch ( $column ) {
//     case 'location':
//       echo get_post_meta( $post_id, 'location', true );
//       break;
//     case 'status':
//       echo get_post_meta( $post_id, 'label', true );
//       break;
//     case 'custom_date':
//       echo get_post_meta( $post_id, 'date', true );
//       break;
//   }
// }
// add_action( 'manage_seminar_posts_custom_column', 'seminar_add_column_content', 10, 2);

// Making custom columns sortable
// function seminar_enable_sort_column( $columns ) {
//   $columns['location'] = 'location';
//   $columns['status'] = 'label';
//   $columns['custom_date'] = 'date';
//   return $columns;
// }
// add_filter( 'manage_edit-seminar_sortable_columns', 'seminar_enable_sort_column');

// Sort by meta value
// use meta_value_num if value is numeric
// function seminar_sort_column_meta_value( $query ) {
//   if ( ! is_admin() ) return;
//   $orderby = $query->get( 'orderby' );
//   switch ( $orderby ) {
//     case 'location': // meta_key
//       $query->set( 'meta_key', 'location' );
//       $query->set( 'orderby', 'meta_value' );
//       break;
//     case 'label':
//       $query->set( 'meta_key', 'label' );
//       $query->set( 'orderby', 'meta_value' );
//       break;
//     case 'date':
//       $query->set( 'meta_key', 'date' );
//       $query->set( 'orderby', 'meta_value' );
//       break;
//   }
// }
// add_action( 'pre_get_posts', 'seminar_sort_column_meta_value' );

?>
<?php
/**
 * Update posts based on provided parameters.
 *
 * @package WordPress
 * @since 1.0.0
 */

/**
 * This function retrieves posts based on the provided parameters from the $_POST array.
 * It then queries the database using WP_Query and outputs the posts accordingly.
 */
function update_post() {
	// Verify nonce.
	if (
		! isset( $_POST['skel-nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['skel-nonce'] ) ), 'update_post_nonce' )
	) {
		wp_send_json_error( 'Invalid nonce.' );
	}

	$data = $_POST;

	// Define query arguments.
	$args = array(
		'post_type'      => $data['cpt'],
		'posts_per_page' => $data['postsPerPage'],
	);

	// Check if pagenumber is set for load more.
	if ( isset( $data['pageNumber'] ) && '' !== $data['pageNumber'] ) {
		$args['paged'] = $data['pageNumber'] + 1;
	}

	// Add taxonomy query if category is set.
	if ( '' !== $data['cat'] ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => $data['tax'],
				'field'    => 'slug',
				'terms'    => $data['cat'],
			),
		);
	}

	// Add author ID if provided.
	if ( '' !== $data['authorID'] ) {
		$args['author'] = $data['authorID'];
	}

	// Add tag ID if provided.
	if ( '' !== $data['tagID'] ) {
		$args['tag_id'] = $data['tagID'];
	}

	// Add search query if provided.
	if ( '' !== $data['search'] ) {
		$args['s'] = $data['search'];
	}

	// Query posts based on arguments.
	$custom_query = new WP_Query( $args );

	// Output posts if found.
	if ( $custom_query->have_posts() ) :
		while ( $custom_query->have_posts() ) :
			$custom_query->the_post();

			// Output post card template part for 'post' post type.
			if ( 'post' === $data['cpt'] ) {
				get_template_part( 'template-parts/post-card' );
			}

		endwhile;
		wp_reset_postdata();
	endif;

	wp_die();
}

// Hook the update_post function to AJAX action.
add_action( 'wp_ajax_update_post_ajax', 'update_post' );

// Hook the update_post function to AJAX action for non-logged in users.
add_action( 'wp_ajax_nopriv_update_post_ajax', 'update_post' );

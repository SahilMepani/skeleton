<?php
/**
 * Includes functions to help with formatting and information-gathering for posts.
 *
 * @package Core
 * @subpackage Posts Utilities
 */

/**
 * Retrieves all taxonomy terms attached to the specified post.
 *
 * @since 1.0.0
 *
 * @param int $post_id
 * @return array
 */
function core_get_post_terms( $post_id ) {
	$taxonomies = get_post_taxonomies( $post_id );
	if ( empty( $taxonomies ) ) return null;

	$terms = [];

	foreach ( $taxonomies as $taxonomy ) {
		$terms[ $taxonomy ] = [];
		$post_terms = get_the_terms( $post_id, $taxonomy );

		if ( ! empty( $post_terms ) ) {
			foreach( $post_terms as $term ) {
				$terms[ $taxonomy ][] = [
					'ID' => $term->term_id,
					'title' => $term->name,
					'slug' => $term->slug
				];
			}
		}
	}

	return $terms;
}

/**
 * Retrieves all thumbnail sizes for the specified post.
 *
 * @since 1.0.0
 *
 * @param int $post_id
 * @return array
 */
function core_get_post_thumbnail( $post_id ) {
	$thumbnail = get_field( 'thumbnail', $post_id );

	if ( ! $thumbnail ) {

		// Get the placeholder thumbnail.
		$ph_image = get_field( 'default_thumbnail', 'option' ) ?? null;

		// Prevent an error when field keys change.
		if ( $ph_image !== null && ! is_array( $ph_image ) ) {
			update_field( 'default_thumbnail', $ph_image, 'option' );
			$ph_image = get_field( 'default_thumbnail', 'option' );
		}

		if ( is_array( $ph_image ) ) $ph_image['placeholder'] = true;

		$thumbnail = $ph_image;
	}

	return $thumbnail;
}

/**
 * Retrieves and formats data for the specified post.
 *
 * @since 1.0.0
 * @since 2.3.0 Added author information.
 *
 * @param int $post_id
 * @param boolean [$include_fields=true]
 * @return array
 */
function core_format_post_object( $post_id, $include_fields = true ) {

	/**
	 * The post terms.
	 *
	 * @var WP_Term[]
	 */
	$post_terms = core_get_post_terms( $post_id );

	/**
	 * The post thumbnail.
	 *
	 * @var mixed[]
	 */
	$post_thumbnail = core_get_post_thumbnail( $post_id );

	/**
	 * The raw published date.
	 *
	 * @var int
	 */
	$publish_date = get_the_date( 'U', $post_id );

	/**
	 * The formatted published date.
	 *
	 * @var string
	 */
	$formatted_publish_date = date( 'F j, Y', $publish_date );

	/**
	 * The raw modified date.
	 *
	 * @var int
	 */
	$modified_date = get_the_modified_date( 'U', $post_id );

	/**
	 * The formatted modified date.
	 *
	 * @var string
	 */
	$formatted_modified_date = date( 'F j, Y', $modified_date );

	/**
	 * The post type.
	 *
	 * @var string
	 */
	$post_type = get_post_type( $post_id );

	/**
	 * The page template.
	 *
	 * @var string|null
	 */
	$page_template = $post_type === 'page' ? get_post_meta( $post_id, '_wp_page_template', true ) : null;

	/**
	 * The post excerpt.
	 *
	 * @var string
	 */
	$post_excerpt = get_field( 'excerpt', $post_id );

	/**
	 * The post author.
	 *
	 * @var array|null
	 */
	$post_author_id = get_post_field( 'post_author', $post_id );
	$post_author = [
		'name' => get_the_author_meta( 'display_name', $post_author_id ),
		'fields' => get_fields( "user_{$post_author_id}" )
	];

	/**
	 * The formatted post.
	 *
	 * @var mixed[]
	 */
	$formatted_post = [
		'ID' => $post_id,
		'title' => get_the_title( $post_id ),
		'post_type' => $post_type,
		'page_template' => $page_template,
		'permalink' => get_the_permalink( $post_id ),
		'thumbnail' => $post_thumbnail,
		'excerpt' => $post_excerpt,
		'terms' => $post_terms,
		'date' => '' . $publish_date,
		'date_formatted' => $formatted_publish_date,
		'modified' => '' . $modified_date,
		'modified_formatted' => $formatted_modified_date,
		'author' => $post_author
	];

	// Add the post fields, if needed.
	if ( $include_fields ) {
		$formatted_post['fields'] = core_get_fields( $post_id );
	}

	// ? Apply Filters: Global
	$formatted_post = apply_filters( 'core/formatted_post', $formatted_post );

	// ? Apply Filters: Post Type
	$formatted_post = apply_filters( "core/formatted_post/post-type={$post_type}", $formatted_post );

	// ? Apply filters: Page Template
	if ( $page_template ) {
		$formatted_post = apply_filters( "core/formatted_post/page-template={$page_template}", $formatted_post );
	}

	// Return.
	return $formatted_post;
}

/**
 * Checks, based on backtrace depth, if a formatted post
 * should include fields.
 *
 * This prevents an infinite loop due to posts possibly including
 * other posts, and those posts including other posts, and so on.
 *
 * Max depth is 2: Current Post > Child Post (Grandchild post will not include fields).
 */
function core_should_include_post_fields() {
	$backtrace_files = array_map( function( $entry ) {
		if ( ! array_key_exists( 'file', $entry ) ) return false;

		$file_name = explode( '/', $entry['file'] );

		return [
			'file' => end( $file_name ),
			'function' => $entry['function']
		];
	}, debug_backtrace() );

	$formatting_depth = count(
		array_filter( $backtrace_files, function( $entry ) {
			return $entry && $entry['file'] === 'class-wp-hook.php' && (
				$entry['function'] === 'core_acf_format_post_object_field' ||
				$entry['function'] === 'core_acf_format_relationship_field'
			);
		})
	);

	return $formatting_depth < 3;
}

<?php
/**
 * Formats the result returned from custom ACF fields.
 *
 * @package Core
 * @subpackage Advanced Custom Fields
 * @since 2.7.0
 */

/**
 * The entire list of custom ACF fields and their formatting methods.
 * This list is automatically looped through once.
 *
 * @since 2.7.0
 */
$core_acf_custom_fields = array(

	// * Type: Button
	'button'           => function ( $value ) {
		if ( $value['link'] ) {
			$value['link']['style'] = $value['style'];
		}
		$value                                        = $value['link'];

		return $value;
	},

	// * Type: Dynamic Image
	'dynamic_image'    => function ( $value ) {
		$ratio          = $value['ratio'];
		$value          = $value['image'];
		$value['ratio'] = $ratio;

		return $value;
	},

	// * Type: Hidden
	'hidden'           => function ( $_value, $field ) {
		return $field['value'];
	},

	// * Type: Post Content
	'post_content'     => function ( $value ) {
		$custom = $value['content_type'] === 'custom';
		$value  = $custom ? $value['custom'] : $value['post'];

		// Format the custom value.
		if ( $custom ) {

			// * Thumbnail.
			if ( array_key_exists( 'thumbnail', $value ) && ! $value['thumbnail'] ) {
				$value['thumbnail'] = get_field( 'default_thumbnail', 'option' );
			}

			// * Permalink.
			if (
				array_key_exists( 'permalink', $value ) &&
				$value['permalink']
			) {
				$value['permalink'] = $value['permalink']['url'];
			}

			// Move custom fields into the `fields` variable.
			$post_field_names = array(
				'thumbnail',
				'title',
				'excerpt',
				'permalink',
			);

			foreach ( $value as $field_name => $field_value ) {
				if ( in_array( $field_name, $post_field_names ) ) {
					continue;
				}

				if ( ! array_key_exists( 'fields', $value ) ) {
					$value['fields'] = array();
				}

				$value['fields'][ $field_name ] = $field_value;
			}
		}

		return $value;
	},

	// * Type: Post List
	'post_list'        => function ( $value ) {
		if ( $value['query_type'] === 'custom' ) {
			return $value['post_number'] > 1 ? $value['posts'] : $value['post'];
		}

		$post_types = $value['post_types'];

		/**
		 * The query arguments.
		 *
		 * @var array
		 */
		$query_args = array(
			'post_type'      => array_column( $post_types, 'slug' ),
			'posts_per_page' => $value['post_number'],
			'fields'         => 'ids',
		);

		// Run query.
		$query = new WP_Query( $query_args );

		// Check if the list is empty.
		if ( empty( $query->posts ) ) {
			return $value['post_number'] > 1 ? array() : null;
		}

		// Format and save the posts.
		if ( $value['post_number'] > 1 ) {
			$value = array_map(
				function ( $post ) {
					return core_format_post_object( $post, false );
				},
				$query->posts
			);
		} else {
			$value = core_format_post_object( $query->posts[0], false );
		}

		// Return.
		return $value;
	},

	// * Type: Post Type Select
	'post_type_select' => function ( $value ) {
		if ( is_array( $value ) ) {
			return array_map( 'core_get_post_type', array_unique( $value ) );
		} elseif ( is_string( $value ) ) {
			return core_get_post_type( $value );
		} else {
			return $value;
		}
	},

	// * Type: Taxonomy Select
	'taxonomy_select'  => function ( $value ) {
		if ( is_array( $value ) ) {
			return array_map( 'core_get_taxonomy', array_unique( $value ) );
		} elseif ( is_string( $value ) ) {
			return core_get_taxonomy( $value );
		} else {
			return $value;
		}
	},
);

/**
 * Automatically loop through all formatting methods, adding
 * filter hooks to each one of them.
 */
foreach ( $core_acf_custom_fields as $field_name => $formatting_method ) {
	add_filter( "core_acf_format_custom_field/field={$field_name}", $formatting_method, 11, 3 );
}

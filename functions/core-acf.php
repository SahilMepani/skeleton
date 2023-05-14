<?php
/**
 * Prepares the environment for Custom Fields registration using ACF.
 */

/**
 * Checks if the specified registration data includes all the necessary
 * information for the Field Group.
 *
 * @param array[] $reg_data The Field Group registration data.
 * @return boolean
 */
function core_check_field_group_integrity( $reg_data ) {
	/**
	 * The list of errors.
	 *
	 * @var string[]
	 */
	$errors = [];

	/**
	 * The list of required options.
	 *
	 * @var string[]
	 */
	$required_options = [
		'slug',
		'title',
		'location',
		'fields'
	];

	// Check if all the required options exist.
	foreach ( $required_options as $option ) {
		if ( ! array_key_exists( $option, $reg_data ) ) {
			$errors[] = 'Missing required ACF registration data: "' . $option . '"';
		}
	}

	// Display errors.
	foreach ( $errors as $error ) {
		core_add_notice( 'warning', $error, core_docs( 'custom-fields' ) );
	}

	return empty( $errors );
}

/**
 * Checks the specified list of fields for invalid formatting or missing
 * data before registering fields to a Field Group.
 *
 * @since 1.0.0
 * @internal
 *
 * @param array[] $fields
 * @return boolean
 */
function core_check_fields_integrity( $fields ) {
	if ( ! is_array( $fields ) ) return false;

	$invalid_fields = array_filter( $fields, function( $field ) {

		// There should be at least 2 parameters (type and label).
		if ( count( $field ) < 2 ) return true;

		// The first 2 parameters should be strings.
		if ( ! is_string( $field[0] ) || ! is_string( $field[1] ) ) return true;

		// The third parameter should be an associative array (options).
		if ( isset( $field[2] ) && ! core_is_assoc( $field[2] ) ) return true;

		// Also validate sub fields.
		if ( isset( $field[2] ) && array_key_exists( 'sub_fields', $field[2] ) ) {
			$sub_fields_integrity = core_check_fields_integrity( $field[2]['sub_fields'] );

			if ( ! $sub_fields_integrity ) return true;
		}

		return false;
	});

	return empty( $invalid_fields );
}

/**
 * Formats the arguments for a simple custom ACF field.
 *
 * There are other, more advanced custom field types registered in the core,
 * but these ones are simple enough for us to register them here.
 *
 * @since 1.0.0
 * @internal
 *
 * @param array $field
 * @return array
 */
function core_build_custom_field_type( $field ) {

	/**
	 * The list of custom field types.
	 *
	 * @var array
	 */
	$custom_field_types = [

		/**
		 * A simple link field with the option of specifying the button style.
		 *
		 * @since 1.1.8
		 */
		'button' => function( $args ) {
			$button_styles = core_get_option( 'button-styles' );
			if ( ! $button_styles ) $button_styles = [ 'default' => 'Default' ];

			return array_merge( $args, [
				'type' => 'group',
				'sub_fields' => [
					[ 'link', 'Link', [
						'wrapper_width' => 50
					]],
					[ 'select', 'Style', [
						'wrapper_width' => 50,
						'choices' => $button_styles
					]]
				]
			]);
		},

		/**
		 * A common field wrapper. Retrieves the common field configuration.
		 *
		 * @since 1.1.5
		 */
		'common' => function( $args ) {
			$common_field_slug = core_default( 'slug', $args, false );
			$common_field = core_get_common_field( $common_field_slug );

			if ( $common_field ) {
				return array_merge( $args, [
					'type' => 'group',
					'layout' => 'block',
					'sub_fields' => $common_field
				]);
			} else {
				return [
					'type' => 'message',
					'label' => 'Common Field Error',
					'message' => 'Common field "'.$common_field_slug.'" was not found.'
				];
			}
		},

		/**
		 * An image field with the option to toggle between
		 * different ratios.
		 *
		 * @since 2.14.0
		 */
		'dynamic_image' => function( $args ) {
			return array_merge( $args, [
				'type' => 'group',
				'sub_fields' => [
					[ 'image', 'Image', [
						'dimensions' => core_default( 'dimensions', $args, null ),
						'wrapper_width' => 50
					]],
					[ 'button_group', 'Ratio (Optional)', [
						'choices' => [
							'none' => 'None',
							'horizontal' => 'Horizontal',
							'square' => 'Square',
							'vertical' => 'Vertical'
						],
						'wrapper_width' => 50
					]]
				]
			]);
		},

		/**
		 * A form selector field.
		 *
		 * @since 1.1.2
		 * @since 1.1.4 Added the option to customize the submit button label.
		 * @uses core_list_forms()
		 */
		'form_select' => function( $args ) {
			$new_args = [
				'type' => 'group',
				'sub_fields' => [
					[ 'select', 'Variation', [
						'name' => 'id',
						'choices' => core_list_forms(),
						'instructions' => 'You can create new variations ' . core_admin( 'admin.php?page=gf_edit_forms', 'here.', true )
					]],
					[ 'true_false', 'Inline', [
						'instructions' => 'Displays the fields and submit button on the same line. This is only recommended if the form doesn\'t have a lot of fields.',
						'wrapper_width' => 50
					]],
					[ 'select', 'Button Alignment', [
						'show_if' => '!inline',
						'choices' => [
							'left' => 'Left',
							'center' => 'Center',
							'right' => 'Right'
						],
						'wrapper_width' => 50
					]],
					[ 'message', 'Button Alignment', [
						'show_if' => 'inline',
						'message' => 'Not applicable.',
						'wrapper_width' => 50
					]],
					[ 'text', 'Button Label', [
						'required' => 1,
						'default_value' => 'Submit',
						'wrapper_width' => 50
					]],
				]
			];

			// Add the button style selector.
			$button_styles = core_get_option( 'button-styles' );

			if ( $button_styles ) {
				$new_args['sub_fields'][] = [ 'select', 'Button Style', [
					'choices' => $button_styles,
					'wrapper_width' => 50
				]];
			} else {
				$new_args['sub_fields'][] = [ 'message', 'Button Style', [
					'message' => 'Not applicable.',
					'wrapper_width' => 50
				]];
			}

			return array_merge( $args, $new_args );
		},

		/**
		 * A hidden field, meant to be used internally.
		 *
		 * @since 1.0.4
		 */
		'hidden' => function( $args ) {
			return array_merge( $args, [
				'type' => 'text',
				'default_value' => core_default( 'value', $args, '' ),
				'wrapper' => [
					'class' => 'hidden'
				]
			]);
		},

		/**
		 * This is used when we want to give the option of selecting a post
		 * to pull content from, instead of filling out a list of fields.
		 *
		 * @since 1.0.0
		 */
		'post_content' => function( $args ) {

			/**
			 * The list of fields used for the `custom` option.
			 *
			 * @var array
			 */
			$post_fields = [
				'thumbnail' => [ 'image', 'Thumbnail' ],
				'title' => [ 'text', 'Title' ],
				'excerpt' => [ 'textarea', 'Excerpt', [
					'new_lines' => ''
				]],
				'permalink' => [ 'link', 'Link', [
					'name' => 'permalink',
				]]
			];

			$post_types = core_get_post_types( false, true );

			// Filter the list of custom fields.
			if ( array_key_exists( 'post_fields', $args ) ) {
				foreach ( array_keys( $post_fields ) as $post_field_key ) {
					if ( ! in_array( $post_field_key, $args['post_fields'] ) ) {
						unset( $post_fields[ $post_field_key ] );
					}
				}
			}

			$post_fields = array_values( $post_fields );

			// Append custom fields to the list of post fields.
			if ( array_key_exists( 'custom_fields', $args ) ) {
				foreach ( $args['custom_fields'] as $sub_field ) {
					$post_fields[] = $sub_field;
				}
			}

			return array_merge( $args, [
				'type' => 'group',
				'required' => 0,
				'instructions' => 'Select a post to pull content from, or add custom content.',
				'sub_fields' => [
					[ 'button_group', 'Content Type', [
						'choices' => [
							'pull-from-post' => 'Pull from post',
							'custom' => 'Custom'
						],
						'wrapper_width' => 30
					]],
					[ 'post_object', 'Post', [
						'post_type' => core_default( 'post_type', $args, $post_types ),
						'required' => core_default( 'required', $args, 0 ),
						'wrapper_width' => 70,
						'show_if' => [
							'content_type' => 'pull-from-post'
						]
					]],
					[ 'group', 'Custom Content', [
						'name' => 'custom',
						'sub_fields' => $post_fields,
						'wrapper_width' => 70,
						'show_if' => [
							'content_type' => 'custom'
						]
					]]
				]
			]);
		},

		/**
		 * This is a simple select field with post types as options.
		 *
		 * @since 1.0.0
		 */
		'post_type_select' => function( $args ) {
			$post_type_filter = core_default( 'post_types', $args, [] );
			$post_types = core_get_post_types( $post_type_filter );

			sort( $post_types );

			// Build the choices array.
			$choices = [];

			foreach ( $post_types as $post_type ) {
				$choices[ $post_type['slug'] ] = $post_type['name'];
			}

			return array_merge( $args, [
				'type' => 'select',
				'multiple' => core_default( 'multiple', $args, 1 ),
				'choices' => $choices,
				'default_value' => core_default( 'default_value', $args, array_key_first( $choices ) )
			]);
		},

		/**
		 * This is a simple post listing field with the option to query posts
		 * automatically, or add them manually.
		 *
		 * @since 2.7.0
		 */
		'post_list' => function( $args ) {
			$post_number = core_default( 'max', $args, null );

			// Build the custom post field.
			$custom_post_field = [ 'post_content', 'Post', [
				'required' => 1
			]];

			if ( array_key_exists( 'post_fields', $args ) ) {
				$custom_post_field[2]['post_fields'] = $args['post_fields'];
			}

			if ( array_key_exists( 'custom_fields', $args ) ) {
				$custom_post_field[2]['custom_fields'] = $args['custom_fields'];
			}

			// Build the custom query field.
			if ( $post_number === 1 ) {
				$custom_post_field[2]['show_if'] = [ 'query_type' => 'custom' ];
				$custom_query_field = $custom_post_field;
			} else {
				$custom_query_field = [ 'repeater', 'Posts', [
					'button_label' => 'Add Post',
					'min' => core_default( 'min', $args, null ),
					'max' => core_default( 'max', $args, null ),
					'show_if' => [ 'query_type' => 'custom' ],
					'sub_fields' => [
						$custom_post_field
					]
				]];
			}

			return [
				'type' => 'group',
				'label' => $args['label'],
				'sub_fields' => array_filter([
					(
						$post_number ? [ 'hidden', 'Post Number', [
							'value' => $post_number
						]] : null
					),
					[ 'button_group', 'Query Type', [
						'choices' => [
							'auto' => 'Automatic',
							'custom' => 'Custom'
						]
					]],
					(
						! $post_number ? [ 'number', 'Number of posts', [
							'instructions' => 'This is the maximum number of posts to display.',
							'name' => 'post_number',
							'default_value' => 9,
							'min' => 1,
							'max' => 1000,
							'show_if' => [ 'query_type' => 'auto' ]
						]] : null
					),
					[ 'post_type_select', 'Post Types', [
						'required' => 1,
						'show_if' => [ 'query_type' => 'auto' ],
						'post_types' => core_default( 'post_types', $args, [] )
					]],
					$custom_query_field
				])
			];
		},

		/**
		 * This is a stripped-down version of the default Wysiwyg field.
		 *
		 * @since 1.0.0
		 */
		'rich_text' => function( $args ) {
			return array_merge( $args, [
				'type' => 'wysiwyg',
				'tabs' => core_default('tabs', $args, 'visual'),
				'toolbar' => 'core',
				'media_upload' => 0,
				'delay' => 1
			]);
		},

		/**
		 * This is used to have a section as part of a page, or as a standalone collection of fields.
		 * Useful if you need a section to be required on a page.
		 *
		 * @since 1.0.4
		 */
		'section' => function( $args ) {
			$section_slug = core_default( 'slug', $args, false );

			/**
			 * Check for the `section` key, if `slug` was not specified.
			 *
			 * @deprecated 1.0.5 Use `slug` instead.
			 */
			if ( ! $section_slug ) {
				$section_slug = core_default( 'section', $args, false );
			}

			// Attempt to find the section.
			$section = ! $section_slug ? null : core_get_section( $section_slug );

			if ( $section ) {
				$fields = core_default( 'fields', $section, [] );

				// Automatically add the 'acf_fc_layout' prop.
				array_unshift( $fields, [ 'hidden', 'Slug', [
					'value' => $section_slug
				]]);

				unset( $args['section'] );

				return array_merge( $args, [
					'type' => 'group',
					'layout' => 'block',
					'sub_fields' => $fields
				]);
			} else {
				return array_merge( $args, [
					'type' => 'message',
					'message' => 'The specified section was not found.'
				]);
			}
		},

		/**
		 * This is a simple select field with taxonomies as options.
		 *
		 * @since 1.0.0
		 */
		'taxonomy_select' => function( $args ) {
			$post_type_filter = core_default( 'post_types', $args, [] );
			$taxonomies = core_get_taxonomies( $post_type_filter );

			sort( $taxonomies );

			if ( empty( $taxonomies ) ) {
				return array_merge( $args, [
					'type' => 'message',
					'message' => 'No taxonomies found.'
				]);
			}

			// Build the choices array.
			$choices = [];

			foreach ( $taxonomies as $taxonomy ) {
				foreach ( $taxonomy['post_types'] as $post_type ) {
					$post_type = core_get_post_type( $post_type );

					if ( ! array_key_exists( $post_type['name'], $choices ) ) {
						$choices[ $post_type['name'] ] = [];
					}

					$choices[ $post_type['name'] ][ $taxonomy['slug'] ] = $taxonomy['singular_label'];
				}
			}

			return array_merge( $args, [
				'type' => 'select',
				'multiple' => core_default( 'multiple', $args, 1 ),
				'choices' => $choices
			]);
		},

		/**
		 * A video selector field. Adds the option to upload a file or
		 * add a YouTube or Vimeo URL.
		 *
		 * @since 2.0.3
		 */
		'video' => function( $args ) {
			return array_merge( $args, [
				'type' => 'group',
				'required' => core_default( 'required', $args, 0 ),
				'sub_fields' => [
					[ 'button_group', 'Type', [
						'choices' => [
							'file' => 'File',
							'embed' => 'Embed'
						],
						'wrapper_width' => 40,
					]],
					[ 'file', 'File (mp4)', [
						'name' => 'file',
						'mime_types' => 'mp4',
						'show_if' => [ 'type' => 'file' ],
						'wrapper_width' => 60
					]],
					[ 'text', 'URL', [
						'instructions' => 'Accepted sources: YouTube or Vimeo.',
						'show_if' => [ 'type' => 'embed' ],
						'wrapper_width' => 60
					]]
				]
			]);
		}
	];

	if ( array_key_exists( $field['type'], $custom_field_types ) ) {
		$field = array_merge(
			call_user_func( $custom_field_types[ $field['type'] ], $field ),
			[ 'core_field' => $field['type'] ]
		);
	}

	return $field;
}

/**
 * Applies default options to some field types.
 *
 * @since 1.0.0
 * @internal
 *
 * @param array $field
 * @return array
 */
function core_apply_default_field_options( $field ) {

	/**
	 * The list of fields and their default options.
	 *
	 * @var array
	 */
	$field_types = [
		'group' => [
			'layout' => 'block'
		],
		'image' => [
			'preview_size' => 'thumbnail',
			'instructions' => isset( $field['dimensions'] ) ? "Recommended dimensions (WxH): <code>{$field['dimensions']} px</code>" : ''
		],
		'message' => [
			'new_lines' => ''
		],
		'relationship' => [
			'post_type' => core_get_post_types( false, true ),
			'return_format' => 'id'
		],
		'repeater' => [
			'layout' => 'block'
		],
		'textarea' => [
			'rows' => 4,
			'new_lines' => ''
		],
		'title' => [
			'instructions' => 'Formatting options: <code>*Text*</code> for <strong>Bold</strong>',
			'auto_format' => 1
		],
		'true_false' => [
			'ui' => 1
		]
	];

	if ( array_key_exists( $field['type'], $field_types ) ) {
		$default_options = $field_types[ $field['type'] ];

		foreach ( $default_options as $key => $value ) {
			$field[ $key ] = core_default( $key, $field, $value );
		}
	}

	return $field;
}

/**
 * Applies custom field options designed to make it easier to
 * configura custom fields.
 *
 * @since 1.0.0
 * @internal
 *
 * @param array $fields
 * @return array
 */
function core_apply_custom_field_options( $fields ) {
	return array_map( function( $field ) use( $fields ) {

		// ? Wrapper width.
		if ( array_key_exists( 'wrapper_width', $field ) ) {
			$wrapper_width = $field['wrapper_width'];
			unset( $field['wrapper_width'] );

			if ( is_numeric( $wrapper_width ) ) {
				if ( ! array_key_exists( 'wrapper', $field ) ) {
					$field['wrapper'] = [];
				}

				$field['wrapper']['width'] = $wrapper_width;
			}
		}

		// ? Hidden label.
		if ( array_key_exists( 'no_label', $field ) && $field['no_label'] ) {
			$field['wrapper'] = core_default( 'wrapper', $field, [] );
			$field['wrapper']['class'] = core_default( 'class', $field['wrapper'], '' );
			$field['wrapper']['class'] = trim( "{$field['wrapper']['class']} core-acf-no-label" );
		}

		// ? Conditional logic.
		if ( array_key_exists( 'show_if', $field ) ) {
			$show_if = $field['show_if'];
			unset( $field['show_if'] );

			/**
			 * The list of conditions sent to ACF.
			 *
			 * - First level: OR
			 * - Second level: AND
			 *
			 * @var array[]
			 */
			$conditions = [];

			/**
			 * ? The value is one single condition.
			 * Expected match result should only be true (1) or false (0).
			 */
			if ( is_string( $show_if ) ) {
				$value = strpos( $show_if, '!' ) === 0 ? 0 : 1;
				$conditions = [
					[
						'field' => core_acf_find_field_key( str_replace( '!', '', $show_if ), $fields ),
						'operator' => '==',
						'value' => $value
					]
				];
			}

			/**
			 * ? The value is list of multiple conditions.
			 * Expected match result can be based on an OR/AND relation + special conditions.
			 */
			elseif ( is_array( $show_if ) ) {

				/**
				 * ? The list of conditions is only 1 level deep.
				 * Relation: AND
				 */
				if ( core_is_assoc( $show_if ) ) {

					// Add one `OR` level, which is the only one.
					$conditions[] = [];

					// Add each condition.
					foreach ( $show_if as $field_name => $condition ) {
						if ( ! is_string( $field_name ) ) continue;
						$conditions[0][] = core_acf_build_show_if_condition( $field_name, $condition, $fields );
					}
				}

				/**
				 * ? The list of conditions is 2 levels deep.
				 * Relation: OR/AND
				 */
				else {

					// Loop through each `OR` level.
					foreach ( $show_if as $level ) {
						$conditions[] = [];
						$condition_index = count( $conditions ) - 1;

						// Add each condition.
						foreach ( $level as $field_name => $condition ) {
							if ( ! is_string( $field_name ) ) continue;
							$conditions[ $condition_index ][] = core_acf_build_show_if_condition( $field_name, $condition, $fields );
						}
					}
				}
			}

			// Save the field conditional logic.
			if ( ! empty( $conditions ) ) {
				$field['conditional_logic'] = $conditions;
			}
		}

		// ? Collapsed (repeater fields).
		if (
			array_key_exists( 'collapsed', $field ) &&
			array_key_exists( 'sub_fields', $field )
		) {
			$field['collapsed'] = core_acf_find_field_key( $field['collapsed'], $field['sub_fields'] );
		}

		// Also apply to sub fields and layouts.
		if ( array_key_exists( 'sub_fields', $field ) ) {
			$field['sub_fields'] = core_apply_custom_field_options( $field['sub_fields'] );
		}

		if ( array_key_exists( 'layouts', $field ) ) {
			$field['layouts'] = core_apply_custom_field_options( $field['layouts'] );
		}

		// Return.
		return $field;
	}, $fields );
}

/**
 * Builds a custom `show_if` condition.
 *
 * @since 1.1.8
 * @internal
 *
 * @param string $field_name
 * @param mixed $condition
 * @param mixed[] $fields The list of all sibling fields.
 * @return array The formatted condition
 */
function core_acf_build_show_if_condition( $field_name, $condition, $fields ) {

	/**
	 * The conditional operator.
	 *
	 * - If it's a string, check for `!` signs. Determines a false match.
	 * - If it's not a string, the operator should always be '=='.
	 */
	$operator = ! is_string( $condition ) || strpos( $condition, '!' ) === false ? '==' : '!=';

	/**
	 * The value to match against.
	 *
	 * - If it's a string, remove any possible `!` instances.
	 * - If it's a boolean, replace the condition with the int value.
	 * - If it's nor a string or a boolean, the condition itself is the value.
	 */
	$value = is_string( $condition ) ?
		str_replace( '!', '', $condition ) : (
			is_bool( $condition ) ? ( int ) $condition : $condition
		);

	// Build the condition.
	$condition = [
		'field' => core_acf_find_field_key( $field_name, $fields ),
		'operator' => $operator,
		'value' => $value
	];

	return $condition;
}

/**
 * Finds a field key from its name.
 *
 * @since 1.0.0
 * @since 1.1.8 Changed function name.
 * @internal
 *
 * @param string $field_name
 * @return array|null
 */
function core_acf_find_field_key( $field_name, $fields ) {
	$result = array_values(
		array_filter( $fields, function( $field ) use( $field_name ) {
			return $field['name'] === $field_name;
		})
	);

	return ! empty( $result ) ? $result[0]['key'] : null;
}

/**
 * Formats the arguments for a new Custom Field.
 *
 * @since 1.0.0
 * @internal
 *
 * @param string $type
 * @param string $label
 * @param array [$args=[]]
 * @param string [$key_prefix=""]
 * @return array
 */
function core_format_field( $type, $label, $args=[], $key_prefix="" ) {
	$args['type'] = $type;
	$args['label'] = $label;

	// Pre-format as custom field types.
	$args = core_build_custom_field_type( $args );
	$type = $args['type'];

	// Apply default field options.
	$args = core_apply_default_field_options( $args );

	// Set the field name, if none is specified.
	if ( ! array_key_exists( 'name', $args ) ) {

		/**
		 * Set name prefix for Tab and Accordion fields.
		 * This is useful to avoid conflicts.
		 */
		$prefix = '';

		if ( in_array( $type, [ 'tab', 'accordion', 'message' ] ) ) {
			$prefix = "cf-{$type}-";
		}

		$simplified_label = trim( str_replace( '(Optional)', '', $label ) );
		$args['name'] = $prefix . core_sanitize_title_underscore( $simplified_label );
	}

	$args['name'] = core_sanitize_title_underscore( $args['name'] );

	// Set the field key.
	$field_key = join( '-', [ $key_prefix, $args['name'] ]);

	$args['key'] = $field_key;

	// ? Field Type: Flexible Content
	if ( $type === 'flexible_content' && array_key_exists( 'layouts', $args ) ) {
		$layouts = [];

		foreach ( $args['layouts'] as $layout ) {
			$layout_label = $layout[0];
			$layout_args = core_default( 1, $layout, [] );
			$layout_name = sanitize_title( core_default( 'name', $layout_args, $layout_label ) );

			/**
			 * The layout key.
			 *
			 * @var string
			 */
			$layout_key = core_sanitize_title_underscore( "{$field_key}_layout_{$layout_name}" );

			// Build the layout.
			$layout = [
				'key' => $layout_key,
				'label' => $layout_label,
				'name' => $layout_name,
				'min' => core_default( 'min', $layout_args, '' ),
				'max' => core_default( 'max', $layout_args, '' )
			];

			// Add the sub fields.
			if ( array_key_exists( 'sub_fields', $layout_args ) ) {
				$layout_fields = [];

				foreach ( $layout_args['sub_fields'] as $layout_field ) {
					if ( count( $layout_field ) < 2 ) continue;

					$layout_fields[] = core_format_field(
						$layout_field[0],
						$layout_field[1],
						core_default( 2, $layout_field, [] ),
						$layout_key
					);
				}

				$layout['sub_fields'] = $layout_fields;
			}

			// Save the layout.
			$layouts[] = $layout;
		}

		$args['layouts'] = $layouts;
	}

	// Format sub fields.
	if ( array_key_exists( 'sub_fields', $args ) ) {
		$sub_fields = [];

		foreach ( $args['sub_fields'] as $sub_field ) {
			if ( count( $sub_field ) < 2 ) continue;

			$sub_fields[] = core_format_field(
				$sub_field[0],
				$sub_field[1],
				core_default( 2, $sub_field, [] ),
				$field_key
			);
		}

		$args['sub_fields'] = $sub_fields;
	}

	return $args;
}

/**
 * Prepares the specified Field Group data for registration.
 *
 * @since 1.0.0
 * @internal
 *
 * @param array $data
 * @return array
 */
function core_prepare_field_group( $data ) {
	$data['fields'] = core_default( 'fields', $data, [] );

	// Run integrity checks.
	$integrity_check = core_check_field_group_integrity( $data );
	if ( $integrity_check === false ) return;

	// Run a generic field integrity check.
	$fields_integrity_check = core_check_fields_integrity( $data['fields'] );

	/**
	 * The unique key.
	 *
	 * @var string
	 */
	$unique_key = md5( $data['slug'] );

	$field_group_data = [
		'title' => $data['title'],
		'slug' => $data['slug'],
		'key' => 'core_field_group_'.$unique_key,
		'hide_on_screen' => core_default( 'hide_on_screen', $data, [ 'the_content' ] ),
		'location' => [],
		'menu_order' => core_default( 'menu_order', $data, 0 ),
		'position' => core_default( 'position', $data, 'normal' ),
		'fields' => []
	];

	// Add the locations.
	foreach ( $data['location'] as $param => $value ) {
		if ( $param === 'post_type' && $value === 'all' ) {
			$value = core_get_post_types( false, true );
		}

		$value = is_array( $value ) ? $value : [ $value ];

		foreach ( $value as $location ) {
			$field_group_data['location'][] = [
				[
					'param' => $param,
					'operator' => '===',
					'value' => $location
				]
			];
		}
	}

	// Format fields.
	if ( array_key_exists( 'fields', $data ) ) {
		$fields = [];

		foreach ( $data['fields'] as $field ) {
			if ( count( $field ) < 2 ) continue;

			$fields[] = core_format_field(
				$field[0],
				$field[1],
				core_default( 2, $field, [] ),
				$unique_key
			);
		}

		$field_group_data['fields'] = $fields;
	}

	/**
	 * Apply custom field options.
	 *
	 * This has to be done after the fields have been formatted because
	 * certain options depend on other fields in the same Field Group.
	 */
	$field_group_data['fields'] = core_apply_custom_field_options( $field_group_data['fields'] );

	return $field_group_data;
}

/**
 * Registers a new Field Group.
 *
 * @since 1.0.0
 * @internal
 *
 * @param array $data
 * @return null
 */
function core_register_field_group( $data ) {
	$field_group_data = core_prepare_field_group( $data );
	acf_add_local_field_group( $field_group_data );
}

/**
 * Checks if the ACF Pro license was added to the configuration.
 *
 * @since 1.0.0
 * @internal
 */
function core_check_acf_pro_activation() {
	$acf_pro_license = get_option( 'acf_pro_license' );

	if ( ! $acf_pro_license ) {
		core_add_notice(
			'warning',
			'ACF Pro is not activated.',
			[
				'You need to activate ACF Pro to use all of its features. ' . core_admin( 'edit.php?post_type=acf-field-group&page=acf-settings-updates&core-notices=0', 'Activate it here.' ),
				core_docs( 'environment-variables' )
			]
		);
	}
}

add_action( 'core_after_setup', 'core_check_acf_pro_activation' );

/**
 * Checks if the specified field is a Core ACF field.
 *
 * @since 1.1.8
 * @internal
 *
 * @param mixed[] $field
 * @param string $field_type
 * @return boolean
 */
function core_acf_field_is( $field, $field_type ) {
	return strpos( $field['wrapper']['class'], "core-acf-{$field_type}") !== false;
}

/**
 * Updates the ACF configuration to include the user-specified
 * Google Maps API key.
 *
 * @since 1.1.8
 */
function core_acf_set_gmaps_key () {
	$integrations = get_field( 'integrations', 'option' );
	if ( ! $integrations ) return;

	$gmaps_key = core_default( 'gmaps_key', $integrations, null );
	if ( $gmaps_key ) acf_update_setting( 'google_api_key', $gmaps_key );
}

add_action( 'acf/init', 'core_acf_set_gmaps_key' );

/**
 * Registers a custom field group for authors.
 *
 * @since 2.3.0
 */
function core_acf_register_author_field_group() {
	$author_field_group = [
		'title' => 'Generic Information',
		'slug' => 'core-author-fields',
		'location' => [ 'user_role' => 'all' ],
		'fields' => core_get_option( 'author-fields' )
	];

	core_register_field_group( $author_field_group );
}

add_action( 'acf/init', 'core_acf_register_author_field_group' );

/**
 * Registers a custom field group that shows up for all post types.
 *
 * @since 2.1.2
 */
function core_acf_register_generic_field_group() {
	$generic_field_group = [
		'title' => 'Generic',
		'slug' => 'core-generic-fields',
		'position' => 'side',
		'location' => [ 'post_type' => [] ],
		'fields' => [
			[ 'image', 'Thumbnail' ],
			[ 'textarea', 'Excerpt' ]
		]
	];

	// Add extra fields.
	$extra_generic_fields = core_get_option( 'post-generic-fields' );

	if ( $extra_generic_fields && ! empty( $extra_generic_fields ) ) {
		$generic_field_group['fields'] = array_merge(
			$generic_field_group['fields'],
			$extra_generic_fields
		);
	}

	// Add locations.
	$post_types = array_filter( core_get_post_types(), function( $post_type ) {
		if ( array_key_exists( 'remove_support', $post_type ) ) {
			return ! in_array( 'generic-fields', $post_type['remove_support'] );
		}

		return true;
	});

	if ( empty( $post_types ) ) return;

	foreach ( array_column( $post_types, 'slug' ) as $post_type ) {
		$generic_field_group['location']['post_type'][] = $post_type;
	}

	core_register_field_group( $generic_field_group );
}

add_action( 'acf/init', 'core_acf_register_generic_field_group' );

// * FIELD FORMATTING

// Load the formatting methods for all custom fields.
require_once 'custom-fields-format.php';

/**
 * Applies custom formatting to custom field types.
 *
 * @since 2.7.0
 * @internal
 *
 * @param mixed $value
 * @param int $post_id
 * @param array $field
 * @return mixed The formatted value.
 */
function core_acf_format_custom_field( $value, $post_id, $field ) {
	if ( ! isset( $field['core_field'] ) ) return $value;

	return apply_filters_ref_array(
		"core_acf_format_custom_field/field={$field['core_field']}",
		[ $value, $field, $post_id ]
	);
}

add_filter( 'acf/format_value', 'core_acf_format_custom_field', 11, 3 );

/**
 * Formats the post object field to contain all the info about the post.
 *
 * @since 1.1.5
 * @internal
 *
 * @param int|WP_Post $post
 * @return array
 */
function core_acf_format_post_object_field( $value, $post_id, $field ) {
	if (
		$field['return_format'] === 'id' ||
		! ( $value instanceof WP_Post )
	) return $value;

	$include_fields = core_should_include_post_fields();

	return core_format_post_object( $value->ID, $include_fields );
}

add_filter( 'acf/format_value/type=post_object', 'core_acf_format_post_object_field', 11, 3 );

/**
 * Formats the relationship field to contain all the info about posts.
 *
 * @since 1.0.0
 * @internal
 *
 * @param array $value
 * @return array
 */
function core_acf_format_relationship_field( $value ) {
	if ( ! $value ) return $value;

	$include_fields = core_should_include_post_fields();

	return array_map( function( $post ) use( $include_fields ) {
		if ( ! is_numeric( $post ) ) return $post;
		return core_format_post_object( $post, $include_fields );
	}, $value );
}

add_filter( 'acf/format_value/type=relationship', 'core_acf_format_relationship_field', 11, 1 );

/**
 * Formats the value of repeater fields when there is only 1 sub field.
 *
 * The result should be a simple array with only the added values.
 *
 * @since 2.0.6
 * @internal
 *
 * @param array $value
 * @param int $_post_id
 * @param array $field
 * @return array
 */
function core_acf_format_repeater_field( $value, $_post_id, $field ) {
	if ( empty( $value ) ) return $value;

	$sub_fields = core_default( 'sub_fields', $field, [] );

	if ( count( $sub_fields ) === 1 ) {
		return array_map( function( $item ) {
			return $item[ array_keys( $item )[0] ];
		}, $value );
	}

	return $value;
}

add_filter( 'acf/format_value/type=repeater', 'core_acf_format_repeater_field', 11, 3 );

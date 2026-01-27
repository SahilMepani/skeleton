<?php
/**
 * Register ACF Blocks
 *
 * @package Skeleton
 * @subpackage ACF
 */

/**
 * Add custom blocks
 * ?string[]
 */
$block_types = array(
	'Visual Editor',
	'Search Result',
	'Flexible Editor',
	'Spacer',
	'Two Columns',
	'Not Found 404',
	'Hero Slider',
	'Faqs',
	'Logo Slider',
	'Test',
);

/**
 * Blocks that require JavaScript files.
 */
$blocks_with_js = array(
	'Hero Slider',
	'Faqs',
	'Logo Slider',
);

/**
 * Define allowed post types per block.
 */
$block_post_type_map = array(
	'Visual Editor' => array( 'page' ),
	// All post types will be used for blocks not listed here.
);

// Hash the current block types array.
$blocks_current_hash = md5( wp_json_encode( $block_types ) );

// Get the stored hash.
$blocks_stored_hash = get_option( 'acf_block_types_hash' );

/**
 * Load ACF blocks from JSON files.
 */
function skel_load_acf_json_blocks() {
	global $block_post_type_map;

	$paths    = skel_get_acf_block_paths();
	$json_dir = $paths['json'];

	if ( ! is_dir( $json_dir ) ) {
		return;
	}

	$files = glob( $json_dir . '*.json' );

	if ( empty( $files ) ) {
		return;
	}

	foreach ( $files as $file ) {
		$json_content = file_get_contents( $file );
		$block_data   = json_decode( $json_content, true );

		if ( ! $block_data || ! isset( $block_data['title'] ) ) {
			continue;
		}

		// Check if block is active.
		if ( isset( $block_data['active'] ) && false === $block_data['active'] ) {
			continue;
		}

		$slug = basename( $file, '.json' );

		// 1. Register Block.
		// Define default block arguments.
		$default_block_args = array(
			'description'     => '',
			'render_template' => 'acf-blocks/' . $slug . '.php',
			'category'        => 'uncategorized',
			'icon'            => 'layout',
			'mode'            => 'edit',
			'supports'        => array(
				'align'           => false,
				'customClassName' => false,
				'mode'            => false,
			),
			'example'         => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'preview_image' => get_template_directory_uri() . '/acf-blocks/preview/' . $slug . '.png',
					),
				),
			),
		);

		// Merge settings from JSON over defaults.
		$block_settings = $block_data['settings'] ?? array();
		$args           = wp_parse_args( $block_settings, $default_block_args );

		// Enforce required args.
		$args['name']  = $slug;
		$args['title'] = $block_data['title'];

		// Check for post type restrictions.
		if ( isset( $block_post_type_map[ $block_data['title'] ] ) ) {
			$args['post_types'] = $block_post_type_map[ $block_data['title'] ];
		}

		if ( function_exists( 'acf_register_block_type' ) ) {
			acf_register_block_type( $args );
		}

		// 2. Register Field Group.
		if ( ! empty( $block_data['fields'] ) && function_exists( 'acf_add_local_field_group' ) ) {
			// Define default field group arguments.
			$default_field_group = array(
				'menu_order'            => 0,
				'position'              => 'normal',
				'style'                 => 'default',
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen'        => '',
				'active'                => true,
				'description'           => '',
			);

			// Merge JSON data over defaults.
			// Note: $block_data contains 'fields', 'title', etc.
			// We filter out keys that shouldn't be in the field group args if necessary,
			// but wp_parse_args handles the defaults nicely.
			$field_group = wp_parse_args( $block_data, $default_field_group );

			// Inject default settings fields if not present.
			$default_fields = skel_get_block_default_settings_tab_fields();
			$slug_snake     = str_replace( '-', '_', $slug );

			// Replace placeholders in default fields.
			$default_fields_json = wp_json_encode( $default_fields );
			$default_fields_json = str_replace( '{{slug_snake}}', $slug_snake, $default_fields_json );
			$default_fields      = json_decode( $default_fields_json, true );

			// Get existing keys to avoid overwriting.
			$existing_keys = array();
			if ( ! empty( $field_group['fields'] ) ) {
				foreach ( $field_group['fields'] as $field ) {
					if ( isset( $field['key'] ) ) {
						$existing_keys[] = $field['key'];
					}
				}
			} else {
				$field_group['fields'] = array();
			}

			// Append default fields if they don't exist.
			foreach ( $default_fields as $default_field ) {
				if ( ! in_array( $default_field['key'], $existing_keys, true ) ) {
					$field_group['fields'][] = $default_field;
				}
			}

			// Enforce critical keys.
			$field_group['key']      = 'group_' . str_replace( '-', '_', $slug );
			$field_group['location'] = array(
				array(
					array(
						'param'    => 'block',
						'operator' => '==',
						'value'    => 'acf/' . $slug,
					),
				),
			);

			// Remove 'settings' key as it's for block reg, not field group.
			unset( $field_group['settings'] );

			acf_add_local_field_group( $field_group );
		}
	}
}
add_action( 'acf/init', 'skel_load_acf_json_blocks' );

if ( $blocks_current_hash !== $blocks_stored_hash ) {
	// Update the stored hash with the current hash.
	update_option( 'acf_block_types_hash', $blocks_current_hash );

	// Call the helper function with the block types array.
	if ( 'local' === wp_get_environment_type() ) {
		skel_create_acf_block_files( $block_types, $blocks_with_js );
		skel_delete_unwanted_acf_block_files( $block_types );
	}
}

/**
 * Get default fields for ACF blocks.
 *
 * @return array Default fields.
 */
function skel_get_block_default_settings_tab_fields() {
	return array(
		array(
			'key'   => 'field_{{slug_snake}}_settings_tab',
			'label' => 'Settings',
			'type'  => 'tab',
		),
		array(
			'key'           => 'field_{{slug_snake}}_display',
			'label'         => 'Show on Page',
			'name'          => 'display',
			'type'          => 'button_group',
			'choices'       => array(
				'on'  => 'Yes',
				'off' => 'No',
			),
			'default_value' => 'on',
		),
		array(
			'key'        => 'field_{{slug_snake}}_spacing',
			'label'      => 'Spacing',
			'type'       => 'group',
			'layout'     => 'block',
			'sub_fields' => array(
				array(
					'key'        => 'field_{{slug_snake}}_spacing_top_group',
					'label'      => 'Top',
					'name'       => 'top',
					'type'       => 'group',
					'layout'     => 'table',
					'sub_fields' => array(
						array(
							'key'           => 'field_{{slug_snake}}_spacing_top',
							'label'         => 'Spacing Top',
							'name'          => 'spacing_top',
							'type'          => 'button_group',
							'choices'       => array(
								'none'    => 'None',
								'small'   => 'Small',
								'medium'  => 'Medium',
								'large'   => 'Large',
								'x-large' => 'X-Large',
								'custom'  => 'Custom',
							),
							'default_value' => 'medium',
						),
						array(
							'key'               => 'field_{{slug_snake}}_custom_value_top',
							'label'             => 'Custom Value',
							'name'              => 'custom_value_top',
							'type'              => 'range',
							'min'               => 0,
							'max'               => 200,
							'step'              => 1,
							'append'            => 'px',
							'conditional_logic' => array(
								array(
									array(
										'field'    => 'field_{{slug_snake}}_spacing_top',
										'operator' => '==',
										'value'    => 'custom',
									),
								),
							),
						),
					),
				),
				array(
					'key'        => 'field_{{slug_snake}}_spacing_bottom_group',
					'label'      => 'Bottom',
					'name'       => 'bottom',
					'type'       => 'group',
					'layout'     => 'table',
					'sub_fields' => array(
						array(
							'key'           => 'field_{{slug_snake}}_spacing_bottom',
							'label'         => 'Spacing Bottom',
							'name'          => 'spacing_bottom',
							'type'          => 'button_group',
							'choices'       => array(
								'none'    => 'None',
								'small'   => 'Small',
								'medium'  => 'Medium',
								'large'   => 'Large',
								'x-large' => 'X-Large',
								'custom'  => 'Custom',
							),
							'default_value' => 'medium',
						),
						array(
							'key'               => 'field_{{slug_snake}}_custom_value_bottom',
							'label'             => 'Custom Value',
							'name'              => 'custom_value_bottom',
							'type'              => 'range',
							'min'               => 0,
							'max'               => 200,
							'step'              => 1,
							'append'            => 'px',
							'conditional_logic' => array(
								array(
									array(
										'field'    => 'field_{{slug_snake}}_spacing_bottom',
										'operator' => '==',
										'value'    => 'custom',
									),
								),
							),
						),
					),
				),
			),
		),
		array(
			'key'          => 'field_{{slug_snake}}_custom_css',
			'label'        => 'Custom CSS',
			'name'         => 'custom_css',
			'type'         => 'text',
			'instructions' => 'If unsure, do not edit.',
			'wrapper'      => array(
				'width' => '33',
			),
		),
		array(
			'key'          => 'field_{{slug_snake}}_custom_classes',
			'label'        => 'Custom Class(es)',
			'name'         => 'custom_classes',
			'type'         => 'text',
			'instructions' => 'If unsure, do not edit.',
			'wrapper'      => array(
				'width' => '33',
			),
		),
		array(
			'key'          => 'field_{{slug_snake}}_unique_id',
			'label'        => 'Unique ID',
			'name'         => 'unique_id',
			'type'         => 'text',
			'instructions' => 'only small case word allowed',
			'wrapper'      => array(
				'width' => '33',
			),
		),
	);
}

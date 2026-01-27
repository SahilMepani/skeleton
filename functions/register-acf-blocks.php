<?php
/**
 * Register ACF Blocks
 *
 * @package Skeleton
 * @subpackage ACF
 */

// Load configuration.
require_once get_template_directory() . '/functions/config/acf-blocks.php';

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

		$slug = basename( $file, '.json' );
		skel_register_single_block( $block_data, $slug, $block_post_type_map );
	}
}
add_action( 'acf/init', 'skel_load_acf_json_blocks' );

/**
 * Register a single ACF block and its fields.
 *
 * @param array  $block_data The block data from JSON.
 * @param string $slug       The block slug.
 * @param array  $post_type_map Map of blocks to post types.
 */
function skel_register_single_block( $block_data, $slug, $post_type_map ) {
	// Check if block is active.
	if ( isset( $block_data['active'] ) && false === $block_data['active'] ) {
		return;
	}

	// 1. Register Block.
	$default_block_args = array(
		'description'     => '',
		'render_template' => 'acf/blocks/' . $slug . '.php',
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
					'preview_image' => get_template_directory_uri() . '/acf/blocks/preview/' . $slug . '.png',
				),
			),
		),
	);

	$block_settings = $block_data['settings'] ?? array();
	$args           = wp_parse_args( $block_settings, $default_block_args );

	$args['name']  = $slug;
	$args['title'] = $block_data['title'];

	if ( isset( $post_type_map[ $block_data['title'] ] ) ) {
		$args['post_types'] = $post_type_map[ $block_data['title'] ];
	}

	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( $args );
	}

	// 2. Register Field Group.
	if ( function_exists( 'acf_add_local_field_group' ) ) {
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

		$field_group = wp_parse_args( $block_data, $default_field_group );

		// Inject default settings fields.
		$slug_snake     = str_replace( '-', '_', $slug );
		$default_fields = skel_get_block_default_settings_tab_fields( $slug_snake );

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

		foreach ( $default_fields as $default_field ) {
			if ( ! in_array( $default_field['key'], $existing_keys, true ) ) {
				$field_group['fields'][] = $default_field;
			}
		}

		// Ensure all fields have keys.
		$field_group_key = 'group_' . $slug_snake;
		skel_ensure_field_keys( $field_group['fields'], $field_group_key );

		$field_group['key']      = $field_group_key;
		$field_group['location'] = array(
			array(
				array(
					'param'    => 'block',
					'operator' => '==',
					'value'    => 'acf/' . $slug,
				),
			),
		);

		unset( $field_group['settings'] );

		acf_add_local_field_group( $field_group );
	}
}

/**
 * Recursively ensure all fields have a key.
 *
 * @param array  $fields The fields array.
 * @param string $prefix The prefix for generating keys.
 */
function skel_ensure_field_keys( &$fields, $prefix ) {
	foreach ( $fields as &$field ) {
		// If key is missing, generate one.
		if ( empty( $field['key'] ) ) {
			$suffix       = $field['name'] ?? uniqid();
			$field['key'] = $prefix . '_' . $suffix;
		}

		// Recurse for sub_fields (Group, Repeater).
		if ( ! empty( $field['sub_fields'] ) ) {
			skel_ensure_field_keys( $field['sub_fields'], $field['key'] );
		}

		// Recurse for layouts (Flexible Content).
		if ( ! empty( $field['layouts'] ) ) {
			foreach ( $field['layouts'] as &$layout ) {
				if ( empty( $layout['key'] ) ) {
					$layout['key'] = $field['key'] . '_' . $layout['name'];
				}
				if ( ! empty( $layout['sub_fields'] ) ) {
					skel_ensure_field_keys( $layout['sub_fields'], $layout['key'] );
				}
			}
		}
	}
}

if ( $blocks_current_hash !== $blocks_stored_hash ) {
	update_option( 'acf_block_types_hash', $blocks_current_hash );

	if ( 'local' === wp_get_environment_type() ) {
		skel_create_acf_block_files( $block_types, $blocks_with_js );
		skel_delete_unwanted_acf_block_files( $block_types );
	}
}

/**
 * Get default fields for ACF blocks.
 *
 * @param string $slug_snake The block slug in snake_case.
 * @return array Default fields.
 */
function skel_get_block_default_settings_tab_fields( $slug_snake ) {
	return array(
		array(
			'key'   => 'field_' . $slug_snake . '_settings_tab',
			'label' => 'Settings',
			'type'  => 'tab',
		),
		array(
			'key'           => 'field_' . $slug_snake . '_display',
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
			'key'        => 'field_' . $slug_snake . '_spacing',
			'label'      => 'Spacing',
			'type'       => 'group',
			'layout'     => 'block',
			'sub_fields' => array(
				array(
					'key'        => 'field_' . $slug_snake . '_spacing_top_group',
					'label'      => 'Top',
					'name'       => 'top',
					'type'       => 'group',
					'layout'     => 'table',
					'sub_fields' => array(
						array(
							'key'           => 'field_' . $slug_snake . '_spacing_top',
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
							'key'               => 'field_' . $slug_snake . '_custom_value_top',
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
										'field'    => 'field_' . $slug_snake . '_spacing_top',
										'operator' => '==',
										'value'    => 'custom',
									),
								),
							),
						),
					),
				),
				array(
					'key'        => 'field_' . $slug_snake . '_spacing_bottom_group',
					'label'      => 'Bottom',
					'name'       => 'bottom',
					'type'       => 'group',
					'layout'     => 'table',
					'sub_fields' => array(
						array(
							'key'           => 'field_' . $slug_snake . '_spacing_bottom',
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
							'key'               => 'field_' . $slug_snake . '_custom_value_bottom',
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
										'field'    => 'field_' . $slug_snake . '_spacing_bottom',
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
			'key'          => 'field_' . $slug_snake . '_custom_css',
			'label'        => 'Custom CSS',
			'name'         => 'custom_css',
			'type'         => 'text',
			'instructions' => 'If unsure, do not edit.',
			'wrapper'      => array(
				'width' => '33',
			),
		),
		array(
			'key'          => 'field_' . $slug_snake . '_custom_classes',
			'label'        => 'Custom Class(es)',
			'name'         => 'custom_classes',
			'type'         => 'text',
			'instructions' => 'If unsure, do not edit.',
			'wrapper'      => array(
				'width' => '33',
			),
		),
		array(
			'key'          => 'field_' . $slug_snake . '_unique_id',
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

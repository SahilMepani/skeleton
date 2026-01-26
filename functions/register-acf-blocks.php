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
	'Search Result' => array( 'page' ),
	// Default post types will be used for blocks not listed here.
);

// Hash the current block types array.
$blocks_current_hash = md5( wp_json_encode( $block_types ) );


// Get the stored hash.
$blocks_stored_hash = get_option( 'acf_block_types_hash' );

/**
 * Load ACF blocks from JSON files.
 */
function skel_load_acf_json_blocks() {
	$json_dir = get_template_directory() . '/functions/acf-json/';

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

		// Define arguments for block registration.
		$args = array(
			'name'            => $slug,
			'title'           => $block_data['title'],
			'description'     => $block_data['settings']['description'] ?? '',
			'render_template' => 'acf-blocks/' . $slug . '.php',
			'category'        => $block_data['settings']['category'] ?? 'uncategorized',
			'icon'            => $block_data['settings']['icon'] ?? 'layout',
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

		// Register the block.
		if ( function_exists( 'acf_register_block_type' ) ) {
			acf_register_block_type( $args );
		}

		// Register fields if they exist.
		if ( ! empty( $block_data['fields'] ) && function_exists( 'acf_add_local_field_group' ) ) {
			$field_group = array(
				'key'      => 'group_' . str_replace( '-', '_', $slug ),
				'title'    => $block_data['title'],
				'fields'   => $block_data['fields'],
				'location' => array(
					array(
						array(
							'param'    => 'block',
							'operator' => '==',
							'value'    => 'acf/' . $slug,
						),
					),
				),
			);
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

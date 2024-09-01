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
);

// Hash the current block types array.
$blocks_current_hash = md5( wp_json_encode( $block_types ) );

// Get the stored hash.
$blocks_stored_hash = get_option( 'acf_block_types_hash' );

/**
 * Create block options.
 *
 * Generates an array of options for a custom block based on the provided block name.
 *
 * @param string $block The name of the block.
 * @return array An array of options for the custom block.
 */
function skel_create_block_options( string $block ): array {
	// Sanitize the block name.
	$sanitize_block = sanitize_title( $block );

	// Define the options for the custom block.
	$options = array(
		'name'            => $sanitize_block,
		'title'           => $block,
		'icon'            => array(
			'background' => '#fbf3db',
			'foreground' => '#333',
			'src'        => 'layout',
		),
		'post_types'      => array( 'page' ),
		'category'        => 'uncategorized',
		'mode'            => 'edit',
		'render_template' => 'acf-blocks/' . $sanitize_block . '.php',
		'example'         => array(
			'attributes' => array(
				'mode' => 'preview',
				'data' => array(
					'preview_image' => get_template_directory_uri() . '/acf-blocks/preview/' . $sanitize_block . '.png',
				),
			),
		),
		'supports'        => array(
			'align'           => false,
			'customClassName' => false,
			'mode'            => false, // Disable toggle preview and edit.
		),
	);

	return $options;
}


/**
 * Register ACF blocks.
 *
 * Registers custom ACF blocks using the ACF plugin's `acf_register_block_type()` function.
 * The block options are generated using the `skel_create_block_options()` function.
 * This function is hooked into the 'acf/init' action.
 *
 * @return void
 */
function skel_register_acf_blocks(): void {
	global $block_types;

	// Create block options for each block type.
	$blocks = array_map( 'skel_create_block_options', $block_types );

	// Sort blocks in ascending order.
	sort( $blocks );

	// Register each block.
	foreach ( $blocks as $block ) {
		acf_register_block_type( $block );
	}
}

if ( has_action( 'acf/init' ) ) {
	add_action( 'acf/init', 'skel_register_acf_blocks' );
}

if ( $blocks_current_hash !== $blocks_stored_hash ) {

	// Update the stored hash with the current hash.
	update_option( 'acf_block_types_hash', $blocks_current_hash );

	// Call the helper function with the block types array.
	if ( 'local' === wp_get_environment_type() ) {
		skel_create_acf_block_files( $block_types );
		skel_delete_unwanted_acf_block_files( $block_types );
	}
}

<?php

/**
 * Prepare blocks
 * @param string $dir_name
 * @return array
 */
function skel_prepare_block( $dir_name ) {

	// get the config from the block
	$data = include BLOCKS_DIR . $dir_name . '/config.php';

	if ( ! $data ) return;

	// block options
	return [
		'name'            => $dir_name,
		'title'           => $data['title'],
		'icon'            => [
			'background' => '#2271b1',
			'foreground' => '#fff',
			'src'        => $data['icon'] ?? 'layout'
		],
		'mode'            => 'edit',
		'render_template' => 'acf-blocks/' . $dir_name . '/layout.php',
		'example'         => [
			'attributes' => [
				'mode' => 'preview',
				'data' => [
					'preview_image' => get_template_directory_uri() . '/acf-blocks/' . $dir_name . '/preview.jpg'
				]
			]
		],
		'supports' => [
			'align'           => false,
			'customClassName' => false,
			'mode'            => false // disable toggle preview and edit
		]
	];

}

/**
 * Prepare block fields
 * @param string $dir_name
 * @return array
 */
function skel_prepare_block_field_group( $dir_name ) {

	// get the config from the block
	$data = include BLOCKS_DIR . $dir_name . '/config.php';

	if ( ! $data ) return;

	return [
		'title'          => $data['title'],
		'key'            => 'field_group_' . md5( $dir_name ),
		'fields'         => [],
		'hide_on_screen' => $data['hide_on_screen'] ?? ['the_content'],
		'active'         => $data['active'] ?? true,
		'description'    => $data['description'] ?? '',
		'show_in_rest'   => $data['show_in_rest'] ?? 0,
		'location' => [
			[
				[
					'param'    => 'block',
					'operator' => '==',
					'value'    => 'acf/' . $dir_name,
				],
			],
		]
	];

}

/**
 * Register block type
 * @uses acf_register_block_type()
 */
function skel_register_block() {

	// prepare block options
	$blocks_type_options = array_map( 'skel_prepare_block', BLOCK_DIR_NAMES );

	// arrange the blocks in ascending order
	sort( $blocks_type_options );

	// register blocks
	foreach( $blocks_type_options as $block ) {
		acf_register_block_type( $block );
	}

}

/**
 * Register block field group
 * @uses acf_add_local_field_group()
 */
function skel_register_block_field_group() {

	// prepare block options
	$blocks_type_options = array_map( 'skel_prepare_block', BLOCK_DIR_NAMES );

	// arrange the blocks in ascending order
	sort( $blocks_type_options );

	// register blocks
	foreach( $blocks_type_options as $block ) {
		acf_add_local_field_group( $block );
	}

}

// run if acf is activated
add_action( 'acf/init', 'skel_register_block' );
add_action( 'acf/init', 'skel_register_block_field_group' );

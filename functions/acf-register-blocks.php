<?php

/**
 * Prepare block
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
		'title'           => $data['title'] ?? $dir_name,
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
					'preview_image' => BLOCKS_DIR . $dir_name . '/preview.jpg'
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
 * Register block type
 * @uses skel_prepare_block
 * @uses acf_register_block_type()
 */
function skel_register_block() {

	// prepare block settings
	$blocks_settings = array_map( 'skel_prepare_block', BLOCK_DIR_NAMES );

	// var_dump($blocks_settings);

	// register blocks
	foreach( $blocks_settings as $block ) {
		acf_register_block_type( $block );
	}

}

/**
 * Prepare fields
 * @uses skel_refactor_fields
 * @param array $fields
 * @param string $dir_name
 * @return array
 */
function skel_prepare_fields( $fields, $dir_name ) {
	$refactor_fields = array_map( 'refactor_fields', $fields );
}

/**
 * Prepare block field group
 * @uses skel_prepare_fields
 * @param string $dir_name
 * @return array
 */
function skel_prepare_block_field_group( $dir_name ) {

	// get the config from the block
	$data = include BLOCKS_DIR . $dir_name . '/config.php';

	if ( ! $data ) return;

	return [
		'title'          => $data['title'] ?? $dir_name,
		'key'            => 'group_' . substr(md5( $dir_name ), 0, 13),
		'fields'         => $data['fields'],
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
 * Register block field group
 * @uses skel_prepare_block_field_group()
 * @uses acf_add_local_field_group()
 */
function skel_register_block_field_group() {

	// prepare block field options
	$blocks_field_group = array_map( 'skel_prepare_block_field_group', BLOCK_DIR_NAMES );

	// var_dump($blocks_field_group);

	// register field groups
	foreach( $blocks_field_group as $block_field_group ) {
		acf_add_local_field_group( $block_field_group );
	}

}



// run if acf is activated
add_action( 'acf/init', 'skel_register_block' );
// add_action( 'acf/init', 'skel_register_block_field_group' );

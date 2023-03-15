<?php

/**
 * Add custom blocks
 * ?string[]
 */
$block_types = [
	'Visual Editor',
	'Spacer'
];

/**
 * Create block options
 * @param string
 * @return array
 */
function skel_create_block_options( $block ) {
	$sanitize_block = sanitize_title( $block );
	return [
		'name'            => $sanitize_block,
		'title'           => $block,
		'icon'            => [
			'background' => '#fbf3db',
			'foreground' => '#333',
			'src'        => 'layout'
		],
		'post_types'      => [ 'page' ],
		'category'        => 'uncategorized',
		'mode'            => 'edit',
		'render_template' => 'acf-blocks/' . $sanitize_block . '.php',
		'example'         => [
			'attributes' => [
				'mode' => 'preview',
				'data' => [
					'preview_image' => get_template_directory_uri() . '/acf-blocks/preview/' . $sanitize_block . '.jpg'
				]
			]
		],
		'supports'        => [
			'align'           => false,
			'customClassName' => false,
			'mode' => false // disable toggle preview and edit
		]
	];
}

/**
 * Register blocks
 * @uses acf_register_block_type()
 */
function skel_register_acf_blocks() {

	global $block_types;

	// create block options
	$blocks = array_map( 'skel_create_block_options', $block_types );

	// arrange the blocks in ascending order
	sort( $blocks );

	// register blocks
	foreach( $blocks as $block ) {
		acf_register_block_type( $block );
	}

}


/**
 * Check if function exists and hook into setup
 */
if ( function_exists( 'acf_register_block_type' ) ) {
	add_action( 'acf/init', 'skel_register_acf_blocks' );
}
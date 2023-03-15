<?php

/**
 * Get blocks parent dir
 * @var string path
 */
$blocks_parent_dir = get_template_directory() . '/acf-blocks/';

/**
 * Get the path of all folders inside blocks parent dir
 * @var array
 */
$blocks_dir = glob($blocks_parent_dir . '*' , GLOB_ONLYDIR);

/**
 * Extract basename from filename in array
 * @param function basename
 * @param array $blocks_dir
 * @return array
 */
$blocks_slug = array_map( 'basename', $blocks_dir );

/**
 * Create block options
 * @param string
 * @return array
 */
function skel_create_block_options( $slug ) {
	$title = ucwords(str_replace( '-', ' ', $slug ));
	return [
		'name'            => $slug,
		'title'           => $title,
		'icon'            => [
			'background' => '#fbf3db',
			'foreground' => '#333',
			'src'        => 'layout'
		],
		'post_types'      => [ 'page' ],
		'category'        => 'uncategorized',
		'mode'            => 'edit',
		'render_template' => 'acf-blocks/' . $slug . '/layout.php',
		'example'         => [
			'attributes' => [
				'mode' => 'preview',
				'data' => [
					'preview_image' => get_template_directory_uri() . '/acf-blocks/' . $slug . '/preview.jpg'
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
 * Register blocks
 * @uses acf_register_block_type()
 */
function skel_register_acf_blocks() {

	global $blocks_slug;

	// create block options
	$blocks = array_map( 'skel_create_block_options', $blocks_slug );

	// arrange the blocks in ascending order
	sort( $blocks );

	// register blocks
	foreach( $blocks as $slug ) {
		acf_register_block_type( $slug );
	}

}


/**
 * Check if function exists and hook into setup
 */
if ( function_exists( 'acf_register_block_type' ) ) {
	add_action( 'acf/init', 'skel_register_acf_blocks' );
}
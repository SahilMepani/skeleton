<?php

/**
 * Get blocks parent dir
 * @var string path
 */
$blocks_parent_dir_path = get_template_directory() . '/acf-blocks/';

/**
 * Get the path of all folders inside blocks parent dir
 * @var array
 */
$blocks_dir_path = glob($blocks_parent_dir_path . '*' , GLOB_ONLYDIR);

/**
 * Extract basename from filename in array
 * @param function basename
 * @param array $blocks_dir_path
 * @return array
 */
$blocks_dir_name = array_map( 'basename', $blocks_dir_path );

// $blocks_config = [];
// foreach( $blocks_dir_name as $dir_name ) {
// 	$blocks_config = require_once $blocks_parent_dir_path . $dir_name . '/config.php';
// }
// print_r( $blocks_config );

/**
 * Create block options
 * @param string $dir_name
 * @return array
 */
function skel_create_block_options( $dir_name ) {
	$title = ucwords(str_replace( '-', ' ', $dir_name ));
	return [
		'name'            => $dir_name,
		'title'           => $title,
		'icon'            => [
			'background' => '#2271b1',
			'foreground' => '#fff',
			'src'        => 'layout'
		],
		'post_types'      => [ 'page' ],
		'category'        => 'uncategorized',
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
 * Register blocks
 * @uses acf_register_block_type()
 */
function skel_register_acf_blocks() {

	global $blocks_dir_name;

	// create block options
	$blocks_options = array_map( 'skel_create_block_options', $blocks_dir_name );

	// arrange the blocks in ascending order
	sort( $blocks_options );

	// register blocks
	foreach( $blocks_options as $block ) {
		acf_register_block_type( $block );
	}

}

/**
 * Require fields group
 */
foreach( $blocks_dir_name as $slug ) {
	require_once get_template_directory() . '/acf-blocks/' . $slug . '/fields.php';
}


/**
 * Check if function exists and hook into setup
 */
if ( function_exists( 'acf_register_block_type' ) ) {
	add_action( 'acf/init', 'skel_register_acf_blocks' );
}
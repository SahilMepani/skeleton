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

/**
 * Prepare block type options
 * @param string $dir_name
 * @return array
 */
function skel_prepare_block_type_options( $dir_name ) {

	$title = ucwords(str_replace( '-', ' ', $dir_name ));

	return [
		'name'            => $dir_name,
		'title'           => $title,
		'icon'            => [
			'background' => '#2271b1',
			'foreground' => '#fff',
			'src'        => 'layout'
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
 * Register block type
 * @uses acf_register_block_type()
 */
function skel_register_block_type() {

	global $blocks_dir_name;

	// prepare block options
	$blocks_type_options = array_map( 'skel_prepare_block_type_options', $blocks_dir_name );

	// arrange the blocks in ascending order
	sort( $blocks_type_options );

	// register blocks
	foreach( $blocks_type_options as $block ) {
		acf_register_block_type( $block );
	}

}

/**
 * Require fields group
 */
// foreach( $blocks_dir_name as $slug ) {
// 	require_once get_template_directory() . '/acf-blocks/' . $slug . '/fields.php';
// }

/**
 * Setup group options
 * @param array $block_config
 * @param string $dir_name
 */
function setup_group_options( $block_config, $dir_name ) {
	$default_group_options = [
		'key'  => 'group_' . md5( $dir_name ),
		'name' => $dir_name,
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

	return $group_options = array_merge( $default_group_options, $block_config );
}

/**
 * Get the configs from all the blocks
 */
function skel_register_field_group() {

	global $blocks_dir_name;
	global $blocks_parent_dir_path;
	$blocks_config = [];
	$i = 0;

	// foreach( $blocks_dir_name as $dir_name ) {
	// 	$blocks_config[$i] = require_once $blocks_parent_dir_path . $dir_name . '/config.php';
	// 	$blocks_config[$i] = setup_group_options( $blocks_config[$i], $dir_name );
	// 	acf_add_local_field_group( $blocks_config[$i] );
	// 	$i++;
	// }

	// echo '<pre>'; print_r( $blocks_config ); echo '</pre>';
}

// run if acf is activated
add_action( 'acf/init', 'skel_register_block_type' );
add_action( 'acf/init', 'skel_register_field_group' );

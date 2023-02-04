<?php

// Create a new block category
////////////////////////////////////////////////
function skel_block_category( $categories, $post ) {
	return array_merge(
		$categories,
		[
			[
				'slug'  => 'skeleton',
				'title' => __( 'Skeleton', 'skel' )
			]
		]
	);
}
add_filter( 'block_categories_all', 'skel_block_category', 10, 2 );

function skel_register_acf_blocks() {

	// Visual Editor
	////////////////////////////////////////////////
	acf_register_block_type( [
		'name'            => 'visual-editor',
		'title'           => 'Visual Editor',
		'description'     => '',
		'category'        => 'skeleton',
		'icon'            => [
			'background' => '#fbf3db',
			'foreground' => '#333',
			'src'        => 'layout'
		],
		'keywords'        => [ '', 'skel' ],
		'render_template' => 'acf-blocks/visual-editor.php',
		'example'         => [
			'attributes' => [
				'mode' => 'preview',
				// 'viewportWidth' => 800, // doesn't work. It sets the preview width
				'data' => [
					'preview_image' => get_template_directory_uri() . '/acf-blocks/preview/visual-editor.jpg'
				]
			]
		],
		'mode'            => 'edit',
		'post_types'      => [ 'page' ],
		'supports'        => [
			'align'           => false,
			'customClassName' => false,
			'mode' => false // disable toggle preview and edit
		]
	] );

	// Spacer
	////////////////////////////////////////////////
	acf_register_block_type( [
		'name'            => 'spacer',
		'title'           => 'Spacer',
		'category'        => 'skeleton',
		'icon'            => [
			'background' => '#fbf3db',
			'foreground' => '#333',
			'src'        => 'layout'
		],
		'keywords'        => [ '', 'skel' ],
		'render_template' => 'acf-blocks/spacer.php',
		'example'         => [
			'attributes' => [
				'mode' => 'preview',
				'data' => [
					'preview_image' => get_template_directory_uri() . '/acf-blocks/preview/spacer.jpg'
				]
			]
		],
		'mode'            => 'edit',
		'post_types'      => [ 'page' ],
		'supports'        => [
			'align'           => false,
			'customClassName' => false,
			'mode' => false
		]
	] );

}

// Check if function exists and hook into setup
////////////////////////////////////////////////
if ( function_exists( 'acf_register_block_type' ) ) {
	add_action( 'acf/init', 'skel_register_acf_blocks' );
}

<?php

// Create a new block category
////////////////////////////////////////////////
function skel_block_category( $categories, $post )
{
	return array_merge(
		$categories,
		array(
			array(
				'slug'  => 'skeleton',
				'title' => __( 'Skeleton', 'skel' )
			)
		)
	);
}
add_filter( 'block_categories_all', 'skel_block_category', 10, 2 );

function skel_register_acf_blocks()
{

	// Visual Editor
	////////////////////////////////////////////////
	acf_register_block_type( array(
		'name'            => 'visual-editor',
		'title'           => 'Visual Editor',
		'description'     => 'Generally used as a banner at the beginning of the page',
		'category'        => 'skeleton',
		'icon'            => array(
			'background' => '#ff2500',
			'foreground' => '#fff',
			'src'        => 'layout'
		),
		'keywords'        => array( 'banner', 'skel' ),
		'render_template' => 'acf-blocks/visual-editor.php',
		'example'         => [
			'attributes' => [
				'mode' => 'preview',
				// 'viewportWidth' => 800, // doesn't work. It sets the preview width
				'data' => array(
					'preview_image' => get_template_directory_uri() . '/acf-blocks/preview/visual-editor.jpg'
				)
			]
		],
		'mode'            => 'edit',
		'post_types'      => array( 'page' ),
		'supports'        => array(
			'align'           => false,
			'customClassName' => false
		)
	) );

}

// Check if function exists and hook into setup
////////////////////////////////////////////////
if ( function_exists( 'acf_register_block_type' ) ) {
	add_action( 'acf/init', 'skel_register_acf_blocks' );
}

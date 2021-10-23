<?php

// Create a new block category
////////////////////////////////////////////////
function skel_block_category( $categories, $post ) {
  return array_merge(
    $categories,
    array(
      array(
        'slug' => 'threesixtyeight',
        'title' => __( 'ThreeSixtyEight', 'skel' ),
      ),
    )
  );
}
add_filter( 'block_categories_all', 'skel_block_category', 10, 2);

function skel_register_acf_blocks() {

  // Sample
  ////////////////////////////////////////////////
  acf_register_block_type(array(
    'name'              => 'hero-image-slider',
    'title'             => __( 'Hero Image Slider', 'skel' ),
    'description'       => __( 'Generally used as a banner at the beginning of the page', 'skel' ),
    'category'          => 'threesixtyeight',
    'icon' => array(
      'background' => '#ff2500',
      'foreground' => '#fff',
      'src' => 'layout',
    ),
    'keywords'          => array( 'banner', 'skel' ),
    'render_template'  	=> 'acf-blocks/hero-image-slider.php',
    'example'           => [
      'attributes' => [
        'mode' => 'preview',
        // 'viewportWidth' => 800, // doesn't work. It sets the preview width
        'data' => array(
          'preview_image' => get_template_directory_uri() . '/acf-blocks/preview/hero-image-slider.jpg',
        ),
      ]
    ],
    'mode'              => 'edit',
    'post_types'        => array( 'page' ),
    'supports'          => array(
      'align' => false,
      'customClassName' => false
    )
  ));

}


// Check if function exists and hook into setup
////////////////////////////////////////////////
if ( function_exists( 'acf_register_block_type' ) ) {
  add_action( 'acf/init', 'skel_register_acf_blocks' );
}
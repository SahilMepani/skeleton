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
add_filter( 'block_categories', 'skel_block_category', 10, 2);

function skel_register_acf_blocks() {

  // Sample
  ////////////////////////////////////////////////
  acf_register_block_type(array(
    'name'              => 'homepage-hero',
    'title'             => __( 'Homepage Hero', 'skel' ),
    'description'       => __( 'Generally used as a banner at the beginning of the page', 'skel' ),
    'category'          => 'threesixtyeight',
    'icon'              => 'layout',
    'keywords'          => array( 'banner', 'skel' ),
    'render_template'  	=> 'acf-blocks/blank.php',
    'example'           => [],
    'mode'              => 'edit',
    'post_types'        => array( 'page' ),
    'supports'          => array(
      'align' => false,
      'customClassName' => false
    ),
  ));

}


// Check if function exists and hook into setup
////////////////////////////////////////////////
if ( function_exists( 'acf_register_block_type' ) ) {
  add_action( 'acf/init', 'skel_register_acf_blocks' );
}
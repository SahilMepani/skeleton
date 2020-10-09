<?php
// Add custom image sizes
////////////////////////////////////////////////
// add_image_size( 'blog_featured_thumb', width, height, crop );
add_image_size( 'h200', 9999, 200 ); // used for image acf preview
add_image_size( 'w200', 200, 9999 ); // used for image acf preview
add_image_size( 'w414', 414, 9999 );
add_image_size( 'w768', 768, 9999 );
add_image_size( 'w992', 992, 9999 );
add_image_size( 'w1400', 1400, 9999 );
add_image_size( 'w1200', 1200, 9999 );
add_image_size( 'w1600', 1600, 9999 );
add_image_size( 'w1920', 1920, 9999 );
add_image_size( 'w2560', 2560, 9999 );
add_image_size( 'w3840', 3840, 9999 );


// Enable featured images for all post types including custom
////////////////////////////////////////////////
// add_theme_support('post-thumbnails');


// Add instructions to featured images
////////////////////////////////////////////////
// WORKS FOR CLASSIC EDITOR ONLY
function tse_featured_image_html( $html ) {
  return $html .= '<p><b>Recommended:</b> <br /> Minimum width: 1000px. <br /> Aspect ratio: Landscape. <br /> Format: JPG/JPEG </p>';
}
add_filter( 'admin_post_thumbnail_html', 'tse_featured_image_html');

// WORKS FOR GUTENBERG - NOT TESTED
// function change_post_type_labels() {
//   $post_object = get_post_type_object( 'page' );
//   if ( ! $post_object ) {
//     return false;
//   }
//   $post_object->labels->set_featured_image = 'Set featured image (540px x 350px)';
//   return true;
// }
// add_action( 'wp_loaded', 'change_post_type_labels', 20 );
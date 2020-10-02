<?php

require_once( get_template_directory() . '/functions/acf.php' );
require_once( get_template_directory() . '/functions/actions.php' );
require_once( get_template_directory() . '/functions/filters.php' );
require_once( get_template_directory() . '/functions/register-acf-blocks.php' );
require_once( get_template_directory() . '/functions/block-editor-settings.php' );


/* ===============================================
=            Create/Edit media sizes            =
=============================================== */
// Enable featured images
add_theme_support('post-thumbnails');

// Update default media sizes
update_option( 'thumbnail_size_w', 200 );
// update_option( 'thumbnail_size_h', 0 );
update_option( 'medium_size_w', 768 );
update_option( 'large_size_w', 992 );

// Custom media sizes
// add_image_size( 'blog_featured_thumb', width, height, crop );
add_image_size( 'h200', 9999, 200 ); // used for image acf preview
// add_image_size( 'w200', 200, 9999 ); added as a thumbnail size
add_image_size( 'w576', 576, 9999 );
// add_image_size( 'w768', 768, 9999 ); added as a medium size
// add_image_size( 'w992', 992, 9999 ); added as a large size
add_image_size( 'w1200', 1200, 9999 );
// add_image_size( 'w1400', 1400, 9999 );
add_image_size( 'w1600', 1600, 9999 );
add_image_size( 'w1920', 1920, 9999 );
add_image_size( 'w2560', 2560, 9999 );
add_image_size( 'w3840', 3840, 9999 );


/*======================================
=            Register menus            =
======================================*/
register_nav_menus(
  array(
    'header-menu' => 'Header Menu'
  )
);


//*! ----------  REQUIRED - Do not edit  ----------*/

// Add editor stylesheet
////////////////////////////////////////////////
add_editor_style();

// Overrides default image-URL behavior
////////////////////////////////////////////////
// http://wordpress.org/support/topic/insert-image-default-to-no-link
update_option('image_default_link_type', 'none');
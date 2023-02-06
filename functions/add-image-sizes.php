<?php

// Add custom image sizes
////////////////////////////////////////////////
// add_image_size( 'blog_featured_thumb', width, height, crop );
add_image_size( 'h200', 9999, 200 );
add_image_size( 'w200', 200, 9999 );
add_image_size( 'w768', 768, 9999 );
add_image_size( 'w1400', 1400, 9999 );
add_image_size( 'w1920', 1920, 9999 );

// Enable featured images for all post types including custom
////////////////////////////////////////////////
add_theme_support('post-thumbnails');

<?php
/**
 * Add custom image sizes
 *
 * @package WordPress
 * @subpackage Skeleton
 * @since 1.0.0
 */

/**
 * Add custom image sizes
 * Format: add_image_size( 'name', width, height, crop );
 */
// Add image size for a fixed height of 200px.
add_image_size( 'h200', 9999, 200 );
// Add image size for a fixed width of 200px.
add_image_size( 'w200', 200, 9999 );
add_image_size( 'w768', 768, 9999 );
add_image_size( 'w1400', 1400, 9999 );
add_image_size( 'w1920', 1920, 9999 );


/**
 * Enable featured images for all post types including custom post types
 *
 * This line adds support for featured images (post thumbnails) to all post types,
 * including custom post types registered by themes or plugins.
 * This enables you to set featured images for posts and display them in your theme.
 */
add_theme_support( 'post-thumbnails' );

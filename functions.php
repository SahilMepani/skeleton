<?php

require_once( get_template_directory() . '/functions/shortcodes.php' );
require_once( get_template_directory() . '/functions/filters.php' );
require_once( get_template_directory() . '/functions/actions.php' );
require_once( get_template_directory() . '/functions/acf.php' );


/* ===============================================
=            Create/Edit media sizes            =
=============================================== */
// Enable featured images
add_theme_support('post-thumbnails');

// Disable default media sizes
update_option( 'thumbnail_size_w', 0 );
update_option( 'thumbnail_size_h', 0 );
update_option( 'medium_size_w', 0 );
update_option( 'medium_size_h', 0 );
update_option( 'large_size_w', 0 );
update_option( 'large_size_h', 0 );

// Custom media sizes
// add_image_size( 'blog_featured_thumb', width, height, crop );
add_image_size( 'h200', 9999, 200 ); // used for image acf preview
add_image_size( 'w200', 200, 9999 );
add_image_size( 'w375', 375, 9999 );
add_image_size( 'w414', 414, 9999 );
add_image_size( 'w576', 576, 9999 );
add_image_size( 'w768', 768, 9999 );
add_image_size( 'w992', 992, 9999 );
add_image_size( 'w1200', 1200, 9999 );
add_image_size( 'w1400', 1400, 9999 );
add_image_size( 'w1600', 1600, 9999 );
add_image_size( 'w1920', 1920, 9999 );
add_image_size( 'w2560', 2560, 9999 );
add_image_size( 'w3840', 3840, 9999 );
add_image_size( 'w2560h1600', 2560, 1600 );
add_image_size( 'ar16by9', 1920, 1080 );
add_image_size( 'w375@2x', 750, 9999 );
add_image_size( 'w414@2x', 828, 9999 );
add_image_size( 'w576@2x', 1152, 9999 );
add_image_size( 'w768@2x', 1536, 9999 );
add_image_size( 'w992@2x', 1984, 9999 );
add_image_size( 'w1200@2x', 2400, 9999 );
add_image_size( 'w1400@2x', 2800, 9999 );
add_image_size( 'w1600@2x', 3200, 9999 );


/*======================================
=            Register menus            =
======================================*/
register_nav_menus(
	array(
		'header-menu' => 'Header Menu',
		'footer-menu' => 'Footer Menu',
	)
);


/*----------  REQUIRED - Do not edit  ----------*/

/*=============================================
=            Add editor stylesheet            =
=============================================*/
add_editor_style();


/*============================================================
=            Overrides default image-URL behavior            =
============================================================*/
// http://wordpress.org/support/topic/insert-image-default-to-no-link
update_option('image_default_link_type', 'none');


/*=======================================
=            Blog pagination            =
=======================================*/
// http://wp.tutsplus.com/tutorials/wordpress-pagination-a-primer
function tse_posts_pagination( $pages ) {
	$total_pages = $pages;

	if ( $total_pages > 1 ) {

		$current_page = max( 1, get_query_var( 'paged' ) );

		echo '<div class="posts-pagination">';

		echo '<span class="index"> Page ' . $current_page . ' of ' . $total_pages . "</span>";

		echo paginate_links(array(
				'base'      => get_pagenum_link( 1 ) . '%_%',
				'format'    => 'page/%#%/',
				'current'   => $current_page,
				'total'     => $total_pages,
				'type'      => 'list', // plain, array, list
				'prev_text' => '&lsaquo; Previous',
				'next_text' => 'Next &rsaquo;',
		));
		echo '</div>';
	}
}

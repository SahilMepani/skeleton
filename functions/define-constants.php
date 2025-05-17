<?php
add_action( 'acf/init', 'define_constants' );

function define_constants() {
	$global_default_thumbnail_id = get_field( 'default_featured_image', 'option' );
	$global_pages                = get_field( 'pages', 'option' );

	if ( $global_default_thumbnail_id && ! defined( 'DEFAULT_THUMBNAIL_ID' ) ) {
		define( 'DEFAULT_THUMBNAIL_ID', $global_default_thumbnail_id );
	}

	if ( $global_pages && $global_pages['four_four'] && ! defined( 'PAGE_404_ID' ) ) {
		define( 'PAGE_404_ID', $global_pages['four_four'] );

	}

	if ( $global_pages && $global_pages['search'] && ! defined( 'PAGE_SEARCH_ID' ) ) {
		define( 'PAGE_SEARCH_ID', $global_pages['search'] );
	}
}

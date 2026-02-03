<?php // phpcs:ignore file comment
/**
 * Define global constants based on ACF option fields.
 *
 * This function retrieves global option values from the ACF Options Page
 * and defines them as constants for use throughout the theme or plugin.
 *
 * Hooked into the 'acf/init' action to ensure that ACF functions
 * (like get_field) are available before this runs.
 *
 * Constants defined:
 * - DEFAULT_THUMBNAIL_ID : The default featured image ID.
 * - PAGE_404_ID          : The page ID used for the 404 error page.
 * - PAGE_SEARCH_ID       : The page ID used for the search results page.
 *
 * @since 1.0.0
 *
 * @return void
 */
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

add_action( 'acf/init', 'define_constants' );

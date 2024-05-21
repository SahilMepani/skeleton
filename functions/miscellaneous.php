<?php
/**
 * The header.
 *
 * This file contains filters and actions for various purpose
 *
 * @package WordPress
 * @subpackage Skeleton
 * @since 1.0.0
 */

// Hide admin toolbar.
add_filter( 'show_admin_bar', '__return_false' );

// Disable the sitemaps feature - /wp-sitemap.xml.
add_filter( 'wp_sitemaps_enabled', '__return_false' );

/**
 * Disable the Customizer page and Theme Editor in the WordPress admin.
 */
add_action(
	'admin_menu',
	function () {
		// Build the customizer URL to remove.
		$customizer_url = add_query_arg(
			'return',
			rawurlencode( wp_unslash( $_SERVER['REQUEST_URI'] ) ),
			'customize.php'
		);

		// Remove the Customizer and Theme Editor submenu pages.
		remove_submenu_page( 'themes.php', $customizer_url );
		remove_submenu_page( 'themes.php', 'theme-editor.php' );
	},
	999
);


/**
 * Filter callback to set JPEG image quality to 100.
 *
 * This function is used as a callback for the 'jpeg_quality' filter hook.
 * It sets the quality of JPEG images to 100.
 *
 * @param int $arg The current JPEG quality level.
 * @return int The updated JPEG quality level (100).
 */
add_filter(
	'jpeg_quality',
	function ( $quality = 100 ) {
		return $quality;
	}
);

/**
 * Check if the current page is the login or registration page.
 *
 * @return bool True if the current page is the login or registration page, false otherwise.
 */
function is_login_or_registration_page(): bool {
	return in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ), true );
}

if ( is_login_or_registration_page() ) {
	require_once get_template_directory() . '/functions/captcha.php';
}


/**
 * Display pagination for posts.
 * http://wp.tutsplus.com/tutorials/wordpress-pagination-a-primer
 *
 * @param int $total_pages The total number of pages.
 */
function skel_posts_pagination( int $total_pages ): void {
	if ( 1 < $total_pages ) {
		$current_page = max( 1, get_query_var( 'paged' ) );

		echo '<nav class="posts-pagination" role="navigation" aria-label="' . esc_attr__( 'Posts Pagination', 'text-domain' ) . '">';

		$big = 999999999; // A large number for replacing in the pagination link.
		echo paginate_links(
			array(
				'base'       => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'     => '?paged=%#%',
				'current'    => $current_page,
				'total'      => $total_pages,
				'prev_text'  => svg( 'arrow-left', array( 'aria-hidden' => 'true' ) ) . '<span class="screen-reader-text">' . esc_html__( 'Previous page', 'text-domain' ) . '</span>',
				'next_text'  => svg( 'arrow-right', array( 'aria-hidden' => 'true' ) ) . '<span class="screen-reader-text">' . esc_html__( 'Next page', 'text-domain' ) . '</span>',
				'mid_size'   => 1,
				'start_size' => 0,
				'end_size'   => 0,
			)
		);

		echo '</nav>';
	}
}

/**
 * Generates an SVG icon.
 *
 * @param string $icon The icon name.
 * @param array  $attributes Additional attributes for the SVG element.
 * @return string SVG HTML.
 */
function svg( $icon, $attributes = array() ) {
	$svg = '<svg class="icon icon-' . esc_attr( $icon ) . '"';

	foreach ( $attributes as $key => $value ) {
		$svg .= ' ' . esc_attr( $key ) . '="' . esc_attr( $value ) . '"';
	}

	$svg .= '><use xlink:href="#icon-' . esc_attr( $icon ) . '"></use></svg>';

	return $svg;
}

// Add attributes to enqueue styles
//
/*
DO NOT USE with Autoptimizer or any contact plugin */
// function add_style_attribute($tag, $handle) {
// if ( 'google-fonts' !== $handle )
// return $tag;
// return str_replace( " rel='stylesheet'", " rel='preload'", $tag );
// }
// add_filter('style_loader_tag', 'add_style_attribute', 10, 2);



/**
 * Remove jQuery Migrate script.
 *
 * The jQuery Migrate is not useful if autoptimize for JS with concatenation is enabled.
 * If any jQuery-dependent script is loaded at the top, then jQuery is forced by WordPress
 * to load at the top, e.g., Gravity Forms.
 *
 * @param WP_Scripts $scripts The WP_Scripts object.
 */
function remove_jquery_migrate( &$scripts ) {
	if ( ! is_admin() ) {
		$scripts->remove( 'jquery' );
		$scripts->add( 'jquery', false, array( 'jquery-core' ), '1.10.2' );
	}
}
add_filter( 'wp_default_scripts', 'remove_jquery_migrate' );


// Remove query string from static files
function skel_remove_cssjs_ver( $src ) {
	if ( strpos( $src, '?ver=' ) ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}
add_filter( 'style_loader_src', 'skel_remove_cssjs_ver', 10, 2 );
add_filter( 'script_loader_src', 'skel_remove_cssjs_ver', 10, 2 );

// Redirect to result, if search query one result
//
// function skel_redirect_single_post() {
// if (is_search()) {
// global $wp_query;
// if ($wp_query->post_count == 1 && $wp_query->max_num_pages == 1) {
// wp_redirect(get_permalink($wp_query->posts['0']->ID));
// exit;
// }
// }
// }
// add_action('template_redirect', 'skel_redirect_single_post');

// Limit search results to post
//
// http://www.wpbeginner.com/wp-tutorials/how-to-limit-search-results-for-specific-post-types-in-wordpress/*/
// function searchfilter($query) {
// if ($query->is_search && !is_admin() ) {
// $query->set('post_type',array('post'));
// }
// return $query;
// }
// add_filter('pre_get_posts','searchfilter');

// Add attributes to enqueue scripts
//
// function add_script_attribute($tag, $handle) {
// if ( 'modernizr' !== $handle )
// return $tag;
// return str_replace( ' src', ' async="async" src', $tag );
// }
// add_filter('script_loader_tag', 'add_script_attribute', 10, 2);

//
// ! REQUIRED - Do not edit below
//

// Wrap oEmbed resource/video inside a div
//
function skel_embed_oembed_html( $html, $url, $attr, $post_id ) {
	return '<div class="embed-responsive embed-responsive-16by9">' . $html . '</div>';
}
add_filter( 'embed_oembed_html', 'skel_embed_oembed_html', 99, 4 );

// Add body classes to editor
//
function skel_mce_settings( $initArray ) {
	$initArray['body_class'] = 'post';

	return $initArray;
}
add_filter( 'tiny_mce_before_init', 'skel_mce_settings' );

// Add page slug to body class
//
function skel_add_slug_body_class( $classes ) {
	global $post;
	if ( isset( $post ) ) {
		$classes[] = $post->post_type . '-' . $post->post_name;
	}

	return $classes;
}
add_filter( 'body_class', 'skel_add_slug_body_class' );

// Prevent WP Editor from removing span
//
function skel_no_delete_span( $init ) {
	// Command separated string of extended elements
	$ext = 'span[id|name|class|style]';

	// Add to extended_valid_elements if it alreay exists
	if ( isset( $init['extended_valid_elements'] ) ) {
		$init['extended_valid_elements'] .= ',' . $ext;
	} else {
		$init['extended_valid_elements'] = $ext;
	}

	// Super important: return $init!

	return $init;
}
add_filter( 'tiny_mce_before_init', 'skel_no_delete_span' );

// Custom login errors
//
function skel_custom_wordpress_errors() {
	return 'Something is wrong!';
}
add_filter( 'login_errors', 'skel_custom_wordpress_errors' );

// Change default excerpt length
//
function skel_get_the_excerpt_length() {
	return 150; // Default Length
}
add_filter( 'excerpt_length', 'skel_get_the_excerpt_length' );

// Add ellipsis at the end of excerpt
//
function skel_get_the_excerpt_more( $more ) {
	return '... ';
}
add_filter( 'excerpt_more', 'skel_get_the_excerpt_more' );

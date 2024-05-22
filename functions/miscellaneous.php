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
 *
 * This function removes the Customizer and Theme Editor submenu pages from the admin menu.
 *
 * @return void
 */
/**
 * Disable the Customizer page and Theme Editor in the WordPress admin.
 *
 * This function removes the Customizer and Theme Editor submenu pages from the admin menu.
 *
 * @return void
 */
add_action(
	'admin_menu',
	function () {
		// Check if REQUEST_URI is set before using it.
		if ( isset( $_SERVER['REQUEST_URI'] ) ) {
			// Build the customizer URL to remove.
			$customizer_url = add_query_arg(
				'return',
				rawurlencode( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) ),
				'customize.php'
			);

			// Remove the Customizer and Theme Editor submenu pages.
			remove_submenu_page( 'themes.php', $customizer_url );
			remove_submenu_page( 'themes.php', 'theme-editor.php' );
		}
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
		// phpcs:ignore -- Allow non escaping html
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

/**
 * Add attributes to enqueued styles.
 *
 * This function modifies the attributes of enqueued stylesheets. Note: Do not use with Autoptimizer
 * or any contact plugin.
 *
 * DO NOT USE with Autoptimizer or any contact plugin
 *
 * @param string $tag    The HTML link tag for the enqueued style.
 * @param string $handle The handle of the enqueued style.
 * @return string Modified HTML link tag with additional attributes.
 */
function add_style_attribute( $tag, $handle ) {
	if ( 'google-fonts' !== $handle ) {
		return $tag;
	}
	// phpcs:ignore -- Disable enqueue script warning
	return str_replace( " rel='stylesheet'", " rel='preload'", $tag );
}
add_filter( 'style_loader_tag', 'add_style_attribute', 10, 2 );


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


/**
 * Remove version query string from styles and scripts.
 *
 * This function removes the version query string (?ver=) from enqueued
 * style and script URLs to improve caching.
 *
 * @param string $src The source URL of the enqueued style or script.
 * @return string The modified source URL without the version query string.
 */
function skel_remove_cssjs_ver( string $src ): string {
	if ( false !== strpos( $src, '?ver=' ) ) { // Yoda condition.
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}

add_filter( 'style_loader_src', 'skel_remove_cssjs_ver', 10, 2 );
add_filter( 'script_loader_src', 'skel_remove_cssjs_ver', 10, 2 );


/**
 * Redirect to the single post if the search query returns only one result.
 *
 * This function checks if the search query has exactly one result and redirects
 * the user to that post's permalink.
 *
 * @return void
 */
function skel_redirect_single_post(): void {
	if ( is_search() ) {
		global $wp_query;

		// Check if the search query returned exactly one post.
		if ( 1 === $wp_query->post_count && 1 === $wp_query->max_num_pages ) {
			wp_safe_redirect( get_permalink( $wp_query->posts[0]->ID ) );
			exit;
		}
	}
}
add_action( 'template_redirect', 'skel_redirect_single_post' );


/**
 * Limit search results to posts only.
 *
 * This function modifies the main query to limit search results to the 'post' post type.
 *
 * @param WP_Query $query The main query.
 * @return WP_Query Modified query.
 */
function searchfilter( WP_Query $query ): WP_Query {
	if ( $query->is_search && ! is_admin() ) {
		$query->set( 'post_type', array( 'post' ) );
	}
	return $query;
}

add_filter( 'pre_get_posts', 'searchfilter' );


/**
 * Add async attribute to the specified script handle.
 *
 * This function adds the async attribute to the script tag for the 'modernizr' handle.
 *
 * @param string $tag    The script tag for the enqueued script.
 * @param string $handle The handle of the enqueued script.
 * @return string Modified script tag with async attribute.
 */
function add_script_attribute( string $tag, string $handle ): string {
	if ( 'modernizr' !== $handle ) {
		return $tag;
	}
	return str_replace( ' src', ' async="async" src', $tag );
}

add_filter( 'script_loader_tag', 'add_script_attribute', 10, 2 );


//
// ! REQUIRED - Do not edit below
//


/**
 * Wrap embedded oEmbed HTML in a responsive container.
 *
 * This function adds a responsive wrapper around the oEmbed HTML to ensure
 * that embedded content is displayed responsively.
 *
 * @param string $html    The oEmbed HTML.
 * @return string Modified oEmbed HTML with responsive wrapper.
 */
function skel_embed_oembed_html( string $html ): string {
	return '<div class="embed-responsive embed-responsive-16by9">' . $html . '</div>';
}

add_filter( 'embed_oembed_html', 'skel_embed_oembed_html', 99, 4 );

/**
 * Add custom body class to TinyMCE editor.
 *
 * This function modifies the TinyMCE settings to include a custom body class
 * for the editor.
 *
 * @param array $init_array An array of TinyMCE initialization parameters.
 * @return array Modified array of TinyMCE initialization parameters.
 */
function skel_mce_settings( array $init_array ): array {
	$init_array['body_class'] = 'post';
	return $init_array;
}

add_filter( 'tiny_mce_before_init', 'skel_mce_settings' );


/**
 * Add post type and slug to the body class.
 *
 * This function adds a class to the body element that includes the post type and post slug
 * of the current post.
 *
 * @param array $classes An array of body classes.
 * @return array Modified array of body classes.
 */
function skel_add_slug_body_class( array $classes ): array {
	global $post;
	if ( isset( $post ) ) {
		$classes[] = $post->post_type . '-' . $post->post_name;
	}

	return $classes;
}

add_filter( 'body_class', 'skel_add_slug_body_class' );


/**
 * Prevent the WordPress editor from removing <span> elements.
 *
 * This function modifies TinyMCE settings to ensure that <span> elements with specific attributes
 * are not removed by the editor.
 *
 * @param array $init An array of TinyMCE initialization parameters.
 * @return array Modified array of TinyMCE initialization parameters.
 */
function skel_no_delete_span( array $init ): array {
	// Comma-separated string of extended elements.
	$ext = 'span[id|name|class|style]';

	// Add to extended_valid_elements if it already exists.
	if ( isset( $init['extended_valid_elements'] ) ) {
		$init['extended_valid_elements'] .= ',' . $ext;
	} else {
		$init['extended_valid_elements'] = $ext;
	}

	// Super important: return $init!
	return $init;
}

add_filter( 'tiny_mce_before_init', 'skel_no_delete_span' );


/**
 * Custom login error message.
 *
 * This function modifies the default WordPress login error message to prevent
 * revealing details about login failures.
 *
 * @return string Custom login error message.
 */
function skel_custom_wordpress_errors(): string {
	return 'Something is wrong!';
}

add_filter( 'login_errors', 'skel_custom_wordpress_errors' );


/**
 * Change the default excerpt length.
 *
 * This function modifies the default excerpt length to 150 words.
 *
 * @return int Custom excerpt length.
 */
function skel_get_the_excerpt_length(): int {
	return 150; // Default length.
}

add_filter( 'excerpt_length', 'skel_get_the_excerpt_length' );


/**
 * Add ellipsis at the end of the excerpt.
 *
 * This function modifies the excerpt "more" string to display an ellipsis.
 *
 * @param string $more The string shown within the more link.
 * @return string Modified "more" string.
 */
function skel_get_the_excerpt_more( string $more ): string {
	return '... ';
}

add_filter( 'excerpt_more', 'skel_get_the_excerpt_more' );

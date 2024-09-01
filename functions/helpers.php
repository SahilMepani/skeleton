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

/**
 * Check if the current page is the login or registration page.
 *
 * @return bool True if the current page is the login or registration page, false otherwise.
 */
function is_login_or_registration_page(): bool {
	return in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ), true );
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
 * Retrieve the Swiper direction-based class for slides.
 *
 * This function returns a class name based on the language direction for Swiper slides.
 * If the current language is English ('en'), it returns 'swiper' for left-to-right direction.
 * If the current language is Arabic ('ar'), it returns 'swiper-rtl' for right-to-left direction.
 * This function requires the WPML plugin to work properly.
 *
 * @requires WPML plugin
 * @return string|null The class name for the Swiper direction, or null if the language code is not supported.
 */
function skel_swiper_direction_class(): string|null {
	if ( ICL_LANGUAGE_CODE === 'en' ) {
		return 'swiper';
	} elseif ( ICL_LANGUAGE_CODE === 'ar' ) {
		return 'swiper-rtl';
	}
}

/**
 * Retrieve the language direction-based class for elements.
 *
 * This function returns a class name based on the language direction.
 * If the current language is English ('en'), it returns 'dir-ltr' for left-to-right direction.
 * If the current language is Arabic ('ar'), it returns 'dir-rtl' for right-to-left direction.
 * This function requires the WPML plugin to work properly.
 *
 * @requires WPML plugin
 * @return string|null The class name for the language direction, or null if the language code is not supported.
 */
function skel_direction_class(): string|null {
	if ( ICL_LANGUAGE_CODE === 'en' ) {
		return 'dir-ltr';
	} elseif ( ICL_LANGUAGE_CODE === 'ar' ) {
		return 'dir-rtl';
	}
}

/**
 * Retrieve the content of an SVG file located in the current active theme's '/images/svg/' directory.
 *
 * @param  string $image The name of the SVG file (without the '.svg' extension) to retrieve.
 * @return string|false The content of the SVG file if found, or FALSE if the file does not exist or cannot be read.
 */
function skel_get_svg_content( string $image ): string|false {
	// Construct the full path to the SVG file.
	$file_path = get_template_directory() . '/images/svg/' . $image . '.svg';

	// Check if the file exists and is readable.
	if ( file_exists( $file_path ) && is_readable( $file_path ) ) {
		// Read the content of the SVG file.
		$content = file_get_contents( $file_path );

		// Return the content.
		return $content;
	} else {
		// If the file does not exist or cannot be read, return FALSE.
		return false;
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
 * Generates a valid YouTube video link from a given YouTube video URL.
 *
 * @param  string $url The YouTube video URL from which to extract the video ID.
 * @return string The valid YouTube video link generated from the provided URL.
 */
function skel_get_yt_link( string $url ): string {
	// Find the position of the last occurrence of forward slash '/' in the URL.
	$pos = strrpos( $url, '/' );
	// If no forward slash is found, set $id to the entire URL; otherwise, extract the substring starting from the position after the last forward slash.
	$id = false === $pos ? $url : substr( $url, $pos + 1 );
	// Concatenate the extracted video ID with the YouTube watch URL to create a working YouTube video link.
	$url = 'https://www.youtube.com/watch?v=' . $id;

	return $url;
}

/**
 * Validates and retrieves a YouTube video link from a given input string.
 *
 * @param string $link The input string containing a potential YouTube video link.
 * @return string|false The valid YouTube video link generated from the provided input string,
 */
function skel_get_validate_youtube_link( string $link ): string|false {
	// Regular expression to extract the video ID from various YouTube URL formats.
	$pattern = "#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#";

	// Check if the input string matches the expected YouTube URL format.
	if ( preg_match( $pattern, $link, $matches ) ) {
		// Construct the valid YouTube video link.
		$youtube_link = 'https://www.youtube.com/watch?v=' . $matches[0];
		return $youtube_link;
	} else {
		// If no valid YouTube video link found, return false.
		return false;
	}
}


/**
 * Retrieves a customized excerpt for a specified post.
 *
 * This function retrieves the excerpt of the specified post and customizes it based on the provided limit.
 * It truncates the excerpt to the specified word limit and adds ellipsis (...) if the excerpt exceeds the limit.
 * Additionally, it removes any shortcodes from the excerpt before returning it.
 *
 * @param int $post_id The ID of the post for which to retrieve the excerpt.
 * @param int $limit   The maximum number of words in the excerpt.
 * @return string The customized excerpt of the specified post.
 */
function skel_get_the_excerpt( int $post_id, int $limit = 50 ): string {
	// Retrieve the excerpt of the specified post.
	$excerpt = explode( ' ', get_the_excerpt( $post_id ), $limit );

	// If the excerpt exceeds the limit, truncate and add ellipsis.
	if ( count( $excerpt ) >= $limit ) {
		array_pop( $excerpt );
		$excerpt = implode( ' ', $excerpt ) . '...';
	} else {
		$excerpt = implode( ' ', $excerpt );
	}

	// Remove any shortcodes from the excerpt before returning.
	$excerpt = preg_replace( '`\[[^\]]*\]`', '', $excerpt );

	return $excerpt;
}


/**
 * Shorten a text string to a specified length, preserving whole words.
 *
 * This function shortens the given text string to the specified length while preserving whole words.
 * If the text is already shorter than the specified length, it is returned as is.
 * If the text needs to be shortened, it finds the last space within the specified length and trims the text up to that space.
 * It then appends ellipses (...) to indicate that the text has been shortened.
 *
 * @param  string $input  The input text string to be shortened.
 * @param  int    $length The maximum length of the shortened text.
 * @return string The shortened text string.
 */
function skel_get_text_shorter( string $input, int $length ): string {
	// No need to trim, already shorter than trim length.
	if ( strlen( $input ) <= $length ) {
		return $input;
	}
	// find last space within length.
	$last_space = strrpos( substr( $input, 0, $length ), ' ' );
	if ( ! $last_space ) {
		$last_space = $length;
	}

	$trimmed_text = substr( $input, 0, $last_space );

	// add ellipses (...).
	$trimmed_text .= '...';

	return $trimmed_text;
}

/**
 * Return terms without link.
 *
 * This function retrieves the terms associated with a specified post and taxonomy
 * and returns them as a string without any HTML links.
 *
 * @param  int    $post_id   The ID of the post for which to retrieve the terms.
 * @param  string $taxonomy  The taxonomy from which to retrieve the terms.
 * @param  string $separator (Optional) The separator to use between terms. Default is a single space.
 * @return string The terms associated with the specified post, separated by the specified separator.
 */
function skel_get_the_terms( int $post_id, string $taxonomy, string $separator = ' ' ): string {
	// Retrieve term objects associated with the post and taxonomy.
	$term_objects = get_the_terms( $post_id, $taxonomy );

	// Extract the names of the terms.
	$term_names = wp_list_pluck( $term_objects, 'name' );

	// Join all term names with the specified separator.
	$output = join( $separator, $term_names );

	return $output;
}

/**
 * Retrieve terms data.
 *
 * This function retrieves the terms associated with a specified post and taxonomy
 * and returns an array containing term names and IDs.
 *
 * @param  int    $post_id   The ID of the post for which to retrieve the terms.
 * @param  string $taxonomy  The taxonomy from which to retrieve the terms.
 * @return array An array containing term names and IDs.
 */
function skel_get_the_terms_data( int $post_id, string $taxonomy ): array {
	// Retrieve term objects associated with the post and taxonomy.
	$terms = get_the_terms( $post_id, $taxonomy );

	// Initialize an array to store term data.
	$terms_data = array();

	// If terms are found, iterate over them to extract name and ID.
	if ( $terms ) {
		foreach ( $terms as $term ) {
			// Store term name and ID in the terms data array.
			$terms_data[] = array(
				'name' => $term->name,
				'id'   => $term->term_id,
			);
		}
	}

	return $terms_data;
}

/**
 * Generate a URL for a phone number.
 *
 * This function takes a phone number and removes any non-numeric characters such as parentheses, hyphens, dots, etc.
 * Then it constructs a tel: URL with the sanitized phone number and returns it.
 *
 * @param  string|false $phone_number (Optional) The phone number to generate the URL for. If not provided or false, an empty tel: URL is returned.
 * @return string       The URL for the phone number in the format tel:phonenumber.
 */
function skel_get_phone_url( string|false $phone_number = false ): string {
	$phone_number = str_replace( array( '(', ')', '-', '.', '|', ' ' ), '', $phone_number );

	return esc_url( 'tel:' . $phone_number );
}

/**
 * Limit WP Revisions
 */
// define( 'WP_POST_REVISIONS', 5 );.

/**
 * Adds support for excerpts to the 'page' post type
 */
add_post_type_support( 'page', 'excerpt' );

/**
 * Adds support for post thumbnails (featured images)
 */
add_theme_support( 'post-thumbnails' );

/**
 * Retrieve the content of a specified page and apply content filters.
 *
 * This function retrieves the content of the specified page by its ID using `get_post()`.
 * It then applies the content filters using `apply_filters('the_content', $content)` to ensure
 * that any necessary transformations are applied, such as shortcode processing.
 *
 * @param int  $id The ID of the page to retrieve and insert into another page.
 * @param bool $display Whether to echo the output. Default is false.
 * @return string|null The content of the specified page,
 * or null if the page with the provided ID does not exist.
 */
function skel_insert_page( int $id, bool $display = false ): ?string {
	// Retrieve the post object based on the provided ID.
	$post   = get_post( $id );
	$output = null;

	// If the post exists, retrieve its content and apply content filters.
	if ( $post ) {
		$output = apply_filters( 'the_content', $post->post_content );
	} else {
		echo esc_html( "Cannot Find Page ID: {$id}" );
	}

	if ( $display ) {
		// phpcs:ignore
		echo $output;
	}

	return $output;
}


/**
 * Extracts the src attribute value from an oembed ACF field.
 *
 * This function uses a regular expression to find the src attribute in an iframe tag
 * and returns its value. If no src attribute is found, it returns null.
 *
 * @param string $html The HTML string containing the iframe element.
 *
 * @return string|null The value of the src attribute, or null if not found.
 */
function skel_extract_oembed_src( $html ) {
	if ( ! $html ) {
		return null;
	}

	// Regular expression to match the src attribute in the iframe tag.
	$regex = '/<iframe[^>]*src=["\']([^"\']+)["\']/';

	// Check if there's a match.
	if ( preg_match( $regex, $html, $matches ) ) {
		// Return the first capture group, which is the value of the src attribute.
		$src = $matches[1];

		// Replace youtube.com with youtube-nocookie.com.
		$src = str_replace( 'youtube.com', 'youtube-nocookie.com', $src );

		// Remove ?feature=oembed from the src attribute.
		$src = preg_replace( '/\?feature=oembed/', '', $src );

		// Return the modified src attribute.
		return $src;
	}

	// Return null if no match is found.
	return null;
}

/**
 * Get Full URL.
 *
 * This function constructs a full URL based on the current request URI
 *
 * @return string full_url
 */
function skel_get_full_url() {
	// Get the current URI.
	// phpcs:ignore
	$server_uri  = $_SERVER['REQUEST_URI'];
	$server_port = $_SERVER['SERVER_PORT'];
	$server_host = $_SERVER['HTTP_HOST'];

	// Determine the protocol.
	$protocol = ( ( ! empty( $_SERVER['HTTPS'] ) && 'off' !== $_SERVER['HTTPS'] ) || 443 === $server_port ) ? 'https://' : 'http://';

	// Construct the full URL.
	$full_url = $protocol . $server_host . $server_uri;

	return $full_url;
}

/**
 * Replaces a text placeholder with an icon HTML in the provided text.
 *
 * This function searches for the placeholder '[i-play]' in the given text
 * and replaces it with the corresponding HTML for an icon. If the echo
 * parameter is set to true, it also outputs the modified text.
 *
 * @param string $text The text in which to replace the placeholder with an icon.
 * @param bool   $display Whether to echo the output. If true, the output is echoed.
 * @return string The modified text with the placeholder replaced by the icon HTML.
 */
function skel_replace_text_with_icon( string $text ) {
	// Check if the text is not falsy.
	if ( ! $text ) {
		echo '';
	}

	// Replace the placeholder '[play]' with the HTML for the icon.
	$output = str_replace( '[play]', '<i class="i-play"></i>', $text );

	if ( str_contains( $output, '[play-image]' ) ) {
		// Replace the placeholder '[play-image]' with the HTML for the icon.
		$output = str_replace( '[play-image]', '<i class="i-play w-image"></i>', $text );
	}
	// phpcs:ignore
	echo $output;
}

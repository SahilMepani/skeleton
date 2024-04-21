<?php

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
function skel_swiper_direction_class()
{
    if ( ICL_LANGUAGE_CODE == 'en' ) {
        return 'swiper';
    } else if ( ICL_LANGUAGE_CODE == 'ar' ) {
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
////////////////////////////////////////////////
function skel_direction_class()
{
    if ( ICL_LANGUAGE_CODE == 'en' ) {
        return 'dir-ltr';
    } else if ( ICL_LANGUAGE_CODE == 'ar' ) {
        return 'dir-rtl';
    }
}

/**
 * Retrieves the content of an SVG file located in the '/images/svg/' directory
 *
 * @param  string       $image The name of the SVG file (without the '.svg' extension) to retrieve.
 * @return string|false The content of the SVG file if found, or FALSE if the file does not exist or cannot be read.
 */
function svg( $image )
{
    $file = get_template_directory_uri() . '/images/svg/' . $image . '.svg';

    return file_get_contents( $file );
}

/**
 * Generates a valid YouTube video link from a given YouTube video URL.
 *
 * @param  string $url The YouTube video URL from which to extract the video ID.
 * @return string The valid YouTube video link generated from the provided URL.
 */
function skel_get_yt_link( $url )
{
    // grab the position of forward slash
    $pos = strrpos( $url, '/' );
    // use position to get substring
    $id = $pos === false ? $url : substr( $url, $pos + 1 );
    // create working youtube link
    $url = 'https://www.youtube.com/watch?v=' . $id;

    return $url;
}

/**
 * Validates and retrieves a YouTube video link from a given input string.
 *
 * @param  string       $link The input string containing a potential YouTube video link.
 * @return string|false The valid YouTube video link generated from the provided input string,
 */
function skel_get_validate_youtube_link( $link )
{
    preg_match( "#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $link, $matches );
    $link = 'https://www.youtube.com/watch?v=' . $matches[ 0 ];

    return $link;
}

/**
 * Retrieves a customized excerpt for a specified post.
 *
 * This function retrieves the excerpt of the specified post and customizes it based on the provided limit.
 * It truncates the excerpt to the specified word limit and adds ellipsis (...) if the excerpt exceeds the limit.
 * Additionally, it removes any shortcodes from the excerpt before returning it.
 *
 * @param  int    $post_id The ID of the post for which to retrieve the excerpt.
 * @param  int    $limit   The maximum number of words in the excerpt.
 * @return string The customized excerpt of the specified post.
 */
function skel_get_the_excerpt( $post_id, $limit )
{
    $excerpt = explode( ' ', get_the_excerpt( $post_id ), $limit );
    if ( count( $excerpt ) >= $limit ) {
        array_pop( $excerpt );
        $excerpt = implode( " ", $excerpt ) . '...';
    } else {
        $excerpt = implode( " ", $excerpt );
    }
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
function skel_get_text_shorter( $input, $length )
{
    // no need to trim, already shorter than trim length
    if ( strlen( $input ) <= $length ) {
        return $input;
    }
    // find last space within length
    $last_space = strrpos( substr( $input, 0, $length ), ' ' );
    if ( ! $last_space ) {
        $last_space = $length;
    }

    $trimmed_text = substr( $input, 0, $last_space );

    //add ellipses (...)
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
function skel_get_the_terms( $post_id, $taxonomy, $separator )
{
    $terms     = get_the_terms( $post_id, $taxonomy ); // returns objects array
    $ar_term   = wp_list_pluck( $terms, 'name' );
    $separator = ( $separator ) ? $separator : ' ';
    $result    = join( $separator, $ar_term ); // join all terms name

    return $result;
}

/**
 * Return terms without link and their data.
 *
 * This function retrieves the terms associated with a specified post and taxonomy
 * and returns an array containing the name and ID of each term.
 *
 * @param  int    $post_id  The ID of the post for which to retrieve the terms.
 * @param  string $taxonomy The taxonomy from which to retrieve the terms.
 * @return array  An array containing the name and ID of each term associated with the specified post.
 */
function skel_get_the_terms_data( $post_id, $taxonomy )
{
    $terms   = get_the_terms( $post_id, $taxonomy ); // Returns objects array
    $ar_term = [  ]; // Initialize an array
    $i       = 0;
    if ( $terms ) {
        foreach ( $terms as $term ) {
            $ar_term[ $i ][ 'name' ] = $term->name; // Store term name
            $ar_term[ $i ][ 'id' ]   = $term->term_id; // Store term id
            $i++;
        }
    }

    return $ar_term;
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
function skel_get_phone_url( $phone_number = false )
{
    $phone_number = str_replace( [ '(', ')', '-', '.', '|', ' ' ], '', $phone_number );

    return esc_url( 'tel:' . $phone_number );
}

// Limit WP Revisions
////////////////////////////////////////////////
// define('WP_POST_REVISIONS', 5);

// Add except to page post type
/* ========================================== */
// add_post_type_support( 'page', 'excerpt' );

// Enable featured images for all post types including custom
////////////////////////////////////////////////
// add_theme_support('post-thumbnails');

/**
 * Retrieve the content of a specified page and apply content filters.
 *
 * This function retrieves the content of the specified page by its ID using `get_post()`.
 * It then applies the content filters using `apply_filters('the_content', $content)` to ensure
 * that any necessary transformations are applied, such as shortcode processing.
 *
 * @param  int         $id The ID of the page to retrieve and insert into another page.
 * @return string|null The content of the specified page, or null if the page with the provided ID does not exist.
 */
function skel_insert_page( $id )
{
    $post = get_post( $id );
    if ( $post ) {
        $content = apply_filters( 'the_content', $post->post_content );

        return $content;
    } else {
        return null;
    }
}

// Faster WordPress
// Disable if Autoptimize is enabled
/* ========================================== */
function skel_hints()
{
    header( "link: <" . get_stylesheet_uri() . ">;" );
}
add_action( 'send_headers', 'skel_hints' );

// Load MO files
// file name should only be {locale}.mo/po
////////////////////////////////////////////////
// add_action('after_setup_theme', 'wpdocs_theme_setup');
// function wpdocs_theme_setup(){
//   load_theme_textdomain( 'skel', get_template_directory().'/lang' );
// }

/*----------  REQUIRED - Do not edit  ----------*/

/*============================================================
=            Overrides default image-URL behavior            =
============================================================*/
// http://wordpress.org/support/topic/insert-image-default-to-no-link
update_option( 'image_default_link_type', 'none' );

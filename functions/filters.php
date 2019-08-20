<?php

/*==========================================
=            Hide admin toolbar            =
==========================================*/
// add_filter('show_admin_bar', '__return_false');


/*----------  REQUIRED  ----------*/

/*===============================================================
=            Wrap oEmbed resource/video inside a div            =
===============================================================*/
add_filter('embed_oembed_html', 'my_embed_oembed_html', 99, 4);
function my_embed_oembed_html($html, $url, $attr, $post_id) {
	return '<div class="embed-responsive embed-responsive-16by9">' . $html . '</div>';
}


/*==================================================
=            Add SVG support in backend            =
==================================================*/
function wpcontent_svg_mime_type($mimes = array()) {
	$mimes['svg']  = 'image/svg+xml';
	$mimes['svgz'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'wpcontent_svg_mime_type');


/*=============================================================
=            Change Gravity Form submission loader            =
=============================================================*/
function tse_custom_gforms_spinner($src) {
	return get_stylesheet_directory_uri() . '/images/gf-submission.gif';
}
add_filter('gform_ajax_spinner_url', 'tse_custom_gforms_spinner');


/*==================================================
=            Add body classes to editor            =
==================================================*/
function tse_mce_settings($initArray) {
	$initArray['body_class'] = 'post';
	return $initArray;
}
add_filter('tiny_mce_before_init', 'tse_mce_settings');


/*===================================================
=            Add page slug to body class            =
===================================================*/
function tse_add_slug_body_class($classes) {
	global $post;
	if (isset($post)) {
		$classes[] = $post->post_type . '-' . $post->post_name;
	}
	return $classes;
}
add_filter('body_class', 'tse_add_slug_body_class');


/*============================================================
=            Prevent WP Editor from removing span            =
============================================================*/
function myextensionTinyMCE($init) {
	// Command separated string of extended elements
	$ext = 'span[id|name|class|style]';

	// Add to extended_valid_elements if it alreay exists
	if (isset($init['extended_valid_elements'])) {
		$init['extended_valid_elements'] .= ',' . $ext;
	} else {
		$init['extended_valid_elements'] = $ext;
	}

	// Super important: return $init!
	return $init;
}
add_filter('tiny_mce_before_init', 'myextensionTinyMCE');


/*===========================================
=            Custom login errors            =
===========================================*/
function no_wordpress_errors() {
	return 'Something is wrong!';
}
add_filter('login_errors', 'no_wordpress_errors');


/*=====================================================
=            Change default excerpt length            =
=====================================================*/
function tse_get_the_excerpt_length() {
	return 150; // Default Length
}
add_filter('excerpt_length', 'tse_get_the_excerpt_length');


/*==========================================================
=            Add ellipsis at the end of excerpt            =
==========================================================*/
function tse_get_the_excerpt_more( $more ) {
	return '... ';
}
add_filter('excerpt_more', 'tse_get_the_excerpt_more');


/*====================================
=            Remove Emoji            =
====================================*/
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
	add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'disable_emojis' );


/*=======================================================
=            Remove the tinymce emoji plugin            =
=======================================================*/
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

/*============================================================================
=            Remove emoji CDN hostname from DNS prefetching hints            =
============================================================================*/
function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
if ( 'dns-prefetch' == $relation_type ) {
	/** This filter is documented in wp-includes/formatting.php */
	$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );

	$urls = array_diff( $urls, array( $emoji_svg_url ) );
}
	return $urls;
}


/*=============================================
=            Remove junk from head            =
=============================================*/
remove_action('wp_head', 'rsd_link'); // remove really simple discovery link

remove_action('wp_head', 'wp_generator'); // remove wordpress version

remove_action('wp_head', 'feed_links', 2); // remove rss feed links (make sure you add them in yourself if youre using feedblitz or an rss service)
remove_action('wp_head', 'feed_links_extra', 3); // removes all extra rss feed links

remove_action('wp_head', 'index_rel_link'); // remove link to index page

remove_action('wp_head', 'wlwmanifest_link'); // remove wlwmanifest.xml (needed to support windows live writer)

remove_action('wp_head', 'start_post_rel_link', 10, 0); // remove random post link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // remove parent post link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // remove the next and previous post links
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0 );
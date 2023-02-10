<?php

// Hide admin toolbar
////////////////////////////////////////////////
add_filter( 'show_admin_bar', '__return_false' );

// Disable WordPress all sitemaps - /wp-sitemap.xml
////////////////////////////////////////////////
add_filter( 'wp_sitemaps_enabled', '__return_false' );

// Disable the customizer page and theme editor.
add_action( 'admin_menu', function() {
	$customizer_url = add_query_arg(
		'return',
		urlencode( remove_query_arg( wp_removable_query_args(), wp_unslash( $_SERVER['REQUEST_URI'] ) ) ),
		'customize.php'
	);

	remove_submenu_page( 'themes.php', $customizer_url );
	remove_submenu_page( 'themes.php', 'theme-editor.php' );
}, 999 );

// Remove jquery migrate
////////////////////////////////////////////////
// Not useful if autoptimize for JS with concatenation is enabled
// If any jquery dependent script is loaded at top then the jquery is forced by WP to load at top for e.g Gravity forms
function dequeue_jquery_migrate( &$scripts ) {
	if ( !  is_admin() ) {
		$scripts->remove( 'jquery' );
		$scripts->add( 'jquery', false, [ 'jquery-core' ], '1.10.2' );
	}
}
add_filter( 'wp_default_scripts', 'dequeue_jquery_migrate' );

////////////////////////////////////////////////
//! REQUIRED - Do not edit below
////////////////////////////////////////////////

// Wrap oEmbed resource/video inside a div
////////////////////////////////////////////////
function skel_embed_oembed_html( $html, $url, $attr, $post_id ) {
	return '<div class="embed-responsive embed-responsive-16by9">' . $html . '</div>';
}
add_filter( 'embed_oembed_html', 'skel_embed_oembed_html', 99, 4 );

// Add body classes to editor
////////////////////////////////////////////////
function skel_mce_settings( $initArray ) {
	$initArray['body_class'] = 'post';

	return $initArray;
}
add_filter( 'tiny_mce_before_init', 'skel_mce_settings' );

// Add page slug to body class
////////////////////////////////////////////////
function skel_add_slug_body_class( $classes ) {
	global $post;
	if ( isset( $post ) ) {
		$classes[] = $post->post_type . '-' . $post->post_name;
	}

	return $classes;
}
add_filter( 'body_class', 'skel_add_slug_body_class' );

// Prevent WP Editor from removing span
////////////////////////////////////////////////
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
////////////////////////////////////////////////
function skel_custom_wordpress_errors() {
	return 'Something is wrong!';
}
add_filter( 'login_errors', 'skel_custom_wordpress_errors' );

// Change default excerpt length
////////////////////////////////////////////////
function skel_get_the_excerpt_length() {
	return 150; // Default Length
}
add_filter( 'excerpt_length', 'skel_get_the_excerpt_length' );

// Add ellipsis at the end of excerpt
////////////////////////////////////////////////
function skel_get_the_excerpt_more( $more ) {
	return '... ';
}
add_filter( 'excerpt_more', 'skel_get_the_excerpt_more' );

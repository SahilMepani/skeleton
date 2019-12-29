<?php

/* ===========================================
=            Enqueue javascripts            =
=========================================== */
function tse_enqueue_scripts() {
	/* Load google fonts */
	wp_enqueue_style('google-fonts', '//fonts.googleapis.com/css?family=Montserrat&display=swap', 'all');

	/* Do not load in backend */
	if (is_admin()) return;

	/* wp_enqueue_script( 'identifier', 'url', 'dependency', version', load_in_footer_boolean ); */
	wp_enqueue_style('skeleton-style', get_stylesheet_uri(), array(), time());
	wp_enqueue_script('modernizr', get_template_directory_uri() . '/js/vendor/modernizr-3.6.0.min.js');
	wp_enqueue_script('ua-parser', get_template_directory_uri() . '/js/vendor/ua-parser-0.7.20.min.js');
	wp_enqueue_script('plugins', get_template_directory_uri() . '/js/plugins.js', array('jquery'), time(), true);
	wp_enqueue_script('custom', get_template_directory_uri() . '/js/custom.js', array('jquery', 'plugins'), time(), true);
	/* First argument is the handle where it is used */
	wp_localize_script('custom', 'localize_var', array(
		'adminUrl' => admin_url('admin-ajax.php'),
	));
}
add_action('wp_enqueue_scripts', 'tse_enqueue_scripts');


/*=================================================
=            Load custom css in editor            =
=================================================*/
// change the font styles as per project
function editor_css() {
	?>
	<style type="text/css">
		#editorcontainer #content, #wp_mce_fullscreen, textarea.wp-editor-area {
			font-family: 'Lato', sans-serif; /* this font should be imported editor-style.css */
			font-size: 16px;
			line-height: 1.7;
		}
	</style>
	<?php
}
add_action('admin_head-post.php', 'editor_css');
add_action('admin_head-post-new.php', 'editor_css');


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


/*====================================
=            Remove Emoji            =
====================================*/
function tse_disable_emojis() {
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
add_action( 'init', 'tse_disable_emojis' );


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

?>
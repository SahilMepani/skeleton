<?php

/*========================================
=            Button Shortcode            =
========================================*/
// Usage: [button link="http://google.com" target=""]Go to Google[/button]
function tse_button_primary( $atts, $content = null ) {
	extract( shortcode_atts(
		array(
			'link' => '#',
			'target' => '',
		), $atts )
	);
	return '<a class="btn btn-lg btn-black" href="'. $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
}
add_shortcode('tse_button_primary', 'tse_button_primary');


/*----------  Required  ----------*/

/*================================
=            Home URL            =
================================*/
function tse_home_url() {
	return home_url();
}
add_shortcode( 'home_url', 'tse_home_url' );


/*==============================================
=            Template directory URL            =
==============================================*/
// Usage: [tse_template_dir]
function tse_template_directory() {
	return get_template_directory_uri();
}
add_shortcode( 'tse_template_dir', 'tse_template_directory' );


/*============================================
=            Images directory URL            =
============================================*/
// Usage: [tse_image_dir]
function tse_images_directory() {
	return get_template_directory_uri() . '/images';
}
add_shortcode( 'tse_image_dir', 'tse_images_directory' );


/*===============================
=            Columns            =
===============================*/
// Usage: [tse_row]
function tse_row( $atts, $content = null ) {
	return '<div class="row">' . do_shortcode($content) . '</div>';
}
add_shortcode('tse_row', 'tse_row');

// Usage: [tse_one_half]
function tse_sm_one_half( $atts, $content = null ) {
	return '<div class="col-sm-6">' . do_shortcode($content) . '</div>';
}
add_shortcode('tse_one_half', 'tse_sm_one_half');

// Usage: [tse_one_third]
function tse_sm_one_third( $atts, $content = null ) {
	return '<div class="col-sm-4">' . do_shortcode($content) . '</div>';
}
add_shortcode('tse_one_third', 'tse_sm_one_third');

// Usage: [tse_one_fourth]
function tse_sm_one_fourth( $atts, $content = null ) {
	return '<div class="col-sm-3">' . do_shortcode($content) . '</div>';
}
add_shortcode('tse_one_fourth', 'tse_sm_one_fourth');

// Usage: [tse_md_one_half]
function tse_md_one_half( $atts, $content = null ) {
	return '<div class="col-md-6">' . do_shortcode($content) . '</div>';
}
add_shortcode('tse_md_one_half', 'tse_md_one_half');

// Usage: [tse_md_one_third]
function tse_one_third( $atts, $content = null ) {
	return '<div class="col-md-4">' . do_shortcode($content) . '</div>';
}
add_shortcode('tse_md_one_third', 'tse_md_one_third');

// Usage: [tse_md_one_fourth]
function tse_one_fourth( $atts, $content = null ) {
	return '<div class="col-md-3">' . do_shortcode($content) . '</div>';
}
add_shortcode('tse_md_one_fourth', 'tse_md_one_fourth');


/*====================================================
=            Enable shortcodes in widgets            =
====================================================*/
add_filter( 'widget_text', 'do_shortcode' );
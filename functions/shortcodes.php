<?php

/*========================================
=            Button Shortcode            =
========================================*/
// Usage: [button link="http://google.com" target=""]Go to Google[/button]
function skel_button_primary( $atts, $content = null ) {
	extract( shortcode_atts(
		array(
			'link' => '#',
			'target' => '',
		), $atts )
	);
	return '<a class="btn btn-lg btn-black" href="'. $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
}
add_shortcode('skel_button_primary', 'skel_button_primary');


/*----------  Required  ----------*/

/*================================
=            Home URL            =
================================*/
function skel_home_url() {
	return home_url();
}
add_shortcode( 'home_url', 'skel_home_url' );


/*==============================================
=            Template directory URL            =
==============================================*/
// Usage: [skel_template_dir]
function skel_template_directory() {
	return get_template_directory_uri();
}
add_shortcode( 'skel_template_dir', 'skel_template_directory' );


/*============================================
=            Images directory URL            =
============================================*/
// Usage: [skel_image_dir]
function skel_images_directory() {
	return get_template_directory_uri() . '/images';
}
add_shortcode( 'skel_image_dir', 'skel_images_directory' );


/*===============================
=            Columns            =
===============================*/
// Usage: [skel_row]
function skel_row( $atts, $content = null ) {
	return '<div class="row">' . do_shortcode($content) . '</div>';
}
add_shortcode('skel_row', 'skel_row');

// Usage: [skel_one_half]
function skel_sm_one_half( $atts, $content = null ) {
	return '<div class="col-sm-6">' . do_shortcode($content) . '</div>';
}
add_shortcode('skel_one_half', 'skel_sm_one_half');

// Usage: [skel_one_third]
function skel_sm_one_third( $atts, $content = null ) {
	return '<div class="col-sm-4">' . do_shortcode($content) . '</div>';
}
add_shortcode('skel_one_third', 'skel_sm_one_third');

// Usage: [skel_one_fourth]
function skel_sm_one_fourth( $atts, $content = null ) {
	return '<div class="col-sm-3">' . do_shortcode($content) . '</div>';
}
add_shortcode('skel_one_fourth', 'skel_sm_one_fourth');

// Usage: [skel_md_one_half]
function skel_md_one_half( $atts, $content = null ) {
	return '<div class="col-md-6">' . do_shortcode($content) . '</div>';
}
add_shortcode('skel_md_one_half', 'skel_md_one_half');

// Usage: [skel_md_one_third]
function skel_one_third( $atts, $content = null ) {
	return '<div class="col-md-4">' . do_shortcode($content) . '</div>';
}
add_shortcode('skel_md_one_third', 'skel_md_one_third');

// Usage: [skel_md_one_fourth]
function skel_one_fourth( $atts, $content = null ) {
	return '<div class="col-md-3">' . do_shortcode($content) . '</div>';
}
add_shortcode('skel_md_one_fourth', 'skel_md_one_fourth');


/*====================================================
=            Enable shortcodes in widgets            =
====================================================*/
add_filter( 'widget_text', 'do_shortcode' );
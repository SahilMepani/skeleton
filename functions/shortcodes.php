<?php

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
function tse_template_directory() {
	return get_template_directory_uri();
}
add_shortcode( 'tse_template_directory', 'tse_template_directory' );


/*============================================
=            Images directory URL            =
============================================*/
function tse_images_directory() {
	return get_template_directory_uri() . '/images';
}
add_shortcode( 'tse_images_directory', 'tse_images_directory' );


/*========================================
=            Button Shortcode            =
========================================*/
//[button link="http://google.com" target=""]Go to Google[/button]
function tse_button_primary( $atts, $content = null ) {
	extract( shortcode_atts(
		array(
			'link' => '#',
			'target' => '',
		), $atts )
	);
	return '<a class="btn btn-lg btn-primary" href="'. $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
}
add_shortcode('tse_button_primary', 'tse_button_primary');


/*======================================
=            Bootstrap Grid            =
======================================*/

/*----------  Row  ----------*/
function tse_row( $atts, $content = null ) {
	return '<div class="row">' . do_shortcode($content) . '</div>';
}
add_shortcode('tse_row', 'tse_row');

/*----------  One Half - SM  ----------*/
function tse_one_half_sm( $atts, $content = null ) {
	return '<div class="col-sm-6">' . do_shortcode($content) . '</div>';
}
add_shortcode('tse_one_half', 'tse_one_half_sm');

/*----------  One Third - SM  ----------*/
function tse_one_third_sm( $atts, $content = null ) {
	return '<div class="col-sm-4">' . do_shortcode($content) . '</div>';
}
add_shortcode('tse_one_third', 'tse_one_third_sm');

/*----------  One Fourth - SM  ----------*/
function tse_one_fourth_sm( $atts, $content = null ) {
	return '<div class="col-sm-3">' . do_shortcode($content) . '</div>';
}
add_shortcode('tse_one_fourth', 'tse_one_fourth_sm');

/*----------  One Hal - MD  ----------*/
function tse_one_half_md( $atts, $content = null ) {
	return '<div class="col-md-6">' . do_shortcode($content) . '</div>';
}
add_shortcode('tse_one_half_md', 'tse_one_half_md');

/*----------  One Third - MD  ----------*/
function tse_one_third_md( $atts, $content = null ) {
	return '<div class="col-md-4">' . do_shortcode($content) . '</div>';
}
add_shortcode('tse_one_third_md', 'tse_one_third_md');

/*----------  One Fourth - MD  ----------*/
function tse_one_fourth_md( $atts, $content = null ) {
	return '<div class="col-md-3">' . do_shortcode($content) . '</div>';
}
add_shortcode('tse_one_fourth_md', 'tse_one_fourth_md');


/*====================================================
=            Enable shortcodes in widgets            =
====================================================*/
add_filter( 'widget_text', 'do_shortcode' );
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
add_shortcode( 'template_dir', 'tse_template_directory' );


/*============================================
=            Images directory URL            =
============================================*/
function tse_images_directory() {
	return get_template_directory_uri() . '/images';
}
add_shortcode( 'tse_images_dir', 'tse_images_directory' );


/*=============================
=            Phone            =
=============================*/
function tse_phone( $atts, $content = null ) {
	return '<a href="tel:' . do_shortcode($content) .'" class="tel-link">' . do_shortcode($content) . '</a>';
}
add_shortcode('tse_phone', 'tse_phone');


/*=============================
=            Email            =
=============================*/
function tse_email( $atts, $content = null ) {
	return '<a href="mailto:' . do_shortcode($content) .'">' . do_shortcode($content) . '</a>';
}
add_shortcode('tse_email', 'tse_email');


/*=========================================
=            Heading Underline            =
=========================================*/
function h1_underline( $atts, $content = null ) {
	return '<h1 class="heading-underline">' . do_shortcode($content) . '</h1>';
}
add_shortcode('h1_underline', 'h1_underline');

function h2_underline( $atts, $content = null ) {
	return '<h2 class="heading-underline">' . do_shortcode($content) . '</h2>';
}
add_shortcode('h2_underline', 'h2_underline');

function h3_underline( $atts, $content = null ) {
	return '<h3 class="heading-underline">' . do_shortcode($content) . '</h3>';
}
add_shortcode('h3_underline', 'h3_underline');

function h4_underline( $atts, $content = null ) {
	return '<h4 class="heading-underline">' . do_shortcode($content) . '</h4>';
}
add_shortcode('h4_underline', 'h4_underline');

function h5_underline( $atts, $content = null ) {
	return '<h5 class="heading-underline">' . do_shortcode($content) . '</h5>';
}
add_shortcode('h5_underline', 'h5_underline');

function h6_underline( $atts, $content = null ) {
	return '<h6 class="heading-underline">' . do_shortcode($content) . '</h6>';
}
add_shortcode('tse_h6_underline', 'tse_h6_underline');


/*========================================
=            Button Shortcode            =
========================================*/
//[button link="http://google.com" target=""]Go to Google[/button]
function tse_button_bordered_red( $atts, $content = null ) {
	extract( shortcode_atts(
		array(
			'link' => '#',
			'target' => '',
		), $atts )
	);
	return '<a class="btn btn-lg btn-primary" href="'. $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
}
add_shortcode('tse_button_primary', 'tse_button_bordered_red');


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
add_shortcode('one_half_md', 'tse_one_half_md');

/*----------  One Third - MD  ----------*/
function tse_one_third_md( $atts, $content = null ) {
	return '<div class="col-md-4">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_third_md', 'tse_one_third_md');

/*----------  One Fourth - MD  ----------*/
function tse_one_fourth_md( $atts, $content = null ) {
	return '<div class="col-md-3">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fourth_md', 'tse_one_fourth_md');

/*====================================================
=            Enable shortcodes in widgets            =
====================================================*/
add_filter( 'widget_text', 'do_shortcode' );
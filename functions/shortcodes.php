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


/*=============================
=            Email            =
=============================*/
function email( $atts, $content = null ) {
	return '<a href="mailto:' . $content .'">' . $content . '</a>';
}
add_shortcode('email', 'email');


/*============================================
=            Images directory URL            =
============================================*/
function tse_images_directory() {
	return get_template_directory_uri() . '/images';
}
add_shortcode( 'images_dir', 'tse_images_directory' );


/*========================================
=            Button Shortcode            =
========================================*/
//[button link="http://google.com" target=""]Go to Google[/button]
function button_bordered_red( $atts, $content = null ) {
	extract( shortcode_atts(
		array(
			'link' => '#',
			'target' => '',
		), $atts )
	);
	return '<a class="btn btn-lg btn-primary" href="'. $link . '" target="' . $target . '">' . $content . '</a>';
}
add_shortcode('button_primary', 'button_bordered_red');


/*======================================
=            Bootstrap Grid            =
======================================*/
function one_half( $atts, $content = null ) {
	return '<div class="col-md-6">' . $content . '</div>';
}
add_shortcode('one_half', 'one_half');


/*====================================================
=            Enable shortcodes in widgets            =
====================================================*/
add_filter( 'widget_text', 'do_shortcode' );
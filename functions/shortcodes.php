<?php

/*================================
=            Home URL            =
================================*/
function vt_home_url() {
	return home_url();
}
add_shortcode( 'home_url', 'vt_home_url' );


/*==============================================
=            Template directory URL            =
==============================================*/
function vt_template_directory() {
	return get_template_directory_uri();
}
add_shortcode( 'template_dir', 'vt_template_directory' );


/*============================================
=            Images directory URL            =
============================================*/
function vt_images_directory() {
	return get_template_directory_uri() . '/images';
}
add_shortcode( 'images_dir', 'vt_images_directory' );


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
	return '<a class="btn btn-lg btn-primary" href="'. $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
}
add_shortcode('button_primary', 'button_primary');


/*======================================
=            Bootstrap Grid            =
======================================*/
function one_half( $atts, $content = null ) {
	return '<div class="col-md-6">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_half', 'one_half');


/*====================================================
=            Enable shortcodes in widgets            =
====================================================*/
add_filter( 'widget_text', 'do_shortcode' );
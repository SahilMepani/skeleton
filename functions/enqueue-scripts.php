<?php
/**
 * Enqueue scripts
 *
 * It will enqueue script and styles
 *
 * @package WordPress
 * @subpackage Skeleton
 * @since 1.0.0
 */
function skel_enqueue_scripts() {

	/* Load google fonts */
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Montserrat&display=swap', 'all' );

	/* Do not load in backend */
	if ( is_admin() ) {
		return;
	}

	// load jquery at bottom
	// https://wordpress.stackexchange.com/questions/173601/enqueue-core-jquery-in-the-footer
	// ths will break gravity forms on some pages, be careful.
	wp_scripts()->add_data( 'jquery', 'group', 1 );
	wp_scripts()->add_data( 'jquery-core', 'group', 1 );

	/*
	wp_enqueue_script(
	'identifier',
	'url',
	'dependency',
	'version',
	load_in_footer_boolean
	); */

	wp_enqueue_style(
		'skeleton-style',
		get_stylesheet_uri(),
		array(),
		filemtime( get_template_directory() . '/style.css' )
	);

	// load style-rtl for rtl languages.
	wp_style_add_data( 'skeleton-style', 'rtl', 'replace' );

	wp_enqueue_script(
		'skeleton-plugins',
		get_template_directory_uri() . '/js/plugins.js',
		array( 'jquery' ),
		filemtime( get_template_directory() . '/js/plugins.js' ),
		true
	);

	wp_enqueue_script(
		'skeleton-custom',
		get_template_directory_uri() . '/js/custom.js',
		array( 'jquery' ),
		filemtime( get_template_directory() . '/js/custom.js' ),
		true
	);

	// wp_enqueue_script(
	// 'match-height',
	// get_template_directory_uri() . '/js/vendor/match-height.js',
	// [ 'jquery' ],
	// filemtime( get_template_directory() . '/js/vendor/match-height.js' ),
	// true
	// );

	// localize scripts
	// wp_localize_script(
	// 'skeleton-plugins', // file name without extension where we want to use the localize_var
	// 'localize_var',
	// array(
	// 'adminUrl' => admin_url( 'admin-ajax.php' ),
	// );
}
add_action( 'wp_enqueue_scripts', 'skel_enqueue_scripts' );



/**
 * Modify script tags to add defer, async, or type="module" attributes.
 *
 * Adds defer, async, or type="module" attributes to specified script handles.
 * - 'defer' for scripts listed in the $defer array.
 * - 'async' for the 'modernizr' handle.
 * - 'type="module"' for scripts listed in the $modules array.
 *
 * This function only applies modifications on the frontend (not in the admin area).
 *
 * @param string $tag The script tag for the enqueued script.
 * @param string $handle The handle of the enqueued script.
 * @param string $src The source URL of the enqueued script.
 * @return string Modified script tag with the added attributes.
 */
function modify_script_attributes( $tag, $handle ) {
	// Arrays of script handles to modify.
	$defer        = array(
		'jquery',
		'jquery-core',
		'skel-plugins',
		'skel-custom',
	);
	$async        = array();
	$priority_low = array(
		// 'skel-lottie-player',
	);
	$priority_high = array(
		// 'skel-lottie-player',
	);
	$modules = array(
		// 'skel-lottie-player',
	);
	// Add defer attribute.
	if ( in_array( $handle, $defer, true ) ) {
		$tag = str_replace( ' src', ' defer="defer" src', $tag );
	}

	// Add async attribute.
	if ( in_array( $handle, $async, true ) ) {
		$tag = str_replace( ' src', ' async="async" src', $tag );
	}

	// Add fetchpriority attribute to low.
	if ( in_array( $handle, $priority_low, true ) ) {
		$tag = str_replace( ' src', ' fetchpriority="low" src', $tag );
	}

	// Add fetchpriority attribute to high.
	if ( in_array( $handle, $priority_high, true ) ) {
		$tag = str_replace( ' src', ' fetchpriority="high" src', $tag );
	}

	// Add type="module" attribute.
	if ( in_array( $handle, $modules, true ) ) {
		$tag = str_replace( ' type="text/javascript"', ' type="module"', $tag );
	}

	// Return the original tag if no modifications are needed.
	return $tag;
}

// Apply the filter only on the frontend.
if ( ! is_admin() ) {
	add_filter( 'script_loader_tag', 'modify_script_attributes', 10, 3 );
}

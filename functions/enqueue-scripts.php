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

if ( is_admin() ) {
	return;
}

/**
 * Enqueue and register theme scripts and styles.
 *
 * This function loads Google Fonts, theme stylesheets, and JS files.
 * It also ensures jQuery is deregistered (if needed) and styles are
 * versioned automatically using their file modification times.
 *
 * @since 1.0.0
 *
 * @return void
 */
function skel_inline_critical_css(): void {
	$critical_css_path = get_template_directory() . '/critical.css';

	if ( file_exists( $critical_css_path ) ) {
		echo '<style id="critical-css">' . file_get_contents( $critical_css_path ) . '</style>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
add_action( 'wp_head', 'skel_inline_critical_css', 1 );

/**
 * Enqueue and register theme scripts and styles.
 *
 * This function loads Google Fonts, theme stylesheets, and JS files.
 * It also ensures jQuery is deregistered (if needed) and styles are
 * versioned automatically using their file modification times.
 *
 * @since 1.0.0
 *
 * @return void
 */
function skel_enqueue_scripts(): void {

	/* Load google fonts */
	wp_enqueue_style( 'google-font', '//fonts.googleapis.com/css?family=Montserrat&display=swap', array(), '1.0.0', 'all' );

	/* Do not load in backend */
	if ( is_admin() ) {
		return;
	}

	// Remove jquery.
	wp_dequeue_script( 'jquery' );
	wp_deregister_script( 'jquery' );

	// load jquery at bottom. if you need Jquery
	// https://wordpress.stackexchange.com/questions/173601/enqueue-core-jquery-in-the-footer
	// ths will break gravity forms on some pages, be careful.
	// wp_scripts()->add_data( 'jquery', 'group', 1 );
	// wp_scripts()->add_data( 'jquery-core', 'group', 1 );.

	$critical_css_path = get_template_directory() . '/critical.css';
	$has_critical_css  = file_exists( $critical_css_path );

	wp_enqueue_style(
		'skel-style',
		get_stylesheet_uri(),
		array(),
		filemtime( get_template_directory() . '/style.css' ),
		$has_critical_css ? 'print' : 'all'
	);

	if ( $has_critical_css ) {
		wp_style_add_data( 'skel-style', 'onload', "this.media='all'" );
	}

	// load style-rtl for rtl languages.
	wp_style_add_data( 'skel-style', 'rtl', 'replace' );

	wp_enqueue_script(
		'skel-swiper',
		get_template_directory_uri() . '/js/swiper-bundle.js',
		array(),
		filemtime( get_template_directory() . '/js/swiper-bundle.js' ),
		true
	);

	wp_enqueue_script(
		'skel-plugins',
		get_template_directory_uri() . '/js/plugins.js',
		array(),
		filemtime( get_template_directory() . '/js/plugins.js' ),
		true
	);

	wp_enqueue_script(
		'skel-custom',
		get_template_directory_uri() . '/js/custom.js',
		array( 'skel-plugins' ),
		filemtime( get_template_directory() . '/js/custom.js' ),
		true
	);

	// localize scripts.
	// wp_localize_script(
	// 'skel-plugins', // file name without extension where we want to use the localize_var
	// 'localize_var',
	// array(
	// 'adminUrl' => admin_url( 'admin-ajax.php' ),
	// );.
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
	 * @return string Modified script tag with the added attributes.
	 */
function modify_script_attributes( $tag, $handle ) {
	// Arrays of script handles to modify.
	$defer = array(
		// uncomment for production as it doesn't work with Query monitor
		// 'jquery',
		// 'jquery-core',
		// .
		'skel-swiper',
		'skel-plugins',
		'skel-custom',
	);
	$async = array(
	// 'skel-lottie-player',
	);
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

<?php
function skel_enqueue_scripts() {

	/* Load google fonts */
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Montserrat&display=swap', 'all' );

	/* Do not load in backend */
	if ( is_admin() ) {
		return;
	}

	// load jquery at bottom
	// https://wordpress.stackexchange.com/questions/173601/enqueue-core-jquery-in-the-footer
	// ths will break gravity forms on some pages, be careful
	wp_scripts()->add_data( 'jquery', 'group', 1 );
	wp_scripts()->add_data( 'jquery-core', 'group', 1 );

	/* wp_enqueue_script(
	'identifier',
	'url',
	'dependency',
	'version',
	load_in_footer_boolean
	); */

	wp_enqueue_style(
		'skeleton-style',
		get_stylesheet_uri(),
		[],
		filemtime( get_template_directory() . '/style.css' )
	);

	// load style-rtl for rtl languages
	wp_style_add_data( 'skeleton-style', 'rtl', 'replace' );

	wp_enqueue_script(
		'skeleton-plugins',
		get_template_directory_uri() . '/js/plugins.js',
		[ 'jquery' ],
		filemtime( get_template_directory() . '/js/plugins.js' ),
		true
	);

}
add_action( 'wp_enqueue_scripts', 'skel_enqueue_scripts' );


/**
 * Add defer attribute to the scripts to set the resource priority to low
 * @param string $tag
 * @param string $handle
 * @param string $src
 *
 * @return $tag
 */
function skel_defer_scripts( string $tag, string $handle, string $src ) {
	$defer = [
		// 'jquery',
		// 'jquery-core',
		'plugins',
		'match-height'
	];
	if ( in_array( $handle, $defer ) ) {
		return '<script src="' . $src . '" defer="defer" type="text/javascript"></script>' . "\n";
	}

	return $tag;
}
/* Do not load in backend */
if ( ! is_admin() ) {
	add_filter( 'script_loader_tag', 'skel_defer_scripts', 10, 3 );
}

<?php //phpcs:ignore file comment
/**
 * Remove Gutenberg Block Library CSS from loading on the frontend
 *
 * @return void
 */
function skel_remove_wp_block_library_css(): void {
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );

	// Dequeue the styles with IDs 'global-styles' and 'classic-theme-styles'.
	wp_dequeue_style( 'global-styles' );
	wp_dequeue_style( 'classic-theme-styles' );
}
add_action( 'wp_enqueue_scripts', 'skel_remove_wp_block_library_css', 100 );

/**
 * Remove jQuery from the front end.
 * Re-enable conditionally (e.g. for Gravity Forms) by guarding the dequeue calls.
 */
function skel_dequeue_jquery(): void {
	if ( is_admin() ) {
		return;
	}
	wp_dequeue_script( 'jquery' );
	wp_deregister_script( 'jquery' );
}
add_action( 'wp_enqueue_scripts', 'skel_dequeue_jquery' );

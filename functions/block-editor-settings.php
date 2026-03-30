<?php
/**
 * Block editor settings
 *
 * @package WordPress
 * @subpackage Skeleton
 * @since 1.0.0
 */

/**
 * When set, users will be restricted to the default sizes provided
 *  in the block editor or the sizes provided via the
 * editor-font-sizes theme support setting.
 */
add_theme_support( 'disable-custom-font-sizes' );

/**
 * This flag will make sure users are only able to choose colors from
 * the editor-color-palette the theme provided or from the editor default
 * colors if the theme did not provide one.
 */
add_theme_support( 'disable-custom-colors' );

/**
 * Enable responsive embedded content
 */
add_theme_support( 'responsive-embeds' );

/**
 * Enqueue editor styles
 *
 * @return void
 */
function skel_editor_css(): void {
	wp_enqueue_style(
		'skel-editor-css',
		get_stylesheet_directory_uri() . '/assets/css/editor.css',
		array(),
		filemtime( get_stylesheet_directory() . '/assets/css/editor.css' )
	);
}
add_action( 'enqueue_block_editor_assets', 'skel_editor_css' );

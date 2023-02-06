<?php

// When set, users will be restricted to the default sizes provided in the block editor or the sizes provided via the editor-font-sizes theme support setting.
add_theme_support( 'disable-custom-font-sizes' );

// This flag will make sure users are only able to choose colors from the editor-color-palette the theme provided or from the editor default colors if the theme did not provide one.
add_theme_support( 'disable-custom-colors' );

// -- Enable editor styles
// add_theme_support( 'editor-styles' );

// -- Enable responsive embedded content
add_theme_support( 'responsive-embeds' );

// Add Google Fonts - Before using check if fonts are already loading or not in the backend
// add_editor_style( 'https://fonts.googleapis.com/css?family=Roboto+Slab' );

// -- Remove Gutenberg Block Library CSS from loading on the frontend
function skel_remove_wp_block_library_css() {
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
}
add_action( 'wp_enqueue_scripts', 'skel_remove_wp_block_library_css' );

?>

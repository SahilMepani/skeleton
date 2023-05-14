<?php
/**
 * Configures custom theme support.
 *
 * @package Core
 * @subpackage Theme Support
 * @since 1.0.0
 */

/**
 * Sets the support for WordPress core features.
 *
 * @since 1.0.0
 * @internal
 */
function core_set_theme_support() {

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Disable custom colors (color-wheel) in the editor.
	add_theme_support( 'disable-custom-colors' );

	// Disable custom font sizes in the editor.
	add_theme_support( 'disable-custom-font-sizes' );

	// Disable support for menus.
	remove_theme_support( 'menus' );

	// Enable RSS support.
	add_theme_support( 'automatic-feed-links' );
}

add_action( 'core_after_setup', 'core_set_theme_support' );

// Disable default Block Editor blocks.
add_filter( 'allowed_block_types_all', function() {
	$block_types = WP_Block_Type_Registry::get_instance()->get_all_registered();

	return array_values(
		array_filter( array_keys( $block_types ), function( $block ) {
			return strpos( $block, 'acf/' ) === 0;
		})
	);
});

// Disable the customizer page and theme editor.
add_action( 'admin_menu', function() {
	$customizer_url = add_query_arg(
		'return',
		urlencode( remove_query_arg( wp_removable_query_args(), wp_unslash( $_SERVER['REQUEST_URI'] ) ) ),
		'customize.php'
	);

	remove_submenu_page( 'themes.php', $customizer_url );
	remove_submenu_page( 'themes.php', 'theme-editor.php' );
}, 999 );

// Enable duplicating of all post types.
add_action( 'admin_init', function() {
	$post_types = core_get_post_types( false, true );
	update_option( 'duplicate_post_types_enabled', $post_types );
});

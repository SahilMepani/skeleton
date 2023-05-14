<?php
/**
 * Additional WordPress configuration and assets.
 *
 * @package Core
 * @subpackage WordPress
 * @since 1.0.0
 */

/**
 * Replaces the global post information in 404 pages.
 *
 * @since 2.4.0
 */
function core_wp_setup_not_found() {
	if ( ! is_404() ) return;

	$default_pages = get_field( 'default_pages', 'option' );

	if ( isset( $default_pages['not_found'] ) && $default_pages['not_found'] ) {
		$GLOBALS['post'] = get_post( $default_pages['not_found'] );
	}
}

add_action( 'wp', 'core_wp_setup_not_found' );

/**
 * Updates the default WordPress media sizes to match the current website standards.
 *
 * @since 1.0.0
 * @internal
 */
function core_update_media_sizes() {
	$media_sizes = core_get_option( 'media-sizes' );

	$default_media_sizes = [
		'thumbnail' => 600,
		'medium' => 1280,
		'large' => 1920
	];

	if ( ! $media_sizes ) $media_sizes = $default_media_sizes;

	// Check for invalid format.
	$invalid_sizes = 0;

	foreach ( $media_sizes as $size_name => $size ) {
		if (
			( is_array( $size ) && ( count( $size ) !== 2 || array_filter( $size, 'is_int' ) !== $size ) ) ||
			( ! is_array( $size ) && ! is_int( $size ) )
		) {
			core_add_notice(
				'error',
				'Invalid custom media size format: `' . $size_name . '` = `' . json_encode( $size ) . '`',
				core_docs( 'media-sizes' )
			);

			$invalid_sizes += 1;
		}
	}

	if ( $invalid_sizes > 0 ) return;

	/**
	 * Whether or not thumbnails have been updated in the core before.
	 *
	 * @var boolean
	 */
	$thumbnails_updated_before = get_option( 'core_thumbnails_updated' );

	/**
	 * Whether or not thumbnails match the current media size settings.
	 *
	 * @var boolean
	 */
	$should_regenerate = get_option( 'core_should_regenerate_thumbnails' ) ?? false;

	if ( $should_regenerate && isset( $_GET['dismiss-regenerate'] ) && $_GET['dismiss-regenerate'] == 1 ) {
		$should_regenerate = false;
	}

	// Update media sizes.
	foreach ( $media_sizes as $size_name => $size ) {
		$size_w = is_array( $size ) ? $size[0] : $size;
		$size_h = is_array( $size ) ? $size[1] : $size;

		$prev_size_w = get_option( "{$size_name}_size_w" );
		$prev_size_h = get_option( "{$size_name}_size_h" );

		if ( $prev_size_w != $size_w || $prev_size_h != $size_h ) {
			$should_regenerate = true;

			update_option( "{$size_name}_crop", false );
			update_option( "{$size_name}_size_w", $size_w );
			update_option( "{$size_name}_size_h", $size_h );
		}
	}

	if ( $should_regenerate && $thumbnails_updated_before ) {
		core_add_notice( 'info', 'Suggested action: *Regenerate Thumbnails*', [
			"Custom media sizes were updated in the core. It's important to " . core_admin( 'tools.php?page=regenerate-thumbnails&core-notices=0&dismiss-regenerate=1', 'regenerate media thumbnails' ) . " for this change to take effect.",
			core_docs( 'media-sizes' )
		]);
	}

	// Finish.
	if ( ! $thumbnails_updated_before ) update_option( 'core_thumbnails_updated', 1 );
	update_option( 'core_should_regenerate_thumbnails', $should_regenerate );
}

add_action( 'core_after_setup', 'core_update_media_sizes' );

/**
 * Updates the default permalink structure.
 *
 * Runs only once per install, usually after the theme is activated for the first time.
 *
 * @since 1.0.0
 * @internal
 */
function core_update_permalinks() {
	$already_updated = get_option( 'core_permalinks_updated' );
	if ( $already_updated ) return;

	update_option( 'permalink_structure', '/%postname%/' );
	update_option( 'core_permalinks_updated', 1 );

	core_flush_rewrite_rules();
}

add_action( 'core_after_setup', 'core_update_permalinks' );

/**
 * Flushes the WordPress rewrite rules.
 *
 * @since 1.0.0
 * @internal
 */
function core_flush_rewrite_rules() {
	flush_rewrite_rules();

	// Inform the user.
	core_add_notice( 'info', 'Your permalink structure was updated.', [
		'This action is only run once. Check the updated value ' . core_admin( 'options-permalink.php', 'here' ) . '.',
		core_docs( 'initial-setup' )
	]);
}

/**
 * Implements custom ordering for the WordPress menu.
 *
 * @since 2.11.0
 * @internal
 *
 * @param array $menu_order
 * @return array The reordered menu.
 */
function core_customize_menu_order( $menu_order ) {
	$new_order = [
		1 => 'index.php',
		2 => 'sep-1',
		10 => 'edit.php?post_type=page'
	];

	// * Custom Post Types
	$custom_post_types = array_values(
		array_filter( $menu_order, function( $item ) {
			return (
				strpos( $item, 'edit.php?post_type=' ) === 0 &&
				$item !== 'edit.php?post_type=page' &&
				$item !== 'edit.php?post_type=acf-field-group'
			);
		})
	);

	sort( $custom_post_types );

	foreach ( $custom_post_types as $index => $item ) {
		$new_order[ 10 + ( $index + 1 ) ] = $item;
	}

	// Separator
	$new_order[20] = 'sep-2';

	// * Options Pages
	$options_pages = array_values(
		array_filter( $menu_order, function( $item ) {
			return strpos( $item, 'core-options-' ) === 0;
		})
	);

	sort( $options_pages );

	foreach ( $options_pages as $index => $item ) {
		$new_order[ 21 + $index ] = $item;
	}

	// Separator
	$new_order[40] = 'sep-3';

	// * General Configuration
	$new_order[41] = 'users.php';
	$new_order[42] = 'gf_edit_forms';
	$new_order[43] = 'upload.php';

	// Separator
	$new_order[50] = 'sep-4';

	// ? Other Menu Items (added at the end of this function)

	// Separator
	$new_order[80] = 'sep-5';

	// * Advanced Configuration
	$new_order[81] = 'edit.php?post_type=acf-field-group';
	$new_order[82] = 'themes.php';
	$new_order[83] = 'plugins.php';
	$new_order[84] = 'tools.php';
	$new_order[85] = 'options-general.php';
	$new_order[85] = 'options-general.php';

	/**
	 * Add other menu items between General and Advanced configuration.
	 * This steps needs to be here, because now we have all the expected menus already in place.
	 */
	$other_menus = array_values(
		array_filter( $menu_order, function( $item ) use( $new_order ) {
			return ! in_array( $item, $new_order );
		})
	);

	foreach ( $other_menus as $index => $item ) {
		$new_order[ 50 + ( $index + 1 ) ] = $item;
	}

	// Finish
	return $new_order;
}

add_filter( 'menu_order', 'core_customize_menu_order' );
add_filter( 'custom_menu_order', '__return_true' );

/**
 * Adds separators between the admin menu sections.
 *
 * @since 2.11.0
 * @internal
 */
function core_customize_menu_separators() {
	global $menu;

	// Remove default separators.
	foreach ( $menu as $index => $item ) {
		if ( $item[4] === 'wp-menu-separator' ) {
			unset( $menu[ $index ] );
		}
	}

	// Add new separators.
	$x = 0;
	while ( $x++ < 5 ) {
		$menu[ $x + 150 ] = [ '', 'read', "sep-$x", '', 'wp-menu-separator' ];
	}
}

add_action( 'admin_menu', 'core_customize_menu_separators' );

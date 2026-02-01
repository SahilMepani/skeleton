<?php
/**
 * ACF Block Helpers
 *
 * @package Skeleton
 * @subpackage ACF
 */

/**
 * Get ACF block paths.
 *
 * @return array
 */
function skel_get_acf_block_paths() {
	return array(
		'php'        => get_template_directory() . '/acf/blocks/',
		'js'         => get_template_directory() . '/src/js/custom/acf-blocks/',
		'sass'       => get_template_directory() . '/src/sass/partials/acf-blocks/',
		'json'       => get_template_directory() . '/acf/field-groups/',
		'style_scss' => get_template_directory() . '/src/sass/style.scss',
	);
}

/**
 * Get block slug from name.
 *
 * @param string $block_name Block name.
 * @return string
 */
function skel_get_block_slug( $block_name ) {
	return sanitize_title( $block_name );
}

/**
 * Handle preview image rendering for ACF blocks.
 */
function skel_render_block_preview( array $block ): bool {
	if ( isset( $block['data']['preview_image'] ) ) {
		echo '<img src="' . esc_url( $block['data']['preview_image'] ) . '" style="width:100%; height:auto;">';
		return true;
	}
	return false;
}

/**
 * Check if block should display.
 */
function skel_should_display_block(): bool {
	return 'on' === get_field( 'display' );
}

/**
 * Get developer options for block.
 */
function skel_get_block_developer_options(): array {
	$display        = get_field( 'display' );
	$spacing        = get_field( 'spacing' );
	$spacing_top    = $spacing['top']['spacing_top'] ?? '';
	$spacing_bottom = $spacing['bottom']['spacing_bottom'] ?? '';

	$spacing_top_custom    = '';
	$spacing_bottom_custom = '';

	if ( 'custom' === $spacing_top ) {
		$spacing_top_custom = "--spacing-top-custom: {$spacing['top']['custom_value_top']};";
		$spacing_top        = 'spacing-top-custom';
	}
	if ( 'custom' === $spacing_bottom ) {
		$spacing_bottom_custom = "--spacing-bottom-custom: {$spacing['bottom']['custom_value_bottom']};";
		$spacing_bottom        = 'spacing-bottom-custom';
	}

	return array(
		'display_class'         => 'on' === $display ? 'section-display-on' : 'section-display-off',
		'spacing_top'           => $spacing_top,
		'spacing_bottom'        => $spacing_bottom,
		'spacing_top_custom'    => $spacing_top_custom,
		'spacing_bottom_custom' => $spacing_bottom_custom,
		'custom_classes'        => get_field( 'custom_classes' ),
		'custom_css'            => get_field( 'custom_css' ),
		'unique_id'             => get_field( 'unique_id' ),
	);
}

/**
 * Get background image CSS string.
 */
function skel_get_background_image_css( $image_id, string $size = 'medium_crop' ): string {
	if ( $image_id ) {
		$image_url = wp_get_attachment_image_url( $image_id, $size );
	} else {
		$image_url = get_template_directory_uri() . '/images/placeholder.png';
	}
	return 'background-image: url(' . esc_url( $image_url ) . ');';
}

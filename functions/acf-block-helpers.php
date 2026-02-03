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
		'blocks' => get_template_directory() . '/blocks/',
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
		$image_url = get_template_directory_uri() . '/assets/images/placeholder.png';
	}
	return 'background-image: url(' . esc_url( $image_url ) . ');';
}

/**
 * Render block section opening tag with developer options.
 *
 * @param array  $dev_options   Developer options array from skel_get_block_developer_options().
 * @param string $section_class Additional section class names.
 */
function skel_render_block_section_open( array $dev_options, string $section_class = '' ): void {
	printf(
		'<section class="%s" style="%s" id="%s">',
		esc_attr( trim( "{$section_class} section {$dev_options['display_class']} {$dev_options['spacing_top']} {$dev_options['spacing_bottom']} {$dev_options['custom_classes']}" ) ),
		esc_attr( trim( "{$dev_options['spacing_top_custom']} {$dev_options['spacing_bottom_custom']} {$dev_options['custom_css']}" ) ),
		esc_attr( $dev_options['unique_id'] )
	);
}

/**
 * Render ACF link field as HTML anchor tag.
 *
 * @param array  $link         ACF link field array.
 * @param string $classes      CSS classes for the link. Default 'btn'.
 * @param string $default_text Default text if link title is empty.
 */
function skel_render_acf_link( $link, string $classes = 'btn', string $default_text = '' ): void {
	if ( ! is_array( $link ) || empty( $link['url'] ) ) {
		return;
	}
	printf(
		'<a href="%s" target="%s" class="%s">%s</a>',
		esc_url( $link['url'] ),
		esc_attr( $link['target'] ?? '_self' ),
		esc_attr( $classes ),
		'<span>' . esc_html( $link['title'] ?: $default_text ) . '</span>'
	);
}

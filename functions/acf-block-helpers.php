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

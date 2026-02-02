<?php
/**
 * Generator for Block SCSS files.
 *
 * @package Skeleton
 */

/**
 * Create SCSS file for a block.
 *
 * @param string $sanitize_title The sanitized block title.
 * @param string $sass_directory The directory for SCSS files.
 * @return void
 */
function skel_create_block_scss( $sanitize_title, $sass_directory ) {
	$wp_filesystem = skel_init_filesystem();

	$sass_file_path = $sass_directory . '_' . $sanitize_title . '.scss';

	if ( ! file_exists( $sass_file_path ) ) {
		$sass_content = '.' . $sanitize_title . '-section {' . "\r\n\r\n" . '}';
		if ( ! $wp_filesystem->put_contents( $sass_file_path, $sass_content, FS_CHMOD_FILE ) ) {
			echo 'Error saving SASS file for ' . esc_html( $sanitize_title ) . '!';
		}
	}
}

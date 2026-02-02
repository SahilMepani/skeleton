<?php
/**
 * Generator for Block JS files.
 *
 * @package Skeleton
 */

/**
 * Create JS file for a block.
 *
 * @param string $block_name     The original block name.
 * @param string $sanitize_title The sanitized block title.
 * @param string $js_directory   The directory for JS files.
 * @param array  $blocks_with_js Array of blocks that require JS.
 * @return void
 */
function skel_create_block_js( $block_name, $sanitize_title, $js_directory, $blocks_with_js ) {
	$wp_filesystem = skel_init_filesystem();

	$js_file_path = $js_directory . $sanitize_title . '.js';

	if ( in_array( $block_name, $blocks_with_js, true ) ) {
		if ( ! file_exists( $js_file_path ) ) {
			if ( ! $wp_filesystem->put_contents( $js_file_path, '', FS_CHMOD_FILE ) ) {
				echo 'Error saving JS file for ' . esc_html( $block_name ) . '!';
			}
		}
	}
}

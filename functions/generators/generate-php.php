<?php
/**
 * Generator for Block PHP files.
 *
 * @package Skeleton
 */

/**
 * Create PHP file for a block.
 *
 * @param string $block_name     The original block name.
 * @param string $sanitize_title The sanitized block title.
 * @param string $php_directory  The directory for PHP files.
 * @param string $template_file  The path to the template file.
 * @return void
 */
function skel_create_block_php( $block_name, $sanitize_title, $php_directory, $template_file ) {
	$wp_filesystem = skel_init_filesystem();

	$php_file_path = $php_directory . $sanitize_title . '.php';

	if ( ! file_exists( $php_file_path ) ) {
		if ( file_exists( $template_file ) ) {
			$php_content = $wp_filesystem->get_contents( $template_file );
			if ( false !== $php_content ) {
				$php_content = str_replace( 'blank-section', $sanitize_title . '-section', $php_content );
				$php_content = str_replace( 'Blank ACF block', $block_name . ' ACF Block', $php_content );

				if ( ! $wp_filesystem->put_contents( $php_file_path, $php_content, FS_CHMOD_FILE ) ) {
					echo 'Error saving PHP file for ' . esc_html( $block_name ) . '!';
				}
			} else {
				echo 'Error reading template file!';
			}
		} else {
			echo 'Template file does not exist!';
		}
	}
}

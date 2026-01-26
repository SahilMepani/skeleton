<?php
/**
 * Generator for Block JSON files.
 *
 * @package Skeleton
 */

/**
 * Create JSON file for a block.
 *
 * @param string $block_name         The original block name.
 * @param string $sanitize_title     The sanitized block title.
 * @param string $json_directory     The directory for JSON files.
 * @param string $json_template_file The path to the JSON template file.
 * @return void
 */
function skel_create_block_json( $block_name, $sanitize_title, $json_directory, $json_template_file ) {
	global $wp_filesystem;

	if ( ! function_exists( 'WP_Filesystem' ) ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
	}
	WP_Filesystem();

	$json_file_path = $json_directory . $sanitize_title . '.json';

	if ( ! file_exists( $json_file_path ) ) {
		if ( file_exists( $json_template_file ) ) {
			$json_content = $wp_filesystem->get_contents( $json_template_file );
			if ( false !== $json_content ) {
				$json_content = str_replace( '{{title}}', $block_name, $json_content );
				$json_content = str_replace( '{{slug_snake}}', str_replace( '-', '_', $sanitize_title ), $json_content );
				$json_content = str_replace( '"active": false,', '', $json_content );

				if ( ! $wp_filesystem->put_contents( $json_file_path, $json_content, FS_CHMOD_FILE ) ) {
					echo 'Error saving JSON file for ' . esc_html( $block_name ) . '!';
				}
			} else {
				echo 'Error reading JSON template file!';
			}
		} else {
			echo 'JSON Template file does not exist!';
		}
	}
}

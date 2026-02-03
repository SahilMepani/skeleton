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
 * @param string $slug               The sanitized block slug.
 * @param string $block_dir          The block directory path.
 * @param string $json_template_file The path to the JSON template file.
 * @return void
 */
function skel_create_block_json( $block_name, $slug, $block_dir, $json_template_file ) {
	$wp_filesystem = skel_init_filesystem();

	$json_file_path = $block_dir . $slug . '.json';

	if ( ! file_exists( $json_file_path ) ) {
		if ( file_exists( $json_template_file ) ) {
			$json_content = $wp_filesystem->get_contents( $json_template_file );
			if ( false !== $json_content ) {
				$json_content = str_replace( '{{title}}', $block_name, $json_content );
				$json_content = str_replace( '{{slug_snake}}', str_replace( '-', '_', $slug ), $json_content );
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

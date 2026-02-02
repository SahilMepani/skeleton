<?php
/**
 * Helper function to create .php files for ACF blocks.
 *
 * @package WordPress
 * @subpackage Skeleton
 * @since 1.0.0
 */

// Require the generator files.
require_once get_template_directory() . '/functions/generators/generate-php.php';
require_once get_template_directory() . '/functions/generators/generate-js.php';
require_once get_template_directory() . '/functions/generators/generate-scss.php';
require_once get_template_directory() . '/functions/generators/generate-json.php';
require_once get_template_directory() . '/functions/generators/update-style.php';

/**
 * This function checks the $block_types values, sanitizes the block names,
 * and creates a new .php file inside the acf-blocks folder in the root directory
 * with the corresponding name. Only creates the file if it doesn't exist.
 *
 * @param array $block_types An array of block names.
 * @param array $blocks_with_js An array of block names using js.
 * @return void
 */
function skel_create_acf_block_files( array $block_types, array $blocks_with_js = array() ): void {
	// Initialize the WordPress filesystem API.
	skel_init_filesystem();

	// Define the directory where the block files will be created.
	// Get block paths.
	$paths = skel_get_acf_block_paths();

	// Define the directory where the block files will be created.
	$php_directory      = $paths['php'];
	$js_directory       = $paths['js'];
	$sass_directory     = $paths['sass'];
	$style_file         = $paths['style_scss'];
	$template_file      = $php_directory . 'blank.php';
	$json_directory     = $paths['json'];
	$json_template_file = $json_directory . 'blank.json';

	// Initialize an array to hold the new import statements.
	$sass_imports = array();

	// Loop through each block type.
	foreach ( $block_types as $block ) {
		// Sanitize the block name by replacing spaces with dashes.
		// Sanitize the block name by replacing spaces with dashes.
		$sanitize_title = skel_get_block_slug( $block );

		// Generate PHP file.
		skel_create_block_php( $block, $sanitize_title, $php_directory, $template_file );

		// Generate JS file.
		skel_create_block_js( $block, $sanitize_title, $js_directory, $blocks_with_js );

		// Generate SCSS file.
		skel_create_block_scss( $sanitize_title, $sass_directory );

		// Add the import statement to the array.
		$sass_imports[] = "@import 'partials/acf-blocks/" . $sanitize_title . "';";

		// Generate JSON file.
		skel_create_block_json( $block, $sanitize_title, $json_directory, $json_template_file );
	}

	// Update style.scss.
	skel_update_style_scss( $style_file, $sass_imports );
}

<?php
/**
 * Helper function to create .php files for ACF blocks.
 *
 * This function checks the $block_types values, sanitizes the block names,
 * and creates a new .php file inside the acf-blocks folder in the root directory
 * with the corresponding name. Only creates the file if it doesn't exist.
 *
 * @param array $block_types An array of block names.
 * @return void
 */
function skel_create_acf_block_files( array $block_types ): void {
	global $wp_filesystem;

	// Define the directory where the block files will be created.
	$php_directory  = get_template_directory() . '/acf-blocks/';
	$js_directory   = get_template_directory() . '/src/js/custom/acf-blocks/';
	$sass_directory = get_template_directory() . '/src/sass/partials/acf-blocks/';
	$style_file     = get_template_directory() . '/src/sass/style.scss';
	$template_file  = $php_directory . 'blank.php';

	// Initialize an array to hold the new import statements.
	$sass_imports = array();

	// Loop through each block type.
	foreach ( $block_types as $block ) {
		// Sanitize the block name by replacing spaces with dashes.
		$sanitize_title = sanitize_title( $block );

		// Define the full path to the block files.
		$php_file_path  = $php_directory . $sanitize_title . '.php';
		$js_file_path   = $js_directory . $sanitize_title . '.js';
		$sass_file_path = $sass_directory . '_' . $sanitize_title . '.scss';

		// Check if the PHP file already exists. If not, create it.
		if ( ! file_exists( $php_file_path ) ) {
			// Check if the template file exists.
			if ( file_exists( $template_file ) ) {
				// Get the content of the template file.
				$php_content = $wp_filesystem->get_contents( $template_file );
				if ( false !== $php_content ) {
					// Replace the placeholder string with the sanitized block name.
					$php_content = str_replace( 'blank-section', $sanitize_title . '-section', $php_content );
					$php_content = str_replace( 'Blank ACF block', $block . ' ACF Block', $php_content );
					// Create the new PHP file with the modified content.
					if ( ! $wp_filesystem->put_contents( $php_file_path, $php_content, FS_CHMOD_FILE ) ) {
						echo 'Error saving PHP file!';
					}
				} else {
					echo 'Error reading template file!';
				}
			} else {
				echo 'Template file does not exist!';
			}
		}

		// Check if the JS file already exists. If not, create it.
		if ( ! file_exists( $js_file_path ) ) {
			// Create the file and add a basic JS template.
			if ( ! $wp_filesystem->put_contents( $js_file_path, '', FS_CHMOD_FILE ) ) {
				echo 'error saving JS file!';
			}
		}

		// Check if the SASS file already exists. If not, create it.
		if ( ! file_exists( $sass_file_path ) ) {
			$sass_content = '.' . $sanitize_title . '-section {' . "\r\n\r\n" . '}';
			// Create the new SASS file with the modified content.
			if ( ! $wp_filesystem->put_contents( $sass_file_path, $sass_content, FS_CHMOD_FILE ) ) {
				echo 'Error saving SASS file!';
			}
		}

		// Add the import statement to the array.
		$sass_imports[] = "@import 'partials/acf-blocks/" . $sanitize_title . "';";

		// Update the style.scss file.
		update_style_scss( $style_file, $sass_imports );
	}
}

/**
 * Update the style.scss file with new ACF block imports.
 *
 * This function will find the section between // ACF Blocks and // END ACF Blocks
 * in the style.scss file and replace it with new import statements.
 *
 * @param string $style_file Path to the style.scss file.
 * @param array  $sass_imports Array of new import statements to add.
 * @return void
 */
function update_style_scss( string $style_file, array $sass_imports ): void {
	global $wp_filesystem;

	// Read the current content of the style.scss file.
	$styles_content = $wp_filesystem->get_contents( $style_file );

	if ( false === $styles_content ) {
		echo 'Error reading style.scss file!';
		return;
	}

	// Define the pattern to match the block between // ACF Blocks and // END ACF Blocks.
	$pattern = '/(\/\/ ACF Blocks)(.*?)(\/\/ END ACF Blocks)/s';

	// Create the new block content with the import statements.
	$new_block = "// ACF Blocks\n" . implode( "\n", $sass_imports ) . "\n\n// END ACF Blocks";

	// Replace the existing block with the new one.
	$updated_content = preg_replace( $pattern, $new_block, $styles_content );

	// Write the updated content back to the style.scss file.
	if ( ! $wp_filesystem->put_contents( $style_file, $updated_content, FS_CHMOD_FILE ) ) {
		echo 'Error updating style.scss file!';
	}
}

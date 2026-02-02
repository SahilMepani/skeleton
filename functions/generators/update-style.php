<?php
/**
 * Helper to update style.scss.
 *
 * @package Skeleton
 */

/**
 * Update the style.scss file with new ACF block imports.
 *
 * This function will find the section between // ACF Blocks and // END ACF Blocks
 * in the style.scss file and replace it with new import statements.
 *
 * @param string $style_file   Path to the style.scss file.
 * @param array  $sass_imports Array of new import statements to add.
 * @return void
 */
function skel_update_style_scss( $style_file, $sass_imports ) {
	$wp_filesystem = skel_init_filesystem();

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

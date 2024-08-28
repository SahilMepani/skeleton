<?php
/**
 * Helper function to delete unnecessary ACF block files.
 *
 * This function checks the existing files against the $block_types values,
 * and deletes any files that are no longer needed, except for the `blank.php` file.
 *
 * @param array $block_types An array of current block names.
 * @return void
 */
function skel_delete_unwanted_acf_block_files( array $block_types ): void {
	global $wp_filesystem;

	// Define the directories where the block files are located.
	$php_directory  = get_template_directory() . '/acf-blocks/';
	$js_directory   = get_template_directory() . '/src/js/custom/acf-blocks/';
	$sass_directory = get_template_directory() . '/src/sass/partials/acf-blocks/';

	// Get a list of existing PHP files.
	$existing_php_files = glob( $php_directory . '*.php' );
	// Get a list of existing JS files.
	$existing_js_files = glob( $js_directory . '*.js' );
	// Get a list of existing SASS files.
	$existing_sass_files = glob( $sass_directory . '*.scss' );

	// Create arrays of filenames from the block types.
	$current_files = array_map(
		function ( $block ) {
			return sanitize_title( $block );
		},
		$block_types
	);

	// Remove the '.php', '.js', and '.scss' extensions for comparison.
	$current_php_files  = array_map(
		function ( $filename ) use ( $php_directory ) {
			return $php_directory . $filename . '.php';
		},
		$current_files
	);
	$current_js_files   = array_map(
		function ( $filename ) use ( $js_directory ) {
			return $js_directory . $filename . '.js';
		},
		$current_files
	);
	$current_sass_files = array_map(
		function ( $filename ) use ( $sass_directory ) {
			return $sass_directory . '_' . $filename . '.scss';
		},
		$current_files
	);

	// Exclude 'blank.php' from deletion.
	$exclude_php_file = $php_directory . 'blank.php';

	// Delete PHP files that are no longer needed, excluding `blank.php`.
	foreach ( $existing_php_files as $file ) {
		if ( $file !== $exclude_php_file && ! in_array( $file, $current_php_files ) ) {
			if ( ! $wp_filesystem->delete( $file, false ) ) {
				echo "Error deleting PHP file: $file!";
			}
		}
	}

	// Delete JS files that are no longer needed.
	foreach ( $existing_js_files as $file ) {
		if ( ! in_array( $file, $current_js_files ) ) {
			if ( ! $wp_filesystem->delete( $file, false ) ) {
				echo "Error deleting JS file: $file!";
			}
		}
	}

	// Delete SASS files that are no longer needed.
	foreach ( $existing_sass_files as $file ) {
		if ( ! in_array( $file, $current_sass_files ) ) {
			if ( ! $wp_filesystem->delete( $file, false ) ) {
				echo "Error deleting SASS file: $file!";
			}
		}
	}
}

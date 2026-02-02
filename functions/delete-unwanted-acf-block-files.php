<?php // phpcs:ignore file comment
/**
 * Helper function to delete unnecessary ACF block files.
 *
 * This function checks the existing files against the $block_types values,
 * and deletes any files that are no longer needed, except for the `blank.php` and `blank.json` files.
 *
 * @param array $block_types An array of current block names.
 * @return void
 */
function skel_delete_unwanted_acf_block_files( array $block_types ): void {
	// Initialize the WordPress filesystem API.
	$wp_filesystem = skel_init_filesystem();

	// Define the directories where the block files are located.
	// Get block paths.
	$paths = skel_get_acf_block_paths();

	// Define the directories where the block files are located.
	$php_directory  = $paths['php'];
	$js_directory   = $paths['js'];
	$sass_directory = $paths['sass'];
	$json_directory = $paths['json'];

	// Get a list of existing PHP files.
	$existing_php_files = glob( $php_directory . '*.php' );
	// Get a list of existing JS files.
	$existing_js_files = glob( $js_directory . '*.js' );
	// Get a list of existing SASS files.
	$existing_sass_files = glob( $sass_directory . '*.scss' );
	// Get a list of existing JSON files.
	$existing_json_files = glob( $json_directory . '*.json' );

	// Create arrays of filenames from the block types.
	$current_files = array_map(
		function ( $block ) {
			return skel_get_block_slug( $block );
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
	$current_json_files = array_map(
		function ( $filename ) use ( $json_directory ) {
			return $json_directory . $filename . '.json';
		},
		$current_files
	);

	// Exclude 'blank.php' from deletion.
	$exclude_php_file  = $php_directory . 'blank.php';
	$exclude_json_file = $json_directory . 'blank.json';

	// Delete PHP files that are no longer needed, excluding `blank.php`.
	foreach ( $existing_php_files as $file ) {
		if ( $file !== $exclude_php_file && ! in_array( $file, $current_php_files, true ) ) {
			if ( ! $wp_filesystem->delete( $file, false ) ) {
				printf( 'Error deleting PHP file: %s!', esc_html( $file ) );
			}
		}
	}

	// Delete JS files that are no longer needed.
	foreach ( $existing_js_files as $file ) {
		if ( ! in_array( $file, $current_js_files, true ) ) {
			if ( ! $wp_filesystem->delete( $file, false ) ) {
				printf( 'Error deleting JS file: %s!', esc_html( $file ) );
			}
		}
	}

	// Delete SASS files that are no longer needed.
	foreach ( $existing_sass_files as $file ) {
		if ( ! in_array( $file, $current_sass_files, true ) ) {
			if ( ! $wp_filesystem->delete( $file, false ) ) {
				printf( 'Error deleting SASS file: %s!', esc_html( $file ) );
			}
		}
	}

	// Delete JSON files that are no longer needed, excluding `blank.json`.
	foreach ( $existing_json_files as $file ) {
		if ( $file !== $exclude_json_file && ! in_array( $file, $current_json_files, true ) ) {
			if ( ! $wp_filesystem->delete( $file, false ) ) {
				printf( 'Error deleting JSON file: %s!', esc_html( $file ) );
			}
		}
	}
}

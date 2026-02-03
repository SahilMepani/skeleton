<?php // phpcs:ignore file comment
/**
 * Helper function to delete unnecessary ACF block folders.
 *
 * This function checks the existing block folders against the $block_types values,
 * and deletes any folders that are no longer needed, except for the `blank` folder.
 *
 * @param array $block_types An array of current block names.
 * @return void
 */
function skel_delete_unwanted_acf_block_files( array $block_types ): void {
	// Initialize the WordPress filesystem API.
	$wp_filesystem = skel_init_filesystem();

	// Define the blocks directory.
	$blocks_directory = get_template_directory() . '/blocks/';

	// Check if blocks directory exists.
	if ( ! is_dir( $blocks_directory ) ) {
		return;
	}

	// Get all existing block folders.
	$existing_folders = glob( $blocks_directory . '*', GLOB_ONLYDIR );

	// Create array of current block slugs.
	$current_blocks = array_map(
		function ( $block ) {
			return skel_get_block_slug( $block );
		},
		$block_types
	);

	// Delete block folders that are no longer needed, excluding `blank`.
	foreach ( $existing_folders as $folder ) {
		$folder_name = basename( $folder );

		// Skip the blank template folder.
		if ( 'blank' === $folder_name ) {
			continue;
		}

		// If this folder is not in the current blocks list, delete it.
		if ( ! in_array( $folder_name, $current_blocks, true ) ) {
			if ( ! $wp_filesystem->delete( $folder, true ) ) {
				printf( 'Error deleting block folder: %s!', esc_html( $folder ) );
			}
		}
	}
}

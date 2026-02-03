<?php
/**
 * Admin Notices
 *
 * This is the template that displays all of the <head> section and everything up until main.
 *
 * @package WordPress
 * @subpackage Skeleton
 * @since 1.0.0
 */

if ( ! is_admin() ) {
	return;
}

/**
 * Displays a custom admin notice if a protected post was attempted to be deleted.
 *
 * This function hooks into the 'admin_notices' action to display a warning notice
 * in the WordPress admin area if a user tries to delete a protected post.
 * The notice is triggered by the presence of a 'protected_post=true' query parameter
 * in the URL, which is set when a protected post is attempted to be deleted.
 */
function show_custom_admin_notice() {
	if ( isset( $_GET['protected_post'] ) && 'true' === sanitize_text_field( wp_unslash( $_GET['protected_post'] ) ) ) {
		// Display the custom admin notice.
		echo '<div id="custom-admin-notice" class="notice notice-warning is-dismissible">
            <p>This page is protected and cannot be deleted.</p>
        </div>';
	}
}
add_action( 'admin_notices', 'show_custom_admin_notice' );



/**
 * Check for missing ACF block preview images and display an admin notice.
 *
 * This function iterates through the defined block types, constructs the expected
 * path for their preview images within the 'acf - blocks / preview / ' folder,
 * and checks if the image file exists. If a preview image is missing for any block,
 * it adds the block's name to a list . finally, if there are missing images,
 * it displays a warning notice in the WordPress admin area listing these blocks .
 *
 * This function is hooked into the 'admin_notices' action, ensuring it runs
 * when admin pages are loaded .
 *
 * @return void
 */
function skel_check_missing_acf_block_previews(): void {
	global $block_types;

	if ( ! current_user_can( 'manage_options' ) ) {
		return; // Only show notice to users who can manage options.
	}

	$missing_preview_blocks = array();
	$preview_folder_path    = get_template_directory() . '/acf/blocks/preview/';

	foreach ( $block_types as $block_name ) {
		$sanitized_block_name = sanitize_title( $block_name );
		$preview_image_path   = $preview_folder_path . $sanitized_block_name . '.png'; // Assuming .png extension.

		// Check if the file exists.
		if ( ! file_exists( $preview_image_path ) ) {
			$missing_preview_blocks[] = $block_name;
		}
	}

	if ( ! empty( $missing_preview_blocks ) ) {
		?>
		<div class="notice notice-warning is-dismissible">
			<p>
				<strong>Heads up!</strong> The following ACF blocks are missing their preview images in
				<code>/acf/blocks/preview/</code>:
			</p>
			<ul>
				<?php
				foreach ( $missing_preview_blocks as $block_name ) {
					echo '<li><strong>' . esc_html( $block_name ) . '</strong></li>';
				}
				?>
			</ul>
			<p>Please ensure a <code>.png</code> preview image with the same name as the block (e.g.,
				<code><?php echo esc_html( sanitize_title( $missing_preview_blocks[0] ) ); ?>.png</code>)
				exists for each listed block.
			</p>
		</div>
		<?php
	}
}

if ( 'local' === wp_get_environment_type() && current_user_can( 'manage_options' ) ) {
	// Hook the function to the 'admin_notices' action.
	add_action( 'admin_notices', 'skel_check_missing_acf_block_previews' );
}

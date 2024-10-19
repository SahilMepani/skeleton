<?php
/**
 * Admin Notices
 *
 * @package WordPress
 * @subpackage Skeleton
 * @since 1.0.0
 */

/**
 * Displays a custom admin notice if a protected post was attempted to be deleted.
 *
 * This function hooks into the 'admin_notices' action to display a warning notice
 * in the WordPress admin area if a user tries to delete a protected post.
 * The notice is triggered by the presence of a 'protected_post=true' query parameter
 * in the URL, which is set when a protected post is attempted to be deleted.
 */
function skel_custom_admin_notice() {
	// phpcs:ignore -- Processing form data without nonce verification
	if ( isset( $_GET['protected_post'] ) && $_GET['protected_post'] == 'true' ) {
		// Display the custom admin notice.
		echo '<div id="custom-admin-notice" class="notice notice-warning is-dismissible">
				<p>This page is protected and cannot be deleted.</p>
			</div>';
	}
}
add_action( 'admin_notices', 'skel_custom_admin_notice' );

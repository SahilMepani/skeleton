<?php
/**
 * Protected Pages
 *
 * This is the template that displays all of the <head> section and everything up until main.
 *
 * @package WordPress
 * @subpackage Skeleton
 * @since 1.0.0
 */

/**
 * Prevents deletion of specific protected posts.
 *
 * This function hooks into the 'wp_trash_post' action to prevent certain posts
 * from being deleted. If a user attempts to delete a protected post, they are
 * redirected back to the page list with a notice.
 *
 * @param int $postid The ID of the post being trashed.
 */
function prevent_post_deletion( $postid ) {
	// 404, search.
	$protected_posts = array( 7, 8 ); // Array of post IDs to protect.

	if ( in_array( $postid, $protected_posts, true ) ) {
		// Redirect to the page list in the admin area with a protected_post flag.
		wp_safe_redirect( admin_url( 'edit.php?post_type=page&protected_post=true' ) );
		exit;
	}
}
add_action( 'wp_trash_post', 'prevent_post_deletion' );

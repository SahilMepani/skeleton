<?php
add_filter( 'login_redirect', 'fe_skip_dash', 10, 3 );

function fe_skip_dash( $url, $request, $user ) {
	if ( ! $user ||  is_wp_error( $user ) ) {
			// There is no user.
			// Do not change the URL.
			return $url;
	}

	if ( ! user_can( $user, 'edit_posts' ) ) {
			// User can not view backend Posts screen.
			// Do not change the URL.
			return $url;
	}

	// Change the URL.
	return admin_url( 'edit.php?post_type=page' );
}
?>
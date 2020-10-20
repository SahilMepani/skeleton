<?php
// Search WP plugin, allow big words search
////////////////////////////////////////////////
add_filter( 'searchwp_big_selects', '__return_true' );

// ACF plugin, increase the backend loading performance
////////////////////////////////////////////////
add_filter('acf/settings/remove_wp_meta_box', '__return_true');

// Gravity forms plugin, change the submission loading icon
////////////////////////////////////////////////
add_filter( 'gform_ajax_spinner_url', 'spinner_url', 10, 2 );
function spinner_url( $image_src, $form ) {
  // relative to you theme images folder
  return  'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
}

// Email Address Encoder plugin, for ACF fields
////////////////////////////////////////////////
// add_filter('acf/load_value', 'eae_encode_emails');
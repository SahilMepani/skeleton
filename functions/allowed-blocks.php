<?php
/*
 * Whitelist specific Gutenberg blocks (paragraph, heading, image and lists)
 *
 * @author Misha Rudrastyh
 * @link https://rudrastyh.com/gutenberg/remove-default-blocks.html#allowed_block_types_all
 */

// Get list of all registered blocks
// Paste it on front-page.php file
/* ========================================== */
// $registered_block_slugs = array_keys( WP_Block_Type_Registry::get_instance()->get_all_registered() );
// echo '<pre>' . print_r( $registered_block_slugs, true ) . '</pre>';

add_filter( 'allowed_block_types_all', 'misha_allowed_block_types', 25, 2 );

function misha_allowed_block_types( $allowed_blocks, $editor_context ) {

  $allowed_blocks = array(
		'acf/hero-image-slider'
	);

  // Allow more blocks depending on the post type
  // Same can also be used for specific post ID or users roles
	// if ( 'CUSTOM_POST_TYPE' === $editor_context->post->post_type ) {
  //   $post_allowed_blocks = array(
  //     'core/image',
  //   );
	// 	$allowed_blocks = array_merge( $post_allowed_blocks );
	// }

	return $allowed_blocks;

}
?>
<?php
/**
 * Whitelist specific Gutenberg blocks (paragraph, heading, image and lists)
 *
 * @link https://rudrastyh.com/gutenberg/remove-default-blocks.html#allowed_block_types_all
 *
 * @package WordPress
 * @subpackage Skeleton
 * @since 1.0.0
 */


/**
 * Filter the allowed block types for all contexts.
 *
 * This function modifies the list of allowed block types for all contexts,
 * including the block editor and block inserter.
 *
 * @return array The modified list of allowed block types.
 */
function skel_allowed_block_types(): array {
	// Get all registered block types.
	$block_types = WP_Block_Type_Registry::get_instance()->get_all_registered();

	// Filter out ACF blocks.
	$allowed_blocks = array_values(
		array_filter(
			array_keys( $block_types ),
			function ( $block ) {
				return strpos( $block, 'acf/' ) === 0;
			}
		)
	);

	// Include reusable blocks in the block inserter.
	$allowed_blocks = array_merge( $allowed_blocks, array( 'core/block' ) );

	// Additional block types allowed based fr page post type.
	if ( 'page' === get_post_type() ) {
		$post_allowed_blocks = array(
			'core/image',
		);
		$allowed_blocks      = array_merge( $allowed_blocks, $post_allowed_blocks );
	}

	return $allowed_blocks;
}

add_filter( 'allowed_block_types_all', 'skel_allowed_block_types', 25, 2 );

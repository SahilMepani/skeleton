<?php
/**
 * ACF Blocks Configuration
 *
 * @package Skeleton
 * @subpackage ACF
 */

/**
 * Add custom blocks
 * ?string[]
 */
$block_types = array(
	'Visual Editor',
	'Search Result',
	'Flexible Editor',
	'Spacer',
	'Two Columns',
	'Not Found 404',
	'Hero Slider',
	'Faqs',
	'Logo Slider',
	'Test',
);

/**
 * Blocks that require JavaScript files.
 */
$blocks_with_js = array(
	'Hero Slider',
	'Faqs',
	'Logo Slider',
);

/**
 * Define allowed post types per block.
 */
$block_post_type_map = array(
	'Visual Editor' => array( 'page' ),
	// All post types will be used for blocks not listed here.
);

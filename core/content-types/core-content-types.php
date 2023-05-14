<?php
/**
 * Registers and manages custom content types.
 * Content Types: Page Templates & Post Types.
 *
 * @package Core
 * @subpackage Content Types
 * @since 1.0.0
 */

/**
 * Retrieves the current content type.
 *
 * @since 1.0.0
 * @internal
 *
 * @param int|bool $post_id=false
 * @return array|null
 */
function core_get_content_type( $post_id=false ) {
	if ( ! $post_id ) $post_id = get_the_ID();
	$post_type = get_post_type( $post_id );

	/**
	 * The content type information.
	 *
	 * @var array|null
	 */
	$content_type = null;

	if ( $post_type === 'page' ) {
		$page_template = core_get_page_template( $post_id, false );
		if ( $page_template ) $content_type = $page_template;
	}

	elseif ( $post_type ) {
		$post_type = core_get_post_type( $post_type );
		if ( $post_type ) $content_type = $post_type;
	}

	return $content_type;
}

/**
 * Retrieves the specified post context.
 *
 * @since 1.0.0
 * @internal
 *
 * @param int [$post_id=false]
 * @return array|null
 */
function core_get_post_context( $post_id=false ) {
	if ( ! $post_id ) $post_id = get_the_ID();
	if ( ! $post_id ) return null;

	/**
	 * The post context.
	 *
	 * @var array
	 */
	$post_context = [
		'post_id' => $post_id
	];

	$post_type = get_post_type( $post_id );

	if ( $post_type === 'page' ) {
		$post_context['post_type'] = 'page';
		$post_context['page_template'] = core_get_page_template( $post_id, false );
	} else {
		$post_type = core_get_post_type( $post_type );
		$post_context['post_type'] = $post_type;
	}

	return $post_context;
}

/**
 * Checks if a given content type supports the specified feature.
 *
 * @since 2.10.0
 * @internal
 *
 * @param string $feature
 * @param array $reg_data
 * @return boolean
 */
function core_content_type_supports( $feature, $reg_data ) {
	if (
		! array_key_exists( 'remove_support', $reg_data ) ||
		! is_array( $reg_data['remove_support'] )
	) return true;

	return ! in_array( $feature, $reg_data['remove_support'] );
}

/**
 * Attempts to find partials in the specified content type.
 *
 * @since 2.15.0
 *
 * @param string $dir
 * @param string[]
 */
function core_scan_partials( $dir ) {
	$dir .= '/partials';
	if ( ! is_dir( $dir ) ) return [];

	$raw_partials = core_scan_dir( $dir, '*.twig', function( $file ) {
		$partial_name = explode( '.', $file['name'] )[0];

		return [
			'name' => $partial_name,
			'path' => $file['path']
		];
	});

	$partials = [];

	foreach ( $raw_partials as $partial ) {
		$partials[ $partial['name'] ] = $partial['path'];
	}

	return $partials;
}

/**
 * Registers custom content types.
 *
 * @since 1.0.0
 * @internal
 */
function core_scan_custom_content_types() {
	if ( function_exists( 'core_scan_page_templates' ) ) {
		core_scan_page_templates();
	}

	if ( function_exists( 'core_scan_post_types' ) ) {
		core_scan_post_types();
	}

	// Run action.
	do_action( 'core_after_scan_custom_content_types' );
}

add_action( 'core_after_setup', 'core_scan_custom_content_types', 3 );

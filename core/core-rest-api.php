<?php
/**
 * Controls endpoints and features related to the REST API.
 *
 * @package Core
 * @subpackage REST API
 * @since 1.0.0
 */

/**
 * Retrieves a list of posts matching the specified query.
 *
 * @since 1.0.0
 * @internal
 *
 * @param WP_REST_Request $query
 * @return array
 */
function core_rest_get_posts( $query ) {
	$params = $query->get_json_params();
	if ( ! $params || ! core_is_assoc( $params ) || empty( $params ) ) return null;

	// Check wether to return the response as a list of components.
	$as_component = core_default( 'as_component', $params, false );
	if ( $as_component ) unset( $params['as_component'] );

	// Get the list of posts.
	$query = new WP_Query( $params );
	$posts = array_map( 'core_format_post_object', $query->posts );

	// Format results as components.
	if ( $as_component ) {
		$posts = array_map( function( $post ) use( $as_component ) {
			return core_render_component( $as_component, $post, true );
		}, $posts );
	}

	$response = [
		'results' => $posts,
		'max_num_pages' => $query->max_num_pages
	];

	return $response;
}

/**
 * Registers custom REST API endpoints.
 *
 * @since 1.0.0
 * @internal
 */
function core_rest_register_endpoints() {

	// ? Endpoint: core/v1/posts
	register_rest_route( 'core/v1', '/posts', [
		'methods' => 'POST',
		'callback' => 'core_rest_get_posts',
		'permission_callback' => '__return_true'
	]);
}

add_action( 'rest_api_init', 'core_rest_register_endpoints' );

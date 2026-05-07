<?php
/**
 * ACF Post Field Groups
 *
 * Loads ACF field groups for post types from JSON files in /post-fields/.
 * Each JSON file must declare 'title', 'post_type', and 'fields'.
 *
 * @package Skeleton
 * @subpackage ACF
 */

function skel_load_acf_json_post_fields() {
	skel_register_acf_json_groups(
		'post-fields',
		'group_post_fields_',
		function ( array $data ): ?array {
			if ( ! isset( $data['post_type'] ) ) {
				return null;
			}
			return array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => $data['post_type'],
					),
				),
			);
		}
	);
}
add_action( 'acf/init', 'skel_load_acf_json_post_fields' );

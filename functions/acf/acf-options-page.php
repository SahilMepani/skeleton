<?php
/**
 * ACF Options Pages
 *
 * @package WordPress
 * @subpackage Skeleton
 * @since 1.0.0
 */

if ( function_exists( 'acf_add_options_page' ) ) {

	acf_add_options_page(
		array(
			'page_title' => 'Global Options',
			'menu_title' => 'Global Options',
			'menu_slug'  => 'global-options',
			'capability' => 'manage_options',
			'redirect'   => true,
			'icon_url'   => 'dashicons-admin-generic',
			'position'   => 2,
		)
	);

	acf_add_options_sub_page(
		array(
			'page_title'  => 'General',
			'menu_title'  => 'General',
			'menu_slug'   => 'global-options-general',
			'parent_slug' => 'global-options',
		)
	);

	acf_add_options_sub_page(
		array(
			'page_title'  => 'Header',
			'menu_title'  => 'Header',
			'menu_slug'   => 'global-options-header',
			'parent_slug' => 'global-options',
		)
	);

	acf_add_options_sub_page(
		array(
			'page_title'  => 'Footer',
			'menu_title'  => 'Footer',
			'menu_slug'   => 'global-options-footer',
			'parent_slug' => 'global-options',
		)
	);

	acf_add_options_sub_page(
		array(
			'page_title'  => 'CTA',
			'menu_title'  => 'CTA',
			'menu_slug'   => 'global-options-cta',
			'parent_slug' => 'global-options',
		)
	);

	acf_add_options_sub_page(
		array(
			'page_title'  => 'Analytics',
			'menu_title'  => 'Analytics',
			'menu_slug'   => 'global-options-analytics',
			'parent_slug' => 'global-options',
		)
	);
}

/**
 * Load ACF options field groups from JSON files in /options/.
 * Each JSON file must declare 'title', 'options_page', and 'fields'.
 */
function skel_load_acf_json_options() {
	skel_register_acf_json_groups(
		'options',
		'group_options_',
		function ( array $data ): ?array {
			if ( ! isset( $data['options_page'] ) ) {
				return null;
			}
			return array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => $data['options_page'],
					),
				),
			);
		}
	);
}
add_action( 'acf/init', 'skel_load_acf_json_options' );


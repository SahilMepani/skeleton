<?php
/**
 * ACF JSON Field Group Loader
 *
 * One generic loader used by acf-options-page.php and acf-post-fields.php.
 * Reads JSON files from a directory, validates them, and registers each
 * as an ACF local field group with a caller-supplied location callback.
 *
 * @package Skeleton
 * @subpackage ACF
 */

/**
 * Register ACF local field groups from JSON files in a theme directory.
 *
 * The location callback receives the decoded JSON array and must return a
 * valid ACF `location` value (array of arrays of param/operator/value
 * arrays), or null to skip the file.
 *
 * @param string   $dir          Theme-relative directory (e.g. 'options' or 'post-fields').
 * @param string   $key_prefix   Prefix used to build the field-group key. Slug appended.
 * @param callable $location_cb  fn( array $data ): ?array — returns ACF location, or null to skip.
 */
function skel_register_acf_json_groups( string $dir, string $key_prefix, callable $location_cb ): void {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$path = get_template_directory() . '/' . trim( $dir, '/' );

	if ( ! is_dir( $path ) ) {
		return;
	}

	$json_files = glob( $path . '/*.json' );

	if ( empty( $json_files ) ) {
		return;
	}

	foreach ( $json_files as $json_file ) {
		$slug = sanitize_key( basename( $json_file, '.json' ) );
		$data = wp_json_file_decode( $json_file, array( 'associative' => true ) );

		if ( ! is_array( $data ) ) {
			if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
				error_log( 'Skeleton: Invalid JSON in ' . basename( $json_file ) );
			}
			continue;
		}

		if ( ! isset( $data['title'], $data['fields'] ) ) {
			continue;
		}

		$location = $location_cb( $data );

		if ( null === $location ) {
			continue;
		}

		acf_add_local_field_group(
			array(
				'key'                   => $key_prefix . $slug,
				'title'                 => $data['title'],
				'fields'                => $data['fields'],
				'location'              => $location,
				'menu_order'            => $data['menu_order'] ?? 0,
				'position'              => $data['position'] ?? 'normal',
				'style'                 => 'default',
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'active'                => true,
			)
		);
	}
}

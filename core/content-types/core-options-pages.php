<?php
/**
 * Prepares the environment for registering and managing
 * custom options pages.
 *
 * @package Core
 * @subpackage Options Pages
 * @since 1.0.0
 */

/**
 * The list of custom options pages.
 *
 * @var array
 * @global
 */
global $core_options_pages;
$core_options_pages = [];

/**
 * Finds and registers all custom options pages.
 *
 * @since 1.0.0
 * @internal
 */
function core_scan_options_pages() {
	global $core_options_pages;

	// Scan for configuration files.
	$options_pages_list = core_scan_dir( PKG_CONTENT_PATH.'/options-pages', '*.php', function( $file ) {
		if ( $file['name'] === 'index.php' ) return null;
		$reg_data = include_once $file['path'];

		try {
			core_check_entity_integrity([
				'type' => 'file',
				'file' => $file,
				'data' => $reg_data,
				'required_options' => [
					'name',
					'icon',
					'sub_pages'
				]
			], function( $entity ) {
				$data = $entity['data'];
				if ( ! array_key_exists( 'sub_pages', $data ) ) return;

				// Check if at least one sub page was declared.
				if ( empty( $data['sub_pages'] ) ) {
					return 'You need to declare at least one sub page.';
				}

				// Check if all the child pages have the required options.
				$errors = [];

				foreach ( $data['sub_pages'] as $sub_page ) {
					if ( ! array_key_exists( 'name', $sub_page ) ) {
						$errors[] = "Missing required option in sub page: `name`";
					}
				}

				return $errors;
			});

			$reg_data['slug'] = 'core-options-' . explode( '.', $file['name'] )[0];

			$reg_data['sub_pages'] = array_map( function( $sub_page ) use( $reg_data ) {
				$sub_page_slug = core_sanitize_title_underscore( $sub_page['name'] );
				$sub_page['slug'] = $reg_data['slug'].'-'.$sub_page_slug;

				return $sub_page;
			}, $reg_data['sub_pages'] );

			// Set default args used for registering the options page.
			$reg_data['args'] = [
				'icon_url' => 'dashicons-'.$reg_data['icon'],
				'menu_title' => $reg_data['name'],
				'page_title' => $reg_data['name'],
				'menu_slug' => $reg_data['slug'],
				'capability' => core_default( 'capability', $reg_data, 'edit_posts' ),
				'position' => core_default( 'position', $reg_data, 21 )
			];

			// Set default args used for registering each sub page.
			foreach ( $reg_data['sub_pages'] as $x => $sub_page ) {
				$reg_data['sub_pages'][ $x ]['args'] = [
					'menu_title' => $sub_page['name'],
					'menu_slug' => $sub_page['slug'],
					'page_title' => $sub_page['name'],
					'parent_slug' => $reg_data['slug']
				];
			}

			// Register options pages.
			acf_add_options_page( $reg_data['args'] );

			foreach ( $reg_data['sub_pages'] as $sub_page ) {
				acf_add_options_page( $sub_page['args'] );
			}

			// Register custom fields.
			foreach ( $reg_data['sub_pages'] as $sub_page ) {
				core_register_field_group([
					'title' => $sub_page['name'],
					'slug' => 'options-page-'.$sub_page['slug'],
					'location' => [
						'options_page' => $sub_page['slug']
					],
					'fields' => core_default( 'fields', $sub_page, [] )
				]);
			}
		} catch ( Exception $error ) {
			$error->data[] = core_docs( 'options-pages' );
			core_add_notice( 'error', $error->getMessage(), $error->data );
			$reg_data = null;
		}

		return $reg_data;
	});

	// Save options pages.
	foreach ( $options_pages_list as $options_page ) {
		$core_options_pages[ $options_page['slug'] ] = $options_page;
	}

	// Run action.
	do_action( 'core_after_scan_options_pages', $core_options_pages );
}

add_action( 'core_after_setup', 'core_scan_options_pages' );

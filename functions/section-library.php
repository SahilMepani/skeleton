<?php
/**
 * Prepares the environment for global sections registration.
 */

/**
 * The list of sections.
 *
 * @var array[]
 * @global
 */
global $core_sections;
$core_sections = array();

/**
 * Retrieves the full list of sections.
 *
 * @since 2.11.0
 * @internal
 *
 * @param boolean [ $slug_only=false]
 * @return array[]|string[]
 */
function core_get_sections( $slug_only = false ) {
	global $core_sections;

	if ( $slug_only ) {
		return array_map(
			function ( $section ) {
				return $section['slug'];
			},
			array_values( $core_sections )
		);
	} else {
		return $core_sections;
	}
}

/**
 * Retrieves the configuration data for the specified section.
 *
 * @since 1.0.0
 * @internal
 *
 * @param string $section_slug
 * @return array|null
 */
function core_get_section( $section_slug ) {
	global $core_sections;

	$section = $core_sections[ $section_slug ] ?? null;
	return $section;
}

/**
 * Adds standard fields to a section.
 *
 * @since 2.10.0
 * @internal
 *
 * @param array $reg_data The section registration data.
 */
function core_add_standard_section_fields( &$reg_data ) {

	// Save the section fields to be used later.
	$generic_fields = array();

	// Save the generic fields.
	if ( ! empty( $generic_fields ) ) {
		array_unshift( $reg_data['fields'], array( 'tab', 'Contents' ) );

		$reg_data['fields'][] = array( 'tab', 'Settings' );

		$reg_data['fields'] = array_merge( $reg_data['fields'], $generic_fields );
	}
}

/**
 * Finds and registers all sections.
 *
 * @since 1.0.0
 * @internal
 */
function core_scan_sections() {
	global $core_sections;

	// Scan for configuration files and register sections.
	$sections_list = core_scan_dir(
		get_template_directory() . '/acf-blocks/',
		'config.php',
		function ( $file ) {
			$reg_data = include_once $file['path'];

			$reg_data['slug']                   = core_default( 'slug', $reg_data, $file['dirname'] );
			$reg_data['location']               = $file['info']['dirname'];
			$reg_data['location_rel']           = $file['path_rel'];
			$reg_data['includes_preview_image'] = is_file( "{$reg_data['location']}/preview.jpg" );
			$reg_data['multiple']               = core_default( 'multiple', $reg_data, true );

			// Prepare the section fields.
			$reg_data['fields'] = core_default( 'fields', $reg_data, array() );

			core_add_standard_section_fields( $reg_data );

			// Add the section title.
			array_unshift(
				$reg_data['fields'],
				array( 'accordion', $reg_data['title'], array( 'open' => 1 ) )
			);

			// Store the Block Editor version of this section.
			$reg_data['block'] = array(
				'name'        => $reg_data['slug'],
				'title'       => $reg_data['title'],
				'description' => core_default( 'description', $reg_data, '' ),
				'icon'        => $reg_data['icon'] ?? 'layout',
				'keywords'    => core_default( 'keywords', $reg_data, array() ),
			);

			return $reg_data;
		}
	);

	// Sort the sections list by section name.
	usort(
		$sections_list,
		function ( $a, $b ) {
			if ( $a['name'] > $b['name'] ) {
				return 1;
			}
			if ( $a['name'] < $b['name'] ) {
				return -1;
			}
			return 0;
		}
	);

	// Add an alert for sections that do not have a preview image.
	$missing_previews = array_filter(
		$sections_list,
		function ( $section ) {
			return ! $section['includes_preview_image'];
		}
	);

	if ( ! empty( $missing_previews ) ) {
		$info = array();
		foreach ( $missing_previews as $section ) {
			$info[] = "{$section['name']} (<code>{$section['slug']}</code>)";
		}
		core_add_notice( 'warning', 'Some sections do not have a preview image:', $info );
	}

	// Save sections.
	foreach ( $sections_list as $section ) {
		$core_sections[ $section['slug'] ] = $section;
	}

	// Run action.
	do_action( 'core_after_scan_sections', $core_sections );
}
core_scan_sections();

/**
 * Registers the Block Editor versions of all sections.
 *
 * @since 2.11.0
 * @internal
 */
function core_register_sections_as_blocks() {
	global $core_sections;

	foreach ( $core_sections as $section ) {
		$block_info         = $section['block'];
		$block_info['mode'] = 'edit';

		// Add the automatic render callback.
		$block_info['render_callback'] = function ( $block ) use ( $section ) {
			$inserting = core_default( 'inserting', $block['data'], false );

			if ( $inserting ) {
				if ( $section['includes_preview_image'] ) {
					$preview_image_url = TPL_URL . '/packages/content/section-library/' . $section['location_rel'] . '/preview.jpeg';

					Timber::render(
						CORE_PATH . '/layouts/block-preview.twig',
						array(
							'preview_image_url' => $preview_image_url,
						)
					);
				}
			} else {
				$block_fields = get_fields();
				core_render_section( $section['slug'], $block_fields );
			}
		};

		// Add preview data.
		if ( $section['includes_preview_image'] ) {
			$block_info['example'] = array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array( 'inserting' => true ),
				),
			);
		}

		// Remove default supports.
		$block_info['supports'] = array(
			'align'           => false,
			'customClassName' => false,
			'mode'            => false,
			'multiple'        => $section['multiple'],
		);

		acf_register_block_type( $block_info );

		// Register the Field Group.
		core_register_field_group(
			array(
				'title'    => $section['title'],
				'slug'     => $section['slug'],
				'location' => array( 'block' => "acf/{$section['slug']}" ),
				'fields'   => $section['fields'],
			)
		);
	}
}

add_action( 'core_after_scan_sections', 'core_register_sections_as_blocks' );

/**
 * Retrieves the list of sections added to a specific post.
 *
 * @since 2.11.0
 * @internal
 *
 * @param int [ $post_id=null]
 * @return mixed[]
 */
function core_get_post_sections( $post_id = null ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$blocks = parse_blocks( get_post_field( 'post_content', $post_id ) );

	return array_filter(
		$blocks,
		function ( $block ) {
			return $block['blockName'] !== null;
		}
	);
}

/**
 * Recursively searches the specified fields array for section library fields.
 *
 * This function is primarily used to see what sections are present on a page.
 *
 * @since 1.0.0
 * @since 2.11.0 Lists sections added to the Block Editor,
 *               instead of Flexible content layouts.
 * @internal
 *
 * @param int [ $post_id=null]
 * @return string[]|null The list of sections present on the page.
 */
function core_list_section_library_sections( $post_id = null ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$sections_list = core_get_post_sections( $post_id );

	return empty( $sections_list ) ? array() : array_unique(
		array_map(
			function ( $section ) {
				return str_replace( 'acf/', '', $section['blockName'] );
			},
			$sections_list
		)
	);
}

/**
 * Disables the section library for specific templates
 * and post types.
 *
 * @since 2.12.0
 */
function core_check_section_library_support( $can_edit, $post_type ) {
	$post_type = core_get_post_type( $post_type );
	if ( ! $post_type ) {
		return $can_edit;
	}

	// $can_edit = core_content_type_supports( 'section-library', $post_type );

	return $can_edit;
}

add_filter( 'gutenberg_can_edit_post_type', 'core_check_section_library_support', 10, 2 );
add_filter( 'use_block_editor_for_post_type', 'core_check_section_library_support', 10, 2 );

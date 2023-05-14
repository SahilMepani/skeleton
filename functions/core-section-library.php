<?php
/**
 * Prepares the environment for global sections registration.
 *
 * @package Core
 * @subpackage Sections
 * @since 1.0.0
 */

// Require section node class.
// require_once CORE_PATH.'/lib/core-section.php';

/**
 * The list of sections.
 *
 * @var array[]
 * @global
 */
global $core_sections;
$core_sections = [];

/**
 * Retrieves the full list of sections.
 *
 * @since 2.11.0
 * @internal
 *
 * @param boolean [$slug_only=false]
 * @return array[]|string[]
 */
function core_get_sections( $slug_only = false ) {
	global $core_sections;

	if ( $slug_only ) {
		return array_map( function( $section ) {
			return $section['slug'];
		}, array_values( $core_sections ) );
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
	$generic_fields = [];

	// ? Anchor ID
	if ( core_content_type_supports( 'anchor-id', $reg_data ) ) {
		array_push( $generic_fields,
			[ 'text', 'Unique ID', [
				'name' => 'anchor_id',
				'instructions' => 'This is used to allow auto scrolling to this section.'
			]]
		);
	}

	// ? Spacing Configuration
	if ( core_content_type_supports( 'spacing-config', $reg_data ) ) {
		$spacing_fields = [
			[ 'button_group', 'Type', [
				'choices' => [
					'none' => 'None',
					'small' => 'Small',
					'normal' => 'Normal',
					'large' => 'Large',
					'custom' => 'Custom'
				]
			]],
			[ 'message', 'Custom Value', [
				'message' => 'Not applicable.',
				'show_if' => [ 'type' => '!custom' ]
			]],
			[ 'range', 'Custom Value', [
				'name' => 'custom',
				'required' => 1,
				'default_value' => 80,
				'min' => 20,
				'max' => 300,
				'step' => 10,
				'show_if' => [ 'type' => 'custom' ]
			]]
		];

		$default_value = core_default( 'default_spacing', $reg_data, 'normal' );

		if ( is_string( $default_value ) ) {
			$spacing_fields[0][2]['default_value'] = $default_value;
		}

		$field_top = [ 'group', 'Top', [
			'name' => 'top',
			'sub_fields' => $spacing_fields,
			'wrapper_width' => 50
		]];

		$field_bottom = [ 'group', 'Bottom', [
			'name' => 'bottom',
			'sub_fields' => $spacing_fields,
			'wrapper_width' => 50
		]];

		if ( is_array( $default_value ) && count( $default_value ) === 2 ) {
			$field_top[2]['sub_fields'][0][2]['default_value'] = $default_value[0];
			$field_bottom[2]['sub_fields'][0][2]['default_value'] = $default_value[1];
		}

		array_push( $generic_fields,
			[ 'group', 'Spacing', [
				'name' => 'spacing_config',
				'sub_fields' => [
					$field_top,
					$field_bottom
				]
			]]
		);
	}

	// ? Custom Generic Fields
	if ( core_content_type_supports( 'custom-generic-fields', $reg_data ) ) {
		$custom_generic_fields = core_get_option( 'section-generic-fields', [] );

		if ( ! empty( $custom_generic_fields ) ) {
			$generic_fields = array_merge( $generic_fields, $custom_generic_fields );
		}
	}

	// Save the generic fields.
	if ( ! empty( $generic_fields ) ) {
		array_unshift( $reg_data['fields'], [ 'tab', 'Contents' ] );

		$reg_data['fields'][] = [ 'tab', 'Settings' ];

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
	$sections_list = core_scan_dir( BLOCKS_DIR, 'config.php', function( $file ) {
		$reg_data = include_once $file['path'];

		$reg_data['slug'] = core_default( 'slug', $reg_data, $file['dirname'] );
		$reg_data['location'] = $file['info']['dirname'];
		// $reg_data['location_rel'] = $file['path_rel'];
		$reg_data['includes_preview_image'] = is_file( "{$reg_data['location']}/preview.jpg" );
		$reg_data['multiple'] = core_default( 'multiple', $reg_data, true );
		// $reg_data['node'] = core_default( 'node', $reg_data, [] );

		// Prepare the section fields.
		$reg_data['fields'] = core_default( 'fields', $reg_data, [] );

		// core_add_standard_section_fields( $reg_data );

		// Add the section title.
		array_unshift( $reg_data['fields'],
			[ 'accordion', $reg_data['name'], [ 'open' => 1 ] ]
		);

		// Store the Block Editor version of this section.
		$reg_data['block'] = [
			'name' => $reg_data['slug'],
			'title' => $reg_data['name'],
			'description' => core_default( 'description', $reg_data, '' ),
			'category' => core_default( 'category', $reg_data, 'uncategorized' ),
			'icon' => $reg_data['icon'],
			'keywords' => core_default( 'keywords', $reg_data, [] )
		];

		// var_dump($reg_data);

		return $reg_data;
	});

	// Sort the sections list by section name.
	usort( $sections_list, function( $a, $b ) {
		if ( $a['name'] > $b['name'] ) return 1;
		if ( $a['name'] < $b['name'] ) return -1;
		return 0;
	});

	// Save sections.
	foreach ( $sections_list as $section ) {
		$core_sections[ $section['slug'] ] = $section;
	}

	// Run action.
	do_action( 'core_after_scan_sections', $core_sections );
}

add_action( 'core_after_scan_custom_content_types', 'core_scan_sections' );

/**
 * Registers the Block Editor versions of all sections.
 *
 * @since 2.11.0
 * @internal
 */
function core_register_sections_as_blocks() {
	global $core_sections;

	foreach ( $core_sections as $section ) {
		$block_info = $section['block'];
		$block_info['mode'] = 'edit';

		// Add the automatic render callback.
		$block_info['render_callback'] = function( $block ) use( $section ) {
			$inserting = core_default( 'inserting', $block['data'], false );

			if ( $inserting ) {
				if ( $section['includes_preview_image'] ) {
					$preview_image_url = TPL_URL.'/packages/content/section-library/'.$section['location_rel'].'/preview.jpeg';

					Timber::render( CORE_PATH.'/layouts/block-preview.twig', [
						'preview_image_url' => $preview_image_url
					]);
				}
			} else {
				$block_fields = get_fields();
				core_render_section( $section['slug'], $block_fields );
			}
		};

		// Add preview data.
		if ( $section['includes_preview_image'] ) {
			$block_info['example'] = [
				'attributes' => [
					'mode' => 'preview',
					'data' => [ 'inserting' => true ]
				]
			];
		}

		// Remove default supports.
		$block_info['supports'] = [
			'align' => false,
			'customClassName' => false,
			'mode' => false,
			'multiple' => $section['multiple']
		];

		acf_register_block_type( $block_info );

		// Register the Field Group.
		core_register_field_group([
			'title' => $section['name'],
			'slug' => $section['slug'],
			'location' => [ 'block' => "acf/{$section['slug']}" ],
			'fields' => $section['fields']
		]);
	}
}

add_action( 'core_after_scan_sections', 'core_register_sections_as_blocks' );

/**
 * Retrieves the list of sections added to a specific post.
 *
 * @since 2.11.0
 * @internal
 *
 * @param int [$post_id=null]
 * @return mixed[]
 */
function core_get_post_sections( $post_id = null ) {
	if ( ! $post_id ) $post_id = get_the_ID();

	$blocks = parse_blocks( get_post_field( 'post_content', $post_id ) );

	return array_filter( $blocks, function( $block ) {
		return $block['blockName'] !== null;
	});
}

/**
 * Recursively searches the specified fields array for section library fields.
 *
 * This function is primarily used to see what sections are present on a page.
 *
 * @since 1.0.0
 * @since 2.11.0 Lists sections added to the Block Editor,
 * 				 instead of Flexible content layouts.
 * @internal
 *
 * @param int [$post_id=null]
 * @return string[]|null The list of sections present on the page.
 */
function core_list_section_library_sections( $post_id = null ) {
	if ( ! $post_id ) $post_id = get_the_ID();

	$sections_list = core_get_post_sections( $post_id );

	return empty( $sections_list ) ? [] : array_unique(
		array_map( function( $section ) {
			return str_replace( 'acf/', '', $section['blockName'] );
		}, $sections_list )
	);
}

/**
 * Renders the specified section to the frontend.
 *
 * @since 1.0.4
 * @since 1.1.2  Added unique ID implementation.
 * @since 2.11.0 Expects the section parameter to be only the section fields.
 * @internal
 *
 * @param string $slug
 * @param mixed[] [$fields=[]]
 */
function core_render_section( $slug, $fields=[] ) {
	$config = core_get_section( $slug );

	if ( ! $config ) {
		throw new ErrorException( 'Section "'.$slug.'" not found.' );
	}

	if ( ! is_array( $fields ) ) $fields = [];

	// ? Apply filters to all fields
	$fields = core_acf_fields_apply_filters( $fields, 'section', $slug );

	// The current environment.
	$env = core_env();

	/**
	 * The automatic key. This is used by developers, mostly for accessibility.
	 *
	 * @var string|boolean
	 */
	$section_key = core_id( 'section' );

	/**
	 * The custom ID, usually specified by the user upon insertion.
	 *
	 * @var string|boolean
	 */
	$anchor_id = core_default( 'anchor_id', $fields, false );

	/**
	 * The spacing configuration, provided by the user.
	 *
	 * @var array[]|null
	 */
	$spacing_config = core_default( 'spacing_config', $fields, null );

	// Prepare the section wrapper info.
	if ( is_callable( $config['node'] ) ) {
		$comp_instance = new Core_Section( $config['slug'] );
		call_user_func( $config['node'], $comp_instance, $fields );
	} else {
		$comp_instance = new Core_Section( $config['slug'], $config['node'] );
	}

	// ? Section key
	$comp_instance->set_attr( 'data-key', $section_key );

	// ? Anchor ID
	if ( $anchor_id ) {
		$comp_instance->set_attr( 'id', $anchor_id );
	}

	// ? Spacing Configuration
	if ( array_key_exists( 'spacing_config', $fields ) ) {
		$spacing_config = $fields['spacing_config'];

		foreach ( $spacing_config as $sp_position => $sp_config ) {
			$comp_instance->add_class( "spacing-{$sp_position}-{$sp_config['type']}" );

			if ( $sp_config['type'] === 'custom' ) {
				$comp_instance->set_attr( 'style', "--core-spacing-{$sp_position}: {$sp_config['custom']}" );
			}
		}
	}

	/**
	 * The section context.
	 *
	 * @var mixed[]
	 */
	$context = core_get_context( 'section', $config, [
		'content_type' => $config,
		'section_slug' => $config['slug'],
		'section_key' => $section_key,
		'anchor_id' => $anchor_id,
		'section_preview_available' => $config['includes_preview_image'],
		'spacing' => $spacing_config,
		'fields' => $fields
	]);

	// Render the section contents.
	ob_start();
		if ( $env['current'] !== 'prod' ) {
			Timber::render( 'core/layouts/preview-manager-wrapper.twig', $context );
		}

		Timber::render( $config['location'].'/layout.twig', $context );
	$render_result = trim( ob_get_clean() );

	$result = $comp_instance->generate_node( $render_result );

	echo $result ?? '';
}

/**
 * Disables the section library for specific templates
 * and post types.
 *
 * @since 2.12.0
 */
function core_check_section_library_support( $can_edit, $post_type ) {
	$post_type = core_get_post_type( $post_type );
	if ( ! $post_type ) return $can_edit;

	$can_edit = core_content_type_supports( 'section-library', $post_type );

	return $can_edit;
}

add_filter( 'gutenberg_can_edit_post_type', 'core_check_section_library_support', 10, 2 );
add_filter( 'use_block_editor_for_post_type', 'core_check_section_library_support', 10, 2 );

<?php
/**
 * Prepares the environment for registering and managing
 * custom page templates.
 *
 * @package Core
 * @subpackage Content Types - Page Templates
 * @since 1.0.0
 */

/**
 * The list of custom page templates.
 *
 * @var array[]
 * @global
 */
global $core_page_templates;
$core_page_templates = [];

/**
 * The default page template.
 *
 * This template is attached to a new page, if no template is selected.
 *
 * @var string|null
 * @global
 */
global $core_default_page_template;

/**
 * Retrieves the page template for the specified page.
 *
 * @since 1.0.0
 *
 * @param int $post_id
 * @param bool $slug_only=true
 * @return string|null
 */
function core_get_page_template( $post_id, $slug_only=true ) {
	global $core_page_templates;

	$page_template = get_post_meta( $post_id, '_wp_page_template', true );
	if ( ! $page_template ) return null;

	$page_template = $core_page_templates[ $page_template ] ?? null;
	if ( ! $page_template ) return null;

	return $slug_only
		? $page_template['slug']
		: $page_template;
}

/**
 * Finds and registers all custom page templates.
 *
 * @since 1.0.0
 * @internal
 */
function core_scan_page_templates() {
	global $core_page_templates, $core_default_page_template;

	// Scan for configuration files and register page templates.
	$page_templates_list = core_scan_dir( PKG_CONTENT_PATH.'/page-templates', 'config.php', function( $file ) {
		$reg_data = include_once $file['path'];

		try {
			core_check_entity_integrity([
				'type' => 'dir',
				'file' => $file,
				'data' => $reg_data,
				'base' => 'page-templates',
				'required_files' => [
					'layout.twig'
				],
				'required_options' => [
					'name'
				]
			]);

			$reg_data['type'] = 'page-templates';
			$reg_data['slug'] = $file['dirname'];
			$reg_data['location'] = $file['info']['dirname'];
			$reg_data['location_rel'] = $file['path_rel'];

			$reg_data['default'] = core_default( 'default', $reg_data, false );
			$reg_data['layout_base'] = core_default( 'layout_base', $reg_data, 'base.twig' );

			// Check if the layout file exists.
			if ( ! is_file( PKG_LAYOUTS_PATH.'/'.$reg_data['layout_base'] ) ) {
				core_add_notice( 'warning', "Layout base file not found: *{$reg_data['layout_base']}*" );
			}

			// Load the filters file, is there is one.
			if ( is_file( $reg_data['location'].'/filters.php' ) ) {
				$filters = include_once( $reg_data['location'].'/filters.php' );

				if ( $filters && core_is_assoc( $filters ) ) {
					foreach ( $filters as $filter_type => $filter_func ) {
						add_filter( "core/{$filter_type}/page-template={$reg_data['slug']}", $filter_func, 10 );
					}
				}
			}
		} catch ( Exception $error ) {
			$error->data[] = core_docs( 'page-templates' );
			core_add_notice( 'error', $error->getMessage(), $error->data );
			$reg_data = null;
		}

		return $reg_data;
	});

	// Save page templates.
	foreach ( $page_templates_list as $page_template ) {
		$core_page_templates[ $page_template['slug'] ] = $page_template;
	}

	// Check for a default page template.
	$default_page_template = array_values(
		array_filter( $core_page_templates, function( $template ) {
			return $template['default'];
		})
	);

	if ( empty( $default_page_template ) ) {
		core_add_notice( 'error', 'No default template found.', [
			'You need to specify a default page template, otherwise new pages will be broken on the frontend, if they do not have a template assigned manually.',
			core_docs( 'page-templates' )
		]);
	}

	elseif ( count( $default_page_template ) > 1 ) {
		$default_page_templates = array_map( function( $template ) {
			return "`{$template['slug']}`";
		}, $default_page_template );

		core_add_notice( 'error', 'Found more than one default template.', [
			'Only one page template can be the default, but found multiple: ' . join( ', ', $default_page_templates ),
			core_docs( 'page-templates' )
		]);
	}

	else {
		$core_default_page_template = $default_page_template[0]['slug'];

		// Add default page template to the JS context.
		core_insert_js_context( 'default_page_template', $core_default_page_template );
	}

	// Run action.
	do_action( 'core_after_scan_page_templates', $core_page_templates );
}

/**
 * Registers page templates' field groups.
 *
 * This needs to run after all custom content types are registered, because
 * some field types depend on it.
 *
 * @since 1.0.0
 * @since 2.11.0 No longer registers the Field Group if there are
 *               no fields to register.
 * @internal
 */
function core_register_page_templates_fields() {
	global $core_page_templates;

	// Register custom fields.
	foreach ( $core_page_templates as $page_template ) {
		$page_fields = core_default( 'fields', $page_template, [] );

		if ( ! empty( $page_fields ) ) {
			core_register_field_group([
				'title' => 'Content',
				'slug' => 'page-template-'.$page_template['slug'],
				'location' => [
					'page_template' => $page_template['slug']
				],
				'fields' => $page_fields
			]);
		}
	}
}

add_action( 'core_after_scan_custom_content_types', 'core_register_page_templates_fields' );

/**
 * Replaces the default list of templates WordPress has with
 * the custom list we have registered.
 *
 * Also checks if there are any templates defined with a file.
 *
 * @since 1.0.0
 * @internal
 */
function core_wp_list_page_templates( $current_list ) {
	global $core_page_templates;

	/**
	 * Check for templates defined by file.
	 *
	 * This feature is not supported to ensure an organized configuration.
	 *
	 * Displays an error, but the custom page templates have been registered.
	 */
	if ( ! empty( $current_list ) ) {
		$file_templates = array_filter( $current_list, function( $name, $slug ) {
			return strpos( $slug, '.php' );
		}, ARRAY_FILTER_USE_BOTH );

		if ( ! empty( $file_templates ) ) {
			$error_info_list = [
				'Please remove these files and register the page templates as *Content Types*.',
				core_docs( 'content-types' )
			];

			foreach ( $file_templates as $slug => $name ) {
				$error_info_list[] = "Local template file found: `{$name}` (`{$slug}`)";
			}

			core_add_notice(
				'error',
				'Declaring page templates as files is not supported.',
				$error_info_list
			);
		}
	}

	// Add custom page templates to the list.
	$page_templates = [];

	foreach ( $core_page_templates as $template ) {
		$page_templates[ $template['slug'] ] = $template['name'];
	}

	return $page_templates;
}

add_filter( 'theme_page_templates', 'core_wp_list_page_templates' );

/**
 * Updates the WordPress cache with the list of custom page templates.
 *
 * @since 1.0.0
 * @internal
 */
function core_wp_page_templates_init() {
	global $core_page_templates;

	remove_action( current_filter(), __FUNCTION__ );

	if ( is_admin() && get_current_screen()->post_type === 'page' ) {
		if ( ! empty( $core_page_templates ) ) {
			ksort( $core_page_templates );

			$hash = md5( TPL_PATH );
			$persistently = apply_filters( 'wp_cache_themes_persistently', false, 'WP_Theme' );
			$expiration = is_int( $persistently ) ? $persistently : 1800;

			wp_cache_set( "page_templates-{$hash}", $core_page_templates, 'themes', $expiration );
		}
	}
}

add_action( 'edit_form_after_editor', 'core_wp_page_templates_init' );

/**
 * Runs the cache update when editing a post, or
 * creating a new one.
 *
 * @since 1.0.0
 * @internal
 */
function core_wp_page_templates_init_post() {
	remove_action( current_filter(), __FUNCTION__ );

	$method = filter_input( INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING );
	if ( empty( $method ) || strtoupper( $method ) !== 'POST' ) return;
	if ( get_current_screen()->post_type === 'page' ) {
		core_wp_page_templates_init();
	}
}

add_action( 'load-post.php', 'core_wp_page_templates_init_post' );
add_action( 'load-post-new.php', 'core_wp_page_templates_init_post' );

/**
 * Sets the default page template to a page, on save, if that
 * page does not have a template applied.
 *
 * @since 1.0.0
 * @internal
 */
function core_wp_set_default_template_on_save( $post ) {
	global $core_default_page_template;

	if ( ! is_int( $post ) ) $post = $post->ID;
	$page_template = core_get_page_template( $post );

	if ( ! $page_template ) {
		$_POST['page_template'] = $core_default_page_template;
		update_post_meta( $post, '_wp_page_template', $core_default_page_template );
	}
}

add_action( 'save_post_page', 'core_wp_set_default_template_on_save' );
add_action( 'rest_after_insert_page', 'core_wp_set_default_template_on_save' );

/**
 * Adds a custom "template" column to the pages list in the admin panel.
 *
 * @since 1.0.0
 * @internal
 *
 * @param string[] $columns
 * @return string[]
 */
function core_wp_manage_pages_columns( $columns ) {
	$new_columns = [
		'cb' => $columns['cb'],
		'title' => $columns['title'],
		'template' => __( 'Template', 'bsa_core' ),
		'author' => $columns['author'],
		'date' => $columns['date']
	];

	return $new_columns;
}

add_filter( 'manage_page_posts_columns', 'core_wp_manage_pages_columns' );

/**
 * Prints content to the new "template" column.
 *
 * @since 1.0.0
 * @internal
 *
 * @param string $column
 * @param int $post_id
 */
function core_wp_manage_pages_column ( $column, $post_id ) {
	$templates = wp_get_theme()->get_page_templates();

	if ( $column === 'template' ) {
		$template_path = get_post_meta( $post_id, '_wp_page_template', true );

		if ( array_key_exists( $template_path, $templates ) ) {
			echo $templates[ $template_path ];
		} else {
			echo '<p style="color: red; font-weight: bold">No template assigned</p>';
		}
	}
}

add_filter( 'manage_page_posts_custom_column', 'core_wp_manage_pages_column', 10, 2 );

/**
 * Adds the new "template" column to the list of sortable columns.
 *
 * @since 1.0.0
 * @internal
 *
 * @param string[] $columns
 * @return string[]
 */
function core_wp_manage_pages_columns_sortable ( $columns ) {
	$columns['template'] = 'page_template';

	return $columns;
}

add_filter( 'manage_edit-page_sortable_columns', 'core_wp_manage_pages_columns_sortable' );

/**
 * Manages the sorting feature for the "template" column.
 *
 * @since 1.0.0
 * @internal
 *
 * @param WP_Query $query
 */
function core_wp_manage_pages_columns_sort ( $query ) {
	if ( ! is_admin() || ! $query->is_main_query() ) return;

	if ( $query->get( 'orderby' ) === 'page_template' ) {
		$query->set( 'orderby', 'meta_value' );
		$query->set( 'meta_key', '_wp_page_template' );
	}
}

add_filter( 'pre_get_posts', 'core_wp_manage_pages_columns_sort' );

/**
 * Adds a custom filter for "template" to the pages list in the admin panel.
 *
 * @since 1.0.0
 * @internal
 */
function core_wp_print_page_template_filter() {
	global $core_page_templates;

	if ( get_current_screen()->id !== 'edit-page' ) return;

	/**
	 * The list of options for the select element.
	 *
	 * @var string[]
	 */
	$options = [
		'all' => 'All templates'
	];

	foreach ( $core_page_templates as $template ) {
		$options[ $template['slug'] ] = $template['name'];
	}

	/**
	 * The selected option. Defaults to "all".
	 *
	 * @var string
	 */
	$current = 'all';

	if ( isset( $_GET['core-template'] ) && array_key_exists( $_GET['core-template'], $options ) ) {
		$current = $_GET['core-template'];
	}

	// Print the select element.
	echo "\n\t<select name='core-template' id='filter-by-template'>";

	foreach ( $options as $value => $label ) {
		$selected = selected( $value, $current, false );
		echo "\n\t<option value='{$value}' {$selected}>{$label}</option>";
	}

	echo "\n\t</select>";
}

add_action( 'restrict_manage_posts', 'core_wp_print_page_template_filter' );

/**
 * Applies the custom "template" filter when loading pages in the admin panel.
 *
 * @since 1.0.0
 * @internal
 *
 * @param WP_Query $query
 */
function core_wp_filter_pages_by_template( $query ) {
	if ( ! function_exists( 'get_current_screen' ) ) return;
	if ( ! is_admin() || get_current_screen()->id !== 'edit-page' ) return;

	if ( isset( $_GET['core-template'] ) && $_GET['core-template'] !== 'all' ) {
		$query->query_vars['meta_key'] = '_wp_page_template';
		$query->query_vars['meta_value'] = $_GET['core-template'];
	}
}

add_action( 'pre_get_posts', 'core_wp_filter_pages_by_template' );

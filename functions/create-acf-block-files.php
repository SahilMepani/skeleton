<?php
/**
 * Helper function to create .php files for ACF blocks.
 *
 * @package WordPress
 * @subpackage Skeleton
 * @since 1.0.0
 */

/**
 * This function checks the $block_types values, sanitizes the block names,
 * and creates a new .php file inside the acf-blocks folder in the root directory
 * with the corresponding name. Only creates the file if it doesn't exist.
 *
 * @param array $block_types An array of block names.
 * @param array $blocks_with_js An array of block names using js.
 * @return void
 */
function skel_create_acf_block_files( array $block_types, array $blocks_with_js = array() ): void {
	global $wp_filesystem;

	// Initialize the WordPress filesystem API.
	if ( ! function_exists( 'WP_Filesystem' ) ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
	}

	WP_Filesystem();

	// Define the directory where the block files will be created.
	$php_directory  = get_template_directory() . '/acf-blocks/';
	$js_directory   = get_template_directory() . '/src/js/custom/acf-blocks/';
	$sass_directory = get_template_directory() . '/src/sass/partials/acf-blocks/';
	$style_file     = get_template_directory() . '/src/sass/style.scss';
	$template_file  = $php_directory . 'blank.php';

	// Initialize an array to hold the new import statements.
	$sass_imports = array();

	// Loop through each block type.
	foreach ( $block_types as $block ) {
		// Sanitize the block name by replacing spaces with dashes.
		$sanitize_title = sanitize_title( $block );

		// Define the full path to the block files.
		$php_file_path  = $php_directory . $sanitize_title . '.php';
		$js_file_path   = $js_directory . $sanitize_title . '.js';
		$sass_file_path = $sass_directory . '_' . $sanitize_title . '.scss';

		// Check if the PHP file already exists. If not, create it.
		if ( ! file_exists( $php_file_path ) ) {
			// Check if the template file exists.
			if ( file_exists( $template_file ) ) {
				// Get the content of the template file.
				$php_content = $wp_filesystem->get_contents( $template_file );
				if ( false !== $php_content ) {
					// Replace the placeholder string with the sanitized block name.
					$php_content = str_replace( 'blank-section', $sanitize_title . '-section', $php_content );
					$php_content = str_replace( 'Blank ACF block', $block . ' ACF Block', $php_content );
					// Create the new PHP file with the modified content.
					if ( ! $wp_filesystem->put_contents( $php_file_path, $php_content, FS_CHMOD_FILE ) ) {
						echo 'Error saving PHP file!';
					}
				} else {
					echo 'Error reading template file!';
				}
			} else {
				echo 'Template file does not exist!';
			}
		}

		// Only create JS file if it's listed in $blocks_with_js.
		if ( in_array( $block, $blocks_with_js, true ) ) {
			if ( ! file_exists( $js_file_path ) ) {
				if ( ! $wp_filesystem->put_contents( $js_file_path, '', FS_CHMOD_FILE ) ) {
					echo 'error saving JS file!';
				}
			}
		}

		// Check if the SASS file already exists. If not, create it.
		if ( ! file_exists( $sass_file_path ) ) {
			$sass_content = '.' . $sanitize_title . '-section {' . "\r\n\r\n" . '}';
			// Create the new SASS file with the modified content.
			if ( ! $wp_filesystem->put_contents( $sass_file_path, $sass_content, FS_CHMOD_FILE ) ) {
				echo 'Error saving SASS file!';
			}
		}

		// Add the import statement to the array.
		$sass_imports[] = "@import 'partials/acf-blocks/" . $sanitize_title . "';";

		// Update the style.scss file.
		update_style_scss( $style_file, $sass_imports );

		// Create JSON file.
		$json_file_path = get_template_directory() . '/functions/acf-json/' . $sanitize_title . '.json';
		if ( ! file_exists( $json_file_path ) ) {
			$json_data = array(
				'title'    => $block,
				// 'slug' => $sanitize_title, // Auto-generated
				'fields'   => array(
					array(
						'key'          => 'field_' . str_replace( '-', '_', $sanitize_title ) . '_block_options',
						'label'        => $block,
						'type'         => 'accordion',
						'open'         => 1,
						'multi_expand' => 1,
					),
					array(
						'key'   => 'field_' . str_replace( '-', '_', $sanitize_title ) . '_data_tab',
						'label' => 'Data',
						'type'  => 'tab',
					),
					// Add your content fields here...
					array(
						'key'   => 'field_' . str_replace( '-', '_', $sanitize_title ) . '_settings_tab',
						'label' => 'Settings',
						'type'  => 'tab',
					),
					array(
						'key'           => 'field_' . str_replace( '-', '_', $sanitize_title ) . '_display',
						'label'         => 'Show on Page',
						'name'          => 'display',
						'type'          => 'button_group',
						'choices'       => array(
							'on'  => 'Yes',
							'off' => 'No',
						),
						'default_value' => 'on',
					),
					array(
						'key'        => 'field_' . str_replace( '-', '_', $sanitize_title ) . '_spacing',
						'label'      => 'Spacing',
						'type'       => 'group',
						'layout'     => 'block',
						'sub_fields' => array(
							array(
								'key'        => 'field_' . str_replace( '-', '_', $sanitize_title ) . '_spacing_top_group',
								'label'      => 'Top',
								'name'       => 'top',
								'type'       => 'group',
								'layout'     => 'block',
								'sub_fields' => array(
									array(
										'key'           => 'field_' . str_replace( '-', '_', $sanitize_title ) . '_spacing_top',
										'label'         => 'Spacing Top',
										'name'          => 'spacing_top',
										'type'          => 'button_group',
										'choices'       => array(
											'none'    => 'None',
											'small'   => 'Small',
											'medium'  => 'Medium',
											'large'   => 'Large',
											'x-large' => 'X-Large',
											'custom'  => 'Custom',
										),
										'default_value' => 'medium',
									),
									array(
										'key'    => 'field_' . str_replace( '-', '_', $sanitize_title ) . '_custom_value_top',
										'label'  => 'Custom Value',
										'name'   => 'custom_value_top',
										'type'   => 'range',
										'min'    => 0,
										'max'    => 200,
										'step'   => 1,
										'append' => 'px',
										'conditional_logic' => array(
											array(
												array(
													'field'    => 'field_' . str_replace( '-', '_', $sanitize_title ) . '_spacing_top',
													'operator' => '==',
													'value'    => 'custom',
												),
											),
										),
									),
								),
							),
							array(
								'key'        => 'field_' . str_replace( '-', '_', $sanitize_title ) . '_spacing_bottom_group',
								'label'      => 'Bottom',
								'name'       => 'bottom',
								'type'       => 'group',
								'layout'     => 'block',
								'sub_fields' => array(
									array(
										'key'           => 'field_' . str_replace( '-', '_', $sanitize_title ) . '_spacing_bottom',
										'label'         => 'Spacing Bottom',
										'name'          => 'spacing_bottom',
										'type'          => 'button_group',
										'choices'       => array(
											'none'    => 'None',
											'small'   => 'Small',
											'medium'  => 'Medium',
											'large'   => 'Large',
											'x-large' => 'X-Large',
											'custom'  => 'Custom',
										),
										'default_value' => 'medium',
									),
									array(
										'key'    => 'field_' . str_replace( '-', '_', $sanitize_title ) . '_custom_value_bottom',
										'label'  => 'Custom Value',
										'name'   => 'custom_value_bottom',
										'type'   => 'range',
										'min'    => 0,
										'max'    => 200,
										'step'   => 1,
										'append' => 'px',
										'conditional_logic' => array(
											array(
												array(
													'field'    => 'field_' . str_replace( '-', '_', $sanitize_title ) . '_spacing_bottom',
													'operator' => '==',
													'value'    => 'custom',
												),
											),
										),
									),
								),
							),
						),
					),
					array(
						'key'          => 'field_' . str_replace( '-', '_', $sanitize_title ) . '_custom_css',
						'label'        => 'Custom CSS',
						'name'         => 'custom_css',
						'type'         => 'text',
						'instructions' => 'If unsure, do not edit.',
						'wrapper'      => array(
							'width' => '33',
						),
					),
					array(
						'key'          => 'field_' . str_replace( '-', '_', $sanitize_title ) . '_custom_classes',
						'label'        => 'Custom Class(es)',
						'name'         => 'custom_classes',
						'type'         => 'text',
						'instructions' => 'If unsure, do not edit.',
						'wrapper'      => array(
							'width' => '33',
						),
					),
					array(
						'key'          => 'field_' . str_replace( '-', '_', $sanitize_title ) . '_unique_id',
						'label'        => 'Unique ID',
						'name'         => 'unique_id',
						'type'         => 'text',
						'instructions' => 'only small case word allowed',
						'wrapper'      => array(
							'width' => '33',
						),
					),
				),
				'settings' => array(
					'description' => $block . ' block.',
					'icon'        => 'layout',
					'category'    => 'uncategorized',
				),
			);
			$wp_filesystem->put_contents( $json_file_path, wp_json_encode( $json_data, JSON_PRETTY_PRINT ), FS_CHMOD_FILE );
		}
	}
}

/**
 * Update the style.scss file with new ACF block imports.
 *
 * This function will find the section between // ACF Blocks and // END ACF Blocks
 * in the style.scss file and replace it with new import statements.
 *
 * @param string $style_file Path to the style.scss file.
 * @param array  $sass_imports Array of new import statements to add.
 * @return void
 */
function update_style_scss( string $style_file, array $sass_imports ): void {
	global $wp_filesystem;

	// Read the current content of the style.scss file.
	$styles_content = $wp_filesystem->get_contents( $style_file );

	if ( false === $styles_content ) {
		echo 'Error reading style.scss file!';
		return;
	}

	// Define the pattern to match the block between // ACF Blocks and // END ACF Blocks.
	$pattern = '/(\/\/ ACF Blocks)(.*?)(\/\/ END ACF Blocks)/s';

	// Create the new block content with the import statements.
	$new_block = "// ACF Blocks\n" . implode( "\n", $sass_imports ) . "\n\n// END ACF Blocks";

	// Replace the existing block with the new one.
	$updated_content = preg_replace( $pattern, $new_block, $styles_content );

	// Write the updated content back to the style.scss file.
	if ( ! $wp_filesystem->put_contents( $style_file, $updated_content, FS_CHMOD_FILE ) ) {
		echo 'Error updating style.scss file!';
	}
}

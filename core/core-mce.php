<?php
/**
 * Implements custom MCE/TinyMCE actions and buttons for rich text editing.
 *
 * @package Core
 * @subpackage MCE
 * @since 1.0.0
 */

/**
 * Registers the global component plugin.
 *
 * @since 1.0.0
 * @internal
 *
 * @param array $plugins
 * @return array
 */
function core_mce_register_component_plugin( $plugins ) {
	$plugins['coreComponents'] = TPL_URL.'/core/mce-plugins/core-components.js';
	return $plugins;
}

add_filter( 'mce_external_plugins', 'core_mce_register_component_plugin' );

/**
 * Retrieves the specfieid row of tools in the TinyMCE editor.
 *
 * @since 2.18.1
 * @internal
 *
 * @param int $row
 * @return string[]
 */
function core_mce_get_toolbar_row( $row ) {
	if ( $row === 1 ) {
		$text_colors = core_get_option( 'editor-text-colors', null );

		return array_filter([
			'styleselect',
			'bold',
			'italic',
			'underline',
			( $text_colors && ! empty( $text_colors ) ? 'forecolor' : false ),
			'blockquote',
			'strikethrough',
			'bullist',
			'numlist',
			'hr',
			'alignleft',
			'aligncenter',
			'alignright',
			'undo',
			'redo',
			'link'
		]);
	} else {
		$plugins = [];

		return array_map( function( $plugin ) {
			return $plugin['shortcode']['code'];
		}, $plugins );
	}
}

/**
 * Extends ACF's default TinyMCE toolbars.
 *
 * @since 1.0.0
 * @internal
 *
 * @param array $toolbars
 * @return array
 */
function core_mce_extend_acf_toolbars( $toolbars ) {
	$toolbars['Core'] = [
		1 => core_mce_get_toolbar_row( 1 ),
		2 => core_mce_get_toolbar_row( 2 )
	];

	return $toolbars;
}

add_filter( 'acf/fields/wysiwyg/toolbars', 'core_mce_extend_acf_toolbars' );

/**
 * Extends WordPress' default TinyMCE toolbars.
 *
 * @since 2.18.1
 * @internal
 *
 * @return string[]
 */
add_filter( 'mce_buttons', function() {
	return core_mce_get_toolbar_row( 1 );
});

add_filter( 'mce_buttons_2', function() {
	return core_mce_get_toolbar_row( 2 );
});

/**
 * Extend the format select options.
 *
 * @since 1.0.0
 * @internal
 *
 * @param array $mce
 * @return array
 */
function core_mce_extend_format_options( $mce ) {
	$mce['wordpress_adv_hidden'] = false;
	$mce['preview_styles'] = false;

	// Add custom CSS.
	$content_css = isset( $mce['content_css'] ) ? explode( ',', $mce['content_css'] ) : [];
	$content_css[] = TPL_URL.'/build/core/index.css';
	$mce['content_css'] = join( ',', $content_css );

	// Add custom text styles.
	$text_styles = core_get_option( 'editor-text-styles', [] );

	$mce['style_formats'] = wp_json_encode(
		array_map( function( $group ) {
			$group['items'] = array_map( function( $key, $style ) {
				return [
					'title' => $style[1],
					'block' => $style[0],
					'exact' => true,
					'attributes' => [
						'class' => $key
					]
				];
			}, array_keys( $group['items'] ), array_values( $group['items'] ) );

			return $group;
		}, $text_styles )
	);

	// Add custom colors.
	$text_colors = core_get_option( 'editor-text-colors', [] );

	$mce_text_colors = [];

	foreach ( $text_colors as $color_code => $color_name ) {
		$color_code = str_replace( '#', '', $color_code );
		if ( strlen( $color_code ) !== 6 ) continue;

		$mce_text_colors[] = $color_code;
		$mce_text_colors[] = $color_name;
	}

	$mce['textcolor_map'] = json_encode( $mce_text_colors );

    return $mce;
}

add_filter( 'tiny_mce_before_init', 'core_mce_extend_format_options' );

/**
 * Removes the option to set custom colors in the Rich Text field.
 *
 * @since 2.16.2
 *
 * @param mixed[] $plugins
 * @return mixed[]
 */
function core_mce_disable_colorpicker( $plugins ) {
	return array_values(
		array_filter( $plugins, function( $plugin ) {
			return $plugin !== 'colorpicker';
		})
	);
}

add_filter( 'tiny_mce_plugins', 'core_mce_disable_colorpicker' );

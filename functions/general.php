<?php
/**
 * Includes general functions to help with the development process.
 *
 * @package Core
 * @subpackage General Utilities
 */

/**
 * A global list of sequential, but not unique IDs.
 *
 * This is used as the current page is rendered to generate unique IDs for components,
 * sections and other aspects of the development process.
 *
 * @var int[]
 */
global $core_unique_ids;
$core_unique_ids = [];

/**
 * Generates a unique ID.
 *
 * @since 2.8.0
 *
 * @param string $scope
 * @return string
 */
function core_id( $scope ) {
	global $core_unique_ids;

	if ( ! array_key_exists( $scope, $core_unique_ids ) ) {
		$core_unique_ids[ $scope ] = 0;
	}

	$core_unique_ids[ $scope ]++;

	return "{$scope}-{$core_unique_ids[$scope]}";
}

/**
 * Checks if the specified array is associative or sequential.
 *
 * @since 1.0.0
 *
 * @param array $arr
 * @return boolean 'true' for associative, 'false' for sequential.
 */
function core_is_assoc( $arr ) {
	if ( $arr === array() || ! is_array( $arr ) ) return false;
	return array_keys( $arr ) !== range( 0, count( $arr ) - 1 );
}

/**
 * Searches recusively for files in a base directory matching a glob pattern.
 *
 * @since 1.0.0
 *
 * @param string $base
 * @param string $pattern
 * @param int $flags
 * @return string[] Array of files matching the pattern
 */
function core_glob( $base, $pattern, $flags = 0 ) {
	$flags = $flags & ~GLOB_NOCHECK;

	if ( substr( $base, -1 ) !== DIRECTORY_SEPARATOR ) {
		$base .= DIRECTORY_SEPARATOR;
	}

	$files = glob( $base.$pattern, $flags );
	if ( ! is_array( $files ) ) $files = [];

	$dirs = glob( $base.'*', GLOB_ONLYDIR|GLOB_NOSORT|GLOB_MARK );
	if ( ! is_array( $dirs ) ) return $files;

	foreach ( $dirs as $dir ) {
		$dir_files = core_glob( $dir, $pattern, $flags );
		$files = array_merge( $files, $dir_files );
	}

	return $files;
}

/**
 * Checks if an array has the specified attribute and returns it. If the attribute
 * doesn’t exist in the array, it returns the specified default value.
 *
 * @since 1.0.0
 * @since 1.1.4 Now checks if '$args' is an array at all.
 *
 * @param string $key
 * @param array $args
 * @param mixed $default
 * @return mixed
 */
function core_default( $key, $args, $default ) {
	if ( ! is_array( $args ) || ! array_key_exists( $key, $args ) ) return $default;
	return $args[ $key ];
}

/**
 * Sanitizes title strings, replacing dashes with underscores.
 *
 * @since 1.0.0
 *
 * @param string $str=""
 * @return string
 */
function core_sanitize_title_underscore( $str="" ) {
	return str_replace( '-', '_', sanitize_title( $str ) );
}

/**
 * Checks if the slug matches the Core standards.
 *
 * @since 1.0.0
 * @internal
 *
 * @param string $slug
 * @return boolean
 */
function core_check_slug( $slug ) {
	$valid = preg_match( '/^[a-z0-9\-\.]+$/', $slug );
	return $valid === 1;
}

/**
 * Checks the integrity of registration data for various
 * custom content types.
 *
 * Throws an exception if the integrity is questionable.
 *
 * @since 1.0.0
 * @internal
 *
 * @param string $entity The entity to check.
 * @param callable [$custom_check=false] Optional custom callback to run additional checks.
 */
function core_check_entity_integrity( $entity, $custom_check=null ) {
	$type = $entity['type'];
	$file = $entity['file'];
	$data = core_default( 'data', $entity, [] );

	$no_data = core_default( 'no_data', $entity, false );
	$data_required = core_default( 'data_required', $entity, true );

	$required_files = $entity['required_files'] ?? [];
	$required_options = $entity['required_options'] ?? [];

	/**
	 * The base exception object.
	 *
	 * @var Exception
	 */
	$e = new Exception( "Invalid configuration found: *{$file['path']}*" );
	$e->data = [];

	// Check if the entity is being registered in the base directory.
	$base = core_default( 'base', $entity, false );

	if ( $base && $file['dirname'] === $base ) {
		$e->data[] = "Entities should not be declared in the base directory: `{$base}`";
		goto end;
	}

	// Check if the slug source is valid.
	$slug_source = $type === 'file' ? $file['name'] : $file['dirname'];

	if ( ! core_check_slug( $slug_source ) ) {
		$e->data[] = "Invalid name: {$slug_source}";
		goto end;
	}

	// Check if the registration data is valid.
	if (
		$data_required &&
		! $no_data &&
		( ! is_array( $data ) || empty( $data ) )
	) {
		$e->data[] = 'Invalid or missing registration data.';
		goto end;
	}

	// Check if all the required options exist.
	$missing_required_options = core_check_required_attributes( $data, $required_options );

	if ( is_array( $missing_required_options ) ) {
		foreach ( $missing_required_options as $option ) {
			$e->data[] = "Missing required option: `{$option}`";
		}
	}

	// Check if all the required files exist.
	if ( $type === 'dir' && ! empty( $required_files ) ) {
		foreach ( $required_files as $r_file ) {
			$r_file_path = $file['info']['dirname'] . '/' . $r_file;

			if ( ! is_file( $r_file_path ) ) {
				$e->data[] = "Missing required file: *{$r_file}*";
			}
		}
	}

	// Run custom checks.
	if ( $custom_check ) {
		$custom_errors = call_user_func( $custom_check, $entity );

		if (
			$custom_errors ||
			( is_array( $custom_errors ) && ! empty( $custom_errors ) )
		) {
			if ( is_array( $custom_errors ) ) {
				$e->data = array_merge( $e->data, $custom_errors );
			} elseif ( is_string( $custom_errors ) ) {
				$e->data[] = $custom_errors;
			}
		}
	}

	end:
		if ( ! empty( $e->data ) ) {
			throw $e;
		}
}

/**
 * Scans the specified directory and runs the callback function on each file.
 *
 * @since 1.0.0
 * @internal
 *
 * @param string $base_dir
 * @param string $pattern
 * @param callable $callback
 * @return mixed[]
 */
function core_scan_dir( $base_dir, $pattern, $callback ) {

	/**
	 * Bail early if the specified callback is not a function.
	 *
	 * This is a critical error.
	 */
	if ( ! is_callable( $callback ) ) {
		throw new ErrorException( 'The provided callback is not callable.' );
	}

	/**
	 * The final list of files.
	 * Each modified file will be stored here.
	 *
	 * @var array
	 */
	$results = [];

	// Run scan.
	$files_found = core_glob( $base_dir, $pattern );

	if ( empty( $files_found ) ) return $files_found;

	foreach ( $files_found as $file_path ) {
		$file_name = explode( DIRECTORY_SEPARATOR, $file_path );
		$file_name = end( $file_name );

		$file_path_rel = explode( $base_dir, $file_path )[1];
		$file_path_rel = str_replace( '/'.$file_name, '', $file_path_rel );

		$file_info = pathinfo( $file_path );

		$dir_name = explode( '/', $file_path );
		end( $dir_name );
		$dir_name = prev( $dir_name );

		$result = call_user_func( $callback, [
			'name' => $file_name,
			'dirname' => $dir_name,
			'path' => $file_path,
			'path_rel' => $file_path_rel,
			'info' => $file_info,
			'size' => filesize( $file_path )
		]);

		if ( $result === null ) continue;

		$results[] = $result;
	}

	// Return.
	return $results;
}

/**
 * Checks if an array includes all the specified attributes.
 *
 * @since 1.0.0
 * @internal
 *
 * @param array $arr
 * @param array $required_attributes
 * @return (boolean|array)
 */
function core_check_required_attributes( $arr, $required_attributes ) {
	$missing_attributes = array_filter( $required_attributes, function( $attr_name ) use( $arr ) {
		return ! array_key_exists( $attr_name, $arr );
	});

	return ! empty( $missing_attributes ) ? $missing_attributes : true;
}

/**
 * Prints a link to the specified admin page.
 *
 * @since 1.0.0
 * @since 1.1.3 Added support for new tabs.
 *
 * @param string $page
 * @param string $text
 * @param boolean [$new_tab=false]
 * @return string
 */
function core_admin( $page, $text, $new_tab=false ) {
	$admin_url = admin_url( $page );
	$target = $new_tab ? '_blank' : '';
	$result = '<a href="'.$admin_url.'" target="'.$target.'">'.$text.'</a>';

	return $result;
}

/**
 * Prints a link to the specified documentation page.
 *
 * @since 1.0.0
 *
 * @param string $page
 * @param string $text=""
 * @return string
 */
function core_docs( $page, $text="" ) {
	if ( ! $text ) {
		$text = 'Read the {documentation} for more information.';
	}

	/**
	 * The list of pages.
	 *
	 * @var string[]
	 */
	$doc_pages = [
		'default' => '',
		'configuration' => '869957636',
		'custom-fields' => '869761186',
		'options-pages' => '869859435',
		'page-templates' => '869826714',
		'post-types' => '869859412',
		'section-library' => '869859456',
		'taxonomies' => '869793976'
	];

	if ( ! array_key_exists( $page, $doc_pages ) ) $page = 'default';

	$docs_url = 'https://blacksmithagency.atlassian.net/wiki/spaces/BCT/pages/'.$doc_pages[ $page ];

	if ( preg_match( '/{.+}/U', $text ) ) {
		$result = preg_replace( '/{.+}/U', '<a href="' . $docs_url . '" target="_blank">$0</a>', $text );
		$result = str_replace([ '{', '}' ], '', $result );
	} else {
		$result = '<a href="' . $docs_url . '" target="_blank">' . $text . '</a>';
	}

	return $result;
}

/**
 * Renders a style with MD5 hash of the file.
 *
 * @since 1.0.0
 *
 * @param string $name
 * @param string $path
 */
function core_render_style( $name, $path ) {
    if ( preg_match( '/^(\/\/|http)/', $path ) ) {
        wp_enqueue_style( $name, $path );
    } else if ( file_exists( TPL_PATH . $path ) ) {
        $hash = md5_file( TPL_PATH . $path );
        $path = TPL_URL . $path;

        wp_enqueue_style( $name, $path, array(), $hash );
    } else {
        echo "<!-- Style {$name} not loaded -->";
    }
}

/**
 * Renders a script with MD5 hash of the file.
 *
 * @since 1.0.0
 *
 * @param string $name
 * @param string $path
 */
function core_render_script( $name, $path ) {
    if ( preg_match( '/^(\/\/|http)/', $path ) ) {
        wp_enqueue_script( $name, $path );
    } else if ( file_exists( TPL_PATH . $path ) ) {
        $hash = md5_file( TPL_PATH . $path );
        $path = TPL_URL . $path;

        wp_enqueue_script( $name, $path, array(), $hash );
    } else {
        echo "<!-- Script {$name} not loaded -->";
    }
}

/**
 * Applies formatting to a piece of text, replacing markers with HTML tags.
 *
 * @since 1.0.0
 *
 * @param string $text
 * @param array|boolean $tags=false Specific tags to format the text with.
 * @return string
 */
function core_format_text_tags( $text, $tags=false ) {
	$symbols = [
		'code' => '`',
		'em' => '_',
		'strong' => '\*'
	];

	foreach ( $symbols as $tag => $symbol ) {
		if ( is_array( $tags ) && ! in_array( $tag, $tags ) ) continue;

		$text = preg_replace( '/' . $symbol . '.+' . $symbol . '/U' , "<{$tag}>$0</{$tag}>", $text );
		$symbol = str_replace( '\\', '', $symbol );
		$text = str_replace( $symbol, '', $text );
	}

	return $text;
}

/**
 * Retrieves the YouTube video ID from a given URL.
 *
 * @param string $url
 * @return string|null
 */
function core_get_youtube_video_id( $url ) {
	preg_match( "/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user|shorts)\/))([^\?&\"'>]+)/", $url, $matches );

	return ( ! empty( $matches ) ) ? $matches[1] : null;
}

/**
 * Get the embed URL for either Vimeo or Youtube URLs.
 *
 * @param array $video
 * @return array
 */
function core_prepare_video( $video ) {
	if ( $video['type'] === 'file' ) return $video;

	$is_youtube = str_contains( $video['url'], 'youtu' );
	$is_vimeo = str_contains( $video['url'], 'vimeo' );

	if ( $is_youtube ) {
		$video['provider'] = 'youtube';
		$video['url'] = 'https://www.youtube.com/embed/' . core_get_youtube_video_id( $video['url'] );
	} else if ( $is_vimeo ) {
		preg_match( "/(?:http:|https:|)\/\/(?:player.|www.)?vimeo\.com\/(?:video\/|embed\/|watch\?\S*v=|v\/)?(\d*)/", $video['url'], $matches );
		$video['provider'] = 'vimeo';
		$video['url'] = 'https://player.vimeo.com/video/' . $matches[1];
	}

	return $video;
}

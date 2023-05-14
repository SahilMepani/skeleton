<?php


define('FUNC_DIR', get_template_directory() . '/functions/');

/**
 * Get blocks parent dir
 * @var string path
 */
define('BLOCKS_DIR', get_template_directory() . '/acf-blocks/');

/**
 * Get the path of all folders inside blocks parent dir
 * @var array
 */
define('BLOCK_DIR_PATHS', glob(BLOCKS_DIR . '*' , GLOB_ONLYDIR));

/**
 * Extract basename from filename in array
 * @param function basename
 * @param array $block_dir_paths
 * @return array
 */
define('BLOCK_DIR_NAMES', array_map( 'basename', BLOCK_DIR_PATHS ));




/**
 * The template path.
 *
 * @var string
 */
if ( ! defined( 'TPL_PATH' ) ) {
	define( 'TPL_PATH', get_template_directory() );
}

/**
 * The template URL.
 *
 * @var string
 */
if ( ! defined( 'TPL_URL' ) ) {
	define( 'TPL_URL', get_template_directory_uri() );
}

/**
 * The core path.
 *
 * @var string
 */
if ( ! defined( 'CORE_PATH' ) ) {
	define( 'CORE_PATH', TPL_PATH . '/core' );
}

/**
 * The packages path.
 *
 * @var string
 */
if ( ! defined( 'PKG_PATH' ) ) {
	define( 'PKG_PATH', TPL_PATH . '/packages' );
}

/**
 * The package assets path.
 *
 * @var string
 */
if ( ! defined( 'PKG_ASSETS_PATH' ) ) {
	define( 'PKG_ASSETS_PATH', PKG_PATH . '/assets' );
}

/**
 * The content types path.
 *
 * @var string
 */
if ( ! defined( 'PKG_CONTENT_PATH' ) ) {
	define( 'PKG_CONTENT_PATH', PKG_PATH . '/content' );
}

/**
 * The layouts path.
 */
if ( ! defined( 'PKG_LAYOUTS_PATH' ) ) {
	define( 'PKG_LAYOUTS_PATH', PKG_PATH . '/layouts' );
}

// Load Core functionality.
require_once CORE_PATH . '/core.php';


// require_once( get_template_directory() . '/functions/shortcodes.php' );
// require_once get_template_directory() . '/functions/core.php';
// require_once get_template_directory() . '/functions/register-nav-menus.php';
// require_once get_template_directory() . '/functions/miscellaneous.php';
// require_once get_template_directory() . '/functions/helpers.php';
// require_once get_template_directory() . '/functions/disable-auto-embed-script.php';
// require_once get_template_directory() . '/functions/disable-wp-generated-image-sizes.php';
// require_once get_template_directory() . '/functions/add-image-sizes.php';
// require_once get_template_directory() . '/functions/custom-login.php';
// require_once get_template_directory() . '/functions/acf-register-blocks.php';
// require_once get_template_directory() . '/functions/block-editor-settings.php';
// require_once get_template_directory() . '/functions/enqueue-scripts.php';
// require_once get_template_directory() . '/functions/remove-junk-from-head.php';
// require_once get_template_directory() . '/functions/wp-plugins.php';
// require_once get_template_directory() . '/functions/security.php';
// require_once get_template_directory() . '/functions/remove-comments.php';
// require_once get_template_directory() . '/functions/acf-options-page.php';
// require_once get_template_directory() . '/functions/remove-post-type.php';
// require_once get_template_directory() . '/functions/allowed-blocks.php';
// require_once get_template_directory() . '/functions/disable-blocks-directory.php';
// require_once get_template_directory() . '/functions/skip-dashboard.php';
// require_once get_template_directory() . '/functions/general.php';
// require_once get_template_directory() . '/functions/section-library.php';
// require_once get_template_directory() . '/functions/notices.php';
// require_once( get_template_directory() . '/functions/custom-post-types.php' );
// require_once( get_template_directory() . '/functions/custom-admin-columns.php' );
// require_once( get_template_directory() . '/functions/admin-ajax.php' );
// require_once( get_template_directory() . '/functions/remove-admin-menu-items.php' );
// only if amp plugin available
// require_once( get_template_directory() . '/functions/amp.php' )

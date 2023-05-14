<?php

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



// require_once( get_template_directory() . '/functions/shortcodes.php' );
require_once get_template_directory() . '/functions/config.php';
require_once get_template_directory() . '/functions/general.php';
require_once get_template_directory() . '/functions/core-post-types.php';
require_once get_template_directory() . '/functions/core-acf.php';
require_once get_template_directory() . '/functions/core-section-library.php';
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

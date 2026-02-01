<?php
/**
 * Load functions
 *
 * @package WordPress
 * @subpackage Skeleton
 * @since 1.0.0
 */

// require get_template_directory() . '/functions/shortcodes.php';
require get_template_directory() . '/functions/define-constants.php';
require get_template_directory() . '/functions/register-nav-menus.php';
require get_template_directory() . '/functions/helpers.php';
require get_template_directory() . '/functions/hooks.php';
require get_template_directory() . '/functions/disable-auto-embed-script.php';
require get_template_directory() . '/functions/disable-wp-generated-image-sizes.php';
require get_template_directory() . '/functions/add-image-sizes.php';
require get_template_directory() . '/functions/create-acf-block-files.php';
require get_template_directory() . '/functions/delete-unwanted-acf-block-files.php';
require get_template_directory() . '/functions/acf-block-helpers.php';
require get_template_directory() . '/functions/register-acf-blocks.php';
require get_template_directory() . '/functions/block-editor-settings.php';
require get_template_directory() . '/functions/enqueue-scripts.php';
require get_template_directory() . '/functions/remove-junk-from-head.php';
require get_template_directory() . '/functions/wp-plugins.php';
require get_template_directory() . '/functions/remove-comments.php';
require get_template_directory() . '/functions/remove-default-post-type.php';
require get_template_directory() . '/functions/allowed-blocks.php';
require get_template_directory() . '/functions/disable-blocks-directory.php';
require get_template_directory() . '/functions/skip-dashboard.php';
require get_template_directory() . '/functions/dequeue-scripts.php';
require get_template_directory() . '/functions/protected-pages.php';
require get_template_directory() . '/functions/admin-notices.php';
require get_template_directory() . '/functions/add-svg-support.php';
require get_template_directory() . '/functions/admin-ajax.php';
require get_template_directory() . '/functions/wp-cache.php';
// if ( is_login_or_registration_page() ) {
// require_once get_template_directory() . '/functions/captcha.php';
// }

// require get_template_directory() . '/functions/acf-options-page.php';
// require get_template_directory() . '/functions/custom-login.php';
// require( get_template_directory() . '/functions/custom-post-types.php' );
// require get_template_directory() . '/functions/remove-admin-menu-items.php';

if ( 'local' === wp_get_environment_type() && current_user_can( 'manage_options' ) ) {
	require get_template_directory() . '/functions/debugging.php';
}

if ( 'production' === wp_get_environment_type() ) {
	require get_template_directory() . '/functions/security.php';
}

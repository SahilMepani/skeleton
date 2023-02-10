<?php

require_once get_template_directory() . '/functions/miscellaneous.php';
require_once get_template_directory() . '/functions/helpers.php';
require_once get_template_directory() . '/functions/disable-auto-embed-script.php';
require_once get_template_directory() . '/functions/disable-wp-generated-image-sizes.php';
require_once get_template_directory() . '/functions/add-image-sizes.php';
require_once get_template_directory() . '/functions/register-acf-blocks.php';
require_once get_template_directory() . '/functions/block-editor-settings.php';
require_once get_template_directory() . '/functions/enqueue-scripts.php';
require_once get_template_directory() . '/functions/remove-junk-from-head.php';
require_once get_template_directory() . '/functions/wp-plugins.php';
require_once get_template_directory() . '/functions/remove-comments.php';
require_once get_template_directory() . '/functions/remove-post-type.php';
require_once get_template_directory() . '/functions/allowed-blocks.php';
require_once get_template_directory() . '/functions/disable-blocks-directory.php';
require_once get_template_directory() . '/functions/skip-dashboard.php';

// Register menus
////////////////////////////////////////////////
register_nav_menus(
	[
		'header-menu' => 'Header Menu',
		'footer-menu' => 'Footer Menu'
	]
);

/*----------  REQUIRED - Do not edit  ----------*/

/*============================================================
=            Overrides default image-URL behavior            =
============================================================*/
// http://wordpress.org/support/topic/insert-image-default-to-no-link
update_option( 'image_default_link_type', 'none' );

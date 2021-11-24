<?php

// require_once( get_template_directory() . '/functions/shortcodes.php' );
require_once( get_template_directory() . '/functions/miscellaneous.php' );
require_once( get_template_directory() . '/functions/helpers.php' );
require_once( get_template_directory() . '/functions/disable-auto-embed-script.php' );
require_once( get_template_directory() . '/functions/disable-wp-generated-image-sizes.php' );
require_once( get_template_directory() . '/functions/add-image-sizes.php' );
require_once( get_template_directory() . '/functions/custom-login.php' );
require_once( get_template_directory() . '/functions/register-acf-blocks.php' );
require_once( get_template_directory() . '/functions/block-editor-settings.php' );
require_once( get_template_directory() . '/functions/enqueue-scripts.php' );
require_once( get_template_directory() . '/functions/remove-junk-from-head.php' );
require_once( get_template_directory() . '/functions/wp-plugins.php' );
require_once( get_template_directory() . '/functions/security.php' );
// require_once( get_template_directory() . '/functions/custom-post-types.php' );
// require_once( get_template_directory() . '/functions/custom-admin-columns.php' );
require_once( get_template_directory() . '/functions/admin-ajax.php' );
// only if amp plugin available
// require_once( get_template_directory() . '/functions/amp.php' );


// Register menus
////////////////////////////////////////////////
register_nav_menus(
  array(
    'header-menu' => 'Header Menu',
    'footer-menu' => 'Footer Menu',
  )
);

/*=========================================
=            Register sidebars            =
=========================================*/
// $sidebars = array('Blog');
// foreach ($sidebars as $sidebar) :
//   register_sidebar(
//     array(
//       'name' => $sidebar,
//       'before_widget' => '<li id="%1$s" class="widget %2$s clearfix">',
//       'after_widget' => '</li>',
//       'before_title' => '<h4 class="widget-heading">',
//       'after_title' => '</h4>',
//     )
//   );
// endforeach;


/*----------  REQUIRED - Do not edit  ----------*/

/*=============================================
=            Add editor stylesheet            =
=============================================*/
add_editor_style();


/*============================================================
=            Overrides default image-URL behavior            =
============================================================*/
// http://wordpress.org/support/topic/insert-image-default-to-no-link
update_option('image_default_link_type', 'none');
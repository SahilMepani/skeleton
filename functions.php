<?php

// require_once( get_template_directory() . '/functions/shortcodes.php' );
require_once( get_template_directory() . '/functions/filters.php' );
require_once( get_template_directory() . '/functions/action.php' );
require_once( get_template_directory() . '/functions/acf-css.php' );
require_once( get_template_directory() . '/functions/helpers.php' );
require_once( get_template_directory() . '/functions/disable-wp-generated-image-sizes.php' );
require_once( get_template_directory() . '/functions/add-image-sizes.php' );
require_once( get_template_directory() . '/functions/register-acf-blocks.php' );
require_once( get_template_directory() . '/functions/block-editor-settings.php' );
require_once( get_template_directory() . '/functions/enqueue-scripts.php' );
require_once( get_template_directory() . '/functions/remove-junk-from-head.php' );
require_once( get_template_directory() . '/functions/wp-plugins.php' );
// require_once( get_template_directory() . '/functions/custom-post-types.php' );
// require_once( get_template_directory() . '/functions/custom-admin-columns.php' );
// require_once( get_template_directory() . '/functions/admin-ajax.php' );
// only if amp plugin available
// require_once( get_template_directory() . '/functions/amp.php' );

/*----------  Enable login captcha  ----------*/
// function is_login_page() {
// 	return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
// }
// if ( is_login_page() ) {
// 	require_once( get_template_directory() . '/functions/captcha.php' );
// }


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


/* ======================================================
=            Disable file editor in backend            =
====================================================== */
// define('DISALLOW_FILE_EDIT', TRUE);


/*=====================================================
=            Enable Typekit font in editor            =
=====================================================*/
/* Dont forget to add the typekit ID in the below file */

// function tse_mce_external_plugins($plugin_array) {
//   $plugin_array['typekit'] = get_template_directory_uri() . '/js/typekit.tinymce.js';
//   return $plugin_array;
// }
// add_filter("mce_external_plugins", "tse_mce_external_plugins");


/* =========================================
=            Set content width            =
========================================= */
// if ( !isset($content_width) ) $content_width = 1140; // highest content width


/*==============================================
=            Single/Page pagination            =
==============================================*/
/* http://bavotasan.com/2012/a-better-wp_link_pages-for-wordpress/
 * The formatted output of a list of pages.
 *
 * Displays page links for paginated posts (i.e. includes the "nextpage".
 * Quicktag one or more times). This tag must be within The Loop.
 *
 * @param string|array $args Optional. Overwrite the defaults.
 * @return string Formatted output in HTML.
 */

// function tse_wp_link_pages($args = '') {
//   $defaults = array(
//       'before' => '<div class="single-pagination">' . '<span class="index">Pages:</span>',
//       'after' => '</div>',
//       'text_before' => '',
//       'text_after' => '',
//       'next_or_number' => 'number',
//       'nextpagelink' => 'Next page',
//       'previouspagelink' => 'Previous page',
//       'pagelink' => '%',
//       'echo' => 1
//   );
//   $r = wp_parse_args($args, $defaults);
//   $r = apply_filters('wp_link_pages_args', $r);
//   extract($r, EXTR_SKIP);
//   global $page, $numpages, $multipage, $more, $pagenow;
//   $output = '';
//   if ($multipage) {
//     if ('number' == $next_or_number) {
//       $output .= $before;
//       for ($i = 1; $i < ( $numpages + 1 ); $i = $i + 1) {
//         $j = str_replace('%', $i, $pagelink);
//         $output .= ' ';
//         if ($i != $page || ( (!$more ) && ( $page == 1 ) ))
//           $output .= _wp_link_page($i);
//         else
//           $output .= '<span class="current">';
//         $output .= $text_before . $j . $text_after;
//         if ($i != $page || ( (!$more ) && ( $page == 1 ) ))
//           $output .= '</a>';
//         else
//           $output .= '</span>';
//       }
//       $output .= $after;
//     } else {
//       if ($more) {
//         $output .= $before;
//         $i = $page - 1;
//         if ($i && $more) {
//           $output .= _wp_link_page($i);
//           $output .= $text_before . $previouspagelink . $text_after . '</a>';
//         }
//         $i = $page + 1;
//         if ($i <= $numpages && $more) {
//           $output .= _wp_link_page($i);
//           $output .= $text_before . $nextpagelink . $text_after . '</a>';
//         }
//         $output .= $after;
//       }
//     }
//   }
//   if ($echo)
//     echo $output;
//   return $output;
// }


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


// Blog Pagination
// http://wp.tutsplus.com/tutorials/wordpress-pagination-a-primer
/* ========================================== */
// function tse_posts_pagination( $pages ) {
//   $total_pages = $pages;

//   if ( $total_pages > 1 ) {

//     $current_page = max( 1, get_query_var( 'paged' ) );

//     echo '<div class="posts-pagination">';

//     echo '<span class="index"> Page ' . $current_page . ' of ' . $total_pages . "</span>";

//     echo paginate_links(array(
//         'base'      => get_pagenum_link( 1 ) . '%_%',
//         'format'    => 'page/%#%/',
//         'current'   => $current_page,
//         'total'     => $total_pages,
//         'type'      => 'list', // plain, array, list
//         'prev_text' => '&lsaquo; Previous',
//         'next_text' => 'Next &rsaquo;',
//     ));
//     echo '</div>';
//   }
// }

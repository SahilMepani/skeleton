<?php

/* =====================================
=            Require files            =
===================================== */
require_once( get_template_directory() . '/functions/shortcodes.php' );
require_once( get_template_directory() . '/functions/helpers.php' );
require_once( get_template_directory() . '/functions/filters.php' );
require_once( get_template_directory() . '/functions/acf.php' );
require_once( get_template_directory() . '/functions/custom-post-types.php' );
require_once( get_template_directory() . '/functions/admin-ajax.php' );
// require_once( get_template_directory() . '/functions/twitter-feed/feed.php' );
// require_once( get_template_directory() . '/functions/instagram-feed/feed.php' );
// require_once( get_template_directory() . '/functions/pinterest-feed/feed.php' );
// require_once( get_template_directory() . '/functions/post-like/post-like.php' );

// function is_login_page() {
// 	return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
// }
// if ( is_login_page() ) {
// 	require_once( get_template_directory() . '/functions/captcha.php' );
// }


/* =========================================
=            Set content width            =
========================================= */
if ( !isset($content_width) )
	$content_width = 1140; //highest content width


/* ===========================================
=            Enqueue javascripts            =
=========================================== */
function tse_scripts() {
	/* Load google fonts */
	wp_enqueue_style('google-fonts', '//fonts.googleapis.com/css?family=Lato:400,400i,600,600i,700,700i&subset=latin,latin-ext', 'all');

	/* Do not load in backend */
	if (is_admin()) return;

	/* wp_enqueue_script( 'identifier', 'url', 'dependency', version', '' ); */
	wp_enqueue_style('skeleton-style', get_stylesheet_uri(), array(), '1.0');
	wp_enqueue_script('modernizr', get_template_directory_uri() . '/js/vendor/modernizr-3.3.1.min.js');
	wp_enqueue_script('plugins', get_template_directory_uri() . '/js/plugins.js', array('jquery'), '1.0', true);
	wp_enqueue_script('custom', get_template_directory_uri() . '/js/custom.js', array('jquery', 'plugins'), '1.0', true);
	/* First argument is the handle where it is used */
	wp_localize_script('custom', 'localize_var', array(
		'adminUrl' => admin_url('admin-ajax.php'),
	));
}

add_action('wp_enqueue_scripts', 'tse_scripts');


/* ===============================================
=            Create/Edit media sizes            =
=============================================== */
/* Enable featured images */
add_theme_support('post-thumbnails');

/* Update default media sizes */
update_option( 'medium_size_w', 600 );
update_option( 'medium_size_h', 9999 );
update_option( 'large_size_w', 1200 );
update_option( 'large_size_h', 9999 );

/* Custom media sizes */
//add_image_size( 'blog_featured_thumb', width, height, crop );
add_image_size( 'w300', 300, 9999 ); // used for preview
add_image_size( 'h200', 9999, 200 ); // used for preview
add_image_size( 'w600h400_c', 600, 400, true );
add_image_size( 'w300h300c', 300, 300, true );
add_image_size( 'w800', 800, 9999 );
add_image_size( 'w1250', 1250, 9999 );
add_image_size( 'w1920h900', 1920, 9999 );
add_image_size( 'w1600h900', 1600, 900 );
add_image_size( 'w2560', 2560, 9999 );
add_image_size( 'w2560h900', 2560, 900 );
add_image_size( 'w2560h1600', 2560, 1600 );


/*=========================================
=            Register Sidebars            =
=========================================*/
// $sidebars = array('Blog');
// $id = 1;
// foreach ($sidebars as $sidebar) :
//   register_sidebar(
//     array(
//       'name' => $sidebar,
//       'id' => $id,
//       'before_widget' => '<li id="%1$s" class="widget %2$s clearfix">',
//       'after_widget' => '</li>',
//       'before_title' => '<h4 class="widget-heading">',
//       'after_title' => '</h4>',
//     )
//   );
//   $id++;
// endforeach;


/*======================================
=            Register menus            =
======================================*/
register_nav_menus(
	array(
		'header-menu' => 'Header Menu',
		'footer-menu' => 'Footer Menu',
	)
);

/* ----------  Create menus  ---------- */
// wp_create_nav_menu('Header');
// wp_create_nav_menu('Footer');



/* ======================================================
=            Disable file editor in backend            =
====================================================== */
// define('DISALLOW_FILE_EDIT', TRUE);


/*===============================================
=            Disable all the updates            =
===============================================*/
// define('DISALLOW_FILE_MODS', true);


/*=============================================
=            Add editor stylesheet            =
=============================================*/
add_editor_style();


/*=====================================================
=            Enable Typekit font in editor            =
=====================================================*/
/* Dont forget to add the typekit ID in the below file */

// function tse_mce_external_plugins($plugin_array) {
//   $plugin_array['typekit'] = get_template_directory_uri() . '/js/typekit.tinymce.js';
//   return $plugin_array;
// }
// add_filter("mce_external_plugins", "tse_mce_external_plugins");


/* =================================================
	=            Load custom CSS in editor            =
	================================================= */
/* Change the font details as per the site */
function editor_css() {
	?>
	<style type="text/css">
		#editorcontainer #content, #wp_mce_fullscreen, textarea.wp-editor-area {
			font-family: 'Lato', sans-serif; /* this font should be imported editor-style.css */
			font-size: 16px;
			line-height: 1.7;
		}
	</style>
	<?php
}
add_action('admin_head-post.php', 'editor_css');
add_action('admin_head-post-new.php', 'editor_css');


/*=======================================
=            Blog pagination            =
=======================================*/
//http://wp.tutsplus.com/tutorials/wordpress-pagination-a-primer
function tse_posts_pagination($pages) {
	$total_pages = $pages;

	if ($total_pages > 1) {

		$current_page = max(1, get_query_var('paged'));

		echo '<div class="posts-pagination">';

		echo '<span class="index"> Page ' . $current_page . ' of ' . $total_pages . "</span>";

		echo paginate_links(array(
				'base' => get_pagenum_link(1) . '%_%',
				'format' => 'page/%#%/',
				'current' => $current_page,
				'total' => $total_pages,
				'type' => 'list', // plain, array, list
				'prev_text' => '&lsaquo; Previous',
				'next_text' => 'Next &rsaquo;',
		));
		echo '</div>';
	}
}


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


/* ======================================================================
 * Image-URL-Default.php
 * Overrides default image-URL behavior
 * http://wordpress.org/support/topic/insert-image-default-to-no-link
 * ====================================================================== */
update_option('image_default_link_type', 'none');
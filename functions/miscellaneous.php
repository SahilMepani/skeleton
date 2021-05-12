<?php

// Hide admin toolbar
////////////////////////////////////////////////
add_filter('show_admin_bar', '__return_false');


// Disable WordPress all sitemaps - /wp-sitemap.xml
////////////////////////////////////////////////
add_filter('wp_sitemaps_enabled', '__return_false');


// Disable image compression in WordPress
// WordPress sets it to 82% by default
////////////////////////////////////////////////
add_filter('jpeg_quality', function($arg){return 100;});


/* ======================================================
=            Disable file editor in backend            =
====================================================== */
// define('DISALLOW_FILE_EDIT', TRUE);


// Custom WP login logo and link
////////////////////////////////////////////////
/*function skel_login_logo() {
  ?>
  <style type="text/css">
    body.login {
      background: #fefcec;
    }
    body.login #login_error {
      background: #333;
      color: #fff;
      border: none;
    }
    #login form {
      background: #FDF9DC;
      border-color: #B2993E;
    }
    #login input {
      border-color: #B2993E;
    }
    #login input[type="submit"] {
      background: #A38831;
    }
    #login h1 a, .login h1 a {
      background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/images/logo.svg');
      width: auto;
      background-size: contain;
      background-repeat: no-repeat;
      margin: 0 auto 10px;
    }
  </style>
  <?php
}*/
// add_action('login_enqueue_scripts', 'skel_login_logo');

// function skel_login_logo_url() {
//   return home_url();
// }
// add_filter('login_headerurl', 'skel_login_logo_url');

// function skel_login_logo_url_title() {
//   return 'Skeleton';
// }
// add_filter('login_headertitle', 'skel_login_logo_url_title');


/*----------  Enable login captcha  ----------*/
// function is_login_page() {
// 	return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
// }
// if ( is_login_page() ) {
// 	require_once( get_template_directory() . '/functions/captcha.php' );
// }


// Blog Pagination
// http://wp.tutsplus.com/tutorials/wordpress-pagination-a-primer
/* ========================================== */
// function skel_posts_pagination( $pages ) {
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

// function skel_wp_link_pages($args = '') {
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



// Add attributes to enqueue styles
////////////////////////////////////////////////
/* DO NOT USE with Autoptimizer or any contact plugin */
// function add_style_attribute($tag, $handle) {
//   if ( 'google-fonts' !== $handle )
//       return $tag;
//   return str_replace( " rel='stylesheet'", " rel='preload'", $tag );
// }
// add_filter('style_loader_tag', 'add_style_attribute', 10, 2);


// Featured image size
////////////////////////////////////////////////
// function add_featured_image_display_settings( $content, $post_id ) {
// 	$screen = get_current_screen();

// 	if ($screen->post_type == 'post'):
// 		$field_text  = esc_html__( 'Recommended Image Size: 1900 x 1080 (WxH) in px.', 'Uss Kidd' );

// 		$field_label = sprintf(
// 		    '<p><label>%1$s</label></p>',
// 		    $field_text
// 		);

// 		return $content .= $field_label;
// 	endif;

// 	return $content;
// }
// add_filter( 'admin_post_thumbnail_html', 'add_featured_image_display_settings', 10, 2 );


// Customize img srcset sizes
////////////////////////////////////////////////
// https://viastudio.com/optimizing-your-theme-for-wordpress-4-4s-responsive-images/

// Content Images
// function skel_content_image_sizes_attr($sizes, $size) {
//   $width = $size[0];
//   if (get_page_template_slug() === 'template-full_width.php') {
//       if ($width > 910) {
//           return '(max-width: 768px) 92vw, (max-width: 992px) 690px, (max-width: 1200px) 910px, 1110px';
//       }
//       if ($width < 910 && $width > 690) {
//           return '(max-width: 768px) 92vw, (max-width: 992px) 690px, 910px';
//       }
//       return '(max-width: ' . $width . 'px) 92vw, ' . $width . 'px';
//   }
//   return '(max-width: ' . $width . 'px) 92vw, ' . $width . 'px';
// }
// add_filter('wp_calculate_image_sizes', 'skel_content_image_sizes_attr', 10 , 2);


// Featured Images
// function skel_post_thumbnail_sizes_attr($attr, $attachment, $size) {
// Calculate Image Sizes by type and breakpoint
// Header Images
//   if ($size === 'header-thumb') {
//       $attr['sizes'] = '(max-width: 768px) 92vw, (max-width: 992px) 450px, (max-width: 1200px) 597px, 730px';
//   //Blog Thumbnails
//   } else if ($size === 'blog-thumb') {
//       $attr['sizes'] = '(max-width: 992px) 200px, (max-width: 1200px) 127px, 160px';
//   }
//   return $attr;
// }
// add_filter('wp_get_attachment_image_attributes', 'skel_post_thumbnail_sizes_attr', 10 , 3);


// Remove jquery migrate
////////////////////////////////////////////////
// Not useful if autoptimize is enabled
function dequeue_jquery_migrate( &$scripts){
	if(!is_admin()){
		$scripts->remove( 'jquery');
		$scripts->add( 'jquery', false, array( 'jquery-core' ), '1.10.2' );
	}
}
add_filter( 'wp_default_scripts', 'dequeue_jquery_migrate' );


// Remove query string from static files
////////////////////////////////////////////////
// function skel_remove_cssjs_ver( $src ) {
//  if( strpos( $src, '?ver=' ) )
//  $src = remove_query_arg( 'ver', $src );
//  return $src;
// }
// add_filter( 'style_loader_src', 'skel_remove_cssjs_ver', 10, 2 );
// add_filter( 'script_loader_src', 'skel_remove_cssjs_ver', 10, 2 );


// Redirect to result, if search query one result
////////////////////////////////////////////////
// function skel_redirect_single_post() {
// 	if (is_search()) {
// 		global $wp_query;
// 		if ($wp_query->post_count == 1 && $wp_query->max_num_pages == 1) {
// 			wp_redirect(get_permalink($wp_query->posts['0']->ID));
// 			exit;
// 		}
// 	}
// }
// add_action('template_redirect', 'skel_redirect_single_post');


// Limit search results to post
////////////////////////////////////////////////
// http://www.wpbeginner.com/wp-tutorials/how-to-limit-search-results-for-specific-post-types-in-wordpress/*/
// function searchfilter($query) {
// 	if ($query->is_search && !is_admin() ) {
// 			$query->set('post_type',array('post'));
// 	}
// 	return $query;
// }
// add_filter('pre_get_posts','searchfilter');


// Add attributes to enqueue scripts
////////////////////////////////////////////////
// function add_script_attribute($tag, $handle) {
// 	if ( 'modernizr' !== $handle )
// 			return $tag;
// 	return str_replace( ' src', ' async="async" src', $tag );
// }
// add_filter('script_loader_tag', 'add_script_attribute', 10, 2);


////////////////////////////////////////////////
//! REQUIRED - Do not edit below
////////////////////////////////////////////////

// Defer scripts
////////////////////////////////////////////////
// Add defer attribute to the scripts to set the resource priority to low
function skel_defer_scripts( $tag, $handle, $src ) {
  $defer = array(
    'plugins',
    'custom',
  );
  if ( in_array( $handle, $defer ) ) {
     return '<script src="' . $src . '" defer="defer" type="text/javascript"></script>' . "\n";
  }
    return $tag;
}
add_filter( 'script_loader_tag', 'skel_defer_scripts', 10, 3 );


// Wrap oEmbed resource/video inside a div
////////////////////////////////////////////////
function skel_embed_oembed_html($html, $url, $attr, $post_id) {
  return '<div class="embed-responsive embed-responsive-16by9">' . $html . '</div>';
}
add_filter('embed_oembed_html', 'skel_embed_oembed_html', 99, 4);


// Add body classes to editor
////////////////////////////////////////////////
function skel_mce_settings($initArray) {
  $initArray['body_class'] = 'post';
  return $initArray;
}
add_filter('tiny_mce_before_init', 'skel_mce_settings');


// Add page slug to body class
////////////////////////////////////////////////
function skel_add_slug_body_class($classes) {
  global $post;
  if (isset($post)) {
    $classes[] = $post->post_type . '-' . $post->post_name;
  }
  return $classes;
}
add_filter('body_class', 'skel_add_slug_body_class');


// Prevent WP Editor from removing span
////////////////////////////////////////////////
function skel_no_delete_span($init) {
  // Command separated string of extended elements
  $ext = 'span[id|name|class|style]';

  // Add to extended_valid_elements if it alreay exists
  if (isset($init['extended_valid_elements'])) {
    $init['extended_valid_elements'] .= ',' . $ext;
  } else {
    $init['extended_valid_elements'] = $ext;
  }

  // Super important: return $init!
  return $init;
}
add_filter('tiny_mce_before_init', 'skel_no_delete_span');


// Custom login errors
////////////////////////////////////////////////
function skel_custom_wordpress_errors() {
  return 'Something is wrong!';
}
add_filter('login_errors', 'skel_custom_wordpress_errors');


// Change default excerpt length
////////////////////////////////////////////////
function skel_get_the_excerpt_length() {
  return 150; // Default Length
}
add_filter('excerpt_length', 'skel_get_the_excerpt_length');


// Add ellipsis at the end of excerpt
////////////////////////////////////////////////
function skel_get_the_excerpt_more( $more ) {
  return '... ';
}
add_filter('excerpt_more', 'skel_get_the_excerpt_more');

?>
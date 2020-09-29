<?php

// Hide admin toolbar
////////////////////////////////////////////////
add_filter('show_admin_bar', '__return_false');

// Search WP plugin, allow big words search
////////////////////////////////////////////////
add_filter( 'searchwp_big_selects', '__return_true' );

// ACF plugin, increase the backend loading performance
////////////////////////////////////////////////
add_filter('acf/settings/remove_wp_meta_box', '__return_true');

// Gravity forms plugin, change the submission loading icon
////////////////////////////////////////////////
add_filter( 'gform_ajax_spinner_url', 'spinner_url', 10, 2 );
function spinner_url( $image_src, $form ) {
  // relative to you theme images folder
  return  'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
}

// Add attributes to enqueue styles
////////////////////////////////////////////////
/* DO NOT USE with Autoptimizer or any contact plugin */
// function add_style_attribute($tag, $handle) {
//   if ( 'google-fonts' !== $handle )
//       return $tag;
//   return str_replace( " rel='stylesheet'", " rel='preload'", $tag );
// }
// add_filter('style_loader_tag', 'add_style_attribute', 10, 2);


// Custom WP login logo and link
////////////////////////////////////////////////
/*function my_login_logo() {
  ?>
  <style type="text/css">
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
// add_action('login_enqueue_scripts', 'my_login_logo');

// function my_login_logo_url() {
//   return tse_home_url();
// }
// add_filter('login_headerurl', 'my_login_logo_url');

// function my_login_logo_url_title() {
//   return 'Skeleton';
// }
// add_filter('login_headertitle', 'my_login_logo_url_title');


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
// function tse_content_image_sizes_attr($sizes, $size) {
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
// add_filter('wp_calculate_image_sizes', 'tse_content_image_sizes_attr', 10 , 2);


// Featured Images
// function tse_post_thumbnail_sizes_attr($attr, $attachment, $size) {
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
// add_filter('wp_get_attachment_image_attributes', 'tse_post_thumbnail_sizes_attr', 10 , 3);


// Remove jquery migrate
////////////////////////////////////////////////
// Not useful if autoptimize is enabled
// function dequeue_jquery_migrate( &$scripts){
// 	if(!is_admin()){
// 		$scripts->remove( 'jquery');
// 		$scripts->add( 'jquery', false, array( 'jquery-core' ), '1.10.2' );
// 	}
// }
// add_filter( 'wp_default_scripts', 'dequeue_jquery_migrate' );


// Remove query string from static files
////////////////////////////////////////////////
// function tse_remove_cssjs_ver( $src ) {
//  if( strpos( $src, '?ver=' ) )
//  $src = remove_query_arg( 'ver', $src );
//  return $src;
// }
// add_filter( 'style_loader_src', 'tse_remove_cssjs_ver', 10, 2 );
// add_filter( 'script_loader_src', 'tse_remove_cssjs_ver', 10, 2 );


// Redirect to result, if search query one result
////////////////////////////////////////////////
// function tse_redirect_single_post() {
// 	if (is_search()) {
// 		global $wp_query;
// 		if ($wp_query->post_count == 1 && $wp_query->max_num_pages == 1) {
// 			wp_redirect(get_permalink($wp_query->posts['0']->ID));
// 			exit;
// 		}
// 	}
// }
// add_action('template_redirect', 'tse_redirect_single_post');


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


// Email Address Encoder plugin, for ACF fields
////////////////////////////////////////////////
// add_filter('acf/load_value', 'eae_encode_emails');


// Add attributes to enqueue scripts
////////////////////////////////////////////////
// function add_script_attribute($tag, $handle) {
// 	if ( 'modernizr' !== $handle )
// 			return $tag;
// 	return str_replace( ' src', ' async="async" src', $tag );
// }
// add_filter('script_loader_tag', 'add_script_attribute', 10, 2);


// Disable default image compression
////////////////////////////////////////////////
// function tse_wp_generate_image_sizes_quality() {
// 	return 100;
// }
// add_filter( 'jpeg_quality', 'tse_wp_generate_image_sizes_quality');


////////////////////////////////////////////////
//! REQUIRED - Do not edit below
////////////////////////////////////////////////

// Defer scripts
////////////////////////////////////////////////
// Add defer attribute to the scripts to set the resource priority to low
function tse_defer_scripts( $tag, $handle, $src ) {
  $defer = array(
    'plugins',
    'custom',
  );
  if ( in_array( $handle, $defer ) ) {
     return '<script src="' . $src . '" defer="defer" type="text/javascript"></script>' . "\n";
  }
    return $tag;
}
add_filter( 'script_loader_tag', 'tse_defer_scripts', 10, 3 );


// Wrap oEmbed resource/video inside a div
////////////////////////////////////////////////
function tse_embed_oembed_html($html, $url, $attr, $post_id) {
  return '<div class="embed-responsive embed-responsive-16by9">' . $html . '</div>';
}
add_filter('embed_oembed_html', 'tse_embed_oembed_html', 99, 4);


// Add body classes to editor
////////////////////////////////////////////////
function tse_mce_settings($initArray) {
  $initArray['body_class'] = 'post';
  return $initArray;
}
add_filter('tiny_mce_before_init', 'tse_mce_settings');


// Add page slug to body class
////////////////////////////////////////////////
function tse_add_slug_body_class($classes) {
  global $post;
  if (isset($post)) {
    $classes[] = $post->post_type . '-' . $post->post_name;
  }
  return $classes;
}
add_filter('body_class', 'tse_add_slug_body_class');


// Prevent WP Editor from removing span
////////////////////////////////////////////////
function tse_no_delete_span($init) {
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
add_filter('tiny_mce_before_init', 'tse_no_delete_span');


// Custom login errors
////////////////////////////////////////////////
function tse_custom_wordpress_errors() {
  return 'Something is wrong!';
}
add_filter('login_errors', 'tse_custom_wordpress_errors');


// Change default excerpt length
////////////////////////////////////////////////
function tse_get_the_excerpt_length() {
  return 150; // Default Length
}
add_filter('excerpt_length', 'tse_get_the_excerpt_length');


// Add ellipsis at the end of excerpt
////////////////////////////////////////////////
function tse_get_the_excerpt_more( $more ) {
  return '... ';
}
add_filter('excerpt_more', 'tse_get_the_excerpt_more');

?>
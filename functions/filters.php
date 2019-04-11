<?php

/*==========================================
=            Hide admin toolbar            =
==========================================*/
add_filter('show_admin_bar', '__return_false');


/*===========================================
=            Change Backend Logo            =
===========================================*/
function custom_loginlogo() {
echo '<style type="text/css">
h1 a {background-image: url('.get_bloginfo('template_directory').'/images/header-logo.png) !important; width: auto !important; background-size: contain !important; }
</style>';
}
add_action('login_head', 'custom_loginlogo');


/*=======================================
=            Remove wp-emded            =
=======================================*/
// function dequeue_jquery_embed() {
//   if (!is_admin()) {
//     wp_deregister_script('wp-embed');
//   }
// }
// add_action('init', 'dequeue_jquery_embed');

// // Remove the REST API endpoint.
// remove_action( 'rest_api_init', 'wp_oembed_register_route' );

// // Turn off oEmbed auto discovery.
// add_filter( 'embed_oembed_discover', '__return_false' );

// // Don't filter oEmbed results.
// remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );

// // Remove oEmbed discovery links.
// remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

// // Remove oEmbed-specific JavaScript from the front-end and back-end.
// remove_action( 'wp_head', 'wp_oembed_add_host_js' );

// // Remove all embeds rewrite rules.
// add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' ); //generates error


/*==============================================
=            Auto update all plugins            =
==============================================*/
// add_filter('auto_update_plugin', '__return_true');


/*===================================================================
=            Display a custom taxonomy dropdown in admin            =
===================================================================*/
// add_action('restrict_manage_posts', 'tse_filter_post_type_by_taxonomy');
// function tse_filter_post_type_by_taxonomy() {
// 	global $typenow;
// 	$post_type = 'project'; // change to your post type
// 	$taxonomy  = 'tax-one'; // change to your taxonomy
// 	if ($typenow == $post_type) {
// 		$selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
// 		$info_taxonomy = get_taxonomy($taxonomy);
// 		wp_dropdown_categories(array(
// 			'show_option_all' => __("Show All {$info_taxonomy->label}"),
// 			'taxonomy'        => $taxonomy,
// 			'name'            => $taxonomy,
// 			'orderby'         => 'name',
// 			'selected'        => $selected,
// 			'show_count'      => true,
// 			'hide_empty'      => true,
// 		));
// 	};
// }


/*=========================================================
=            Filter posts by taxonomy in admin            =
=========================================================*/
// add_filter('parse_query', 'tse_convert_id_to_term_in_query');
// function tse_convert_id_to_term_in_query($query) {
// 	global $pagenow;
// 	$post_type = 'project'; // change to your post type
// 	$taxonomy  = 'tax-one'; // change to your taxonomy
// 	$q_vars    = &$query->query_vars;
// 	if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
// 		$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
// 		$q_vars[$taxonomy] = $term->slug;
// 	}
// }



/*==========================================================
=            Filter post by meta field in admin            =
==========================================================*/

// //Adding Column
// //We can change the function name as we want
// add_filter( 'manage_post-type_posts_columns', 'post_type_filter_posts_columns' );
// function post_type_filter_posts_columns( $columns ) {
//   $columns['meta_field'] = 'Meta Field';
//   return $columns;
// }


// //Adding content to the column
// add_action( 'manage_post-type_posts_custom_column', 'post_type_column', 10, 2);
// function post_type_column( $column, $post_id ) {

//  // Rank Column
//   if ( 'meta_field' === $column ) {
//     $meta_field = get_post_meta( $post_id, 'meta_field', true );
//     echo @$meta_field;
//   }
// }

// //Filter posts by the column
// add_filter( 'manage_edit-post-type_sortable_columns', 'post_type_sortable_columns');
// function post_type_sortable_columns( $columns ) {
//   $columns['meta_field'] = 'meta_field';
//   return $columns;
// }

// //Ordering by meta value
// add_action( 'pre_get_posts', 'meta_field_orderby' );
// function meta_field_orderby( $query ) {
//   if( ! is_admin() )
//       return;

//   $orderby = $query->get( 'orderby');

//   if( 'meta_field' == $orderby ) {
//       $query->set('meta_key','meta_field');
//       $query->set('orderby','meta_value'); //use meta_value_num if it is numeric
//   }
// }


/*=====  End of Filter post by meta field in admin  ======*/



/*========================================================
=            Add attributes to enqueue styles            =
========================================================*/
/* DO NOT USE with Autoptimizer or any contact plugin */
// function add_style_attribute($tag, $handle) {
//   if ( 'google-fonts' !== $handle )
//       return $tag;
//   return str_replace( " rel='stylesheet'", " rel='preload'", $tag );
// }
// add_filter('style_loader_tag', 'add_style_attribute', 10, 2);


/* ==========================================================
	=            Custom wp login logo and link            =
	========================================================== */

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


/*===================================================
=            Featured Image - Image Size            =
===================================================*/

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

/*=====  End of Featured Image - Image Size  ======*/


/*=============================================================
=            Customize the sizes and srcset values            =
=============================================================*/
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


// // Featured Images
// function tse_post_thumbnail_sizes_attr($attr, $attachment, $size) {
//   //Calculate Image Sizes by type and breakpoint
//   //Header Images
//   if ($size === 'header-thumb') {
//       $attr['sizes'] = '(max-width: 768px) 92vw, (max-width: 992px) 450px, (max-width: 1200px) 597px, 730px';
//   //Blog Thumbnails
//   } else if ($size === 'blog-thumb') {
//       $attr['sizes'] = '(max-width: 992px) 200px, (max-width: 1200px) 127px, 160px';
//   }
//   return $attr;
// }
// add_filter('wp_get_attachment_image_attributes', 'tse_post_thumbnail_sizes_attr', 10 , 3);


/*=============================================
=            Remove jquery migrate            =
=============================================*/
/* Not useful if autoptimize is enabled */
// function dequeue_jquery_migrate( &$scripts){
// 	if(!is_admin()){
// 		$scripts->remove( 'jquery');
// 		$scripts->add( 'jquery', false, array( 'jquery-core' ), '1.10.2' );
// 	}
// }
// add_filter( 'wp_default_scripts', 'dequeue_jquery_migrate' );


/*=============================================================
=            Remove query string from static files            =
=============================================================*/
// function tse_remove_cssjs_ver( $src ) {
//  if( strpos( $src, '?ver=' ) )
//  $src = remove_query_arg( 'ver', $src );
//  return $src;
// }
// add_filter( 'style_loader_src', 'tse_remove_cssjs_ver', 10, 2 );
// add_filter( 'script_loader_src', 'tse_remove_cssjs_ver', 10, 2 );


/*======================================================================
=            Redirect to result, if search query one result            =
======================================================================*/
/*function tse_redirect_single_post() {
	if (is_search()) {
		global $wp_query;
		if ($wp_query->post_count == 1 && $wp_query->max_num_pages == 1) {
			wp_redirect(get_permalink($wp_query->posts['0']->ID));
			exit;
		}
	}
}
add_action('template_redirect', 'tse_redirect_single_post');*/


/*====================================================
=            Limit search results to post            =
====================================================*/
/*http://www.wpbeginner.com/wp-tutorials/how-to-limit-search-results-for-specific-post-types-in-wordpress/*/
/*function searchfilter($query) {
	if ($query->is_search && !is_admin() ) {
			$query->set('post_type',array('post'));
	}
	return $query;
}
add_filter('pre_get_posts','searchfilter');*/

/*==========================================================
=            Email Address Encoder Plugin - ACF fields            =
==========================================================*/
// add_filter('acf/load_value', 'eae_encode_emails');


/*----------  REQUIRED  ----------*/

/*===============================================================
=            Wrap oEmbed resource/video inside a div            =
===============================================================*/
add_filter('embed_oembed_html', 'my_embed_oembed_html', 99, 4);
function my_embed_oembed_html($html, $url, $attr, $post_id) {
	return '<div class="embed-responsive embed-responsive-16by9">' . $html . '</div>';
}


/*==================================================
=            Add SVG support in backend            =
==================================================*/
function wpcontent_svg_mime_type($mimes = array()) {
	$mimes['svg']  = 'image/svg+xml';
	$mimes['svgz'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'wpcontent_svg_mime_type');


/*=============================================================
=            Change Gravity Form submission loader            =
=============================================================*/
function tse_custom_gforms_spinner($src) {
	return get_stylesheet_directory_uri() . '/images/gf-submission.gif';
}
add_filter('gform_ajax_spinner_url', 'tse_custom_gforms_spinner');


/*==================================================
=            Add body classes to editor            =
==================================================*/
function tse_mce_settings($initArray) {
	$initArray['body_class'] = 'post';
	return $initArray;
}
add_filter('tiny_mce_before_init', 'tse_mce_settings');


/*===================================================
=            Add page slug to body class            =
===================================================*/
function tse_add_slug_body_class($classes) {
	global $post;
	if (isset($post)) {
		$classes[] = $post->post_type . '-' . $post->post_name;
	}
	return $classes;
}
add_filter('body_class', 'tse_add_slug_body_class');


/*============================================================
=            Prevent WP Editor from removing span            =
============================================================*/
function myextensionTinyMCE($init) {
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
add_filter('tiny_mce_before_init', 'myextensionTinyMCE');


/*===========================================
=            Custom login errors            =
===========================================*/
function no_wordpress_errors() {
	return 'Something is wrong!';
}
add_filter('login_errors', 'no_wordpress_errors');


/*=====================================================
=            Change default excerpt length            =
=====================================================*/
function tse_get_the_excerpt_length() {
	return 150; // Default Length
}
add_filter('excerpt_length', 'tse_get_the_excerpt_length');


/*==========================================================
=            Add ellipsis at the end of excerpt            =
==========================================================*/
function tse_get_the_excerpt_more( $more ) {
	return '... ';
}
add_filter('excerpt_more', 'tse_get_the_excerpt_more');


/*====================================
=            Remove Emoji            =
====================================*/
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
	add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'disable_emojis' );


/*=======================================================
=            Remove the tinymce emoji plugin            =
=======================================================*/
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

/*============================================================================
=            Remove emoji CDN hostname from DNS prefetching hints            =
============================================================================*/
function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
if ( 'dns-prefetch' == $relation_type ) {
	/** This filter is documented in wp-includes/formatting.php */
	$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );

	$urls = array_diff( $urls, array( $emoji_svg_url ) );
}
	return $urls;
}


/*=============================================
=            Remove junk from head            =
=============================================*/
remove_action('wp_head', 'rsd_link'); // remove really simple discovery link

remove_action('wp_head', 'wp_generator'); // remove wordpress version

remove_action('wp_head', 'feed_links', 2); // remove rss feed links (make sure you add them in yourself if youre using feedblitz or an rss service)
remove_action('wp_head', 'feed_links_extra', 3); // removes all extra rss feed links

remove_action('wp_head', 'index_rel_link'); // remove link to index page

remove_action('wp_head', 'wlwmanifest_link'); // remove wlwmanifest.xml (needed to support windows live writer)

remove_action('wp_head', 'start_post_rel_link', 10, 0); // remove random post link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // remove parent post link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // remove the next and previous post links
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0 );


/*=========================================================
=            Add attributes to enqueue scripts            =
=========================================================*/
// function add_script_attribute($tag, $handle) {
// 	if ( 'modernizr' !== $handle )
// 			return $tag;
// 	return str_replace( ' src', ' async="async" src', $tag );
// }
// add_filter('script_loader_tag', 'add_script_attribute', 10, 2);


/*=========================================================
=            Disable default image compression            =
=========================================================*/
function tse_wp_generate_image_sizes_quality() {
	return 100;
}
add_filter( 'jpeg_quality', 'tse_wp_generate_image_sizes_quality');
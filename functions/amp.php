<?php

/* ======================================
  =           AMP - Custom CSS         =
  ======================================= */
/*add_action('amp_post_template_css', 'xyz_amp_my_additional_css_styles');

function xyz_amp_my_additional_css_styles($amp_template) {
  // only CSS here please...
  ?>
  .amp-wp-footer div p > a,.amp-wp-article-footer .amp-wp-meta.amp-wp-comments-link{display:none;}
  .amp-wp-article-content{text-align: center;}
  .amp-wp-article-featured-image amp-img{width:100%;}
  <?php
}*/

/* ======================================
  =           AMP - CPT Support        =
  ======================================= */
// add_action('amp_init', 'xyz_amp_add_review_cpt');

// function xyz_amp_add_review_cpt() {
//   add_post_type_support('post-type', AMP_QUERY_VAR);
// }


/*=====  Add Flexible Content to AMP  ======*/

// add_filter( 'the_content', 'flexible_content_amp' );
// function flexible_content_amp( $content ) {
//     global $post;
//     if((function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() )) {
//         if (have_rows('flexible_content',$post->ID)):

//           // loop through the rows of data
//           while (have_rows('flexible_content')) : the_row();
//             if (get_row_layout() == 'wysiwyg_editor_section'):
//               $content .= get_sub_field('wysiwyg_editor');
//             endif;
//           endwhile;
//         endif;
//         $content = $content;//$feat_image_output . $content;
//     }
//     return $content;
// }
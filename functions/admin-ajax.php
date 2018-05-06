<?php
/*===========================================
=            Ajax load more post            =
===========================================*/
function filter_post() {
  $data = $_POST;

  $args = array(
    'post_type'      => $data['cpt'],
    'posts_per_page' => 6,
  );

  /* Check if pagenumber is set for load more */
  if ( isset($data['pageNumber']) && $data['pageNumber'] != '' ) {
    $args['paged'] = $data['pageNumber'] + 1;
  }

  if ( $data['catID'] != '-1' ) {
    $args['tax_query'] = array(
      array(
        'taxonomy' => $data['cptTax'],
        'field'    => 'id',
        'terms'    => $data['catID'],
      )
    );
  }

  if ( $data['authorID'] != '-1' ) {
    $args['author'] = $data['authorID'];
  }

  if ( $data['tagID'] != '-1' ) {
    $args['tag_id'] = $data['tagID'];
  }

  if ( $data['search'] != '-1' ) {
    $args['s'] = $data['search'];
  }

  //print_r( $args );
  $custom_query = new WP_Query($args);

  if ( $custom_query->have_posts() ) :
  while ( $custom_query->have_posts() ) : $custom_query->the_post();

    if ( $data['cpt'] == 'post' ) {
      get_template_part('template-parts/post-card');
    }

  endwhile;
    wp_reset_query();
  endif;
}

add_action('wp_ajax_nopriv_filter_post_ajax', 'filter_post');
add_action('wp_ajax_filter_post_ajax', 'filter_post');
<?php
// Update post
////////////////////////////////////////////////
function update_post() {
  $data = $_POST;

  $args = array(
    'post_type'      => $data['cpt'],
    'posts_per_page' => $data['postsPerPage'],
  );

  // Check if pagenumber is set for load more
  if ( isset($data['pageNumber']) && $data['pageNumber'] != '' ) {
    $args['paged'] = $data['pageNumber'] + 1;
  }

  if ( $data['cat'] != '' ) {
    $args['tax_query'] = array(
      array(
        'taxonomy' => $data['tax'],
        'field'    => 'slug',
        'terms'    => $data['cat'],
      )
    );
  }

  if ( $data['authorID'] != '' ) {
    $args['author'] = $data['authorID'];
  }

  if ( $data['tagID'] != '' ) {
    $args['tag_id'] = $data['tagID'];
  }

  if ( $data['search'] != '' ) {
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

// function must start with wp_ajax_
add_action('wp_ajax_update_post_ajax', 'update_post');
// for logout uers, no privilages, function must start with wp_ajax_nopriv_
add_action('wp_ajax_nopriv_update_post_ajax', 'update_post');
<?php
/*===============================================
=            Ajax filter post by cat            =
===============================================*/
function filter_post_by_cat() {
  $data = $_POST;

  $args = array(
    'post_type'      => $data['cpt'],
    'posts_per_page' => 6,
  );

  if ( $data['catID'] != '-1' ) {
    $args['tax_query'] = array(
      array(
        'taxonomy' => $data['cptTax'],
        'field'    => 'id',
        'terms'    => $data['catID'],
      )
    );
  }
  $custom_query = new WP_Query($args);

  if ( $custom_query->have_posts() ) :
  while ( $custom_query->have_posts() ) : $custom_query->the_post();

    if ( $data['cpt'] == 'post' ) {
      get_template_part('template-parts/post-card');
    }
    else if ( $data['cpt'] == 'project' ) {
      get_template_part('template-parts/project-card');
    }

  endwhile;
    wp_reset_query();
  else :
    echo '<li class="padding-top-2"><h4 class="text-center">Nothing found.</h4></li>';
  endif;
}

add_action('wp_ajax_nopriv_filter_post_by_cat_ajax', 'filter_post_by_cat');
add_action('wp_ajax_filter_post_by_cat_ajax', 'filter_post_by_cat');


/*===========================================
=            Ajax load more post            =
===========================================*/
function load_more_post() {
  $data = $_POST;

  $args = array(
    'post_type'      => $data['cpt'],
    'posts_per_page' => 6,
    'paged'          => $data['pageNumber'] + 1,
  );

  if ( $data['catID'] != '-1' ) {
    $args['tax_query'] = array(
      array(
        'taxonomy' => $data['cptTax'],
        'field'    => 'id',
        'terms'    => $data['catID'],
      )
    );
  }

  //print_r( $args );
  $custom_query = new WP_Query($args);

  if ( $custom_query->have_posts() ) :
  while ( $custom_query->have_posts() ) : $custom_query->the_post();

    if ( $data['cpt'] == 'post' ) {
      get_template_part('template-parts/post-card');
    }
    else if ( $data['cpt'] == 'project' ) {
      get_template_part('template-parts/project-card');
    }

  endwhile;
    wp_reset_query();
  endif;
}

add_action('wp_ajax_nopriv_load_more_post_ajax', 'load_more_post');
add_action('wp_ajax_load_more_post_ajax', 'load_more_post');


/*====================================================
=            Ajax filter post by dual cat            =
====================================================*/
function filter_post_by_dual_cat() {
  $data = $_POST;

  $args = array(
    'post_type' => $data['cpt'],
    'posts_per_page' => 6,
  );

  // If first is NOT ALL and second is ALL
  if ( ($data['firstCatID'] != '-1' && $data['secondCatID'] == '-1') ) {
    $args['tax_query'] = array(
      array(
        'taxonomy' => $data['firstCptTax'],
        'field'    => 'id',
        'terms'    => $data['firstCatID'],
      )
    );
  } // If first is ALL and second is NOT ALL
  else if ( $data['firstCatID'] == '-1' && $data['secondCatID'] != '-1' ) {
    $args['tax_query'] = array(
      array(
        'taxonomy' => $data['secondCptTax'],
        'field'    => 'id',
        'terms'    => $data['secondCatID'],
      )
    );
  } // If both are NOT ALL
  else if ( $data['firstCatID'] != '-1' && $data['secondCatID'] != '-1' ) {
    $args['tax_query'] = array(
      'relation' => 'AND',
      array(
        'taxonomy' => $data['firstCptTax'],
        'field'    => 'id',
        'terms'    => $data['firstCatID'],
      ),
      array(
        'taxonomy' => $data['secondCptTax'],
        'field'    => 'id',
        'terms'    => $data['secondCatID'],
      ),
    );
  }

  $custom_query = new WP_Query($args);

  if ( $custom_query->have_posts() ) :
  while ( $custom_query->have_posts() ) : $custom_query->the_post();

    if ( $data['cpt'] == 'post' ) {
      get_template_part('template-parts/post-card');
    }
    else if ( $data['cpt'] == 'project' ) {
      get_template_part('template-parts/project-card');
    }

  endwhile;
    wp_reset_query();
  else :
    echo '<li class="padding-top-2"><h4 class="text-center">Nothing Found.</h4></li>';
  endif;
}

add_action('wp_ajax_nopriv_filter_post_by_dual_cat_ajax', 'filter_post_by_dual_cat');
add_action('wp_ajax_filter_post_by_dual_cat_ajax', 'filter_post_by_dual_cat');


/*===============================================
=            Ajax load more Dual CPT            =
===============================================*/
function load_more_dual_cpt() {
  $data = $_POST;

  $args = array(
    'post_type'      => $data['cpt'],
    'posts_per_page' => 6,
    'paged'          => $data['pageNumber'] + 1,
  );

  // If first is NOT ALL and second is ALL
  if ( ($data['firstCatID'] != '-1' && $data['secondCatID'] == '-1') ) {
    $args['tax_query'] = array(
      array(
        'taxonomy' => $data['firstCptTax'],
        'field'    => 'id',
        'terms'    => $data['firstCatID'],
      )
    );
  } // If first is ALL and second is NOT ALL
  else if ( $data['firstCatID'] == '-1' && $data['secondCatID'] != '-1' ) {
    $args['tax_query'] = array(
      array(
        'taxonomy' => $data['secondCptTax'],
        'field'    => 'id',
        'terms'    => $data['secondCatID'],
      )
    );
  } // If both are NOT ALL
  else if ( $data['firstCatID'] != '-1' && $data['secondCatID'] != '-1' ) {
    $args['tax_query'] = array(
      'relation' => 'AND',
      array(
        'taxonomy' => $data['firstCptTax'],
        'field'    => 'id',
        'terms'    => $data['firstCatID'],
      ),
      array(
        'taxonomy' => $data['secondCptTax'],
        'field'    => 'id',
        'terms'    => $data['secondCatID'],
      ),
    );
  }

  //print_r( $args );
  $custom_query = new WP_Query($args);

  if ( $custom_query->have_posts() ) :
  while ( $custom_query->have_posts() ) : $custom_query->the_post();

    if ( $data['cpt'] == 'post' ) {
      get_template_part('template-parts/post-card');
    }
    else if ( $data['cpt'] == 'project' ) {
      get_template_part('template-parts/project-card');
    }

  endwhile;
    wp_reset_query();
  endif;
}

add_action('wp_ajax_nopriv_load_more_dual_cpt_ajax', 'load_more_dual_cpt');
add_action('wp_ajax_load_more_dual_cpt_ajax', 'load_more_dual_cpt');
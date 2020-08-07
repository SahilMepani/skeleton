<?php get_header(); ?>

<div class="container py-5 py-md-10">

  <h5 class="text-body mb-4">Showing Results for "<span class="text-capitalize"><?php echo $s ?></span>"</h5>

  <div class="row mx-md-n3">

    <?php
      $swp_query = new SWP_Query(
        array(
          's'              => $s, // search query
          'post_type'      => 'page',
          'posts_per_page' => -1,
          'field'          => 'ID',
        )
      );
      $post_count = $swp_query->post_count;
      // print_r($swp_query);
    ?>

    <?php if ( ! empty( $swp_query->posts ) ) { ?>

      <div class="col-md-6 col-xl-4 px-md-3 mb-4">
        <h5 class="text-uppercase">Pages (<?php echo $post_count; ?>)</h5>
        <ul class="list-unstyled">
          <?php foreach( $swp_query->posts as $post ) : setup_postdata( $post ); ?>
            <li class="mb-0-5">
              <h6 class="mb-0"></h6>
              <a href="<?php the_permalink(); ?>" class="text-body" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?> </a>
            </li>
          <?php endforeach; wp_reset_postdata(); ?>
        </ul>
      </div> <!-- .col-6 -->

    <?php } ?>

    <?php
      $swp_query = new SWP_Query(
        array(
          's'              => $s, // search query
          'post_type'      => 'seminar',
          'posts_per_page' => -1,
          'field'          => 'ID',
        )
      );
      $post_count = $swp_query->post_count;
      // print_r($swp_query);
    ?>

    <?php if ( ! empty( $swp_query->posts ) ) { ?>

      <div class="col-md-6 col-xl-4 px-md-3 mb-4">
        <h5 class="text-uppercase">Seminars (<?php echo $post_count; ?>)</h5>
        <ul class="list-unstyled">
          <?php foreach( $swp_query->posts as $post ) : setup_postdata( $post ); ?>
            <li class="mb-0-5">
              <h6 class="mb-0"></h6>
              <a href="<?php the_permalink(); ?>" class="text-body" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?> </a>
            </li>
          <?php endforeach; wp_reset_postdata(); ?>
        </ul>
      </div> <!-- .col-6 -->

    <?php } ?>

    <?php
      $swp_query = new SWP_Query(
        array(
          's'              => $s, // search query
          'post_type'      => 'instructor',
          'posts_per_page' => -1,
          'field'          => 'ID',
        )
      );
      $post_count = $swp_query->post_count;
      // print_r($swp_query);
    ?>

    <?php if ( ! empty( $swp_query->posts ) ) { ?>

      <div class="col-md-6 col-xl-4 px-md-3 mb-4">
        <h5 class="text-uppercase">Instructors (<?php echo $post_count; ?>)</h5>
        <ul class="list-unstyled">
          <?php foreach( $swp_query->posts as $post ) : setup_postdata( $post ); ?>
            <li class="mb-0-5">
              <h6 class="mb-0"></h6>
              <a href="<?php the_permalink(); ?>" class="text-body" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?> </a>
            </li>
          <?php endforeach; wp_reset_postdata(); ?>
        </ul>
      </div> <!-- .col-6 -->

    <?php } ?>

  </div> <!-- .row -->

  <h5 class="text-body mt-4 mt-md-2 mb-2">Not what you're looking for?</h5>

  <form method="get" action="<?php echo home_url(); ?>/" class="d-flex w-md-60 w-xl-50">
    <input type="text" name="s" placeholder="Try another search" class="w-100" />
    <input type="submit" value="Submit" class="btn btn-md btn-blue" />
  </form>

</div> <!-- .container -->

<?php get_footer(); ?>
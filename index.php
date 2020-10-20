<?php get_header(); ?>

<section class="py-xs-2 py-4">
  <div class="container">

    <div class="d-sm-flex mx-sm-n1 mx-md-n1-5">

      <div class="filters__item--search flex-fill px-sm-1 px-md-1-5 mb-1-5">
        <h5>Search</h5>
        <form action="<?php echo home_url(); ?>/" method="get" id="ajax-search-post" data-cpt="post" data-tax="category">
          <input type="text" name="s" placeholder="Search for" class="input-search w-100" />
          <div id="ajax-submit-block" class="submit-block">
            <input type="submit" value="" class="btn" />
          </div> <!-- .submit-block -->
          <div class="loading-spinner"></div>
          <a href="#" id="ajax-search-clear" class="clear-search" title="clear"></a>
        </form>
      </div> <!-- .filters__item-search -->

      <div class="filters__item--select flex-fill px-sm-1 px-md-1-5">
        <h5>Filter</h5>
        <div class="custom-select-block">
          <select id="ajax-filter-cat">
            <option data-cpt="post" data-tax="category" data-term="">
              <?php _e('Show All Categories','tse'); ?>
            </option>
            <?php
              $cats_args = array(
                'taxonomy' => 'category',
              );
              $cats = get_categories( $cats_args );
              foreach ( $cats as $cat ) :
            ?>
              <option data-cpt="post" data-tax="category" data-term="<?php echo $cat->slug; ?>">
                <?php echo $cat->name; ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div> <!-- .custom-select-block -->
      </div> <!-- .filters__item-select -->

    </div> <!-- .filters -->

  </div> <!-- .container -->
</section>

<section class="pb-6">
  <div class="container">

    <?php
      global $query_string;
      global $wp_query;
      query_posts( $query_string . '&posts_per_page=-1&post_status=publish' ); // set to -1 to get total number of posts
      $total_post_count = $wp_query->post_count; // all the posts count
      $posts_per_page = 6;
      $unseen_post_count = $total_post_count - $posts_per_page; // posts not seen
      query_posts( $query_string . '&posts_per_page=' . $posts_per_page . '&post_status=publish' );
      echo $total_post_count;
      $post_count = $wp_query->post_count; // updated query posts count
      if ( is_category() ) {
        $term = get_query_var( 'cat' );
      }
      if ( is_author() ) {
        $author_id = get_query_var( 'author' );
      }
      if ( is_tag() ) {
        $tag_id = get_query_var( 'tag_id' );
      }
      if ( is_search() ) {
        $search = get_query_var( 's' );
      }
    ?>

    <?php if ( is_category() ) { ?>
      <input type="hidden" id="filter-term" value="<?php echo $term; ?>" />
    <?php } else { ?>
      <input type="hidden" id="filter-term" value="" />
    <?php } ?>

    <?php if ( is_author() ) { ?>
      <input type="hidden" id="filter-author-id" value="<?php echo $author_id; ?>" />
    <?php } else { ?>
      <input type="hidden" id="filter-author-id" value="" />
    <?php } ?>

    <?php if ( is_tag() ) { ?>
      <input type="hidden" id="filter-tag-id" value="<?php echo $tag_id; ?>" />
    <?php } else { ?>
      <input type="hidden" id="filter-tag-id" value="" />
    <?php } ?>

    <?php if ( is_search() ) { ?>
      <input type="hidden" id="filter-search" value="<?php echo $search; ?>" />
    <?php } else { ?>
      <input type="hidden" id="filter-search" value="" />
    <?php } ?>

    <input type="hidden" id="filter-pagenum" value="1" />
    <input type="hidden" id="filter-total-post-count" value="<?php echo $total_post_count; ?>" />
    <input type="hidden" id="filter-posts-per-page" value="<?php echo $posts_per_page; ?>" />
    <input type="hidden" id="filter-unseen-post-count" value="<?php echo $unseen_post_count; ?>" />

    <ul id="ajax-list-post" class="list-blog-post mb-0">

      <?php if ( have_posts() ) : ?>
      <?php while ( have_posts() ) : the_post(); ?>

        <?php get_template_part('template-parts/post-card'); ?>

      <?php endwhile; ?>
      <?php endif; ?>

    </ul> <!-- .list-blog-post -->

    <div class="text-center clear">

      <div class="loading-dots"></div>

      <?php //echo $post_count; ?>

      <div class="clear">
        <h4 id="alert-no-data" class="d-none">Sorry, there are no available post matching your filters.</h4>
        <button id="ajax-more-post" data-cpt="post" data-tax="category" class="<?php echo ($total_post_count <= $posts_per_page) ? 'btn-disabled' : ''; ?> btn btn-black btn-md">Load More</button>
      </div>
    </div> <!-- .text-center -->

  </div> <!-- .container -->
</section>

<?php get_footer(); ?>
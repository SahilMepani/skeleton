<?php /* Template Name: Projects */ ?>

<?php get_header(); ?>

<div class="container padding-4">

  <div class="project-filters-block margin-bottom-3">

    <div class="custom-select-block hidden-sm hidden-md hidden-lg">
      <label for="ajax-first-select-post-categories" class="sr-only"><?php _e('Select Tax One','tse'); ?></label>
      <select id="ajax-first-select-post-categories">
        <option data-cpt="project" data-first-cpt-tax="tax-one" data-first-cat-id="-1"><?php _e('All Tax One','tse'); ?></option>
        <?php
          $cats_args = array(
            'taxonomy' => 'tax-one',
          );
          $cats = get_categories( $cats_args );
          foreach ( $cats as $cat ) :
        ?>
          <option data-cpt="project" data-first-cpt-tax="tax-one" data-first-cat-id="<?php echo $cat->term_id; ?>">
            <?php echo $cat->name; ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div> <!-- .custom-select-block -->

    <div class="custom-select-block hidden-sm hidden-md hidden-lg">
      <label for="ajax-second-select-post-categories" class="sr-only"><?php _e('Select Tax Two','tse'); ?></label>
      <select id="ajax-second-select-post-categories">
        <option data-cpt="project" data-second-cpt-tax="tax-two" data-second-cat-id="-1"><?php _e('All Tax Two','tse'); ?></option>
        <?php
          $cats_args = array(
            'taxonomy' => 'tax-two',
          );
          $cats = get_categories( $cats_args );
          foreach ( $cats as $cat ) :
        ?>
          <option data-cpt="project" data-second-cpt-tax="tax-two" data-second-cat-id="<?php echo $cat->term_id; ?>">
            <?php echo $cat->name; ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div> <!-- .custom-select-block -->

    <ul id="ajax-first-list-post-categories" class="list-tax-one-filters list-filters hidden-xs">
      <li class="js-active">
        <a href="javascript:void(0);" data-cpt="project" data-first-cpt-tax="tax-one" data-first-cat-id="-1"><?php _e('ALL','tse'); ?></a>
      </li>
      <?php
        $cats_args = array(
          'taxonomy' => 'tax-one',
        );
        $cats = get_categories( $cats_args );
        foreach ( $cats as $cat ) {
      ?>
        <li>
          <a href="javascript:void(0);" data-cpt="project" data-first-cpt-tax="tax-one" data-first-cat-id="<?php echo $cat->term_id; ?>"><?php echo $cat->name; ?></a>
        </li>
      <?php } ?>
    </ul> <!-- .list-tax-one-filters -->

    <ul id="ajax-second-list-post-categories" class="list-tax-two-filters list-filters hidden-xs">
      <li class="js-active">
        <a href="javascript:void(0);" data-cpt="project" data-second-cpt-tax="tax-two" data-second-cat-id="-1"><?php _e('ALL','tse'); ?></a>
      </li>
      <?php
        $cats_args = array(
          'taxonomy' => 'tax-two',
        );
        $cats = get_categories( $cats_args );
        foreach ( $cats as $cat ) {
      ?>
        <li>
          <a href="javascript:void(0);" data-cpt="project" data-second-cpt-tax="tax-two" data-second-cat-id="<?php echo $cat->term_id; ?>"><?php echo $cat->name; ?></a>
        </li>
      <?php } ?>
    </ul> <!-- .customer-success-type-filters -->

  </div> <!-- .project-filters-block -->

  <ul id="ajax-list-post" class="row row-grid-4 blog-grid">

    <input type="hidden" id="filter-first-cat-id" value="-1" />
    <input type="hidden" id="filter-second-cat-id" value="-1" />
    <input type="hidden" id="filter-pagenum" value="1" />

    <?php
      $paged = ( get_query_var('paged') ) ? get_query_var( 'paged' ) : 1;
      $args = array(
        'post_type'      => 'project',
        'posts_per_page' => 6, // Pagination won't work if page and custom post type slug are same.
        'paged'          => $paged
      );
      $custom_query = new WP_Query( $args );
      $post_count = $custom_query->post_count;
    ?>

    <?php if ( $custom_query->have_posts() ) : ?>
    <?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>

      <?php get_template_part('template-parts/project-card'); ?>

    <?php endwhile; ?>
      <?php wp_reset_query(); ?>
    <?php endif; ?>

  </ul> <!-- .row -->

  <div class="text-center clear">
    <div class="spinner margin-bottom-2">
      <div class="bounce1"></div>
      <div class="bounce2"></div>
      <div class="bounce3"></div>
    </div> <!-- .spinner -->

    <div class="btn-load-more-block clear">
      <button id="ajax-load-more-post-dual" data-cpt="project" data-first-cpt-tax="tax-one" data-second-cpt-tax="tax-two" class="<?php echo ($post_count < 6) ? 'btn-disabled' : 'js-active'; ?> btn btn-black btn-lg btn-load-more"><b><?php _e('LOAD MORE','tse'); ?></b></button>
    </div>
  </div> <!-- .text-center -->

</div> <!-- .container -->


<?php get_footer(); ?>
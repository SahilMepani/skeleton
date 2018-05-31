<?php get_header(); ?>

<section class="py-xs-2 py-4">
	<div class="container">

		<div class="filters">

			<div class="filters__item--search filters__item">
				<h5>Search</h5>
				<form action="<?php echo home_url(); ?>/" method="get" id="ajax-search-post" data-cpt="post" data-cpt-tax="category">
					<input type="text" name="s" placeholder="Search for" class="input-search w-100" />
					<div class="loading-spinner"></div>
					<a href="#" id="ajax-search-clear" class="clear-search" title="clear"></a>
				</form>
			</div> <!-- .filters__item-search -->

			<div class="filters__item--select filters__item">
				<h5>Filter</h5>
				<div class="custom-select-block">
					<select id="ajax-filter-cat">
					  <option data-cpt="post" data-cpt-tax="category" data-term-id="-1"><?php _e('Show All Categories','vt'); ?></option>
					  <?php
					    $cats_args = array(
					      'taxonomy' => 'category',
					    );
					    $cats = get_categories( $cats_args );
					    foreach ( $cats as $cat ) :
					  ?>
					    <option data-cpt="post" data-cpt-tax="category" data-term-id="<?php echo $cat->term_id; ?>">
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
	    query_posts( $query_string . '&posts_per_page=6' );
	    $post_count = $wp_query->post_count;
	    if ( is_category() ) {
				$cat_id = get_query_var( 'cat' );
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
			<input type="hidden" id="filter-cat-id" value="<?php echo $cat_id; ?>" />
		<?php } else { ?>
			<input type="hidden" id="filter-cat-id" value="-1" />
		<?php } ?>

		<?php if ( is_author() ) { ?>
			<input type="hidden" id="filter-author-id" value="<?php echo $author_id; ?>" />
		<?php } else { ?>
			<input type="hidden" id="filter-author-id" value="-1" />
		<?php } ?>

		<?php if ( is_tag() ) { ?>
			<input type="hidden" id="filter-tag-id" value="<?php echo $tag_id; ?>" />
		<?php } else { ?>
			<input type="hidden" id="filter-tag-id" value="-1" />
		<?php } ?>

		<?php if ( is_search() ) { ?>
			<input type="hidden" id="filter-search" value="<?php echo $search; ?>" />
		<?php } else { ?>
			<input type="hidden" id="filter-search" value="" />
		<?php } ?>

		<input type="hidden" id="filter-pagenum" value="1" />

		<ul id="ajax-list-post" class="list-blog-post list-unstyled">

      <?php if ( have_posts() ) : ?>
      <?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part('template-parts/post-card'); ?>

			<?php endwhile; ?>
      <?php endif; ?>

		</ul> <!-- .list-blog-post -->

		<div class="text-center pt-1 clear">

      <div class="loading-dots"></div>

      <?php //echo $post_count; ?>

      <div class="clear">
      	<h4 id="alert-no-data" class="hide">Sorry, there are no available post matching your filters.</h4>
        <button id="ajax-more-post" data-cpt="post" data-cpt-tax="category" class="<?php echo ($post_count < 6) ? 'btn-disabled' : ''; ?> btn btn-primary btn-more-post btn-md">Load More</button>
      </div>
    </div> <!-- .text-center -->

		<div class="spinner"></div>

	</div> <!-- .container -->
</section>

<?php get_footer(); ?>
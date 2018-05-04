<?php get_header(); ?>

<section class="blog-search-section padding-4">
	<div class="container">

		<div class="pad-block clearfix">
			<div class="search-block">
				<h3 class="block-heading">Search</h3>
				<form action="<?php echo home_url(); ?>/" method="get" class="form-post-search" class="search-box">
					<input type="text" name="s" placeholder="Search for" />
				</form>
			</div> <!-- .search-block -->

			<div class="filter-block">
				<h3 class="block-heading">Filter</h3>
				<div class="select-block custom-select-block">
			    <form action="<?php bloginfo('url'); ?>/" method="get">
			      <?php
			        $select = wp_dropdown_categories('show_option_none=Sort by Category&show_count=1&orderby=name&echo=0&hide_empty=1');
			        $select = preg_replace("#<select([^>]*)>#", "<select$1 onchange='return this.form.submit()'>", $select);
			        echo $select;
			      ?>
			    </form>
			  </div> <!-- .select-block -->
			</div> <!-- .filter-block -->
		</div> <!-- .pad-block -->

	</div> <!-- .container -->
</section> <!-- .blog-search-section -->

<div class="content-section padding-bottom-5">
	<div class="container">

		<ul id="ajax-list-post" class="list-blog-post">

			<?php
				global $query_string;
				global $wp_query;
		    query_posts( $query_string . '&posts_per_page=5' );
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
				<input type="hidden" id="filter-search" value="-1" />
			<?php } ?>

			<input type="hidden" id="filter-pagenum" value="1" />

      <?php if ( have_posts() ) : ?>
      <?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part('template-parts/post-card'); ?>

			<?php endwhile; ?>
      <?php endif; ?>

		</ul> <!-- .list-blog-post -->

		<div class="text-center padding-top-1 clear">
      <div class="spinner margin-bottom-1">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
      </div>

      <?php //echo $post_count; ?>

      <div class="clear">
        <button id="ajax-load-more-post" data-cpt="post" data-cpt-tax="category" class="<?php echo ($post_count < 5) ? 'js-disabled' : 'js-active'; ?> btn btn-green btn-md btn-grow btn-load-more">Load More</button>
      </div>
    </div> <!-- .text-center -->

		<div class="spinner"></div>

	</div> <!-- .container -->
</div> <!-- .content-section -->

<?php get_footer(); ?>
<?php get_header();?>

<section class="py-xs-2 py-4">
	<div class="container">

		<div class="row">

			<div class="filters__item--select col-sm-4">
				<div class="custom-select-block">
					<select id="ajax-filter-cat">
						<option data-cpt="post" data-tax="category" data-term="">
							<?php _e( 'Show All Categories', 'skel' );?>
						</option>
						<?php
							$cats_args = [
								'taxonomy' => 'insight-category'
							];
							$cats = get_categories( $cats_args );
							foreach ( $cats as $cat ):
						?>
						<option data-cpt="post" data-tax="insight-category" data-term="<?php echo $cat->slug; ?>">
							<?php echo $cat->name; ?>
						</option>
						<?php endforeach;?>
					</select>
				</div> <!-- .custom-select-block -->
			</div> <!-- .filters__item-select -->

			<div class="filters__item--select col-sm-4">
				<div class="custom-select-block">
					<select id="ajax-filter-cat">
						<option data-cpt="post" data-tax="category" data-term="">
							<?php _e( 'Show All Topics', 'skel' );?>
						</option>
						<?php
							$cats_args = [
								'taxonomy' => 'insight-topic'
							];
							$cats = get_categories( $cats_args );
							foreach ( $cats as $cat ):
						?>
						<option data-cpt="post" data-tax="insight-topic" data-term="<?php echo $cat->slug; ?>">
							<?php echo $cat->name; ?>
						</option>
						<?php endforeach;?>
					</select>
				</div> <!-- .custom-select-block -->
			</div> <!-- .filters__item-select -->

			<div class="filters__item--search col-sm-4">
				<form action="<?php echo home_url(); ?>/" method="get" id="ajax-search-post" data-cpt="post"
					data-tax="category">
					<input type="search" name="s" placeholder="Search for" class="input-search w-100" />
					<div id="ajax-submit-block" class="submit-block">
						<div class="search-icon-block">
							<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 18 18">
								<path fill="#B2993E"
									d="M11.417 10.042L16 14.625 14.625 16l-4.542-4.583v-.708l-.292-.25c-1.111.944-2.403 1.417-3.875 1.417-1.639 0-3.035-.576-4.188-1.729S-.001 7.598-.001 5.959c0-1.639.576-3.042 1.729-4.208S4.263.001 5.874.001c1.639 0 3.035.583 4.187 1.75S11.79 4.32 11.79 5.959c0 1.472-.472 2.764-1.417 3.875l.292.208h.75zm-5.5 0c1.139 0 2.111-.396 2.917-1.188s1.208-1.757 1.208-2.896-.403-2.111-1.208-2.917-1.778-1.208-2.917-1.208c-1.139 0-2.104.403-2.896 1.208S1.833 4.819 1.833 5.958c0 1.139.396 2.104 1.188 2.896s1.757 1.188 2.896 1.188z" />
							</svg>
						</div> <!-- .search-icon-block -->
						<input type="submit" value="" class="btn" />
					</div> <!-- .submit-block -->

					<div class="loading-spinner"></div>
					<a href="#" id="ajax-search-clear" class="clear-search" title="clear">
						<div class="clear-icon-block">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 18 18">
								<path fill="#B2993E"
									d="M3.727 2.727l10.09 10.09-1.164 1.164-10.09-10.09 1.164-1.164z" />
								<path fill="#B2993E"
									d="M13.817 3.891l-10.09 10.09-1.164-1.164 10.09-10.09 1.164 1.164z" />
							</svg>
						</div> <!-- .clear-svg-block -->
					</a>
				</form>
			</div> <!-- .filters__item-search -->

		</div> <!-- .row -->

	</div> <!-- .container -->
</section>

<section class="pb-6">
	<div class="container">

		<?php
			global $query_string;
			global $wp_query;
			query_posts( $query_string . '&posts_per_page=-1&post_status=publish' ); // set to -1 to get total number of posts
			$total_post_count  = $wp_query->post_count; // all the posts count
			$posts_per_page    = 6;
			$unseen_post_count = $total_post_count - $posts_per_page; // posts not seen
			query_posts( $query_string . '&posts_per_page=' . $posts_per_page . '&post_status=publish' );
			// echo $total_post_count;
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

		<?php if ( is_category() ) {?>
		<input type="hidden" id="filter-term" value="<?php echo $term; ?>" />
		<?php } else {?>
		<input type="hidden" id="filter-term" value="" />
		<?php }?>

		<?php if ( is_author() ) {?>
		<input type="hidden" id="filter-author-id" value="<?php echo $author_id; ?>" />
		<?php } else {?>
		<input type="hidden" id="filter-author-id" value="" />
		<?php }?>

		<?php if ( is_tag() ) {?>
		<input type="hidden" id="filter-tag-id" value="<?php echo $tag_id; ?>" />
		<?php } else {?>
		<input type="hidden" id="filter-tag-id" value="" />
		<?php }?>

		<?php if ( is_search() ) {?>
		<input type="hidden" id="filter-search" value="<?php echo $search; ?>" />
		<?php } else {?>
		<input type="hidden" id="filter-search" value="" />
		<?php }?>

		<input type="hidden" id="filter-pagenum" value="1" />
		<input type="hidden" id="filter-total-post-count" value="<?php echo $total_post_count; ?>" />
		<input type="hidden" id="filter-posts-per-page" value="<?php echo $posts_per_page; ?>" />
		<input type="hidden" id="filter-unseen-post-count" value="<?php echo $unseen_post_count; ?>" />

		<ul id="ajax-list-post" class="list-blog-post mb-0">

			<?php if ( have_posts() ): ?>
			<?php while ( have_posts() ): the_post();?>

			<?php get_template_part( 'template-parts/post-card' );?>

			<?php endwhile;?>
			<?php endif;?>

		</ul> <!-- .list-blog-post -->

		<div class="text-center clear">

			<div class="loading-dots"></div>

			<?php //echo $post_count; ?>

			<div class="clear">
				<h4 id="alert-no-data" class="d-none">Sorry, there are no available post matching your filters.</h4>
			</div>
			<div class="d-flex justify-content-center">
				<button id="ajax-more-post" data-cpt="post" data-tax="category"
					class="<?php echo ( $total_post_count <= $posts_per_page ) ? 'disabled' : ''; ?> btn btn-black btn-md">Load
					More</button>
			</div> <!-- .d-flex justify-content-center -->
		</div> <!-- .text-center -->

	</div> <!-- .container -->
</section>

<?php get_footer();?>
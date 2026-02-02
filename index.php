<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @since 1.0.0
 */

get_header();

?>

<section class="py-xs-2 py-4">
	<div class="container">
		<div class="row">

			<!-- Category Filter -->
			<div class="filters__item--select col-sm-4">
				<div class="custom-select-block">
					<select id="ajax-filter-cat">
						<option data-cpt="post" data-tax="category" data-term="">
							<?php esc_html_e( 'Show All Categories', 'skel' ); ?>
						</option>
						<?php
						$cats = get_categories(
							array(
								'taxonomy' => 'insight-category',
							)
						);

						foreach ( $cats as $skel_cat ) :
							?>
							<option
								data-cpt="post"
								data-tax="insight-category"
								data-term="<?php echo esc_attr( $skel_cat->slug ); ?>">
								<?php echo esc_html( $skel_cat->name ); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

			<!-- Topic Filter -->
			<div class="filters__item--select col-sm-4">
				<div class="custom-select-block">
					<select id="ajax-filter-topic">
						<option data-cpt="post" data-tax="category" data-term="">
							<?php esc_html_e( 'Show All Topics', 'skel' ); ?>
						</option>
						<?php
						$topics = get_categories(
							array(
								'taxonomy' => 'insight-topic',
							)
						);

						foreach ( $topics as $skel_topic ) :
							?>
							<option
								data-cpt="post"
								data-tax="insight-topic"
								data-term="<?php echo esc_attr( $skel_topic->slug ); ?>">
								<?php echo esc_html( $skel_topic->name ); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

			<!-- Search Filter -->
			<div class="filters__item--search col-sm-4">
				<form
					action="<?php echo esc_url( home_url( '/' ) ); ?>"
					method="get"
					id="ajax-search-post"
					data-cpt="post"
					data-tax="category">

					<label for="ajax-search-input" class="screen-reader-text">
						<?php esc_html_e( 'Search for:', 'skel' ); ?>
					</label>

					<input
						type="search"
						id="ajax-search-input"
						name="s"
						placeholder="<?php esc_attr_e( 'Search for…', 'skel' ); ?>"
						class="input-search w-100" />

					<div id="ajax-submit-block" class="submit-block">
						<div class="search-icon-block" aria-hidden="true">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 18 18">
								<path fill="#B2993E" d="M11.417 10.042L16 14.625 14.625 16l-4.542-4.583v-.708l-.292-.25c-1.111.944-2.403 1.417-3.875 1.417-1.639 0-3.035-.576-4.188-1.729S-.001 7.598-.001 5.959c0-1.639.576-3.042 1.729-4.208S4.263.001 5.874.001c1.639 0 3.035.583 4.187 1.75S11.79 4.32 11.79 5.959c0 1.472-.472 2.764-1.417 3.875l.292.208h.75z" />
							</svg>
						</div>
						<input type="submit" value="" class="btn" />
					</div>

					<div class="loading-spinner"></div>

					<a href="#" id="ajax-search-clear" class="clear-search" title="<?php esc_attr_e( 'Clear search', 'skel' ); ?>">
						<div class="clear-icon-block" aria-hidden="true">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 18 18">
								<path fill="#B2993E" d="M3.727 2.727l10.09 10.09-1.164 1.164-10.09-10.09 1.164-1.164z" />
								<path fill="#B2993E" d="M13.817 3.891l-10.09 10.09-1.164-1.164 10.09-10.09 1.164 1.164z" />
							</svg>
						</div>
					</a>
				</form>
			</div>

		</div>
	</div>
</section>

<section class="pb-6">
	<div class="container">

		<?php
		global $wp_query;

		$query_args = wp_parse_args( $wp_query->query );

		$posts_per_page = 6;

		$main_query_args                   = $query_args;
		$main_query_args['posts_per_page'] = $posts_per_page;
		$main_query_args['post_status']    = 'publish';

		$posts_query       = new WP_Query( $main_query_args );
		$total_post_count  = (int) $posts_query->found_posts;
		$unseen_post_count = max( 0, $total_post_count - $posts_per_page );

		$skel_term   = is_category() ? get_query_var( 'cat' ) : '';
		$author_id   = is_author() ? get_query_var( 'author' ) : '';
		$tag_id      = is_tag() ? get_query_var( 'tag_id' ) : '';
		$skel_search = is_search() ? get_query_var( 's' ) : '';
		?>

		<input type="hidden" id="filter-term" value="<?php echo esc_attr( $skel_term ); ?>" />
		<input type="hidden" id="filter-author-id" value="<?php echo esc_attr( $author_id ); ?>" />
		<input type="hidden" id="filter-tag-id" value="<?php echo esc_attr( $tag_id ); ?>" />
		<input type="hidden" id="filter-search" value="<?php echo esc_attr( $skel_search ); ?>" />
		<input type="hidden" id="filter-pagenum" value="1" />
		<input type="hidden" id="filter-total-post-count" value="<?php echo esc_attr( $total_post_count ); ?>" />
		<input type="hidden" id="filter-posts-per-page" value="<?php echo esc_attr( $posts_per_page ); ?>" />
		<input type="hidden" id="filter-unseen-post-count" value="<?php echo esc_attr( $unseen_post_count ); ?>" />

		<ul id="ajax-list-post" class="list-blog-post mb-0">
			<?php
			if ( $posts_query->have_posts() ) :
				while ( $posts_query->have_posts() ) :
					$posts_query->the_post();
					get_template_part( 'template-parts/post-card' );
				endwhile;
				wp_reset_postdata();
			endif;
			?>
		</ul>

		<div class="text-center clear">
			<div class="loading-dots"></div>

			<div class="clear">
				<h4 id="alert-no-data" class="d-none">
					<?php esc_html_e( 'Sorry, there are no posts matching your filters.', 'skel' ); ?>
				</h4>
			</div>

			<div class="d-flex justify-content-center">
				<button
					id="ajax-more-post"
					data-cpt="post"
					data-tax="category"
					class="btn btn-black btn-md <?php echo ( $total_post_count <= $posts_per_page ) ? 'disabled' : ''; ?>">
					<?php esc_html_e( 'Load More', 'skel' ); ?>
				</button>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>

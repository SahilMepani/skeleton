<?php  //phpcs:ignore file comment
get_header();
?>

<div class="content-section">

	<div class="container">

		<section class="main-content">

			<?php
				$paged        = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
				$args         = array(
					'post_type'      => 'project',
					'posts_per_page' => -1, // Pagination won't work if page and custom post type slug are same.
					// 'orderby'     => 'menu_order',
					// 'order'       => 'ASC',
					'paged'          => $paged,
				);
				$custom_query = new WP_Query( $args );
				?>

			<?php
			if ( $custom_query->have_posts() ) :
				?>
				<?php
				while ( $custom_query->have_posts() ) :
					$custom_query->the_post();
					?>

				<article id="post-<?php the_ID(); ?>"<?php post_class(); ?>>

					<?php
					if ( has_post_thumbnail() ) {
						?>
					<aside class="featured-thumb-block">
						<a href="<?php the_permalink(); ?>" title="Read more about<?php the_title_attribute(); ?>">
							<?php the_post_thumbnail( 'medium' ); ?>
						</a>
					</aside> <!-- .featured-thumb-block -->
					<?php } ?>

					<header>
						<h2 class="post-title">
							<a href="<?php the_permalink(); ?>" rel="bookmark"
								title="Read more about<?php the_title_attribute(); ?>"><?php the_title(); ?> </a>
						</h2>

						<div class="post-meta">
							<?php
							printf(
								/* translators: 1: Author link, 2: Published date, 3: Post terms list. */
								wp_kses_post( __( 'Published by %1$s on %2$s under %3$s', 'skel' ) ),
								wp_kses_post( get_the_author_posts_link() ),
								esc_html( get_the_time( 'F j, Y' ) ),
								wp_kses_post( get_the_term_list( get_the_ID(), 'type', '', ', ', '' ) )
							);
							?>
						</div> <!-- .post-meta -->
					</header>

					<div class="excerpt-block">
						<p class="excerpt"><?php echo esc_html( skel_get_the_excerpt( 55 ) ); ?> </p>
						<a href="<?php the_permalink(); ?>" class="btn btn-sm btn-more">
							<?php esc_html_e( 'Read More', 'skel' ); ?>
						</a>
					</div> <!-- .excerpt-block -->

				</article> <!-- .type-post -->

				<?php endwhile; ?>

				<?php skel_posts_pagination( $custom_query->max_num_pages ); ?>

				<?php wp_reset_postdata(); ?>

				<?php
			else :
				?>

			<h2><?php esc_html_e( 'Not Found', 'skel' ); ?></h2>
			<p><?php esc_html_e( 'Sorry, but you are looking for something that isn&#8217;t here.', 'skel' ); ?></p>

			<?php endif; ?>

		</section> <!-- .main-content -->

	</div> <!-- .container -->

</div> <!-- .content-section -->

<?php get_footer(); ?>

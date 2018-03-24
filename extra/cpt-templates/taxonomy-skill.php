<?php get_header(); ?>

<?php
	$current_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
?>

<div class="content-section">

	<div class="container">

		<section class="main-content clearfix">

		<h1 class="category-title"><span>Skills:</span> <?php single_cat_title(); ?></h1>

		<?php
			$paged = ( get_query_var('paged') ) ? get_query_var( 'paged' ) : 1;
			$args = array(
				'post_type'      => 'portfolio',
				'posts_per_page' => 1,
				'tax_query' => array(
					'relation' => 'AND',
					array(
						'taxonomy' => 'skills',
						'field'    => 'slug',
						'terms'    => $current_term->slug
					)
				),
				'paged' => $paged
			);
			$custom_query = new WP_Query( $args );
		?>

		<?php if ( have_posts() ) : ?>
		<?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

				<?php if ( has_post_thumbnail() ) { ?>
					<aside class="featured-thumb-block">
						<a href="<?php the_permalink(); ?>" class="overlay preload" title="Read more about <?php the_title_attribute(); ?>">
							<?php the_post_thumbnail( 'post_featured_thumb' ); ?>
						</a>
					</aside> <!-- .featured-thumb-block -->
				<?php } ?>

				<header>
					<h2 class="post-title">
						<a href="<?php the_permalink(); ?>" rel="bookmark" title="Read more about <?php the_title_attribute(); ?>"><?php the_title(); ?> </a>
					</h2>

					<div class="post-meta">
						Published by <?php the_author_posts_link(); ?> on
						<time pubdate><?php the_time('F j, Y'); ?></time> under <?php tse_the_terms( $post->ID, 'skills' ); ?>
					</div> <!-- .post-meta -->
				</header>

				<div class="excerpt-block">
					<p class="excerpt"> <?php echo tse_get_the_excerpt(55); ?> </p>
					<a href="<?php the_permalink(); ?>" class="btn btn-sm btn-more">Read More</a>
				</div> <!-- .excerpt-block -->

			</article> <!-- .type-post -->

		<?php endwhile; ?>

			<?php tse_posts_pagination( $custom_query->max_num_pages ); ?>

			<?php wp_reset_postdata(); ?>

		<?php else : ?>

			<h2>Not Found</h2>
			<p>Sorry, but you are looking for something that isn&#8217;t here.</p>

		<?php endif; ?>

	</section> <!-- .main-content -->

		<?php get_sidebar(); ?>

	</div> <!-- .container -->

</div> <!-- .content-section -->

<?php get_footer(); ?>
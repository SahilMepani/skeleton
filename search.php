<?php get_header(); ?>

<div class="content-section">
	<div class="main-content container">

		<div class="template-alert">
			<p>Search results for <b>"<?php echo $s ?>"</b></p>
		</div> <!-- .template-alert -->

		<?php
			query_posts( $query_string . '&post_type=page&posts_per_page=-1' );
			if ( have_posts() ) :
		?>

		<h4 class="search-type-heading">Pages</h4>

		<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix type-post'); ?>>

				<header>
					<h2 class="page-title">
						 <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?> </a>
					</h2>
				</header>

				<p class="excerpt"><?php echo vt_excerpt(55); ?> </p>
				<a href="<?php the_permalink(); ?>" class="btn btn-sm btn-more">Read More</a>

			</article> <!-- .type-post -->

		<?php
			endwhile; endif;
			wp_reset_query();
		?>

		<?php
			query_posts( $query_string . '&post_type=post&posts_per_page=-1' );
			if ( have_posts() ) :
		?>

		<h4 class="search-type-heading">Posts</h4>

		<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

				<header>
					<h2 class="post-title">
						<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?> </a>
					</h2>
					<div class="post-meta">
						Published by <?php the_author_link(); ?> on
						<time pubdate><?php the_time('F j, Y'); ?></time> under <?php the_category(' / '); ?>
					</div> <!-- .post-meta -->
				</header>

				<div class="entry">
					<?php if ( has_post_thumbnail() ) { ?>
						<aside class="featured-thumb-block">
							<a href="<?php the_permalink(); ?>" class="featured preload" title="<?php the_title_attribute(); ?>">
								<?php the_post_thumbnail( 'post_featured_thumb' ); ?>
							</a>
						</aside> <!-- .featured-thumb-block -->
					<?php } ?>
					<p class="excerpt"> <?php echo vt_excerpt(55); ?> </p>
					<a href="<?php the_permalink(); ?>" class="btn btn-sm btn-more">Read More</a>
				</div> <!-- Entry -->

			</article> <!-- .type-post -->

		<?php
			endwhile;
			endif;
			wp_reset_query();
		?>

	</section> <!-- .main-content.container -->
</div> <!-- .content-section -->

<?php get_footer(); ?>
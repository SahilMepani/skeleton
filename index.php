<?php get_header(); ?>

<div class="content-section">
	<div class="container">

		<?php if ( is_author() ) { ?>
			<div class="template-alert">
				<p>Showing All News by Author: <b><?php the_author(); ?></b></p>
			</div>
		<?php } elseif ( is_category() ) { ?>
			<div class="template-alert">
				<p>Showing All News in Category: <b><?php single_cat_title(); ?></b></p>
			</div>
		<?php } elseif ( is_tag() ) { ?>
      <div class="template-alert">
        <p>Showing all articles with tag: <b><?php single_cat_title(); ?></b></p>
      </div>
    <?php } elseif ( is_home() ) { ?>
	  	<div class="template-alert">
        <p>Showing all articles</p>
      </div>
	  <?php } ?>

		<div class="row">

			<div class="col-sm-9">
				<section class="main-content clearfix">

					<?php if (have_posts()) : ?>
						<?php while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

								<?php if (has_post_thumbnail()) { ?>
									<aside class="featured-img-block">
										<a href="<?php the_permalink(); ?>" title="Read more about <?php the_title_attribute(); ?>">
											<?php the_post_thumbnail('medium'); ?>
										</a>
									</aside> <!-- .featured-img-block -->
								<?php } ?>

								<header>
									<h2 class="post-title">
										<a href="<?php the_permalink(); ?>" rel="bookmark" title="Read more about <?php the_title_attribute(); ?>"><?php the_title(); ?> </a>
									</h2>

									<div class="post-meta">
										Published by <?php the_author_posts_link(); ?> on
										<time pubdate><?php the_time('F j, Y'); ?></time> under <?php the_category(' / '); ?>
									</div> <!-- .post-meta -->
								</header>

								<div class="excerpt-block">
									<p class="excerpt"> <?php echo tse_excerpt(55); ?> </p>
									<a href="<?php the_permalink(); ?>" class="btn btn-primary btn-md clear">Read More</a>
								</div> <!-- .excerpt-block -->

							</article> <!-- .type-post -->

						<?php endwhile; ?>

						<!-- Archive Pagination -->
						<?php tse_posts_pagination($wp_query->max_num_pages); ?>

					<?php else : ?>

						<h2>Not Found</h2>
						<p>Sorry, but you are looking for something that isn&#8217;t here.</p>

					<?php endif; ?>

				</section> <!-- .main-content -->
			</div> <!-- .col -->

			<div class="col-sm-3">
				<?php get_sidebar(); ?>
			</div> <!-- col -->

		</div> <!-- .row -->
	</div> <!-- .container -->
</div> <!-- .content-section -->

<?php get_footer(); ?>
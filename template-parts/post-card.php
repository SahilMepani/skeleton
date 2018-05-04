<li id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

	<?php if ( has_post_thumbnail() ) { ?>
		<aside class="featured-img-block">
			<a href="<?php the_permalink(); ?>" title="Read more about <?php the_title_attribute(); ?>">
				<?php the_post_thumbnail( 'medium' ); ?>
			</a>
		</aside> <!-- .featured-img-block -->
	<?php } ?>

	<div class="content-block">

		<h2 class="post-title">
			<a href="<?php the_permalink(); ?>" rel="bookmark" title="Read more about <?php the_title_attribute(); ?>"><?php the_title(); ?> </a>
		</h2>

		<div class="post-meta">
			<time pubdate><?php the_time('F j, Y'); ?></time> by <span class="author"><?php echo get_the_author(); ?></span> under <?php the_category(' / '); ?>
		</div> <!-- .post-meta -->

		<div class="excerpt-block">
			<p class="excerpt"><?php echo tse_get_the_excerpt(20); ?></p>
			<a href="<?php the_permalink(); ?>" class="more-link clear">Read More</a>
		</div> <!-- .excerpt-block -->
	</div> <!-- .content-block -->

</li>
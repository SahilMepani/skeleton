<?php get_header(); ?>


<h5>Showing Results for "<span><?php echo $s ?></span>"</h5>

<?php
	$swp_query = new SWP_Query(
		[
			's'              => $s, // search query
			'post_type' => 'page',
			'posts_per_page' => -1,
			'field'          => 'ID'
		]
	);
	$post_count = $swp_query->post_count;
	// print_r($swp_query);
?>

<?php if ( !  empty( $swp_query->posts ) ) { ?>

	<h5>Pages (<?php echo $post_count; ?>)</h5>

	<ul class="list-unstyled">
		<?php foreach ( $swp_query->posts as $post ): setup_postdata( $post );?>
			<li class="mb-0-5">
				<h6 class="mb-0"></h6>
				<a href="<?php the_permalink();?>" class="text-body" rel="bookmark"
					title="<?php the_title_attribute();?>"><?php the_title();?> </a>
			</li>
		<?php endforeach; wp_reset_postdata(); ?>
	</ul>

<?php }?>

<h5Not what you're looking for?</h5>

<form method="get" action="<?php echo home_url(); ?>/">
	<input type="text" name="s" placeholder="Try another search" />
	<input type="submit" value="Submit" />
</form>

<?php get_footer();?>

<?php get_header();?>

<div class="py-4">

<?php //if ( $post->post_content !== "" ) { ?>
	<?php if ( have_posts() ): the_post();?>

		<div id="post-<?php the_ID();?>"<?php post_class();?>>

			<div class="container mb-3">
				<h1 class="page-title"> <?php the_title();?> </h1>
			</div> <!-- .container -->

			<div class="container">
				<?php the_content();?>
			</div> <!-- .container -->

			<?php //get_template_part( 'flexible-content/index' ); ?>

		</div> <!-- .type-post -->

	<?php else: ?>

		<h2>Not Found</h2>
		<p>Sorry, but you are looking for something that isn&#8217;t here.</p>

	<?php endif;?>
<?php //} ?>

</div>

<?php get_footer();?>

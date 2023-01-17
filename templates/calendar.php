<?php /* Template Name: Calendar */?>

<?php get_header();?>

<div class="content-section padding-4">
	<section class="main-content container-fluid">

		<?php if ( have_posts() ): the_post();?>
<?php the_content();?>
<?php endif;?>

	</section> <!-- .main-content -->
</div> <!-- .content-section -->

<?php get_footer();?>

<!-- <h1>Flexible Layout File Called</h1> -->
<?php
	// if layout has any rows
	if ( have_rows('flexible_content') ) :
	while ( have_rows('flexible_content') ) : the_row();
?>

		<!-- <h1>Flexible Layout Called</h1> -->
		<?php get_template_part( 'flexible-content/wysiwyg' ); ?>
		<?php get_template_part( 'flexible-content/half-image-and-half-content' ); ?>
		<?php get_template_part( 'flexible-content/images-slider' ); ?>
		<?php get_template_part( 'flexible-content/centered-slider' ); ?>
		<?php get_template_part( 'flexible-content/carousel-slider' ); ?>
		<?php get_template_part( 'flexible-content/tabs-slider' ); ?>
		<?php get_template_part( 'flexible-content/nested-tabs-slider' ); ?>

<?php
	endwhile; //layout
	endif; //layout
?>
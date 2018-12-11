<?php
	global $flexi_counter;
	$flexi_counter = 0;
	if ( have_rows('flexible_content') ) :
	while ( have_rows('flexible_content') ) : the_row();
	$flexi_counter++;
?>

	<?php get_template_part( 'flexible-content/blank' ); ?>
	<?php get_template_part( 'flexible-content/wysiwyg' ); ?>
	<?php get_template_part( 'flexible-content/fullscreen-slider' ); ?>
	<?php get_template_part( 'flexible-content/post-cards' ); ?>
	<?php get_template_part( 'flexible-content/post-cards-carousel' ); ?>
	<?php get_template_part( 'flexible-content/fixed-and-fluid-column-1' ); ?>
	<?php get_template_part( 'flexible-content/fixed-and-fluid-column-2' ); ?>
	<?php get_template_part( 'flexible-content/fixed-and-fluid-column-3' ); ?>
	<?php get_template_part( 'flexible-content/fixed-and-fluid-column-4' ); ?>

<?php
	endwhile; //layout
	endif; //layout
?>
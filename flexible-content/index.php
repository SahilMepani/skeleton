<?php
	if ( have_rows('flexible_content') ) :
	while ( have_rows('flexible_content') ) : the_row();
?>

	<?php get_template_part( 'flexible-content/blank' ); ?>
	<?php get_template_part( 'flexible-content/hero' ); ?>

<?php
	endwhile; //layout
	endif; //layout
?>
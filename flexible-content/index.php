<!-- <h1>Flexible Layout File Called</h1> -->
<?php
	// if layout has any rows
	if ( have_rows('flexible_content') ) :
	while ( have_rows('flexible_content') ) : the_row();
?>

		<!-- <h1>Flexible Layout Called</h1> -->
		<?php get_template_part( 'flexible-content/blank' ); ?>


<?php
	endwhile; //layout
	endif; //layout
?>
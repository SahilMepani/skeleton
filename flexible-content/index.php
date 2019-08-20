<?php
	global $flexi_counter; // required to target FC section when used multiple times
	$flexi_counter = 0;
	if ( have_rows('flexible_content') ) :
	while ( have_rows('flexible_content') ) : the_row();
	$flexi_counter++;
?>

	<!-- file and section name should match -->
	<?php $layout = str_replace( '_', '-', get_row_layout() ); // replace underscore to dash ?>
	<?php get_template_part( 'flexible-content/' . $layout  ); ?>

<?php
	endwhile;
	endif;
?>
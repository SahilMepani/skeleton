<?php if ( get_row_layout() == '' ) : ?>

<?php
	/* Section Options */

	/* Developer Options */
	$section_bg_color         = get_sub_field('section_bg_color');
	$section_css              = get_sub_field('section_css');
	$section_classes          = get_sub_field('section_classes');
	$section_padding_top      = get_sub_field('section_padding_top');
	$section_padding_bottom   = get_sub_field('section_padding_bottom');
	$section_top_separator    = get_sub_field('section_top_separator_line');
	$section_bottom_separator = get_sub_field('section_bottom_separator_line');
?>

<section class="<?php echo $section_classes . ' ' . $section_bg_color; ?>" style="<?php echo $section_css ?>">
	<div class="container">

		<div class="<?php echo $section_padding_top . ' ' . $section_padding_bottom ?> <?php if ($section_top_separator) echo 'section-top-separator-line '; if ($section_bottom_separator) echo 'section-bottom-separator-line ';  ?>">


		</div> <!-- .separators -->

	</div> <!-- .container -->
</section>

<?php endif; ?>
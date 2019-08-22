<?php if ( get_row_layout() == 'fixed_and_fluid_column_1' ) : ?>

<?php
	/* Section Options */
	$fixed_column            = get_sub_field('fixed_column');
	$fluid_column            = get_sub_field('fluid_column');
	/* Developer Options */
	$section_bg_color       = get_sub_field('section_bg_color');
	$section_css            = get_sub_field('section_css');
	$section_classes        = get_sub_field('section_classes');
	$section_padding_top    = get_sub_field('section_padding_top');
	$section_padding_bottom = get_sub_field('section_padding_bottom');
?>

<section class="fixed-and-fluid-column-1 <?php echo $section_padding_top . ' ' . $section_padding_bottom ?> <?php echo $section_classes . ' ' . $section_bg_color; ?>" style="<?php echo $section_css ?>">

	<div class="flex">

		<div class="fixed-col">
			<?php echo $fixed_column; ?>
		</div> <!-- .fixed-col -->

		<div class="fluid-col" style="background-image: url(<?php echo $fluid_column['sizes']['w1250']; ?>)">
			<img src="<?php echo $fluid_column['sizes']['medium']; ?>" alt="" />
		</div> <!-- .fluid-col -->

	</div> <!-- .flex -->

</section>

<?php endif; ?>
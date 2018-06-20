<?php if ( get_row_layout() == 'hero' ) : ?>

<?php
	/* Section Options */
	$background_image = get_sub_field('background_image');
	/* Developer Options */
	$section_bg_color       = get_sub_field('section_bg_color');
	$section_css            = get_sub_field('section_css');
	$section_classes        = get_sub_field('section_classes');
	$section_padding_top    = get_sub_field('section_padding_top');
	$section_padding_bottom = get_sub_field('section_padding_bottom');
?>

<section class="<?php echo $section_padding_top . ' ' . $section_padding_bottom ?> <?php echo $section_classes . ' ' . $section_bg_color; ?>" style="<?php echo $section_css ?>">
	<div class="container">

		<img
			src="<?php echo wp_get_attachment_image_url( $background_image['id'], 'w2500' ) ?>"
		 	srcset="<?php echo wp_get_attachment_image_srcset( $background_image['id'], 'w2500' ) ?>"
		 	sizes="<?php echo wp_get_attachment_image_sizes( $background_image['id'], 'w2500' ) ?>"
			alt="<?php echo $background_image['alt']; ?>"
		/>

	</div> <!-- .container -->
</section>

<?php endif; ?>
<?php if ( get_row_layout() == 'wysiwyg_section' ) : ?>

	<?php
		$section_bg_image = get_sub_field('section_bg_image');
		$section_bg_image = $section_bg_image['sizes']['w2500h1600'];
		if ( $section_bg_image ) {
			$section_bg_overlay = get_sub_field('section_bg_overlay');
		} else {
			$section_bg_overlay = '';
		}
		$section_bg_color              = get_sub_field('section_bg_color');
		$section_css                   = get_sub_field('section_css');
		$section_classes               = get_sub_field('section_classes');
		$section_padding_top           = get_sub_field('section_padding_top');
		$section_padding_bottom        = get_sub_field('section_padding_bottom');
		$section_heading               = get_sub_field('section_heading');
		$section_content               = get_sub_field('section_content');
	?>

	<section class="wysiwyg-section clear <?php echo ( $section_bg_image ) ? 'bg-cover ' : ''; ?> <?php echo $section_classes . ' ' . $section_bg_color . ' ' . $section_bg_overlay ?>"
		style="<?php if ( $section_bg_image ) { ?> background-image: url(<?php echo $section_bg_image; ?>); <?php } ?>
		<?php echo $section_css ?>">

		<div class="container <?php echo $section_padding_top . ' ' . $section_padding_bottom ?>">

			<?php if ( $section_heading ) { ?>
				<h2 class="wow fadeInUp text-center"><?php echo $section_heading; ?></h2>
			<?php } ?>

			<div class="wow fadeInUp" data-wow-delay=".1s">

				<div class="limit-content text-center">
					<?php echo $section_content; ?>
				</div> <!-- .limit-content -->

			</div> <!-- wow fadeInUp -->

		</div> <!-- .container -->
	</section>

<?php endif; ?>
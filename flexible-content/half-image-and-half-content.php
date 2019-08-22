<?php if ( get_row_layout() == 'half_image_and_half_content_section' ) : ?>

	<?php
		$section_css     = get_sub_field('section_css');
		$section_classes = get_sub_field('section_classes');
		$image           = get_sub_field('image');
		$column_heading  = get_sub_field('column_heading');
		$column_content  = get_sub_field('column_content');
	?>

	<section class="half-image-and-half-content-section <?php echo $section_classes ?>" style="<?php echo $section_css ?>">
		<div class="inner-ie-fix">
			<div class="img-col wow fadeIn" style="background-image: url(<?php echo $image['sizes']['w1250']; ?>)">
				<img src="<?php echo $image['sizes']['medium']; ?>" class="wow fadeInLeft" alt="" />
			</div> <!-- .img-col -->
			<div class="content-col">
				<div class="inner-col">
					<?php if ( $column_heading ) { ?>
						<h2 class="wow fadeInUp"><?php echo $column_heading; ?></h2>
					<?php } ?>
					<div class="wow fadeInUp margin-bottom-xs" data-wow-delay=".1s">
						<?php echo $column_content; ?>
					</div>
				</div> <!-- .inner-col -->
			</div> <!-- .content-col -->
		</div> <!-- .inner-ie-fix -->
	</section>

<?php endif; ?>
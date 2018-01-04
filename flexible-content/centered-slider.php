<?php if ( get_row_layout() == 'centered_slider_section' ) : ?>

	<?php
		$section_css     = get_sub_field('section_css');
		$section_classes = get_sub_field('section_classes');
	?>

	<section class="centered-slider-section clear <?php echo $section_classes ?>" style="<?php echo $section_css ?>">

		<div class="swiper-container centered-slider">

			<div class="swiper-wrapper">

				<?php $slides = get_sub_field('slides'); ?>
				<?php foreach ( $slides as $slide ) { ?>
					<div class="swiper-slide" style="background-image: url(<?php echo $slide['image']['sizes']['w2500h900']; ?>);">
						<div class="container">

							<div class="content-block">
								<?php if ( $caption = $slide['caption'] ) { ?>
									<p class="caption"><?php echo $caption; ?></p>
								<?php } ?>
								<?php
									$target_blank         = ''; $button_text = ''; $button_link = '';
									$button_text          = $slide['button_text'];
									$button_link_type     = $slide['button_link_type'];
									$button_link_internal = $slide['button_link_internal'];
									$button_link_external = $slide['button_link_external'];
									if ($button_link_type == 'internal' && $button_link_internal) {
										$button_link = $button_link_internal;
									} elseif ($button_link_type == 'external' && $button_link_external) {
										$button_link  = $button_link_external;
										$target_blank = 'target="_blank"';
									}
								?>
								<?php if ( $button_link != '' && $button_text != '' ) { ?>
									<a href="<?php echo $button_link; ?>" <?php echo $target_blank; ?> class="btn btn-lg btn-primary"><?php echo $button_text; ?></a>
								<?php } ?>
							</div> <!-- .content-block -->

						</div> <!-- .container -->
					</div> <!-- .swiper-slide -->
				<?php } ?>

			</div> <!-- .swiper-wrapper -->

			<div class="swiper-navigation swiper-arrow-navigation">
				<button class="btn btn-prev" title="Previous"></button>
				<button class="btn btn-next" title="Next"></button>
			</div> <!-- .swiper-arrow-navigation -->

			<div class="container">
				<div class="swiper-pagination"></div> <!-- .swiper-pagination -->
			</div> <!-- .container -->

		</div> <!-- .swiper-container.centered-slider -->

	</section> <!-- .centered-slider-section -->
<?php endif; ?>
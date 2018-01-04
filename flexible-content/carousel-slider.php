<?php if ( get_row_layout() == 'carousel_slider_section' ) : ?>

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
	?>

	<section class="carousel-slider-section clear <?php echo ( $section_bg_image ) ? 'bg-cover ' : ''; ?> <?php echo $section_classes . ' ' . $section_bg_color . ' ' . $section_bg_overlay ?>"
		style="<?php if ( $section_bg_image ) { ?> background-image: url(<?php echo $section_bg_image; ?>); <?php } ?>
		<?php echo $section_css ?>">

		<div class="container <?php echo $section_padding_top . ' ' . $section_padding_bottom ?>">

			<div class="swiper-container carousel-slider">

				<div class="swiper-wrapper">

					<?php $slides = get_sub_field('slides'); ?>
					<?php foreach ( $slides as $slide ) { ?>

					<?php
						$image   = $slide['image'];
						$image   = $image['sizes']['medium'];
						$heading = $slide['heading'];
						$content = $slide['content'];
						$target_blank = ''; $link = '';
						$link_type     = $slide['link_type'];
						$link_internal = $slide['link_internal'];
						$link_external = $slide['link_external'];
			      if ($link_type == 'internal' && $link_internal) {
			        $link = $link_internal;
			      } elseif ($link_type == 'external' && $link_external) {
			        $link = $link_external;
		          $target_blank = 'target="_blank"';
			      }
					?>

						<div class="swiper-slide">
							<?php if ( $link != '' ) { ?>
								<a href="<?php echo $link; ?>" <?php echo $target_blank; ?> title="Read more about <?php the_title_attribute(); ?>">
							<?php } ?>
									<div class="img-block bg-cover" style="background-image: url(<?php echo $image; ?>)"></div>
									<h5 class="heading"><?php echo $heading; ?></h5>
									<div class="content-block">
										<?php echo $content; ?>
									</div> <!-- .content-block -->
							<?php if ( $link != '' ) { ?>
								</a>
							<?php } ?>
						</div> <!-- .swiper-slide -->

					<?php } ?>

				</div> <!-- .swiper-wrapper -->

				<div class="swiper-navigation swiper-arrow-navigation">
					<button class="btn btn-prev" title="Previous"></button>
					<button class="btn btn-next" title="Next"></button>
				</div> <!-- .swiper-arrow-navigation -->

			</div> <!-- .swiper-container.carousel-slider -->

		</div> <!-- .container -->

	</section> <!-- .carousel-slider-section -->
<?php endif; ?>
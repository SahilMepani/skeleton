<?php if ( get_row_layout() == 'tabs_slider_section' ) : ?>

	<?php
		$section_bg_color       = get_sub_field('section_bg_color');
		$section_css            = get_sub_field('section_css');
		$section_classes        = get_sub_field('section_classes');
		$section_padding_top    = get_sub_field('section_padding_top');
		$section_padding_bottom = get_sub_field('section_padding_bottom');
		$section_heading        = get_sub_field('section_heading');
		$slides                 = get_sub_field('slides');
	?>

	<section class="tabs-slider-section clear <?php echo $section_classes . ' ' . $section_bg_color . ' ' . $section_padding_top . ' ' . $section_padding_bottom ?>" style="<?php echo $section_css ?>">

		<div class="container">
			<?php if ( $section_heading ) { ?>
				<h2 class="section-heading text-center margin-bottom-2"><?php echo $section_heading; ?></h2>
			<?php } ?>
			<ul class="tabs-slider-pagination padding-bottom-2">
				<?php foreach ( $slides as $slide ) { ?>
					<li><?php echo $slide['tab_heading']; ?></li>
				<?php } ?>
			</ul> <!-- .tabs-slider-pagination -->
		</div> <!-- .container -->

		<div class="swiper-container tabs-slider">

			<div class="swiper-wrapper">
				<?php foreach ( $slides as $slide ) : ?>
					<div class="swiper-slide">
						<div class="container">

							<div class="content-block text-center">
								<?php echo $slide['slide_content'];  ?>
							</div> <!-- .content-block -->

						</div> <!-- .container -->
					</div> <!-- .swiper-slide -->
				<?php endforeach; ?>
			</div> <!-- .swiper-wrapper -->

			<div class="tabs-slider-navigation">
				<button class="btn btn-prev" title="Previous"></button>
				<button class="btn btn-next" title="Next"></button>
			</div> <!-- .tab-slider-navigation -->

		</div> <!-- .swiper-container tab-slider -->

	</section> <!-- .tab-slider-section -->
<?php endif; ?>
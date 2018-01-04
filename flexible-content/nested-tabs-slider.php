<?php if ( get_row_layout() == 'nested_tabs_slider_section' ) : ?>

	<?php
		$section_bg_color       = get_sub_field('section_bg_color');
		$section_css            = get_sub_field('section_css');
		$section_classes        = get_sub_field('section_classes');
		$section_padding_top    = get_sub_field('section_padding_top');
		$section_padding_bottom = get_sub_field('section_padding_bottom');
		$section_heading        = get_sub_field('section_heading');
		$slides                 = get_sub_field('slides');
	?>

	<section class="nested-tabs-slider-section clear <?php echo $section_classes . ' ' . $section_bg_color . ' ' . $section_padding_top . ' ' . $section_padding_bottom ?>" style="<?php echo $section_css ?>">

		<div class="container">
			<?php if ( $section_heading ) { ?>
				<h2 class="section-heading text-center margin-bottom-2"><?php echo $section_heading; ?></h2>
			<?php } ?>
			<ul class="nested-tabs-slider-pagination padding-bottom-2">
				<?php foreach ( $slides as $slide ) { ?>
					<li class="tab-heading-<?php echo vt_scrollspy_link($slide['tab_heading']); ?>" data-slide-index=""><?php echo $slide['tab_heading']; ?></li>
				<?php  } ?>
			</ul> <!-- .tabs-slider-pagination -->
		</div> <!-- .container -->

		<div class="swiper-container nested-tabs-slider">
			<div class="swiper-wrapper">

				<?php $tab_slides_count = 0; ?>

				<?php foreach ( $slides as $slide ) : ?>

					<?php $nested_slides = $slide['nested_slides']; ?>

					<script>
						jQuery('.tab-heading-<?php echo vt_scrollspy_link($slide['tab_heading']); ?>')
						.attr( 'data-slide-index', <?php echo $tab_slides_count; ?> );
					</script>

					<?php foreach ( $nested_slides as $nested_slide ) : ?>
						<?php $tab_slides_count++; ?>
						<div class="swiper-slide" data-tab-heading="tab-heading-<?php echo vt_scrollspy_link($slide['tab_heading']); ?>">
							<div class="container">

								<div class="content-block text-center">
									<?php echo $nested_slide['slide_content']; ?>
								</div> <!-- .content-block text-center -->

							</div> <!-- .container -->
						</div> <!-- .swiper-slide -->
					<?php endforeach; ?>

				<?php endforeach; ?>

			</div> <!-- .swiper-wrapper -->

			<div class="nested-tabs-slider-navigation">
				<button class="btn btn-prev" title="Previous"></button>
				<button class="btn btn-next" title="Next"></button>
			</div> <!-- .tabs-slider-navigation -->

		</div> <!-- .swiper-container tabs-slider -->
	</section> <!-- .tabs-slider-section -->
<?php endif; ?>
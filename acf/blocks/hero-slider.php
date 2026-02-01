<?php
/**
 * Hero Slider ACF Block
 *
 * @package Skeleton
 * @subpackage ACF
 */

// Set thumbnail preview in backend.
if ( skel_render_block_preview( $block ) ) {
	return;
}

// Return early if display is off.
if ( ! skel_should_display_block() ) {
	return;
}

// Data options.
$slider = get_field( 'slider' );

if ( ! is_array( $slider ) || empty( $slider ) ) {
	return;
}

// Developer options.
$dev_options = skel_get_block_developer_options();
?>

<section
	class="hero-slider-section section <?php echo esc_attr( "{$dev_options['display_class']} {$dev_options['spacing_top']} {$dev_options['spacing_bottom']} {$dev_options['custom_classes']}" ); ?>"
	style="<?php echo esc_attr( "{$dev_options['spacing_top_custom']} {$dev_options['spacing_bottom_custom']} {$dev_options['custom_css']}" ); ?> "
	id="<?php echo esc_attr( $dev_options['unique_id'] ); ?>" data-inview data-aos="fade">

	<div class="swiper hero-slider">
		<!-- Additional required wrapper -->
	<div class="swiper-wrapper">
		<?php
		foreach ( $slider as $index => $slide ) {
			$desktop_image = $slide['desktop_image'] ?? DEFAULT_THUMBNAIL_ID;
			$mobile_image  = $slide['mobile_image'] ?? '';
			$mobile_class  = $mobile_image ? 'has-mobile' : '';
			?>
			<div class="swiper-slide">
				<div class="img-cover-block">
					<?php
					$desktop_attrs = array(
						'class' => 'img-cover img-desktop ' . $mobile_class,
						'sizes' => '100vw',
					);
					if ( 0 === $index ) {
						$desktop_attrs['fetchpriority'] = 'high';
					} else {
						$desktop_attrs['loading'] = 'lazy';
					}
					echo wp_get_attachment_image( $desktop_image, 'w1920', false, $desktop_attrs );
					?>

					<?php
					if ( $mobile_image ) {
						$mobile_attrs = array(
							'class' => 'img-cover img-mobile',
							'sizes' => '100vw',
						);
						if ( 0 === $index ) {
							$mobile_attrs['fetchpriority'] = 'high';
						} else {
							$mobile_attrs['loading'] = 'lazy';
						}
						echo wp_get_attachment_image( $mobile_image, 'w992', false, $mobile_attrs );
					}
					?>
				</div>

			</div> <!-- .swiper-slide -->
		<?php } ?>
		</div> <!-- .swiper-wrapper -->

		<div class="swiper-pagination swiper-pagination-dot"></div>

		<?php
		if ( count( $slider ) > 1 ) {
			get_template_part(
				'template-parts/swiper-navigation',
				null,
				array(
					'style' => 'floating',
				)
			);
		}
		?>
	</div> <!-- .swiper -->
</section>

<?php
/**
 * Hero Slider ACF Block
 *
 * @package Skeleton
 * @subpackage ACF
 */

// Set thumbnail preview in backend.
if ( isset( $block['data']['preview_image'] ) ) {
	echo '<img src="' . esc_url( $block['data']['preview_image'] ) . '" style="width:100%; height:auto;">';
	return; // required.
}

// Return early if display is off.
$display = get_field( 'display' );
if ( 'on' !== $display ) {
	return;
}

// Data options.
$slider = get_field( 'slider' );

if ( ! is_array( $slider ) || empty( $slider ) ) {
	return;
}

// Developer options.
$spacing        = get_field( 'spacing' );
$spacing_top    = $spacing['top']['spacing_top'] ?? '';
$spacing_bottom = $spacing['bottom']['spacing_bottom'] ?? '';
$custom_classes = get_field( 'custom_classes' );
$custom_css     = get_field( 'custom_css' );
$unique_id      = get_field( 'unique_id' );

// Custom Spacing.
$spacing_top_custom    = 'custom' === $spacing_top ? "--spacing-top-custom: {$spacing['top']['custom_value']};" : '';
$spacing_bottom_custom = 'custom' === $spacing_bottom ? "--spacing-bottom-custom: {$spacing['bottom']['custom_value']};" : '';
?>

<section
	class="hero-slider-section section <?php echo esc_attr( "section-display-{$display} {$spacing_top} {$spacing_bottom} {$custom_classes}" ); ?>" style="<?php echo esc_attr( "{$spacing_top_custom} {$spacing_bottom_custom} {$custom_css}" ); ?> "
	id="<?php echo esc_attr( $unique_id ); ?>" data-inview data-aos="fade">

	<div class="swiper hero-slider">
		<!-- Additional required wrapper -->
		<div class="swiper-wrapper">
			<?php
			$i = 1;
			foreach ( $slider as $slide ) {
				$image_id = $slide['image'] ?? '';
				?>
				<div class="swiper-slide slide">
					<div class="img-cover-block">
						<?php
							$image_data = wp_get_attachment_image_src( $image_id, 'w1920' );
							$image_alt  = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
							$image_alt  = trim( wp_strip_all_tags( $image_alt ) );
						?>
						<img
							src="<?php echo esc_attr( wp_get_attachment_image_url( $image_id, 'w1920' ) ); ?>"
							srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( $image_id ) ); ?>"
							sizes="100vw"
							alt="<?php echo esc_attr( $image_alt ); ?>"
							width="<?php echo esc_attr( $image_data[1] ); ?>"
							height="<?php echo esc_attr( $image_data[2] ); ?>"
							class="img-cover"
							<?php echo ( 0 !== $i ) ? 'loading="lazy"' : 'fetchpriority="high"'; ?>
						/>
					</div>
				</div>
			<?php } ?>
		</div> <!-- .swiper-wrapper -->

		<div class="swiper-pagination swiper-pagination-dot"></div>

		<?php
		if ( count( $slider ) > 1 ) {
			get_template_part(
				'components/swiper-navigation',
				null,
				array(
					'style' => 'floating',
				)
			);
		}
		?>
	</div> <!-- .swiper -->
</section>

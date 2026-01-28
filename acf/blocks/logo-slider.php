<?php
/**
 * Logo Slider ACF block
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
$logos = get_field( 'logos' );

if ( ! is_array( $logos ) || empty( $logos ) ) {
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
$spacing_top_custom    = 'custom' === $spacing_top ? "--spacing-top-custom: {$spacing['top']['custom_value_top']};" : '';
$spacing_bottom_custom = 'custom' === $spacing_bottom ? "--spacing-bottom-custom: {$spacing['bottom']['custom_value_bottom']};" : '';

if ( 'custom' === $spacing_top ) {
	$spacing_top = 'spacing-top-custom';
}
if ( 'custom' === $spacing_bottom ) {
	$spacing_bottom = 'spacing-bottom-custom';
}

?>

<section
	class="logo-slider-section section <?php echo esc_attr( "section-display-{$display} {$spacing_top} {$spacing_bottom} {$custom_classes}" ); ?>"
	style="<?php echo esc_attr( "{$spacing_top_custom} {$spacing_bottom_custom} {$custom_css}" ); ?>"
	id="<?php echo esc_attr( $unique_id ); ?>">

	<?php if ( is_array( $logos ) && ! empty( $logos ) ) { ?>
	<div class="logo-slider" data-inview data-aos="fade">
		<div class="swiper-wrapper">
			<?php
			for ( $i = 1; $i <= 6; $i++ ) {
				foreach ( $logos as $slide ) :
					$logo = $slide['image'];

					if ( $logo ) :
						?>
						<div class="swiper-slide">
							<div class="logo-block">
								<?php
									$image_data   = wp_get_attachment_image_src( $logo, 'w768' );
									$image_url    = wp_get_attachment_image_url( $logo, 'w768' );
									$image_srcset = wp_get_attachment_image_srcset( $logo );
									$image_alt    = get_post_meta( $logo, '_wp_attachment_image_alt', true );
									$image_alt    = trim( wp_strip_all_tags( $image_alt ) );

									// Prevent undefined index notices.
									$image_width  = isset( $image_data[1] ) ? $image_data[1] : '';
									$image_height = isset( $image_data[2] ) ? $image_data[2] : '';
								?>
								<img
									src="<?php echo esc_url( $image_url ); ?>"
									srcset="<?php echo esc_attr( $image_srcset ); ?>"
									sizes="40rem"
									alt="<?php echo esc_attr( $image_alt ); ?>"
									width="<?php echo esc_attr( $image_width ); ?>"
									height="<?php echo esc_attr( $image_height ); ?>"
									class="img-responsive"
									loading="lazy"
								/>
							</div>
						</div> <!-- .swiper-slide -->
					<?php endif; ?>

				<?php endforeach; ?>
			<?php } ?>

		</div> <!-- .swiper-wrapper -->
	</div> <!-- .swiper -->
	<?php } ?>

</section>

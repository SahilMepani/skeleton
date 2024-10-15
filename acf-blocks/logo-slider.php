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
$spacing_top_custom    = 'custom' === $spacing_top ? "--spacing-top-custom: {$spacing['top']['custom_value']};" : '';
$spacing_bottom_custom = 'custom' === $spacing_bottom ? "--spacing-bottom-custom: {$spacing['bottom']['custom_value']};" : '';
?>

<section
	class="logo-slider-section section <?php echo esc_attr( "section-display-{$display} {$spacing_top} {$spacing_bottom} {$custom_classes}" ); ?>"
	style="<?php echo esc_attr( "{$spacing_top_custom} {$spacing_bottom_custom} {$custom_css}" ); ?>" id="<?php echo esc_attr( $unique_id ); ?>">

	<div class="container">

		<?php if ( is_array( $logos ) && ! empty( $logos ) ) { ?>
			<div class="<?php echo skel_swiper_direction_class(); //phpcs:ignore ?> logo-slider" data-inview data-aos="fade">
				<div class="swiper-wrapper">
					<?php
					foreach ( $logos as $slide ) {
						$logo = $slide['image'];
						?>
						<?php if ( $logo ) { ?>
							<div class="swiper-slide slide">
								<div class="logo-block">
									<?php
										$image_data = wp_get_attachment_image_src( $logo, 'w768' );
										$image_alt  = get_post_meta( $logo, '_wp_attachment_image_alt', true );
										$image_alt  = trim( wp_strip_all_tags( $image_alt ) );
									?>
									<img
										src="<?php echo esc_attr( wp_get_attachment_image_url( $logo, 'w768' ) ); ?>"
										srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( $logo ) ); ?>"
										sizes="40rem"
										alt="<?php echo esc_attr( $image_alt ); ?>"
										width="<?php echo esc_attr( $image_data[1] ); ?>"
										height="<?php echo esc_attr( $image_data[2] ); ?>"
										class="img-responsive"
										loading="lazy"
									/>
								</div>
							</div> <!-- .swiper-slide -->
						<?php } ?>
					<?php } ?>

					<?php
					foreach ( $logos as $slide ) {
						$logo = $slide['image'];
						?>
						<?php if ( $logo ) { ?>
							<div class="swiper-slide slide">
								<div class="logo-block">
									<?php
										$image_data = wp_get_attachment_image_src( $logo, 'w768' );
										$image_alt  = get_post_meta( $logo, '_wp_attachment_image_alt', true );
										$image_alt  = trim( wp_strip_all_tags( $image_alt ) );
									?>
									<img
										src="<?php echo esc_attr( wp_get_attachment_image_url( $logo, 'w768' ) ); ?>"
										srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( $logo ) ); ?>"
										sizes="40rem"
										alt="<?php echo esc_attr( $image_alt ); ?>"
										width="<?php echo esc_attr( $image_data[1] ); ?>"
										height="<?php echo esc_attr( $image_data[2] ); ?>"
										class="img-responsive"
										loading="lazy"
									/>
								</div>
							</div> <!-- .swiper-slide -->
						<?php } ?>
					<?php } ?>

				</div> <!-- .swiper-wrapper -->
			</div> <!-- .swiper -->
		<?php } ?>

	</div> <!-- .container -->

</section>

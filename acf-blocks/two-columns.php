<?php
/**
 * Two Columns block
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
$section_background = get_field( 'section_background' ) === 'yes' ? 'has-bg' : '';
$section_heading    = get_field( 'section_heading' );
$column_order       = get_field( 'column_order' );
$column_order       = get_field( 'column_order' );
$column_width       = get_field( 'column_width' );
$columns            = get_field( 'columns' );

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
	class="two-columns-section section <?php echo esc_attr( "section-display-{$display} {$spacing_top} {$spacing_bottom} {$custom_classes} {$section_background}" ); ?>"
	style="<?php echo esc_attr( "{$spacing_top_custom} {$spacing_bottom_custom} {$custom_css}" ); ?>"
	id="<?php echo esc_attr( $unique_id ); ?>">

	<div
		class="container"
		style="--grid-first-col: <?php echo esc_html( $column_width ); ?>;">

		<?php if ( $section_heading ) { ?>
			<h3 class="h2 section-heading">
				<?php
				// phpcs:ignore
				echo esc_html( $section_heading );
				?>
			</h3>
		<?php } ?>

		<div class="row <?php echo esc_attr( $column_order ); ?>" data-inview data-aos="fade-up">
			<?php
			if ( is_array( $columns ) && ! empty( $columns ) ) {
				foreach ( $columns as $col ) :
					$col_content_type = $col['content_type'];
					$col_text         = $col['text'];
					$col_video        = $col['video'];
					$col_video_type   = $col_video['video_type'];
					$col_video_file   = $col_video['video_file'];
					$col_stream_url   = skel_extract_oembed_src( $col_video['stream_url'] );
					$col_image        = $col['image'];
					?>

					<div class="col">
					<?php
					if ( 'text' === $col_content_type && $col_text ) {
						echo wp_kses_post( $col_text );
					}
					?>

					<?php
					if ( ( 'text' !== $col_content_type ) && $col_image ) {
						$image_data = wp_get_attachment_image_src( $col_image, 'w768' );
						$image_alt  = get_post_meta( $col_image, '_wp_attachment_image_alt', true );
						$image_alt  = trim( wp_strip_all_tags( $image_alt ) );
						?>
							<div class="img-dialog-block">
								<img
									src="<?php echo esc_attr( wp_get_attachment_image_url( $col_image, 'w768' ) ); ?>"
									srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( $col_image ) ); ?>"
									sizes="100vw"
									alt="<?php echo esc_attr( $image_alt ); ?>"
									width="<?php echo esc_attr( $image_data[1] ); ?>"
									height="<?php echo esc_attr( $image_data[2] ); ?>"
									class="img-responsive"
									loading="lazy"
								/>

							<?php if ( 'video' === $col_content_type ) { ?>
									<button class="btn btn-reset btn-dialog-open js-dialog-open">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 249 239" fill="none">
											<path d="M248.857 119.332L0.609375 0.166016V238.499L248.857 119.332Z" fill="#fff" />
										</svg>
									</button>

									<dialog class="dialog js-dialog">
										<button class="btn btn-reset btn-dialog-close js-dialog-close">
											<svg viewBox="0 0 24 24" fill="none">
												<path d="M5.293 6.707l5.293 5.293-5.293 5.293c-0.391 0.391-0.391 1.024 0 1.414s1.024 0.391 1.414 0l5.293-5.293 5.293 5.293c0.391 0.391 1.024 0.391 1.414 0s0.391-1.024 0-1.414l-5.293-5.293 5.293-5.293c0.391-0.391 0.391-1.024 0-1.414s-1.024-0.391-1.414 0l-5.293 5.293-5.293-5.293c-0.391-0.391-1.024-0.391-1.414 0s-0.391 1.024 0 1.414z" fill="currentColor"></path>
											</svg>
										</button>

										<?php if ( 'file' === $col_video_type && $col_video_file ) { ?>

											<video class="js-video" controls loop preload="none">
												<source src="<?php echo esc_url( $col_video_file ); ?>" type="video/mp4">
												Your browser does not support the video tag.
											</video>

										<?php } elseif ( 'file' !== $col_video_type && $col_stream_url ) { ?>
											<iframe class="js-iframe" frameborder="0" allow="autoplay; encrypted-media; fullscreen; picture-in-picture" loading="lazy" allowfullscreen data-video-url="<?php echo esc_url( $col_stream_url ); ?>"></iframe>
										<?php } ?>
									</dialog>
								<?php } ?>
							</div> <!-- .img-block -->
						<?php } ?>
					</div> <!-- .col -->

					<?php
				endforeach;
			}
			?>
		</div> <!-- .row -->

	</div><!-- .container -->
</section>

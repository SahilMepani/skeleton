<?php
/**
 * Flexible Editor ACF block
 *
 * @package Skeleton
 * @subpackage ACF
 */

// Set thumbnail preview in backend.
if ( isset( $block['data']['preview_image'] ) ) {
	echo '<img src="' . esc_url( $block['data']['preview_image'] ) . '" style="inline-size:100%; block-size:auto;">';
	return; // required.
}

// Return early if display is off.
$display = get_field( 'display' );
if ( 'on' !== $display ) {
	return;
}

// Block options.
$flexible_editor = get_field( 'flexible_editor' );

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

if ( 'on' === $display && is_array( $flexible_editor ) ) { ?>
<section
	class="flexible-editor-section section <?php echo esc_attr( "section-display-{$display} {$spacing_top} {$spacing_bottom} {$custom_classes}" ); ?>"
	style="<?php echo esc_attr( "{$spacing_top_custom} {$spacing_bottom_custom} {$custom_css}" ); ?>"
	id="<?php echo esc_attr( $unique_id ); ?>">
	<div class="container">
		<?php
		foreach ( $flexible_editor as $layout ) :

			switch ( $layout['acf_fc_layout'] ) {
				case 'spacing':
					echo '<div role="presentation" class="spacing-block" style="margin-block-end: ' . esc_html( $layout['spacing'] ) . 'px"></div>';

					break;
				case 'text':
					echo '<div class="text-block">' . $layout['text'] . '</div>';

					break;

				case 'heading':
					$heading_markup = $layout['heading_markup'] ?? '';
					$heading_style  = $layout['heading_style'] ?? '';
					$heading        = $layout['heading'] ?? '';

					echo '<' . esc_html( $heading_markup ) . ' class="' . esc_attr( $heading_style ) . '">';
					echo '<div class="heading-block">' . esc_html( $heading ) . '</div>';
					echo '</' . esc_html( $heading_markup ) . '>';

					break;

				case 'check_list':
					$list = $layout['list'];
					if ( $list ) {
						echo '<div class="checklist-block">';
						echo '<ul class="list-checklist">';
						foreach ( $list as $item ) {
							echo '<li>' . esc_html( $item['text'] ) . '</li>';
						}
						echo '</ul>';
						echo '</div>';
					}
					break;

				case 'media':
					$media_type   = $layout['media_type'] ?? '';
					$enable_popup = $layout['enable_popup'] ?? '';
					$video        = $layout['video'] ?? '';
					$video_type   = $video['video_type'] ?? '';
					$video_file   = esc_url( $video['video_file'] );
					$stream_url   = esc_url( skel_extract_oembed_src( $video['stream_url'] ) ?? '' );

					echo '<div class="media-block">';

					if ( 'yes' === $enable_popup ) {
						// even if when $media is selected as image. Enable popup is Yes because that is its default value set in the ACF backend.
						$image        = $layout['image'] ?? '';
						$image_data   = wp_get_attachment_image_src( $image, 'w1200' );
						$image_alt    = trim( wp_strip_all_tags( get_post_meta( $image, '_wp_attachment_image_alt', true ) ) );
						$image_src    = esc_attr( wp_get_attachment_image_url( $image, 'w768' ) );
						$image_srcset = esc_attr( wp_get_attachment_image_srcset( $image ) );
						$image_alt    = esc_attr( $image_alt ) ?? '';
						$image_width  = esc_attr( $image_data[1] ) ?? '';
						$image_height = esc_attr( $image_data[2] ) ?? '';

						$image_tag = <<<HTML
							<img src="{$image_src}"
								srcset="{$image_srcset}"
								sizes="100vw"
								alt="{$image_alt}"
								width="{$image_width}"
								height="{$image_height}"
								class="img-responsive"
								loading="lazy" />
							HTML;
						echo $image_tag; // phpcs:ignore

						if ( 'video' === $media_type ) {
							$button_play_html = <<<HTML
								<button class="btn btn-reset btn-dialog-open js-dialog-open">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 249 239" fill="none">
										<path d="M248.857 119.332L0.609375 0.166016V238.499L248.857 119.332Z" fill="currentColor" />
									</svg>
								</button>
								HTML;
							echo $button_play_html; // phpcs:ignore

							echo '<dialog class="dialog js-dialog">';

							$dialog_close_button = <<<HTML
								<button class="btn btn-reset btn-dialog-close js-dialog-close">
									<svg viewBox="0 0 24 24" fill="none">
										<path d="M5.293 6.707l5.293 5.293-5.293 5.293c-0.391 0.391-0.391 1.024 0 1.414s1.024 0.391 1.414 0l5.293-5.293 5.293 5.293c0.391 0.391 1.024 0.391 1.414 0s0.391-1.024 0-1.414l-5.293-5.293 5.293-5.293c0.391-0.391 0.391-1.024 0-1.414s-1.024-0.391-1.414 0l-5.293 5.293-5.293-5.293c-0.391-0.391-1.024-0.391-1.414 0s-0.391 1.024 0 1.414z" fill="currentColor"></path>
									</svg>
								</button>
								HTML;
							echo $dialog_close_button; // phpcs:ignore

							if ( 'file' === $video_type && $video_file ) {
								$video_html = <<<HTML
								<video class="js-video" autoplay controls preload="none">
									<source src="{$video_file}" type="video/mp4">
									Your browser does not support the video tag.
								</video>
								HTML;
								echo $video_html; // phpcs:ignore
							} elseif ( 'file' !== $video_type && $stream_url ) {
								$iframe_html = <<<HTML
								<iframe class="js-iframe" frameborder="0" allow="autoplay; encrypted-media; fullscreen; picture-in-picture" loading="lazy" allowfullscreen data-video-url="{$stream_url}"></iframe>
								HTML;
								echo $iframe_html;
							}

							echo '</dialog>';
						}
					}

					if ( 'no' === $enable_popup ) {
						if ( 'file' === $video_type && $video_file ) {
							$video_html = <<<HTML
								<video playsinline controls preload="metadata">
									<source src="{$video_file}" type="video/mp4">
									Your browser does not support the video tag.
								</video>
								HTML;
							echo $video_html; // phpcs:ignore

						} elseif ( 'file' !== $video_type && $stream_url ) {
							$iframe_html = <<<HTML
								<iframe class="js-iframe" frameborder="0" allow="autoplay; encrypted-media; fullscreen; picture-in-picture" loading="lazy" allowfullscreen src="{$stream_url}"></iframe>
								HTML;
							echo $iframe_html;
						}
					}

					echo '</div>';

					break;

				case 'reviews':
					$reviews = $layout['reviews'];

					echo '<div class="reviews-block">';
					if ( $reviews ) {
						foreach ( $reviews as $review ) {
							$quote       = $review['quote'] ?? '';
							$name        = $review['name'] ?? '';
							$review_html = <<<HTML
							<div class="review">
								<blockquote>
									<p>{$quote}<p>
								</blockquote>
								<p class="name">{$name}</p>
							</div>
							HTML;
							echo $review_html;
						}
					}
					echo '</div>';

					break;
			}

		endforeach;
		?>
	</div> <!-- .container -->
</section>
<?php } ?>

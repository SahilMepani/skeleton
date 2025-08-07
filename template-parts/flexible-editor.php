<?php
$flexible_editor = $args['flexible_editor'];
if ( is_array( $flexible_editor ) && ! empty( $flexible_editor ) ) :
	foreach ( $flexible_editor as $layout ) :

		switch ( $layout['acf_fc_layout'] ) {
			case 'spacing':
				echo '<div role="presentation" class="spacing-block" style="margin-block-end: ' . esc_html( $layout['spacing'] ) . 'px"></div>';

				break;
			case 'text':
				echo '<div class="text-block" data-inview data-aos="fade-up">' . $layout['text'] . '</div>'; //phpcs:ignore

				break;
			case 'heading':
				$heading_markup = $layout['heading_markup'] ?? '';
				$heading_style  = $layout['heading_style'] ?? '';
				$heading        = $layout['heading'] ?? '';

				echo '<div class="heading-block" data-inview data-aos="fade-up">';
				echo '<' . esc_html( $heading_markup ) . ' class="' . esc_attr( $heading_style ) . '">' . esc_html( $heading ) . '</' . esc_html( $heading_markup ) . '>';
				echo '</div>';

				break;

			case 'media':
				$media_type   = $layout['media_type'] ?? '';
				$enable_popup = $layout['enable_popup'] ?? '';
				$image        = $layout['image'] ?? '';
				$video        = $layout['video'] ?? '';
				$video_type   = $video['video_type'] ?? '';
				$video_file   = esc_url( $video['video_file'] );
				$stream_url   = esc_url( skel_extract_oembed_src( $video['stream_url'] ) ?? '' );

				echo '<div class="media-block" data-inview data-aos="fade">';

				if ( 'yes' === $enable_popup && $image ) {
					// even if when $media is selected as image. Enable popup is Yes because that is its default value set in the ACF backend.
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
						$random_dialog_id = skel_get_random_string();
						$button_play_html = <<<HTML
						<button class="btn btn-reset btn-dialog-open js-dialog-open" data-dialog="{$random_dialog_id}">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 249 239" fill="none">
								<path d="M248.857 119.332L0.609375 0.166016V238.499L248.857 119.332Z" fill="currentColor" />
							</svg>
						</button>
						HTML;
						echo $button_play_html; // phpcs:ignore

						echo '<dialog class="dialog js-dialog" data-dialog="' . esc_attr( $random_dialog_id ) . '">';

						$dialog_close_button = <<<HTML
						<button class="btn btn-reset btn-dialog-close js-dialog-close" data-dialog="{$random_dialog_id}">
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

			case 'text_cards':
				$text_cards = $layout['text_cards'];

				echo '<div class="text-cards-block">';
				if ( $text_cards ) {
					echo '<div class="swiper text-card-slider">';
					echo '<div class="swiper-wrapper" data-inview>';
					foreach ( $text_cards as $card ) {
						$icon      = $card['icon'] ?? '';
						$text      = $card['text'] ?? '';
						$card_html = <<<HTML
						<div class="swiper-slide" data-aos-stagger-item data-aos="fade-up">
							<div class="card">
								<div class="icon-block">
									<img src="{$icon}" alt="" class="img-responsive">
								</div>
								<p class="text">{$text}</p>
							</div>
						</div>
						HTML;
						echo $card_html;
					}
					echo '</div>';
					?>
				<div class="swiper-controls" data-inview data-aos="fade">
					<div class="swiper-pagination swiper-pagination-line style-dark-blue"></div>

					<?php
					if ( count( $text_cards ) > 1 ) {
						get_template_part(
							'template-parts/swiper-navigation',
							null,
							array(
								'style' => 'light-blue',
							)
						);
					}
					?>
				</div> <!-- .swiper-controls -->
					<?php
					echo '</div>';
				}
				echo '</div>';

				break;

		}

endforeach;
endif;
?>

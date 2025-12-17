<?php
/**
 * FAQs ACF block
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

// Data options.
$section_heading = get_field( 'section_heading' );
$faq_type        = get_field( 'faq_type' );
$faq_count     = get_field( 'faq_count' ) ?: -1; // phpcs:ignore
$button          = get_field( 'button' );

if ( 'latest' === $faq_type ) {
	$faq_categories = get_field( 'faq_categories' );
	$faq_dividers   = get_field( 'faq_dividers' );
}
if ( 'selected' === $faq_type ) {
	$selected_faq = get_field( 'selected_faq' );
}
if ( 'custom' === $faq_type ) {
	$custom_faq = get_field( 'custom_faq' );
}

// Developer options.
$custom_classes = get_field( 'custom_classes' );
$custom_css     = get_field( 'custom_css' );
$unique_id      = get_field( 'unique_id' );
?>

<section class="faq-section js-faq-section section-overlap <?php echo esc_attr( "section-display-{$display} {$custom_classes}" ); ?>"
	style="<?php echo esc_attr( "{$custom_css}" ); ?>" id="<?php echo esc_attr( $unique_id ); ?>">

	<div class="container">

		<?php if ( $section_heading ) { ?>
			<h4 class="section-heading h3" data-inview data-aos="fade-up"><?php echo esc_html( $section_heading ); ?></h4>
		<?php } ?>

		<div class="list-accordions" data-inview>
			<?php
			// Custom.
			if ( 'custom' === $faq_type && is_array( $custom_faq ) && ! empty( $custom_faq ) ) :
				foreach ( $custom_faq as $faq ) :
					$question = $faq['question'] ?? '';
					$answer   = $faq['answer'] ?? '';
					?>
					<div class="accordion" data-aos-stagger-item data-aos="fade-up">
					<?php
					$question_html = <<<HTML
					<p class="accordion-heading h5">
						{$question}
						<span class="icon"></span>
					</p>
					HTML;
					$answer_html   = <<<HTML
					<div class="accordion-content">
						<div class="inner-block">
							{$answer}
						</div> <!-- .inner-block -->
					</div>
					HTML;
					if ( $question ) echo $question_html; //phpcs:ignore
					if ( $answer ) echo $answer_html; //phpcs:ignore
					?>
					</div>
					<?php
			endforeach;
			endif;
			?>

			<?php
			// Selcted or Latest.
			if ( 'latest' === $faq_type || 'selected' === $faq_type ) :
				if ( 'latest' === $faq_type ) {
					$faq_args = array(
						'post_type'      => 'faq',
						'post_status'    => 'publish',
						'fields'         => 'ids',
						'posts_per_page' => $faq_count,
						'no_found_rows'  => true,
					);

					$tax_query = array(
						'relation' => 'OR',
					);

					if ( $faq_categories && is_array( $faq_categories ) && ! empty( $faq_categories ) ) {
						$tax_query[] = array(
							'taxonomy' => 'faq-category',
							'terms'    => $faq_categories,
							'field'    => 'id',
						);
					}

					if ( $faq_dividers && is_array( $faq_dividers ) && ! empty( $faq_dividers ) ) {
						$tax_query[] = array(
							'taxonomy' => 'faq-divider',
							'terms'    => $faq_dividers,
							'field'    => 'id',
						);
					}

					if ( ! empty( $tax_query ) ) {
						$faq_args['tax_query'] = $tax_query; //phpcs:ignore
					}

					$faqs = get_posts( $faq_args );

				} elseif ( 'selected' === $faq_type ) {
					$faqs = $selected_faq;
				}

				if ( $faqs && is_array( $faqs ) && ! empty( $faqs ) ) :
					foreach ( $faqs as $faq_id ) :
						$question = get_post_field( 'post_title', $faq_id );
						$answer   = apply_filters( 'the_content', get_post_field( 'post_content', $faq_id ) );
						?>
						<div class="accordion" data-aos-stagger-item data-aos="fade-up">
								<?php
								$question_html = <<<HTML
								<p class="accordion-heading h5">
									{$question}
									<span class="icon"></span>
								</p>
								HTML;
								$answer_html   = <<<HTML
								<div class="accordion-content">
									<div class="inner-block">
										{$answer}
									</div> <!-- .inner-block -->
								</div>
								HTML;
								if ( $question ) echo $question_html; //phpcs:ignore
								if ( $answer ) echo $answer_html; //phpcs:ignore
								?>
						</div>
						<?php
					endforeach;
				endif;
			endif;
			?>
		</div>

		<?php if ( is_array( $button ) && $button['url'] ) { ?>
		<div data-inview data-aos="fade-up">
			<a href="<?php echo esc_url( $button['url'] ); ?>" target="<?php echo esc_attr( $button['target'] ); ?>"
				class="btn btn-cta btn-md btn-dark-blue">
				<?php
					$text = ( $button['title'] ) ? $button['title'] : __( 'View More', 'skel' );
					echo esc_html( $text );
				?>
			</a>
		</div>
		<?php } ?>

	</div> <!-- .container -->
</section>

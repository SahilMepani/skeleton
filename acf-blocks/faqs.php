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
$faq_type        = get_field( 'faqs_type' );
$custom_faqs     = get_field( 'custom_faqs' );
$button          = get_field( 'button' );

if ( 'latest' === $faqs_type ) {
	$faqs_count     = get_field( 'faqs_count' ) ?: -1; // phpcs:ignore
	$insight_category = get_field( 'insight_category' );
	$insight_type     = get_field( 'insight_type' );
}
if ( 'selected' === $faq_type ) {
	$selected_faqs = get_field( 'selected_faqs' );
}

if ( ! $insight_data_type ) {
	return;
}

// Developer options.
$custom_classes = get_field( 'custom_classes' );
$custom_css     = get_field( 'custom_css' );
$unique_id      = get_field( 'unique_id' );
?>

<section class="faqs-section section-overlap <?php echo esc_attr( "section-display-{$display} {$custom_classes}" ); ?>"
	style="<?php echo esc_attr( "{$custom_css}" ); ?>" id="<?php echo esc_attr( $unique_id ); ?>">

	<div class="container">

		<?php if ( $section_heading ) : ?>
		<h4 class="section-heading h3" data-inview data-aos="fade-up"><?php echo esc_html( $section_heading ); ?></h4>
		<?php endif; ?>

		<div class="list-accordions" data-inview>
			<?php
			// Custom.
			if ( 'custom' === $faq_type && is_array( $custom_faqs ) && ! empty( $custom_faqs ) ) :
				foreach ( $custom_faqs as $faq ) :
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
			// Selected OR Latest.
			$faqs = '';
			if ( 'selected' === $faq_type ) {
				$faqs = $selected_faqs;
			} elseif ( 'latest' === $faq_type ) {
				$faqs = get_posts(
					array(
						'post_type'      => 'faq',
						'post_status'    => 'publish',
						'posts_per_page' => $latest_faqs,
						'fields'         => 'ids',
					)
				);
			}

			if ( is_array( $faqs ) && ! empty( $faqs ) ) :
				foreach ( $faqs as $faq_id ) :
					$question = get_the_title( $faq_id );
					$answer   = apply_filters( 'the_content', get_the_content( null, null, $faq_id ) );
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
		</div>

		<?php if ( is_array( $button ) && $button['url'] ) { ?>
		<div data-inview data-aos="fade-up">
			<a href="<?php echo esc_url( $button['url'] ); ?>" target="<?php echo esc_attr( $button['target'] ); ?>"
				class="btn btn-cta btn-md btn-dark-blue">
				<?php
					$text = ( $button['title'] ) ? $button['title'] : __( 'View More', 'tawrid' );
					echo esc_html( $text );
				?>
			</a>
		</div>
		<?php } ?>

	</div> <!-- .container -->
</section>

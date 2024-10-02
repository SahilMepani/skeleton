<?php
/**
 * FAQs ACF block
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
$section_heading = get_field( 'section_heading' );
$faq_type        = get_field( 'faq_type' );
$selected_faqs   = get_field( 'selected_faqs' );
$custom_faqs     = get_field( 'custom_faqs' );
$button          = get_field( 'button' );

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

<section class="faqs-section section <?php echo esc_attr( "section-display-{$display} {$spacing_top} {$spacing_bottom} {$custom_classes}" ); ?>" style="<?php echo esc_attr( "{$spacing_top_custom} {$spacing_bottom_custom} {$custom_css}" ); ?>" id="<?php echo esc_attr( $unique_id ); ?>">

	<div class="container">

		<?php if ( $section_heading ) : ?>
			<h4 class="section-heading h3" data-inview data-aos="fade-up"><?php echo esc_html( $section_heading ); ?></h4>
		<?php endif; ?>

		<div class="list-accordions" data-inview>
			<?php
			// Custom.
			if ( 'custom' === $faq_type && is_array( $custom_faqs ) && ! empty( $custom_faqs ) ) :
				foreach ( $custom_faqs as $faq ) {
					$question = $faq['question'] ?? '';
					$answer   = $faq['answer'] ?? '';
					?>
					<div class="accordion" data-aos-stagger-item data-aos="fade-up">
					<?php if ( $question ) : ?>
							<p class="accordion-heading"><?php echo esc_html( $question ); ?></p>
						<?php endif; ?>

						<?php if ( $answer ) : ?>
							<div class="accordion-content">
								<div class="inner-block">
									<?php echo wp_kses_post( $answer ); ?>
								</div> <!-- .inner-block -->
							</div>
						<?php endif; ?>
					</div>
					<?php
				}
			endif;

			// Selected OR Auto.
			$faqs = '';
			if ( 'selected' === $faq_type ) {
				$faqs = $selected_faqs;
			} elseif ( 'auto' === $faq_type ) {
				$faqs = get_posts(
					array(
						'post_type'      => 'question',
						'post_status'    => 'publish',
						'posts_per_page' => -1,
						'fields'         => 'ids',
					)
				);
			}

			if ( is_array( $faqs ) && ! empty( $faqs ) ) :
				foreach ( $faqs as $faq_id ) {
					$question = get_the_title( $faq_id );
					$answer   = get_the_content( null, null, $faq_id );
					?>
					<div class="accordion" data-aos-stagger-item data-aos="fade-up">
						<?php if ( $question ) : ?>
							<p class="accordion-heading"><?php echo esc_html( $question ); ?></p>
						<?php endif; ?>

						<?php if ( $answer ) : ?>
							<div class="accordion-content">
								<div class="inner-block">
									<p><?php echo $answer; ?></p>
								</div> <!-- .inner-block -->
							</div>
						<?php endif; ?>
					</div>
					<?php
				}
			endif;
			?>
		</div>

		<?php if ( is_array( $button ) && $button['url'] ) { ?>
			<div data-inview data-aos="fade-up">
				<a
					href="<?php echo esc_url( $button['url'] ); ?>"
					target="<?php echo esc_attr( $button['target'] ); ?>"
					class="btn  btn-cta">
					<?php
					$text = ( $button['title'] ) ? $button['title'] : __( 'View More', 'skel' );
					echo esc_html( $text );
					?>
				</a>
			</div>
		<?php } ?>

	</div> <!-- .container -->
</section>

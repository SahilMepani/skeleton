<?php
/**
 * Flexible content ACF block
 *
 * @package Skeleton
 * @subpackage ACF
 */

// Set thumbnail preview in backend.
if ( isset( $block['data']['preview_image'] ) ) {
	echo '<img src="' . esc_url( $block['data']['preview_image'] ) . '" style="width:100%; height:auto;">';

	return; // required.
}

// Data options.
$display          = get_field( 'display' );
$flexible_content = get_field( 'flexible_content' );

// Developer options.
$spacing        = get_field( 'spacing' );
$spacing_top    = $spacing['top']['spacing_top'];
$spacing_bottom = $spacing['bottom']['spacing_bottom'];
$custom_classes = get_field( 'custom_classes' );
$custom_css     = get_field( 'custom_css' );
$unique_id      = get_field( 'unique_id' );
// Custom Spacing.
if ( 'custom' === $spacing_top ) {
	$spacing_top        = 'spacing-top-custom';
	$spacing_top_custom = "--spacing-top-custom:' {$spacing['top']['custom_value']};";
} else {
	$spacing_top_custom = '';
}
if ( 'custom' === $spacing_bottom ) {
	$spacing_bottom        = 'spacing-bottom-custom';
	$spacing_bottom_custom = "--spacing-bottom-custom:' {$spacing['bottom']['custom_value']};";
} else {
	$spacing_bottom_custom = '';
}

if ( 'on' === $display ) { ?>
<section
	class="search-results-section section <?php echo esc_attr( "section-display-{$display} {$spacing_top} {$spacing_bottom} {$custom_classes}" ); ?>"
	style="<?php echo esc_attr( "{$spacing_top_custom} {$spacing_bottom_custom} {$custom_css}" ); ?>"
	id="<?php echo esc_attr( $unique_id ); ?>">


	<div class="container">
		<?php foreach ( $flexible_content as $layout ) : ?>
			<?php if ( 'post_details' === $layout['acf_fc_layout'] ) : ?>

				<?php
				$date       = get_the_date( 'jS, F Y' );
				$post_title = get_the_title();
				?>

				<div class="post-details-section">
					<?php
					// Get the news updates page permalink.
					$news_updates_permalink = esc_url( get_permalink( get_page_by_path( 'news-updates' ) ) );

					// Output the back link.
					?>
					<a href="<?php echo esc_url( $news_updates_permalink ); ?>" class="back-link">
						<?php echo esc_html( skel_get_svg_content( 'arrow-left' ) ) . 'Back'; ?>
					</a>

					<?php // Output the date. ?>
					<p class="date"><?php echo esc_html( $date ); ?></p>

					<?php // Output the post title. ?>
					<h3 class="h3 title"><?php echo esc_html( $post_title ); ?></h3>
				</div>

			<?php elseif ( 'paragraph' === $layout['acf_fc_layout'] ) : ?>

				<div class="content-section">
					<?php echo esc_html( $layout['content'] ); ?>
				</div>

			<?php elseif ( 'image' === $layout['acf_fc_layout'] ) : ?>

				<?php
				$image_id   = $layout['image'];
				$image_data = wp_get_attachment_image_src( $image_id, 'w1920' );
				$image_alt  = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
				$image_alt  = trim( wp_strip_all_tags( $image_alt ) );
				?>

				<div class="image-section">

					<div class="img-cover-block">
						<img
							src="<?php echo esc_url( $image_data[0] ); ?>"
							srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( $image_id ) ); ?>"
							sizes="100vw"
							alt="<?php echo esc_attr( $image_alt ); ?>"
							width="<?php echo esc_attr( $image_data[1] ); ?>"
							height="<?php echo esc_attr( $image_data[2] ); ?>"
							class="img-cover"
							loading="lazy"
						/>
					</div>

				</div>

			<?php endif; ?>
		<?php endforeach; ?>
	</div><!-- .container -->

</section>
<?php } ?>

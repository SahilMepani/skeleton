<?php
/**
 * Visual Editor ACF block
 *
 * @package Skeleton
 * @subpackage ACF
 */

// Set thumbnail preview in backend.
if ( isset( $block['data']['preview_image'] ) ) {
	echo '<img src="' . esc_url( $block['data']['preview_image'] ) . '" style="width:100%; height:auto;">';
	return; // required.
}

// Block options.
$flexible_editor = get_field( 'flexible_editor' );

// Developer options.
$display        = get_field( 'display' );
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
	class="flexible-editor-section section <?php echo esc_attr( "section-display-{$display} {$spacing_top} {$spacing_bottom} {$custom_classes}" ); ?>"
	style="<?php echo esc_attr( "{$spacing_top_custom} {$spacing_bottom_custom} {$custom_css}" ); ?>"
	id="<?php echo esc_attr( $unique_id ); ?>">
		<div class="container">
			<?php foreach ( $flexible_editor as $layout ) { ?>

				<?php if ( 'text' === $layout['acf_fc_layout'] ) { ?>

					<?php echo wp_kses_post( $layout['text'] ); ?>

				<?php } elseif ( 'heading' === $layout['acf_fc_layout'] ) { ?>

					<?php
					$heading_markup = $layout['heading_markup'];
					$heading_style  = $layout['heading_style'];
					$heading        = $layout['heading'];
					?>

				<<?php echo esc_html( $heading_markup ); ?> class="<?php echo esc_html( $heading_style ); ?>">
					<?php echo esc_html( $heading ); ?>
				</<?php echo esc_html( $heading_markup ); ?>>

				<?php } elseif ( 'image' === $layout['acf_fc_layout'] ) { ?>

					<?php
						$image_id   = $layout['image'];
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
						class="img-responsive"
						loading="lazy"
					/>

				<?php } ?>

			<?php } ?>
		</div> <!-- .container -->

	</div> <!-- .container -->
</section>
<?php } ?>

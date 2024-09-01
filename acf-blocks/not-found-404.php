<?php
/**
 * Not Found 404 ACF Block
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
$heading = get_field( 'heading' );

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
	class="not-found-404-section section <?php echo esc_attr( "section-display-{$display} {$spacing_top} {$spacing_bottom} {$custom_classes}" ); ?>"
	style="<?php echo esc_attr( "{$spacing_top_custom} {$spacing_bottom_custom} {$custom_css}" ); ?>"
	id="<?php echo esc_attr( $unique_id ); ?>">

	<div class="container">

		<?php if ( $heading ) { ?>
			<h1><?php echo esc_html( $heading ); ?></h1>
		<?php } ?>

	</div><!-- .container -->
</section>
<?php } ?>

<?php
// Set preview
if ( isset( $block['data']['preview_image'] ) ) {
	echo '<img src="' . $block['data']['preview_image'] . '" style="width:100%; height:auto;">';

	return; // required
}
?>

<?php
// Block options
$background_color = get_field( 'background_color' );
// Developer options
$spacing_top    = get_field( 'spacing_top' );
$spacing_bottom = get_field( 'spacing_bottom' );
$custom_classes = get_field( 'custom_classes' );
$custom_css     = get_field( 'custom_css' );
$custom_id      = get_field( 'custom_id' );
?>

<section class="<?php echo $background_color; ?> <?php echo $spacing_top; ?> <?php echo $spacing_bottom; ?> <?php echo $custom_classes; ?>" style="<?php echo $custom_css; ?>" id="<?php echo $custom_id; ?>">
</section>

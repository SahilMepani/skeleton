<?php
	// Set preview
	if ( isset( $block['data']['preview_image'] ) ) {
		echo '<img src="' . $block['data']['preview_image'] . '" style="width:100%; height:auto;">';

		return; // required
	}
?>

<?php
	// Block options
	$text = get_field( 'text' );
	// Developer options
	$spacing_top    = get_field( 'spacing_top' );
	$spacing_bottom = get_field( 'spacing_bottom' );
	$custom_classes = get_field( 'custom_classes' );
	$custom_css     = get_field( 'custom_css' );
	$unique_id      = get_field( 'unique_id' );
?>

<section class="<?php $spacing_top . ' ' . $spacing_bottom . ' ' . $custom_classes; ?>"
	style="<?php echo $custom_css; ?>" id="<?php echo $unique_id; ?>">
	<h1>Testing</h1>
	<h1><?php echo $text; ?> </h1>
</section>
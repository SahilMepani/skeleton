<?php
	// Set preview
	if ( isset( $block['data']['preview_image'] ) ) {
		echo '<img src="' . $block['data']['preview_image'] . '" style="width:100%; height:auto;">';

		return; // required
	}
?>

<?php
	// Block options
	// Developer options
	$spacing        = get_field('spacing');
	$spacing_top    = $spacing['top']['spacing_top'];
	$spacing_bottom = $spacing['bottom']['spacing_bottom'];
	// if ( $spacing_top == 'custom' ) {
	// 	$spacing_top_custom = --spacing-top-custom:
	// }
	$custom_classes = get_field( 'custom_classes' );
	$custom_css     = get_field( 'custom_css' );
	$unique_id      = get_field( 'unique_id' );
?>

<section class="search-results-section <?php echo $spacing_top . ' ' . $spacing_bottom . ' ' . $custom_classes; ?>" style="<?php echo $custom_css; ?>" id="<?php echo $unique_id; ?>">
	<div class="container">

		<h1>Testing</h1>

	</div> <!-- .container -->
</section>

<?php
	// Set preview
	if ( isset( $block['data']['preview_image'] ) ) {
		echo '<img src="' . $block['data']['preview_image'] . '" style="width:100%; height:auto;">';
		return; // required
	}
?>

<?php
	// Block options
	$title                 = get_field('title');
	$text                 = get_field('text');
	// Developer options
	$spacing               = get_field('spacing');
	$spacing_top           = $spacing['top']['spacing_top'];
	$spacing_bottom        = $spacing['bottom']['spacing_bottom'];
	$spacing_top_custom    = '';
	$spacing_bottom_custom = '';
	$custom_classes        = get_field( 'custom_classes' );
	$custom_css            = get_field( 'custom_css' );
	$unique_id             = get_field( 'unique_id' );
	// Custom Spacing
	if ( $spacing_top == 'custom' ) {
		$spacing_top = 'spacing-top-custom';
		$spacing_top_custom = '--spacing-top-custom:' . $spacing['top']['custom_value'] . ';';
	}
	if ( $spacing_bottom == 'custom' ) {
		$spacing_bottom = 'spacing-bottom-custom';
		$spacing_bottom_custom = '--spacing-bottom-custom:' . $spacing['bottom']['custom_value'] . ';';
	}
?>

<section class="visual-editor-section section <?php echo $spacing_top . ' ' . $spacing_bottom . ' ' . $custom_classes; ?>" style="<?php echo $spacing_top_custom; ?> <?php echo $spacing_bottom_custom; ?> <?php echo $custom_css; ?>" id="<?php echo $unique_id; ?>">
	<div class="container">

		<h1>Testing</h1>

		<?php echo $title; ?>
		<?php echo $text; ?>

	</div> <!-- .container -->
</section>

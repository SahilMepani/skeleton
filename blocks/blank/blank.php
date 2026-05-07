<?php
// Set thumbnail preview in backend.
if ( skel_render_block_preview( $block ) ) {
	return;
}

// Return early if display is off.
if ( ! skel_should_display_block() ) {
	return;
}

// Developer options.
$dev_options = skel_get_block_developer_options();

skel_render_block_section_open( $dev_options, '{slug}-section' );
?>

	<div class="container">



	</div>

<?php skel_render_block_section_close(); ?>

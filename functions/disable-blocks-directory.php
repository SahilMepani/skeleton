<?php
	function tomjn_remove_block_directory() {
		wp_add_inline_script(
			'wp-block-editor',
			"wp.domReady( () => wp.plugins.unregisterPlugin( 'block-directory' ) )"
		);
	}
	add_action( 'admin_enqueue_scripts', 'tomjn_remove_block_directory' );

	add_action(
		'admin_init',
		function() {
				remove_action( 'enqueue_block_editor_assets', 'wp_enqueue_editor_block_directory_assets' );
				remove_action( 'enqueue_block_editor_assets', 'gutenberg_enqueue_block_editor_assets_block_directory' );
		}
	);
?>
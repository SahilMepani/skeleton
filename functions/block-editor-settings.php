<?php

	// When set, users will be restricted to the default sizes provided in the block editor or the sizes provided via the editor-font-sizes theme support setting.
	add_theme_support( 'disable-custom-font-sizes' );

	// This flag will make sure users are only able to choose colors from the editor-color-palette the theme provided or from the editor default colors if the theme did not provide one.
	add_theme_support( 'disable-custom-colors' );

	// -- Enable editor styles
	// add_theme_support( 'editor-styles' );

	// -- Enable responsive embedded content
	add_theme_support( 'responsive-embeds' );

	// Add Google Fonts - Before using check if fonts are already loading or not in the backend
	// add_editor_style( 'https://fonts.googleapis.com/css?family=Roboto+Slab' );

	// -- Enqueue editor script
	function skel_gutenberg_scripts() {
		// plugins
		// wp_enqueue_script(
		// 	'skel-editor-plugins',
		// 	get_stylesheet_directory_uri() . '/js/plugins.js',
		// 	['jquery'],
		// 	filemtime( get_stylesheet_directory() . '/js/plugins.js' ),
		// 	true
		// );
		// editor js - Npt required anymore
		// https://developer.wordpress.org/block-editor/developers/filters/block-filters/#using-a-blacklist
		// wp_enqueue_script (
		//   'skel-editor',
		//   get_stylesheet_directory_uri() . '/js/editor.js',
		//   array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ),
		//   filemtime( get_stylesheet_directory() . '/js/editor.js' ),
		//   true
		// );
		// typekit fonts
		// wp_enqueue_style( 'typekit-fonts', '//use.typekit.net/soi0ors.css', 'all' );
	}
	// add_action( 'enqueue_block_editor_assets', 'skel_gutenberg_scripts' );

	// -- Load custom css in editor
	function skel_editor_css() {?>
	<style type="text/css">

	.edit-post-visual-editor .core-block-preview {
		padding: 30px;
		color: gray;
		text-align: center;
		border: 2px dashed rgba(0,0,0, 0.5);
	}

	.edit-post-visual-editor .acf-block-fields > .acf-field > .acf-accordion-content > .acf-fields > .acf-tab-wrap > .acf-tab-group {
		display: flex;
		margin: 0;
		padding: 0;
		border: none;
	}

	.edit-post-visual-editor .acf-block-fields > .acf-field > .acf-accordion-content > .acf-fields > .acf-tab-wrap > .acf-tab-group li {
		margin: 0;
	}

	.edit-post-visual-editor .acf-block-fields > .acf-field > .acf-accordion-content > .acf-fields > .acf-tab-wrap > .acf-tab-group li:nth-child(1) {
		width: 100%;
	}

	.edit-post-visual-editor .acf-block-fields > .acf-field > .acf-accordion-content > .acf-fields > .acf-tab-wrap > .acf-tab-group li:nth-child(2) {
		flex-shrink: 0;
	}

	.edit-post-visual-editor .acf-block-fields > .acf-field > .acf-accordion-content > .acf-fields > .acf-tab-wrap > .acf-tab-group li a {
		padding: 5px 20px 4px;
		font-size: 10px;
		font-weight: bold;
		text-transform: uppercase;
		border: none;
	}

	.edit-post-visual-editor .acf-block-fields > .acf-field > .acf-accordion-content > .acf-fields > .acf-tab-wrap > .acf-tab-group li:not(.active) a {
		background: rgba(0,0,0, 0.03);
	}

	.edit-post-visual-editor .acf-block-fields > .acf-field > .acf-accordion-content > .acf-fields > .acf-tab-wrap > .acf-tab-group li:not(.active) a:hover {
		background: rgba(0,0,0, 0.01);
	}


	/* Overwrite sreveal visibility hidden to visible */
	.sreveal-stagger-item,
	[data-sreveal] {
		visibility: visible !important;
	}

	.swiper-slide.wait-for-sreveal .aos-stagger-item,
	.swiper-slide.wait-for-sreveal [data-aos],
	.swiper-wrapper[data-sreveal="trigger"] .aos-stagger-item,
	.swiper-wrapper[data-sreveal="trigger"] [data-aos] {
		opacity: 1 !important;
		transform: none !important;
		visibility: visible !important;
	}
	</style>
	<?php
		}
		add_action( 'admin_head-post.php', 'skel_editor_css' );
		add_action( 'admin_head-post-new.php', 'skel_editor_css' );

		// -- Remove Gutenberg Block Library CSS from loading on the frontend
		function skel_remove_wp_block_library_css() {
			wp_dequeue_style( 'wp-block-library' );
			wp_dequeue_style( 'wp-block-library-theme' );
		}
		add_action( 'wp_enqueue_scripts', 'skel_remove_wp_block_library_css' );

?>

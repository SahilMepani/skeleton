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
		wp_enqueue_script(
			'skel-editor-plugins',
			get_stylesheet_directory_uri() . '/js/plugins.js',
			['jquery'],
			filemtime( get_stylesheet_directory() . '/js/plugins.js' ),
			true
		);
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
	add_action( 'enqueue_block_editor_assets', 'skel_gutenberg_scripts' );

	// -- Load custom css in editor
function skel_editor_css() {?>
<style type="text/css">
/* change the root font size as all selector values are rem unit */
html {
	font-size: 10px;
}

body#tinymce {
	margin: 10px;
	/* required */
}

/* change editor post title height */
textarea#post-title-0 {
	height: 75px;
}

/* Post title */
.wp-block-post-title {
	font-size: 3.6rem !important;
}

/* change the font styles as per project */
#editorcontainer #content,
#wp_mce_fullscreen,
textarea.wp-editor-area,
.block-editor-writing-flow {
	font-family: 'Montserrat', $font-family-sans-serif;
	/* this font should be imported editor-style.css */
	font-size: 1.8rem;
	line-height: 1.55;
}

.acf-block-preview p,
.acf-block-preview table,
.acf-block-preview ul,
.acf-block-preview ol,
.acf-block-preview dl,
.acf-block-preview dd,
.acf-block-preview pre,
.acf-block-preview blockquote,
.acf-block-preview address {
	font-size: 1.8rem !important;
}

/* Increase block editor sidebar */
.edit-post-layout.is-sidebar-opened .edit-post-layout__content {
	margin-inline-end: 25vw !important;
}

.edit-post-layout.is-sidebar-opened .edit-post-plugin-sidebar__sidebar-layout,
.edit-post-layout.is-sidebar-opened .edit-post-sidebar,
.edit-post-toggle-publish-panel {
	width: 25vw !important;
}

/* Main column width */
.wp-block {
	max-width: 100%;
}

/* Width of "wide" blocks */
.wp-block[data-align="wide"] {
	max-width: 108rem;
}

/* Width of "full-wide" blocks */
.wp-block[data-align="full"] {
	max-width: none;
}

/* Overwrites */
.acf-tab-group li {
	margin-bottom: 0 !important;
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

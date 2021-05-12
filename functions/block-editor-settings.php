<?php

// -- Enable Align wide
// add_theme_support( 'align-wide' );

// -- Custom Color Pallette
// add_theme_support( 'editor-color-palette', array(
//   array(
//     'name' => __( 'Dark Blue', 'skel' ),
//     'slug' => 'dark-blue',
//     'color' => '#221a3e',
//   ),
//   array(
//     'name' => __( 'Blue', 'skel' ),
//     'slug' => 'Blue',
//     'color' => '#45367d',
//   ),
//   array(
//     'name' => __( 'Dark gray', 'skel' ),
//     'slug' => 'dark-gray',
//     'color' => '#626262',
//   ),
//   array(
//     'name' => __( 'Golden', 'skel' ),
//     'slug' => 'golden',
//     'color' => '#d2b66f',
//   ),
//   array(
//     'name' => __( 'Gray', 'skel' ),
//     'slug' => 'gray',
//     'color' => '#c2c2c7',
//   ),
//   array(
//     'name' => __( 'Light Gray', 'skel' ),
//     'slug' => 'gray',
//     'color' => '#e3e2e8',
//   ),
// ) );

// -- Custom Font Sizes
// add_theme_support( 'editor-font-sizes', array(
//   array(
//     'name'      => __( 'Small', 'skel' ),
//     'shortName' => __( 'S', 'skel' ),
//     'size'      => 12,
//     'slug'      => 'small'
//   ),
//   array(
//     'name'      => __( 'Normal', 'skel' ),
//     'shortName' => __( 'M', 'skel' ),
//     'size'      => 16,
//     'slug'      => 'normal'
//   ),
//   array(
//     'name'      => __( 'Large', 'skel' ),
//     'shortName' => __( 'L', 'skel' ),
//     'size'      => 20,
//     'slug'      => 'large'
//   ),
// ) );

// When set, users will be restricted to the default sizes provided in the block editor or the sizes provided via the editor-font-sizes theme support setting.
add_theme_support( 'disable-custom-font-sizes' );

// This flag will make sure users are only able to choose colors from the editor-color-palette the theme provided or from the editor default colors if the theme did not provide one.
add_theme_support( 'disable-custom-colors' );

// -- Enable editor styles
add_theme_support( 'editor-styles' );

// -- Enable responsive embedded content
add_theme_support( 'responsive-embeds' );


// -- Enqueue editor script
function skel_gutenberg_scripts() {
  // modernizr
  wp_enqueue_script(
    'skel-modernizr',
    get_stylesheet_directory_uri(). '/js/vendor/modernizr-3.6.0.min.js',
    filemtime( get_stylesheet_directory(). '/js/vendor/modernizr-3.6.0.min.js' ),
    true
  );
  // plugins
  wp_enqueue_script(
    'skel-editor-plugins',
    get_stylesheet_directory_uri(). '/js/plugins.js',
    array( 'jquery' ),
    filemtime( get_stylesheet_directory(). '/js/plugins.js' ),
    true
  );
  // custom
  wp_enqueue_script(
    'skel-editor-custom',
    get_stylesheet_directory_uri(). '/js/custom.js',
    array( 'skel-editor-plugins' ),
    filemtime( get_stylesheet_directory(). '/js/custom.js' ),
    true
  );
  // editor js
  // https://developer.wordpress.org/block-editor/developers/filters/block-filters/#using-a-blacklist
  wp_enqueue_script (
    'skel-editor',
    get_stylesheet_directory_uri() . '/js/editor.js',
    array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ),
    filemtime( get_stylesheet_directory() . '/js/editor.js' ),
    true
  );
  // typekit fonts
  wp_enqueue_style( 'typekit-fonts', '//use.typekit.net/soi0ors.css', 'all' );
}
add_action( 'enqueue_block_editor_assets', 'skel_gutenberg_scripts' );


// -- Load custom css in editor
function skel_editor_css() {
  ?>
    <style type="text/css">
    /* change the root font size as all selector values are rem unit */
      html {
        font-size: 10px;
    }
    /* change editor post title height */
    textarea#post-title-0 {
        height: 75px;
    }
    /* change the font styles as per project */
    #editorcontainer #content, #wp_mce_fullscreen, textarea.wp-editor-area, .block-editor-writing-flow {
        font-family: 'titling-gothic-fb', sans-serif; /* this font should be imported editor-style.css */
      font-size: 1.6rem;
      line-height: 1.7;
    }
    /* Increase block editor sidebar */
    .edit-post-layout.is-sidebar-opened .edit-post-layout__content {
        margin-right: 25vw !important;
    }
    .edit-post-layout.is-sidebar-opened .edit-post-plugin-sidebar__sidebar-layout, .edit-post-layout.is-sidebar-opened .edit-post-sidebar, .edit-post-toggle-publish-panel {
        width: 25vw !important;
    }
    /* Main column width */
    .wp-block {
      max-width: 100%;
    }
    /* Width of "wide" blocks */
    .wp-block[data-align="wide"] {
        max-width: rem-calc( 1080px );
    }
    /* Width of "full-wide" blocks */
    .wp-block[data-align="full"] {
        max-width: none;
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
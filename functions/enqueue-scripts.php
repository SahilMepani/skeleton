<?php
function skel_enqueue_scripts() {

  /* Load google fonts */
  wp_enqueue_style('google-fonts', '//fonts.googleapis.com/css?family=Montserrat&display=swap', 'all');

  /* Do not load in backend */
  if (is_admin()) return;

  // load jquery at bottom
  // https://wordpress.stackexchange.com/questions/173601/enqueue-core-jquery-in-the-footer
  // ths will break gravity forms on some pages, be careful
  wp_scripts()->add_data( 'jquery', 'group', 1 );
  wp_scripts()->add_data( 'jquery-core', 'group', 1 );

  /* wp_enqueue_script(
    'identifier',
    'url',
    'dependency',
    'version',
    load_in_footer_boolean
  ); */

  wp_enqueue_style(
		'skeleton-style',
		get_stylesheet_uri(),
		array(),
		filemtime( get_template_directory() . '/style.css' )
	);

  // load style-rtl for rtl languages
  wp_style_add_data( 'skeleton-style', 'rtl', 'replace' );

  wp_enqueue_script(
    'plugins',
    get_template_directory_uri() . '/js/plugins.js',
    array('jquery'),
    filemtime( get_template_directory() . '/js/plugins.js' ),
    true
  );

  wp_enqueue_script(
    'modernizr',
    get_template_directory_uri() . '/js/vendor/modernizr-3.6.0.min.js'
  );

  // wp_enqueue_script(
  //   'ua-parser',
  //   get_template_directory_uri() . '/js/vendor/ua-parser-0.7.20.min.js'
  // );

  wp_enqueue_script(
    'match-height',
    get_template_directory_uri() . '/js/vendor/match-height.js',
    array('jquery'),
    filemtime( get_template_directory() . '/js/vendor/match-height.js' ),
    true
  );

  // localize scripts
  // wp_localize_script(
  //   'plugins', // file name without extension where we want to use the localize_var
  //   'localize_var',
  //   array(
  //     'ajax_url' => admin_url( 'admin-ajax.php' ),
  //     // security
  //     'nonce'    => wp_create_nonce( 'nonce_name' ),
  //   )
  // );

}
add_action('wp_enqueue_scripts', 'skel_enqueue_scripts');
?>

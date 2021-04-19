<?php
function skel_enqueue_scripts() {
  /* Load google fonts */
  wp_enqueue_style('google-fonts', '//fonts.googleapis.com/css?family=Monskelrrat&display=swap', 'all');

  /* Do not load in backend */
  if (is_admin()) return;

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
    filemtime( get_template_directory() )
  );
  wp_enqueue_script(
    'modernizr',
    get_template_directory_uri() . '/js/vendor/modernizr-3.6.0.min.js'
  );
  wp_enqueue_script(
    'ua-parser',
    get_template_directory_uri() . '/js/vendor/ua-parser-0.7.20.min.js'
  );
  wp_enqueue_script(
    'plugins',
    get_template_directory_uri() . '/js/plugins.js',
    array('jquery'),
    filemtime( get_template_directory() . '/js/plugins.js' ),
    true
  );
  wp_enqueue_script(
    'custom',
    get_template_directory_uri() . '/js/custom.js',
    array('jquery', 'plugins'),
    filemtime( get_template_directory() . '/js/custom.js' ),
    true
  );
  // localize scripts
  wp_localize_script(
    'custom',
    'localize_var',
    array(
      'ajax_url' => admin_url( 'admin-ajax.php' ),
      // security
      'nonce'    => wp_create_nonce( 'nonce_name' ),
    )
  );
}
add_action('wp_enqueue_scripts', 'skel_enqueue_scripts');
?>
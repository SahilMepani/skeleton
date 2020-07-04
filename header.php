<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
  <!-- HTML Boilerplte v6.01 -->
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title><?php wp_title( '-', true, 'right' ); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
  <!-- remove below link if google fonts are not used -->
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="profile" href="http://gmpg.org/xfn/11" />
  <?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
  <?php endif; ?>
  <?php wp_head(); ?>
</head>

<body <?php body_class( 'site-wrapper' ); ?>>

<header class="site-header clearfix">
</header> <!-- .site-header -->

<section class="site-content">

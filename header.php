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

<body class="site-wrapper" <?php body_class(); ?>>

<header class="site-header clearfix" role="banner">
  <div class="container-fluid">

    <h3 class="header-logo">
      <a href="<?php echo esc_url( home_url() ); ?>" title="<?php esc_attr_e( get_bloginfo( 'name' ) ); ?>" aria-label="Go to Home" <?php echo (is_front_page()) ? 'aria-current="page"' : ''; ?>></a>
    </h3>

    <button class="header-nav-toggle icon-font-before" aria-label="<?php _e( 'show primary navigation', 'tse' ); ?>" aria-haspopup="true" aria-expanded="false" aria-controls="siteMenu"><?php _e( 'Menu', 'tse' ); ?></button>

    <nav class="header-nav cleafix" role="navigation" aria-label="<?php _e( 'primary navigation', 'tse' ); ?>">
			<button class="header-nav-close icon-font-before" aria-label="<?php _e( 'close primary navigation' ); ?>" aria-haspopup="true" aria-expanded="true" aria-controls="siteMenu"></button>
			<?php wp_nav_menu( array(
				'theme_location' => 'header-menu',
				'container' => 'false',
				'menu_class' => 'header-nav-parent-menu',
				'items_wrap'	=> '<ul id="%1$s" class="%2$s" id="siteMenu">%3$s</ul>',
				)
			); ?>
		</nav> <!-- .header-nav -->

  </div> <!-- .container-fluid -->
</header> <!-- .site-header -->

<main class="site-content" role="main">

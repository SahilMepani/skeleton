<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
  <!-- HTML Boilerplte v6.01 -->
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title><?php wp_title( '-', true, 'right' ); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="shortcut icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/favicon.png">

  <link rel="profile" href="http://gmpg.org/xfn/11" />
  <?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
  <?php endif; ?>
	<?php wp_head(); ?>
</head>

<body id="site-wrapper" <?php body_class(); ?>>

<header id="header" class="clearfix">
	<div class="container-fluid">

		<h3 class="header__logo">
			<a href="<?php echo esc_url( home_url() ); ?>" title="<?php esc_attr_e( get_bloginfo( 'name' ) ); ?>">
        <?php bloginfo('name'); ?>
        <span><?php bloginfo('description'); ?></span>
        <svg id="Layer_1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2101.8 347.5"><style>.header-logo-path{fill:#ff2500}</style><g id="Layer_2_1_"><g id="Layer_1-2"><path class="header-logo-path" d="M58.6 44.3H6.5c-3.6 0-6.5-2.9-6.5-6.5V9.9c0-3.6 2.9-6.5 6.5-6.5h148.9c3.6 0 6.5 2.9 6.5 6.4v27.9c0 3.6-2.9 6.5-6.4 6.5h-52.1v191.1c-.1 3.5-2.9 6.4-6.5 6.5H65.1c-3.5-.1-6.4-3-6.5-6.5v-191zM183 9.9c.1-3.5 3-6.4 6.5-6.5h29c3.5.1 6.4 2.9 6.5 6.5v103.6c6.8-5.1 20.1-11.2 36.1-11.2 43.3 0 61 33.4 61 67.8v65.4c-.1 3.5-3 6.4-6.5 6.5h-27.7c-3.6 0-6.5-2.9-6.5-6.5v-65.8c0-18.7-10.6-30.7-26.9-30.7-15.7 0-26.2 10.2-29.6 24.2v72.2c0 3.8-2 6.5-7.1 6.5h-28.3c-3.5-.1-6.4-3-6.5-6.5V9.9zM347.3 112.1c0-3.6 2.9-6.5 6.5-6.5h13c2.8-.1 5.3 1.7 6.1 4.4l4.8 13.3c4.8-6.8 17.4-21.1 38.5-21.1 16 0 30.3 5.1 26.2 13.6L429.8 138c-1.7 3.1-5.1 4.4-7.8 3.1-1-.3-6.1-2.1-9.9-2.1-13.6 0-21.8 9.2-24.2 14v82.4c0 4.8-3.1 6.5-7.8 6.5h-26.2c-3.5-.1-6.4-3-6.5-6.5V112.1zM516.1 102.2c35.1 0 63.7 26.6 63.7 63.4-.1 3.1-.3 6.1-.7 9.2-.4 3.3-3.2 5.8-6.5 5.8h-87.2c1.5 16.9 15.7 29.8 32.7 29.6 9.5-.1 18.8-3.1 26.6-8.5 3.4-2.1 6.5-2.7 8.9 0l14 16c2.4 2.4 3.1 6.1-.3 8.9-11.2 10.6-28.6 18.7-50.8 18.7-40.9 0-69.9-32.4-69.9-71.6 0-38.4 29-71.5 69.5-71.5m23.9 54.5c-1-12.6-11.9-23.2-24.9-23.2-13.4 0-24.7 9.9-26.6 23.2H540zM665.7 102.2c35.1 0 63.7 26.6 63.7 63.4-.1 3.1-.3 6.1-.7 9.2-.4 3.3-3.2 5.8-6.5 5.8H635c1.5 16.9 15.7 29.8 32.7 29.6 9.5-.1 18.8-3.1 26.6-8.5 3.4-2.1 6.5-2.7 8.9 0l14 16c2.4 2.4 3.1 6.1-.3 8.9-11.2 10.6-28.6 18.7-50.8 18.7-40.9 0-69.8-32.4-69.8-71.6-.1-38.4 28.9-71.5 69.4-71.5m23.9 54.5c-1-12.6-11.9-23.2-24.9-23.2-13.4 0-24.7 9.9-26.6 23.2h51.5zM748.2 208.5l12.3-21.1c2.2-3.8 7-5.1 10.8-2.9.3.2.5.3.8.5 1.7 1 29.3 21.1 51.5 21.1 17.7 0 31-11.6 31-26.2 0-17.4-14.7-29.3-43.3-40.9-32-12.9-64.1-33.4-64.1-73.6 0-30.3 22.5-65.4 76.7-65.4 34.8 0 61.3 17.7 68.2 22.8 3.4 2 4.4 7.8 2 11.2l-13 19.4c-2.7 4.1-7.8 6.8-11.9 4.1-2.7-1.7-28.6-18.7-47.4-18.7-19.4 0-30 13-30 23.8 0 16 12.6 26.9 40.2 38.2 33 13.3 71.2 33.1 71.2 77 0 35.1-30.3 67.5-78.4 67.5-42.9 0-68.1-20.1-75-26.6-3.1-3-4.8-4.7-1.6-10.2M923.4 33.7c-.1-12.9 10.2-23.4 23-23.5h.1c13-.4 23.8 9.8 24.2 22.8S961 56.8 948 57.2h-1.4c-12.9-.1-23.2-10.5-23.2-23.4v-.1m3.1 78.4c0-3.6 2.9-6.5 6.5-6.5h28.3c3.6 0 6.5 2.9 6.5 6.5v123.3c-.1 3.5-3 6.4-6.5 6.5H933c-3.5-.1-6.4-3-6.5-6.5V112.1zM994.4 232l44.3-59.6-42.9-56.9c-3.4-4.4-.7-9.9 5.1-9.9h28.3c4.4 0 8.2.3 11.2 4.8l22.1 32h.3l22.5-32c2.7-3.8 5.5-4.8 10.2-4.8h30.7c5.8 0 7.5 5.4 4.1 9.9l-42.9 56.6 43.3 60c3.1 4.4 1.4 9.9-4.1 9.9h-30c-4.4 0-7.2-2-9.5-5.4l-24.2-34.1h-.3l-25.9 36.8c-1.4 1.6-3.4 2.5-5.4 2.7h-32.7c-5.9-.1-7.3-5.5-4.2-10M1165.9 141.4h-11.6c-3.5-.2-6.2-3-6.1-6.5v-22.8c-.2-3.4 2.5-6.3 5.9-6.5H1165.9V67.8c.1-3.5 2.9-6.4 6.5-6.5l27.9-.3c3.5.1 6.2 3 6.1 6.5v38.2h30c3.5-.1 6.4 2.6 6.5 6v23.2c0 3.6-2.9 6.5-6.5 6.5h-30v54.5c0 9.5 5.1 10.9 10.6 10.9 5.8 0 12.9-2.4 16.7-3.8s6.5.3 7.5 3.8l6.8 21.5c1.3 3.2-.2 6.8-3.4 8-.1 0-.2.1-.4.1-1.7 1-23.8 8.9-40.6 8.9-26.2 0-37.8-16.4-37.8-44v-59.9zM1262.1 114.5c-2-4.4.7-8.9 5.8-8.9h30.7c2.5-.1 4.8 1.4 5.8 3.8l34.4 77h.3l34.1-77c1.7-3.4 4.1-3.8 8.2-3.8h27.3c5.4 0 8.2 4.4 5.8 8.9L1310.1 340c-1 2-3.1 4.1-5.8 4.1H1275c-5.1 0-8.2-4.4-5.8-9.2l48.4-102.6-55.5-117.8zM1438.8 9.9c0-3.6 2.9-6.5 6.5-6.5H1584c3.6 0 6.5 2.9 6.5 6.5v27.9c0 3.6-2.9 6.5-6.4 6.5h-100.9v55.9h84.2c3.5.1 6.4 2.9 6.5 6.5V135c0 3.6-2.9 6.5-6.5 6.5h-84.2V201h100.9c3.6 0 6.5 2.9 6.5 6.5v27.9c0 3.6-2.9 6.5-6.5 6.5h-138.7c-3.6 0-6.5-2.9-6.5-6.5V9.9zM1614.9 33.7c-.1-12.9 10.2-23.4 23-23.5h.1c13-.4 23.8 9.8 24.2 22.8.4 13-9.8 23.8-22.8 24.2h-1.4c-12.9-.1-23.2-10.5-23.2-23.4.1 0 .1 0 .1-.1m3.1 78.4c0-3.6 2.9-6.5 6.5-6.5h28.3c3.6 0 6.5 2.9 6.5 6.5v123.3c-.1 3.5-3 6.4-6.5 6.5h-28.3c-3.5-.1-6.4-3-6.5-6.5V112.1zM1705.4 193.5s-10.2-11.6-10.2-32c0-31.7 25.6-59.3 59.3-59.3h62c3.5-.1 6.4 2.6 6.5 6V120c0 2.4-1.4 5.1-3.7 5.8l-19.1 6.1s13.6 10.6 13.6 34.8c0 26.9-22.5 53.5-58.3 53.5-12.9 0-21.8-2.7-27.2-2.7-4.8 0-12.6 4.8-12.6 13 0 7.1 6.1 11.6 13.6 11.6h43.6c31 0 56.2 17.7 56.2 47.7 0 31.4-25.2 57.9-74.6 57.9-50.4 0-69.5-24.9-69.5-46.7 0-20.4 17-30.3 20.4-32.4v-1c-5.8-1.7-25.6-10.9-25.6-35.8 0-26.6 25.6-38.2 25.6-38.2m48.7 120c19.1 0 31.7-8.5 31.7-21.5 0-6.1-4.8-16.7-24.9-16.7-7.4-.1-14.8.4-22.2 1.4-4.1 1.4-14.7 6.1-14.7 16.7.1 11.9 11.7 20.1 30.1 20.1m1.3-125.8c14 0 23.5-10.2 23.5-24.5s-9.5-24.5-23.5-24.5c-13.6 0-23.8 10.2-23.8 24.5s10.2 24.5 23.8 24.5M1845.8 9.9c.1-3.5 2.9-6.4 6.5-6.5h29c3.5.1 6.4 2.9 6.5 6.5v103.6c6.8-5.1 20.1-11.2 36.1-11.2 43.3 0 61 33.4 61 67.8v65.4c-.1 3.5-2.9 6.4-6.5 6.5h-27.6c-3.6 0-6.5-2.9-6.5-6.5v-65.8c0-18.7-10.6-30.7-26.9-30.7-15.7 0-26.2 10.2-29.6 24.2v72.2c0 3.8-2.1 6.5-7.2 6.5h-28.3c-3.5-.1-6.4-3-6.5-6.5V9.9zM2019.2 141.4h-11.6c-3.5-.2-6.2-3-6.1-6.5v-22.8c-.2-3.4 2.5-6.3 5.9-6.5H2019.2V67.8c.1-3.5 2.9-6.4 6.5-6.5l27.9-.3c3.5.1 6.2 3 6.1 6.5v38.2h30c3.5-.1 6.4 2.6 6.5 6v23.2c0 3.6-2.9 6.5-6.5 6.5h-30v54.5c0 9.5 5.1 10.9 10.6 10.9 5.8 0 12.9-2.4 16.7-3.8s6.5.3 7.5 3.8l6.8 21.5c1.3 3.2-.2 6.8-3.4 8-.1 0-.2.1-.4.1-1.7 1-23.9 8.9-40.5 8.9-26.2 0-37.8-16.4-37.8-44v-59.9z"/></g></g></svg>
			</a>
		</h3>

		<button class="header__nav-toggle i-font-before"><?php _e( 'Menu', 'skeleton' ); ?></button>

		<nav class="header__nav" class="clearfix">
			<button class="header__nav-close i-font-before"></button>
			<?php wp_nav_menu( array( 'theme_location' => 'header-menu', 'container' => '', 'menu_class' => 'header__nav__parent-menu' ) ); ?>
		</nav> <!-- #header-menu -->

	</div> <!-- .container-fluid -->
</header> <!-- #header -->

<section id="site-content">

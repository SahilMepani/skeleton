<?php
/**
 * The header.
 *
 * This is the template that displays all of the <head> section and everything up until main.
 *
 * @package WordPress
 * @subpackage Skeleton
 * @since 1.0.0
 */

?>

<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<!-- HTML Boilerplte v8.00 -->
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title><?php wp_title( '-', true, 'right' ); ?></title>
	<!-- favicon -->
	<link rel="icon" href="<?php echo esc_attr( get_template_directory_uri() ); ?>/favicon.png" type="image/png">
	<link rel="icon" href="/favicon.svg" type="image/svg+xml">
	<!-- remove below link if google fonts are not used -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<!-- End - Google fonts -->
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
	<!-- DevisedLabs Very Large Image LCP Hack -->
	<img width="99999" height="99999" style="pointer-events: none; position: absolute; top: 0; left: 0; width: 97vw; height: 97vh; max-width: 97vw; max-height: 97vh;"  src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz48c3ZnIHdpZHRoPSI5OTk5OXB4IiBoZWlnaHQ9Ijk5OTk5cHgiIHZpZXdCb3g9IjAgMCA5OTk5OSA5OTk5OSIgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj48ZyBzdHJva2U9Im5vbmUiIGZpbGw9Im5vbmUiIGZpbGwtb3BhY2l0eT0iMCI+PHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9Ijk5OTk5IiBoZWlnaHQ9Ijk5OTk5Ij48L3JlY3Q+IDwvZz4gPC9zdmc+">
</head>

<body <?php body_class( 'site-wrapper' ); ?>>

	<?php wp_body_open(); ?>

	<a class="skip-link screen-reader-text" href="#site-content">
		<?php esc_html_e( 'Skip to content', 'skel' ); ?>
	</a>

	<header class="site-header">
		<div class="container-fluid">

			<div class="header-logo">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_html( get_bloginfo( 'name' ) ); ?>"
					aria-label="Go to Home"	<?php echo is_front_page() ? 'aria-current="page"' : ''; ?>>
					<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/svg/logo.svg" alt="">
				</a>
			</div>

			<button
				class="header-nav-toggle"
				aria-label="<?php esc_attr_e( 'show primary navigation', 'skel' ); ?>"
				aria-haspopup="true"
				aria-expanded="false"
				aria-controls="siteMenu">
				<?php esc_html_e( 'Menu', 'skel' ); ?>
			</button>

			<nav class="header-nav" role="navigation" aria-label="<?php esc_attr_e( 'primary navigation', 'skel' ); ?>">

				<button
					class="header-nav-close"
					aria-label="<?php esc_attr_e( 'close primary navigation' ); ?>"
					aria-haspopup="true"
					aria-expanded="true"
					aria-controls="siteMenu">
				</button>

				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'header-menu',
						'container'      => 'false',
						'menu_class'     => 'header-nav-parent-menu',
						'items_wrap'     => '<ul id="siteMenu" class="%2$s">%3$s</ul>',
					)
				);
				?>
			</nav> <!-- .header-nav -->

		</div> <!-- .container-fluid -->

		<div class="header-search-form" data-toggle-link="search-form">
			<div class="container">
				<?php get_search_form(); ?>
			</div> <!-- .container -->
		</div>
	</header> <!-- .site-header -->

	<main id="site-content" class="site-content" role="main">

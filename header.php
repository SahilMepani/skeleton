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
<html <?php language_attributes(); ?>  class="<?php echo esc_html( skel_direction_class() ); ?>">

<head>
	<!-- HTML Boilerplte v8.00 -->
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="x-ua-compatible" content="ie=edge">

	<!-- favicon -->
	<link rel="icon" href="<?php echo esc_attr( get_template_directory_uri() ); ?>/favicon.png" type="image/png">
	<link rel="icon" href="<?php echo esc_attr( get_template_directory_uri() ); ?>/favicon.svg" type="image/svg+xml">
	<!-- remove below link if google fonts are not used -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<!-- End - Google fonts -->

	<?php wp_head(); ?>
</head>

<body <?php body_class( 'site-wrapper' ); ?>>

	<?php wp_body_open(); ?>

	<!-- this has to be the first item focusable -->
	<a class="skip-link screen-reader-text" href="#site-content">
		<?php esc_html_e( 'Skip to content', 'skel' ); ?>
	</a>

	<div class="modal-backdrop" aria-hidden="true"></div>

	<?php
		$header_options = get_field( 'header', 'option' );
		$header_logo    = $header_options['logo'] ?? '';
	?>

	<header class="site-header">
		<div class="container-fluid">

			<div class="header-logo">
				<?php if ( $header_logo ) { ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"
					title="<?php echo esc_html( get_bloginfo( 'name' ) ); ?>" aria-label="Go to Home"
					<?php echo is_front_page() ? 'aria-current="page"' : ''; ?>>
						<img src="<?php echo esc_url( $header_logo ); ?>" alt="">
					</a>
				<?php } ?>
			</div>

			<button class="header-nav-toggle" aria-label="<?php esc_attr_e( 'show primary navigation', 'skel' ); ?>"
				aria-haspopup="true" aria-expanded="false" aria-controls="siteMenu">
				<?php esc_html_e( 'Menu', 'skel' ); ?>
			</button>

			<nav class="header-nav" data-esc aria-label="<?php esc_attr_e( 'primary navigation', 'skel' ); ?>">

				<button class="header-nav-close" aria-label="<?php esc_attr_e( 'close primary navigation', 'skel' ); ?>"
					aria-expanded="false" aria-controls="siteMenu">
					<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
					<path d="M3 13h18c0.552 0 1-0.448 1-1s-0.448-1-1-1h-18c-0.552 0-1 0.448-1 1s0.448 1 1 1zM3 7h18c0.552 0 1-0.448 1-1s-0.448-1-1-1h-18c-0.552 0-1 0.448-1 1s0.448 1 1 1zM3 19h18c0.552 0 1-0.448 1-1s-0.448-1-1-1h-18c-0.552 0-1 0.448-1 1s0.448 1 1 1z" fill="currentColor"></path>
					</svg>
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

	<main id="site-content" class="site-content">

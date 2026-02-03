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
	<link rel="icon" href="<?php echo esc_attr( get_template_directory_uri() ); ?>/assets/images/favicon.png" type="image/png">
	<link rel="icon" href="<?php echo esc_attr( get_template_directory_uri() ); ?>/assets/images/favicon.ico" type="image/x-icon">
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
		<div class="container">

			<div class="header-logo">
				<a href="/index.php" title="Go to Home" aria-label="Go to Home">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 104 18"><path fill="#080c11" d="M0 0h3.192v18H0zM11.262 18l-3.116-7.85V18H4.979V0h2.593l3.117 8.693V0h3.166v18zM21.94 18l-3.118-7.85V18h-3.166V0h2.593l3.117 8.693V0h3.166v18zM26.333 0h7.605v3.324h-4.414V7.21h3.666v3.324h-3.666v4.142h4.413V18h-7.604zM42.376 0c.748 0 1.321.205 1.72.588.4.384.599.946.599 1.713V8.72c0 .613-.2 1.074-.574 1.33-.374.255-.823.408-1.371.434L45.218 18h-3.291l-2.27-7.082V7.21h1.846V3.324h-2.568V18h-3.192V0zM56.94 18h-3.39l-1.97-9.895L49.66 18h-3.416l3.715-18h3.291zM61.676 18h-3.191V0h3.191zm.698-5.625V5.446L64.47 0h3.391l-3.64 9 3.64 9h-3.391zM77.633 0v3.324h-2.518V18h-3.192V3.324h-2.518V0zM79.424 0h3.192v18h-3.192zM94.85 0l-3.69 18h-3.316l-3.69-18h3.391l1.945 9.895L91.46 0zM96.395 0H104v3.324h-4.413V7.21h3.665v3.324h-3.665v4.142H104V18h-7.605z"/></svg>
				</a>
			</div>

			<button class="header-nav-toggle btn" aria-label="show primary navigation" aria-haspopup="true" aria-expanded="false"
				aria-controls="siteMenu">
				<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
					<path
						d="M3 13h18c0.552 0 1-0.448 1-1s-0.448-1-1-1h-18c-0.552 0-1 0.448-1 1s0.448 1 1 1zM3 7h18c0.552 0 1-0.448 1-1s-0.448-1-1-1h-18c-0.552 0-1 0.448-1 1s0.448 1 1 1zM3 19h18c0.552 0 1-0.448 1-1s-0.448-1-1-1h-18c-0.552 0-1 0.448-1 1s0.448 1 1 1z"
						fill="currentColor"></path>
				</svg>

			</button>

			<nav class="header-nav" data-esc aria-label="primary navigation">

				<button class="header-nav-close btn" aria-label="close primary navigation" aria-expanded="false"
					aria-controls="siteMenu">
					<svg viewBox="0 0 24 24" fill="none">
						<path
							d="M5.293 6.707l5.293 5.293-5.293 5.293c-0.391 0.391-0.391 1.024 0 1.414s1.024 0.391 1.414 0l5.293-5.293 5.293 5.293c0.391 0.391 1.024 0.391 1.414 0s0.391-1.024 0-1.414l-5.293-5.293 5.293-5.293c0.391-0.391 0.391-1.024 0-1.414s-1.024-0.391-1.414 0l-5.293 5.293-5.293-5.293c-0.391-0.391-1.024-0.391-1.414 0s-0.391 1.024 0 1.414z"
							fill="currentColor"></path>
					</svg>
				</button>

				<ul class="header-menu">
					<li><a href="newsletter.php">About</a></li>
					<li class="js-active">
						<a href="#0">Services</a>
						<div class="dropdown-block">
							<ul class="header-sub-menu one-col">
								<li>
									<a href="index.php">
										<div class="inner-block">
											<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/icons/boost.svg" loading="lazy" alt="">
											<div class="text">
												UI/UX
												<span class="sub-title">Intuitive Human-Centered Interface Design</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="#0">
										<div class="inner-block">
											<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/icons/orbit.svg" loading="lazy" alt="">
											<div class="text">
												Web Apps
												<span class="sub-title">Scalable Secure Cloud-Based Application</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="#0">
										<div class="inner-block">
											<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/icons/checks.svg" loading="lazy" alt="">
											<div class="text">
												Web Development
												<span class="sub-title">Modern Responsive High-Performance Websites</span>
											</div>
										</div>
									</a>
								</li>
								<li>
									<a href="#0">
										<div class="inner-block">
											<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/icons/distribution.svg" loading="lazy" alt="">
											<div class="text">
												Mobile App Development
												<span class="sub-title">Custom Cross-Platform Mobile Solutions</span>
											</div>
										</div>
									</a>
								</li>
							</ul>
						</div> <!-- .dropdown-block -->
					</li>
					<li>
						<a href="#0">Case Studies</a>
						<div class="dropdown-block">
							<ul class="header-sub-menu two-col">
								<li>
									<a href="#smart-cart">
										<div class="inner-block"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/icons/cart.svg" loading="lazy" alt="">WordPress</div>
									</a>
								</li>
								<li>
									<a href="#bundle-builder">
										<div class="inner-block"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/icons/package.svg" loading="lazy" alt="">Webflow</div>
									</a>
								</li>
								<li>
									<a href="#collections">
										<div class="inner-block"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/icons/grid.svg" loading="lazy" alt="">Umbraco</div>
									</a>
								</li>
								<li>
									<a href="#post-purchase">
										<div class="inner-block"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/icons/money.svg" loading="lazy" alt="">Shopify
										</div>
									</a>
								</li>
								<li>
									<a href="#checkout-upsells">
										<div class="inner-block"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/icons/payment.svg" loading="lazy" alt="">Sitecore</div>
									</a>
								</li>
								<li>
									<a href="#moneyboard">
										<div class="inner-block"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/icons/dollar.svg" loading="lazy" alt="">Moneyboard</div>
									</a>
								</li>
							</ul>
						</div> <!-- .dropdown-block -->
					</li>
					<li><a href="consultancy.php">How We Work</a></li>
					<li>
						<div class="btns-block">
							<a href="#0" class="btn btn-cta btn-dark">
							<span>Book a Discovery Call</span>
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10"><path fill="currentColor" stroke="currentColor" stroke-width=".5" d="M5.215.25h1.76l4.5 4.5-4.483 4.5h-1.76l4.483-4.483zM.25 5.398V4.102h10.395v1.296z"/></svg>
							</a>
							<button class="btn btn-color-scheme">
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 17"><path fill="currentColor" d="M8.417 16.667A8.1 8.1 0 0 1 5.135 16a8.6 8.6 0 0 1-2.666-1.802A8.6 8.6 0 0 1 .667 11.53 8.1 8.1 0 0 1 0 8.25q0-3.042 1.938-5.365Q3.875.563 6.875 0a8.4 8.4 0 0 0 .23 4.031A8.2 8.2 0 0 0 9.186 7.48a8.2 8.2 0 0 0 3.448 2.084 8.4 8.4 0 0 0 4.032.229q-.542 3-2.875 4.937t-5.375 1.938m0-1.667a6.6 6.6 0 0 0 3.396-.917 6.6 6.6 0 0 0 2.458-2.52 10.3 10.3 0 0 1-3.396-.907A9.9 9.9 0 0 1 8 8.646 10.1 10.1 0 0 1 5.98 5.77a9.8 9.8 0 0 1-.897-3.396 6.5 6.5 0 0 0-2.51 2.469 6.7 6.7 0 0 0-.906 3.406q0 2.813 1.968 4.781 1.97 1.97 4.782 1.969"/></svg>
							</button>
						</div> <!-- .btns-block -->
					</li>
				</ul>
			</nav>

		</div>
	</header> <!-- .site-header -->

	<main id="site-content" class="site-content">

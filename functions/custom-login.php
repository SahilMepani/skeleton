<?php
/**
 * Custom login
 *
 * @package WordPress
 * @subpackage Skeleton
 * @since 1.0.0
 */

/**
 * Add logo
 *
 * @return void
 */
function skel_login_logo(): void {
	?>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;600;700&display=swap">
	<style type="text/css">
		body.login {
			background-color: #e9e9e9;
			font-family: "Josefin Sans", "-apple-system", BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
			position: relative;
			overflow: hidden;
		}
		/* body.login::before {
			content: '';
			background-blend
			display: block;
			width: 500px;
			height: 300px;
			background-color: red;
			position: absolute;
			left: 0;
			bottom: 0;
		} */
		body.login #login_error, #login .message {
			color: #18151d;
			font-size: 16px;
			border-radius: 5px;
			border: 0;
			padding: 12px 20px;
		}
		#login form {
			background: #fff;
			border-color: transparent;
			border-radius: 12px;
			padding: 24px 24px 28px;
		}
		#login label {
			color: #18151d;
		}
		#login .wp-pwd {
			margin-bottom: 5px;
		}
		.wp-pwd button {
			background-position: center center !important;
			background-repeat: no-repeat !important;
		}
		.wp-pwd button:active, .wp-pwd button:focus {
			border: 0 !important;
			outline: 0 !important;
		}
		.wp-pwd input[type="password"] + button {
			background-image: url('<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/images/login-icon-eye.svg') !important;
		}
		.wp-pwd input[type="text"] + button {
			background-image: url('<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/images/login-icon-eye-strike.svg') !important;
		}
		#login input[type="text"], #login input[type="password"] {
			font-size: 20px;
			background: #f7f7f9;
			color: #18151d;
			padding: 8px 15px;
			border-color: #737384;
			border-radius: 4px;
		}
		.dashicons.dashicons {
			display: none;
		}
		#login input[type="text"]:focus, #login input[type="password"]:focus {
			border-color: #6432be;
			box-shadow: none !important;
		}
		#login input[type="submit"] {
			background: #6432be;
			color: #fff;
			text-transform: uppercase;
			min-width: 89px;
			height: 39px;
			line-height: 39px;
			letter-spacing: 0.84px;
			border-radius: 22px;
			border: 0;
			overflow: hidden;
		}
		#login input[type="submit"]:focus {
			box-shadow: none;
		}
		#login h1 a, .login h1 a {
			background-image: url('<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/images/header-logo.svg');
			width: auto;
			height: 90px;
			background-size: contain;
			background-repeat: no-repeat;
			margin: 0 auto 30px;
		}
		#nav, #backtoblog {
			text-align: center;
		}
		#login #nav {
			margin-top: 30px;
		}
		#login #backtoblog {
			margin-top: 18px;
		}
		#login #nav a, #login #backtoblog a, .privacy-policy-page-link a {
			color: #6432be;
		}
		#login #nav a:hover, #login #backtoblog a:hover, .privacy-policy-page-link a:hover {
			color: #6432be;
			text-decoration: underline;
		}
		.privacy-policy-link {
			display: none;
		}
	</style>
	<?php } ?>

<?php
// Add action.
add_action( 'login_enqueue_scripts', 'skel_login_logo' );


/**
 * Add URL to logo
 *
 * @return string
 */
function skel_login_logo_url(): string {
	return home_url( '/' );
}
// Add filter.
add_filter( 'login_headerurl', 'skel_login_logo_url' );

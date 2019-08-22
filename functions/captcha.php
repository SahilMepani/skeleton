<?php
$site_key = "";

/** Captcha verification * */
function captcha_verification() {
	//site secret
	$secret = "";

	$response = isset($_POST['g-recaptcha-response']) ? esc_attr($_POST['g-recaptcha-response']) : '';

	$remote_ip = $_SERVER["REMOTE_ADDR"];

	// make a GET request to the Google reCAPTCHA Server
	$request = wp_remote_get(
					'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $response . '&remoteip=' . $remote_ip
	);

	// get the request response body
	$response_body = wp_remote_retrieve_body($request);

	$result = json_decode($response_body, true);

	return $result['success'];
}

/** Increase the width of login/registration form * */
function default_wp_login_reg_css() {
	echo '<style type="text/css">
	#login {
		width: 350px !important;
	}
	</style>' . "\r\n";
}

add_action('login_enqueue_scripts', 'default_wp_login_reg_css');

// add the header script to login/registration page header
add_action('login_enqueue_scripts', 'header_script');

// add CAPTCHA header script to WordPress header
add_action('wp_head', 'header_script');

/** reCAPTCHA header script */
function header_script() {
	echo '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
}

// adds the CAPTCHA to the login form
add_action('login_form', function() use ($site_key) {
	echo '<div class="g-recaptcha" data-sitekey="' . $site_key . '"></div>';
});


// authenticate the CAPTCHA answer
add_action('wp_authenticate_user', 'validate_captcha', 10, 2);

/**
 * Verify the CAPTCHA answer
 *
 * @param $user string login username
 * @param $password string login password
 *
 * @return WP_Error|WP_user
 */
function validate_captcha($user, $password) {

	if (isset($_POST['g-recaptcha-response']) && !captcha_verification()) {
		return new WP_Error('empty_captcha', '<strong>ERROR</strong>: Please retry CAPTCHA');
	}

	return $user;
}

// adds the CAPTCHA to the registration form
add_action('register_form', 'display_captcha');


// authenticate the CAPTCHA answer
add_action('registration_errors', 'validate_captcha_registration_field', 10, 3);

/**
 * Verify the captcha answer
 *
 * @param $user string login username
 * @param $password string login password
 *
 * @return WP_Error|WP_user
 */
function validate_captcha_registration_field($errors, $sanitized_user_login, $user_email) {
	if (isset($_POST['g-recaptcha-response']) && !captcha_verification()) {
		$errors->add('failed_verification', '<strong>ERROR</strong>: Please retry CAPTCHA');
	}

	return $errors;
}

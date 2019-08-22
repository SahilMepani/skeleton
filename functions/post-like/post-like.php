<?php

/* =======================================
	=              Post Like             =
	======================================= */
function post_like_script() {
	wp_enqueue_script('like_post', get_template_directory_uri() . '/functions/post-like/js/post-like.js', array('jquery'), '1.0', true);
	wp_localize_script('like_post', 'ajax_var', array(
			'url' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('ajax-nonce')
	));
}

add_action('wp_enqueue_scripts', 'post_like_script');

function post_like() {
	// Check for nonce security
	$nonce = $_POST['nonce'];

	if (!wp_verify_nonce($nonce, 'ajax-nonce'))
		die('Busted!');

	if (isset($_POST['post_like'])) {
		// Retrieve user IP address
		$ip       = $_SERVER['REMOTE_ADDR'];
		$post_id  = $_POST['post_id'];

		// Get voters'IPs for the current post
		$meta_IP  = get_post_meta($post_id, "voted_IP");
		$voted_IP = $meta_IP[0];

		if (!is_array($voted_IP))
			$voted_IP = array();

		// Get votes count for the current post
		$meta_count = get_post_meta($post_id, "votes_count", true);

		// Use has already voted ?
		if (!hasAlreadyVoted($post_id)) {
			$voted_IP[$ip] = time();

			// Save IP and increase votes count
			update_post_meta($post_id, "voted_IP", $voted_IP);
			update_post_meta($post_id, "votes_count", ++$meta_count);

			// Display count (ie jQuery return value)
			echo $meta_count;
		} else
			echo "already";
	}
	exit;
}

$timebeforerevote = 120; // = 2 hours

function hasAlreadyVoted($post_id) {
	global $timebeforerevote;

	// Retrieve post votes IPs
	$meta_IP = get_post_meta($post_id, "voted_IP");
	$voted_IP = $meta_IP[0];

	if (!is_array($voted_IP))
		$voted_IP = array();

	// Retrieve current user IP
	$ip = $_SERVER['REMOTE_ADDR'];

	// If user has already voted
	if (in_array($ip, array_keys($voted_IP))) {
		$time = $voted_IP[$ip];
		$now = time();

		// Compare between current time and vote time
		if (round(($now - $time) / 60) > $timebeforerevote)
			return false;

		return true;
	}

	return false;
}

function get_post_like($post_id) {
	$themename = "tidelands";

	if (get_post_meta($post_id, "votes_count", true) > 0) {
		$vote_count = get_post_meta($post_id, "votes_count", true);
	} else {
		$vote_count = 0;
	}

	$output = '<span class="count caps">' . $vote_count . ' Likes</span>';
	if (hasAlreadyVoted($post_id))
		$output .= ' <span title="' . __('Like this article', $themename) . '" class="like alreadyvoted i-heart"></span>';
	else
		$output .= '<a class="post-like" data-post_id="' . $post_id . '">
										<span  title="' . __('Like this article', $themename) . '"class="qtip like i-heart"></span>
								</a>';

	return $output;
}

add_action('wp_ajax_nopriv_post-like', 'post_like');
add_action('wp_ajax_post-like', 'post_like');


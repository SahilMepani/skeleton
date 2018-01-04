<?php

function get_instagram_feed( $max_images = 3 ) {
	//Variables cannot be empty. Replace with app details
	$user_id      = '2796811886';
	$access_token = '3190653665.3a81a9f.2c62bdf1dce246caaea39c1241ca9d50';
	$max_images   = $max_images; //image count

	$instaResult  = file_get_contents("https://api.instagram.com/v1/users/" . $user_id . "/media/recent/?access_token=" . $access_token . "&count=" . $max_images);
	return json_decode($instaResult);
}

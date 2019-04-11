<?php

/* ======================================
=            ScrollSpy Link            =
====================================== */
function tse_scrollspy_link( $string ) {
	// Lower case everything
	$string = strtolower($string);
	// Make alphanumeric (removes all other characters)
	$string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
	// Clean up multiple dashes or whitespaces
	$string = preg_replace("/[\s-]+/", " ", $string);
	// Convert whitespaces and underscore to dash
	$string = preg_replace("/[\s_]/", "-", $string);
	return $string;
}


/*================================================================
=            Validate Youtube link for Magnific Popup            =
================================================================*/
function tse_validate_youtube_link( $link ) {
	preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $link, $matches);
	$link = 'https://www.youtube.com/watch?v=' . $matches[0];
	return $link;
}


/*====================================================================
=            Custom excerpt function with length argument            =
====================================================================*/
function tse_get_the_excerpt( $limit ) {
	$excerpt = explode(' ', get_the_excerpt(), $limit);
	if ( count($excerpt) >= $limit ) {
		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt).'...';
	} else {
		$excerpt = implode(" ",$excerpt);
	}
	$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
	return $excerpt;
}


/*================================
=            Tiny URL            =
================================*/
function tse_tiny_url($url) {
	return file_get_contents('http://tinyurl.com/api-create.php?url=' . $url);
}


/*====================================
=            Text Shorter            =
====================================*/
function tse_text_shorter($input, $length) {
	//no need to trim, already shorter than trim length
	if (strlen($input) <= $length) {
		return $input;
	}
	//find last space within length
	$last_space = strrpos(substr($input, 0, $length), ' ');
	if (!$last_space)
		$last_space = $length;
	$trimmed_text = substr($input, 0, $last_space);

	//add ellipses (...)
	$trimmed_text .= '...';
	return $trimmed_text;
}


/*=================================================
=            Return terms without link            =
=================================================*/
function tse_the_terms($post_id, $taxonomy) {
	$terms = get_the_terms($post_id, $taxonomy); // Returns objects array
	$ar_term = array(); // Initialize an array
	foreach ($terms as $term) {
		$ar_term[] = $term->name; // Store term name
	}
	$result = join(", ", $ar_term); // Join all terms name
	echo $result;
}
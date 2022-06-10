<?php

// Swiper class depending on the direction
////////////////////////////////////////////////
function skel_swiper_direction_class() {
  if ( ICL_LANGUAGE_CODE==en ) {
    return 'swiper-container';
  } else if ( ICL_LANGUAGE_CODE==ar ) {
    return 'swiper-container-rtl';
  }
}

// Language direction class
////////////////////////////////////////////////
function skel_direction_class() {
  if ( ICL_LANGUAGE_CODE==en ) {
    return 'dir-ltr';
  } else if ( ICL_LANGUAGE_CODE==ar ) {
    return 'dir-rtl';
  }
}


// Generate working youtube  link for magnific popup
// Replace youtu.be to youtube.com
////////////////////////////////////////////////
// generate youtube link for magnific popup
function skel_get_yt_link( $url ) {
  // grab the position of forward slash
  $pos = strrpos($url, '/');
  // use position to get substring
  $id = $pos === false ? $url : substr($url, $pos + 1);
  // create working youtube link
  $url = 'https://www.youtube.com/watch?v=' . $id;
  return $url;
}


/*================================================================
=            Validate Youtube link for Magnific Popup            =
================================================================*/
function skel_get_validate_youtube_link( $link ) {
	preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $link, $matches);
	$link = 'https://www.youtube.com/watch?v=' . $matches[0];
	return $link;
}


/*====================================================================
=            Custom excerpt function with length argument            =
====================================================================*/
function skel_get_the_excerpt( $post_id, $limit ) {
	$excerpt = explode(' ', get_the_excerpt( $post_id ), $limit);
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
function skel_get_tiny_url($url) {
	return file_get_contents('http://tinyurl.com/api-create.php?url=' . $url);
}


/*====================================
=            Text Shorter            =
====================================*/
function skel_get_text_shorter($input, $length) {
	// no need to trim, already shorter than trim length
	if (strlen($input) <= $length) {
		return $input;
	}
	// find last space within length
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
// return string
// eg. term 1, term 2
function skel_get_the_terms($post_id, $taxonomy) {
	$terms = get_the_terms($post_id, $taxonomy); // Returns objects array
	$ar_term = array(); // Initialize an array
	if ( $terms ) {
		foreach ($terms as $term) {
			$ar_term[] = $term->name; // Store term name
		}
	}
	$result = join(", ", $ar_term); // Join all terms name
	return $result;
}

// return array
// eg. [name = 'term', 'id' = 3]
function skel_get_the_terms_data($post_id, $taxonomy) {
	$terms = get_the_terms($post_id, $taxonomy); // Returns objects array
	$ar_term = array(); // Initialize an array
	$i = 0;
	if ( $terms ) {
		foreach ($terms as $term) {
			$ar_term[$i]['name'] = $term->name; // Store term name
			$ar_term[$i]['id'] = $term->term_id; // Store term id
			$i++;
		}
	}
	return $ar_term;
}


/**
 * Phone URL
 * @param string $phone_number, ex: (555) 123-4568
 * @return string $phone_url, ex: tel:5551234568
 */
function skel_get_phone_url( $phone_number = false ) {
	$phone_number = str_replace( array( '(', ')', '-', '.', '|', ' ' ), '', $phone_number );
	return esc_url( 'tel:' . $phone_number );
}

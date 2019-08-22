
<?php

include_once('twitteroauth/twitteroauth.php');

function get_twitter_feed( $count = -1 ) {
  //Variables cannot be empty. Replace with app details
  $twitter_customer_key = '970jrB61y6jGq778Rbv8bRBHE';
  $twitter_customer_secret = 'DpKghlGTe97ZupEh843yK4Pc2o50meiNp65GuIbCQ2u8jK8V4Y';
  $twitter_access_token = '700726065602297858-XZLQbyPNBxVKKN8addW305kD6LcXnQI';
  $twitter_access_token_secret = 's2UohkmqfRnb20hKY2nhWLqutZp90iVgWwwMBi2vHhjdq';
  $username = 'threesixtyeight'; //twitter username
  $count = $count; //feed count

  $connection = new TwitterOAuth($twitter_customer_key, $twitter_customer_secret, $twitter_access_token, $twitter_access_token_secret);
  $tweets = $connection->get('statuses/user_timeline', array('screen_name' => $username, 'count' => $count));
  return $tweets;
}

//Function for clickable links
function makeClickableLinks($s) {
  return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a target="blank" rel="nofollow" href="$1" target="_blank">$1</a>', $s);
}

?>
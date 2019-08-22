<?php

//Pinterest Feed
function get_pinterest_feed() {
	$profile_id = "adlappliances"; //Profile ID
	$board      = "inspiration-board"; //Board Name

	/** Pull URL * */
	//Pinterest URL user feed  :  https://www.pinterest.com/' . $profile_id . '/feed.rss/
	//Pinterest URL user feed board  :  https://www.pinterest.com/' . $profile_id . '/'.$board.'.rss/

	$result = file_get_contents('https://www.pinterest.com/' . $profile_id . '/' . $board . '.rss/');
	return simplexml_load_string($result);
}

?>
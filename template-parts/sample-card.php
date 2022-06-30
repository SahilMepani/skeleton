<?php
 // Call the card
 foreach( $leaders as $leader ) {
  get_template_part('template-parts/leader-card', null, array('post_id' => $leader));
}
// Call the passed argument
$post_id = $args['post_id'];
?>
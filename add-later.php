<?php echo wp_get_attachment_image($desktop_image['id'], 'w375c', '', array( "class" => "mobile image-responsive" )); ?>

<?php echo get_the_post_thumbnail($post->ID, 'w375c', array('class' => 'img-responsive d-block mt-auto'); ?>

Try to scale inline img as background images using object fit
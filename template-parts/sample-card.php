<!-- Call the card -->
<?php $team = get_posts( $args ); ?>
<?php foreach( $team as $post ) { setup_postdata( $post ); ?>
	<?php get_template_part('template-parts/team-card', null, array('post_id' => $post)); ?>
<?php } wp_reset_postdata(); ?>
<!-- Call the passed argument inside template part file -->
<?php $post_id = $args['post_id']; ?>
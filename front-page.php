<?php get_header(); ?>

<?php //$registered_block_slugs = array_keys( WP_Block_Type_Registry::get_instance()->get_all_registered() ); echo '<pre>' . print_r( $registered_block_slugs, true ) . '</pre>'; ?>

<?php the_content(); ?>

<?php get_footer(); ?>
<?php get_header();?>

<?php
	// Show blocks used in the backend of the page
	//$registered_block_slugs = array_keys( WP_Block_Type_Registry::get_instance()->get_all_registered() ); echo '<pre>' . print_r( $registered_block_slugs, true ) . '</pre>';
?>

<h1 data-sreveal="fade-up">Animation Style</h1>
<h2 data-sreveal="fade-up">Animation Style</h2>

<?php the_content();?>

<?php get_footer();?>

<?php
	/**
	 * File comment
	 *
	 * @package category
	 */

?>

<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="search-box">
	<input type="text" name="s" class="search" placeholder="Search" />
	<?php wp_nonce_field( 'skel_search', 'my_nonce_field' ); ?>
	<input type="submit" value="" />
</form>

<?php
/**
 * Search form
 *
 * @package WordPress
 * @subpackage Skeleton
 * @since 1.0.0
 */

?>

<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="search-box">
	<input type="text" name="s" class="search" placeholder="<?php echo esc_attr__( 'Search', 'skel' ); ?>" />
	<input type="hidden" name="_wpnonce" value="<?php echo esc_attr( wp_create_nonce( 'search_nonce' ) ); ?>" />
	<input type="submit" value="" />
</form>

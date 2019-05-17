<?php
/**
 * Register Blocks
 * @see https://www.billerickson.net/building-gutenberg-block-acf/#register-block
 *
 */
function be_register_blocks() {
	if ( ! function_exists('acf_register_block') )
		return;
	acf_register_block( array(
		'name'			=> 'team-member',
		'title'			=> __( 'Team Member', 'clientname' ),
		'render_template'	=> 'blocks/block-team-member.php',
		'category'		=> 'formatting',
		'icon'			=> 'admin-users',
		'mode'			=> 'preview',
		'keywords'		=> array( 'profile', 'user', 'author' )
	));
}
add_action('acf/init', 'be_register_blocks' );
?>
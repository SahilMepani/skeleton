<?php

// Removes from admin menu
add_action( 'admin_menu', 'skel_my_remove_admin_menus' );
function skel_my_remove_admin_menus() {
	remove_menu_page( 'edit-comments.php' );
}

// Removes from post and pages
add_action( 'init', 'skel_remove_comment_support', 100 );
function skel_remove_comment_support() {
	remove_post_type_support( 'post', 'comments' );
	remove_post_type_support( 'page', 'comments' );
}

// Removes from admin bar
function skel_admin_bar_render() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu( 'comments' );
}
add_action( 'wp_before_admin_bar_render', 'skel_admin_bar_render' );

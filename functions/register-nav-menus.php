<?php
/**
 * Description: Registers navigation menus for the theme.
 *
 * @package WordPress
 * @subpackage Skeleton
 * @since 1.0.0
 */

/**
 * Register navigation menus.
 *
 * This function registers navigation menus for the theme.
 *
 * @return void
 */
register_nav_menus(
	array(
		'header-menu' => esc_html__( 'Header Menu', 'skel' ),
		'footer-menu' => esc_html__( 'Footer Menu', 'skel' ),
	)
);

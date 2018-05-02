<?php

/*==================================================
=            ACF - Custom options pages            =
==================================================*/
// if (function_exists('acf_add_options_page')) {
	// acf_add_options_page(array(
	//     'page_title' => 'Theme Options',
	//     'menu_title' => 'Theme Options',
	//     'menu_slug'  => 'theme-options',
	//     'capability' => 'edit_posts',
	//     'redirect'   => false //use theme options as a page itself
	// ));

	// acf_add_options_sub_page(array(
	//     'page_title'  => 'Theme Header',
	//     'menu_title'  => 'Header',
	//     'parent_slug' => 'theme-options',
	// ));

	// acf_add_options_sub_page(array(
	//     'page_title'  => 'Theme Footer',
	//     'menu_title'  => 'Footer',
	//     'parent_slug' => 'theme-options',
	// ));
// }


/*===================================================
=            ACF - Custom options CSS            =
===================================================*/
function my_acf_admin_head() {
	?>
	<style type="text/css">
		.acf-flexible-content .layout .acf-fc-layout-handle {
			background-color: #00a0d2 ;
			color: #fff;
		}
		.acf-button-group {
			flex-wrap: wrap;
		}
	</style>
	<?php
}
add_action('acf/input/admin_head', 'my_acf_admin_head');
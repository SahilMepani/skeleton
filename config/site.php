<?php
/**
 * Site-specific configuration for the Skeleton theme.
 *
 * One file. Edit per fork — every value here is expected to vary per site.
 * Consumed by:
 *   - functions/register-acf-blocks.php  (block locations)
 *   - functions/admin-ajax.php           (CPT filter endpoint)
 *   - functions/protected-pages.php      (via PAGE_*_ID constants from define-constants.php)
 *
 * Theme prefix is `skel_` and textdomain is `'skel'`. Both are intentionally
 * fixed and should not be changed per fork — see .cursor/AGENTS.md.
 *
 * Page-ID constants (PAGE_404_ID, PAGE_SEARCH_ID, PAGE_KB_ID, DEFAULT_THUMBNAIL_ID)
 * are defined dynamically from ACF Options at acf/init — see
 * functions/define-constants.php. They are not duplicated here.
 *
 * @package Skeleton
 */

/**
 * Custom post types this site has registered.
 *
 * Used by ACF block `post_types` registration so blocks are insertable on
 * each CPT's editor screen. To remove a CPT from the site, drop it here
 * and (if listed) from skel_ajax_cpts().
 *
 * @return string[]
 */
function skel_site_cpts() {
	return array( 'page', 'service', 'project', 'insights', 'knowledge-base' );
}

/**
 * CPTs exposed to the wp_ajax_update_post_ajax filter endpoint.
 *
 * Typically a subset of skel_site_cpts() — only CPTs that have a
 * filterable archive/listing UI on the front end.
 *
 * @return string[]
 */
function skel_ajax_cpts() {
	return array( 'post', 'project', 'insights', 'knowledge-base' );
}

/**
 * Brand asset paths (theme-relative).
 *
 * Used wherever a logo/favicon path is needed in PHP. The header
 * currently pulls its logo from an ACF Options field; this array
 * is here for fallbacks and forks that prefer a static-file approach.
 *
 * @return array<string,string>
 */
function skel_brand_assets() {
	return array(
		'logo'    => 'assets/images/logo.svg',
		'favicon' => 'assets/images/favicon.svg',
	);
}

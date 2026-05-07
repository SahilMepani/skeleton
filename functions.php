<?php
/**
 * Theme bootstrap.
 *
 * Loads site config, then auto-includes every PHP file under each functions/
 * subfolder. Add a new feature by dropping a file into the right subfolder —
 * no edits here required. Remove a feature by deleting its folder or file.
 *
 * Folder map:
 *   functions/core/           — always-needed scaffolding (helpers, hooks, image sizes, nav)
 *   functions/cleanup/        — WP defaults trimming (delete folder = restore stock WP)
 *   functions/admin/          — admin UI behaviour (skip-dashboard, notices, claude-preview)
 *   functions/admin/_disabled/— commented-out / opt-in admin code; NOT auto-loaded
 *   functions/acf/            — ACF options pages and post-field group registration
 *   functions/assets/         — enqueue / dequeue style and script handling
 *   functions/blocks-system/  — ACF block registration plumbing + generator (under /generator)
 *   functions/integrations/   — anything talking to a CPT or external system (AJAX, etc.)
 *   functions/cpt/            — per-site CPT glue (protected pages, etc.)
 *   functions/env/            — environment-gated (debugging on local, security on prod)
 *
 * @package Skeleton
 * @since 1.0.0
 */

require get_template_directory() . '/config/site.php';

// Auto-load every PHP file in the listed subfolders. _disabled/ is excluded by omission.
$skel_includes = glob(
	get_template_directory() . '/functions/{core,cleanup,admin,acf,assets,blocks-system,integrations,cpt}/*.php',
	GLOB_BRACE
);
foreach ( (array) $skel_includes as $skel_include ) {
	require_once $skel_include;
}

// Block generator helpers live one level deeper.
foreach ( (array) glob( get_template_directory() . '/functions/blocks-system/generator/*.php' ) as $skel_include ) {
	require_once $skel_include;
}

// Environment-gated bootstraps.
if ( 'local' === wp_get_environment_type() ) {
	require get_template_directory() . '/functions/env/debugging.php';
}

if ( 'production' === wp_get_environment_type() ) {
	require get_template_directory() . '/functions/env/security.php';
}

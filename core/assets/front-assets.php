<?php

// Bail early if the asset type is not specified.
if ( ! array_key_exists( 'type', $_GET ) ) die();

/**
 * The asset type. Can be 'scripts' or 'styles'.
 *
 * @var string
 */
$asset_type = $_GET['type'];

// Bail early if the asset type is neither 'scripts' nor 'styles'.
if ( $asset_type !== 'scripts' && $asset_type !== 'styles' ) die();

// Load WordPress core.
$baseDir = explode( '/wp-content', __DIR__ )[0];
require_once "{$baseDir}/wp-load.php";

// Disable PHP warnings.
ini_set( 'error_reporting', E_ERROR );

/**
 * The reference value. Should be a page ID.
 *
 * @var int
 */
$ref = array_key_exists( 'ref', $_GET ) ? $_GET['ref'] : null;

// Set content type.
$content_type = $asset_type === 'scripts' ? 'text/javascript' : 'text/css';
header( "Content-Type: {$content_type}" );

// Load assets.
core_concat_prod_front_assets( $asset_type, $ref );

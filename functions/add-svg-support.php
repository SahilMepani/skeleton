<?php
/**
 * Description: Allows SVG uploads in WordPress while ensuring security through sanitization.
 *
 * @package Skeleton
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Allow SVG file uploads in WordPress media library.
 *
 * @param array $mimes List of allowed mime types.
 * @return array Modified list of allowed mime types including SVG.
 */
function allow_svg_uploads( $mimes ) {
	$mimes['svg'] = 'image/svg+xml'; // Allow SVG uploads.
	return $mimes;
}
add_filter( 'upload_mimes', 'allow_svg_uploads' );

/**
 * Sanitize SVG files before they are uploaded to WordPress.
 * This function removes potentially dangerous elements like <script> tags,
 * XML declarations, DOCTYPE definitions, and inline JavaScript event handlers.
 *
 * @param array $file Uploaded file data.
 * @return array Modified file data with sanitized SVG content.
 */
function sanitize_svg_file( $file ) {
	// Check if the uploaded file is an SVG.
	if ( 'image/svg+xml' === $file['type'] ) {
		global $wp_filesystem;

		// Initialize the WordPress filesystem API.
		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
			WP_Filesystem();
		}

		// Read the SVG file contents securely.
		$svg_contents = $wp_filesystem->get_contents( $file['tmp_name'] );

		// Perform sanitization by removing unwanted elements.
		$clean_svg = preg_replace(
			array(
				'/<script\b[^>]*>(.*?)<\/script>/is', // Remove script tags.
				'/<\?xml\b[^>]*\?>/is', // Remove XML declaration.
				'/<!DOCTYPE\b[^>]*>/is', // Remove DOCTYPE declaration.
				'/on\w+="[^"]*"/is', // Remove inline JavaScript event handlers (e.g., onclick, onload).
				'/javascript:/is', // Remove JavaScript URIs in attributes.
			),
			'',
			$svg_contents
		);

		// If sanitization was successful, overwrite the original file.
		if ( ! empty( $clean_svg ) ) {
			$wp_filesystem->put_contents( $file['tmp_name'], $clean_svg );
		} else {
			$file['error'] = 'SVG file could not be sanitized.'; // Error message.
		}
	}

	return $file;
}
add_filter( 'wp_handle_upload_prefilter', 'sanitize_svg_file' );



/**
 * Adds a custom media filter for SVG files in the WordPress Media Library.
 *
 * This function adds an entry to the MIME type filters dropdown
 * in the Media Library, allowing users to filter by SVG files.
 *
 * @param array $post_mime_types Existing MIME type filters in the Media Library.
 * @return array Modified MIME type filters including SVG.
 */
function add_svg_media_filter( $post_mime_types ) {
	$post_mime_types['image/svg+xml'] = array(
		__( 'SVGs' ),
		__( 'SVGs' ),

		// translators: %s: Number of SVG files.
		_n_noop( 'SVG <span class="count">(%s)</span>', 'SVGs <span class="count">(%s)</span>' ),
	);
	return $post_mime_types;
}
add_filter( 'post_mime_types', 'add_svg_media_filter' );

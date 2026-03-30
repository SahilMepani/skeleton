<?php
/**
 * Auto-updates the 'claude' preview page when a trigger file is present.
 * Runs on init (before main query) so the updated content renders in the same request.
 *
 * @package Skeleton
 * @subpackage Functions
 */
add_action( 'init', 'skel_apply_pending_claude_preview' );

function skel_apply_pending_claude_preview() {
	$trigger_file = get_template_directory() . '/blocks/.claude-preview-pending';

	if ( ! file_exists( $trigger_file ) ) {
		return;
	}

	$slug = trim( file_get_contents( $trigger_file ) );

	if ( empty( $slug ) ) {
		unlink( $trigger_file );
		return;
	}

	$page = get_page_by_path( 'claude' );

	if ( $page ) {
		$slug_snake    = str_replace( '-', '_', $slug );
		$display_key   = 'field_' . $slug_snake . '_display';
		$block_data    = wp_json_encode( array( $display_key => 'on' ) );
		wp_update_post( array(
			'ID'           => $page->ID,
			'post_content' => '<!-- wp:acf/' . $slug . ' {"id":"block_1","name":"acf/' . $slug . '","data":' . $block_data . ',"mode":"preview"} /-->',
		) );
	}

	unlink( $trigger_file );
}

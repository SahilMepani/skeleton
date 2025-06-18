<?php
// Retrieve front page data once.
$frontpage_id    = get_option( 'page_on_front' );
$frontpage_title = get_the_title( $frontpage_id );

// Get the current post type.
$item_post_type = get_post_type( get_the_ID() );

// Initialize CPT data as null (or an empty array for a safer default).
// Using null ensures we explicitly know if it's set later.
$cpt_data = null;

// You could use a mapping array if you have many more CPTs.
$cpt_mapping = array(
	'team' => defined( 'PAGE_TEAMS_ID' ) ? PAGE_TEAMS_ID : 0,
	// Add other CPTs here: 'custom_post_type' => defined('PAGE_CPT_ID') ? PAGE_CPT_ID : 0,.
);

// Check if the current post type has a corresponding ID defined and is valid.
$associated_page_id = $cpt_mapping[ $item_post_type ] ?? 0;

if ( $associated_page_id && get_post_status( $associated_page_id ) ) { // Check if ID is not 0 and post exists.
	$cpt_data = array(
		'title' => get_the_title( $associated_page_id ),
		'link'  => get_permalink( $associated_page_id ),
	);
}
?>
<div class="breadcrumbs-section">
	<div class="container">
		<div class="inner-container">
			<nav aria-label="breadcrumbs" class="breadcrumb">
				<p>
					<a href="<?php echo esc_url( site_url() ); ?>"><?php echo esc_html( $frontpage_title ); ?></a>
					<span class="separator"></span>
					<?php if ( $cpt_data ) { ?>
						<a href="<?php echo esc_url( $cpt_data['link'] ); ?>"><?php echo esc_html( $cpt_data['title'] ); ?></a>
						<span class="separator"></span>
					<?php } ?>
					<span class="last"><?php echo get_the_title(); //phpcs:ignore ?></span>
				</p>
			</nav>
		</div>
	</div>
</div>

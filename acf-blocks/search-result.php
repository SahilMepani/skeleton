<?php
/**
 * Search result block
 *
 * @package WordPress
 * @subpackage Skeleton
 * @since 1.0.0
 */

// Verify nonce.
if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'search_nonce' ) ) {
	// Nonce verification failed, handle the error or exit gracefully.
	// Redirect the user to a safe page.
	wp_safe_redirect( home_url() );
	exit;
}

// Set thumbnail preview in backend.
if ( isset( $block['data']['preview_image'] ) ) {
	echo '<img src="' . esc_url( $block['data']['preview_image'] ) . '" style="width:100%; height:auto;">';

	return; // required.
}

// Developer options.
$spacing        = get_field( 'spacing' );
$spacing_top    = $spacing['top']['spacing_top'];
$spacing_bottom = $spacing['bottom']['spacing_bottom'];
$custom_classes = get_field( 'custom_classes' );
$custom_css     = get_field( 'custom_css' );
$unique_id      = get_field( 'unique_id' );
// Custom Spacing.
if ( 'custom' === $spacing_top ) {
	$spacing_top        = 'spacing-top-custom';
	$spacing_top_custom = "--spacing-top-custom:' {$spacing['top']['custom_value']};";
} else {
	$spacing_top_custom = '';
}
if ( 'custom' === $spacing_bottom ) {
	$spacing_bottom        = 'spacing-bottom-custom';
	$spacing_bottom_custom = "--spacing-bottom-custom:' {$spacing['bottom']['custom_value']};";
} else {
	$spacing_bottom_custom = '';
}
?>

<section
	class="search-results-section section <?php echo esc_attr( "{$spacing_top} {$spacing_bottom} {$custom_classes}" ); ?>"
	style="<?php echo esc_attr( "{$spacing_top_custom} {$spacing_bottom_custom} {$custom_css}" ); ?>"
	id="<?php echo esc_attr( $unique_id ); ?>">

	<div class="container">

		<?php
		$search_term = isset( $_GET['s'] ) ? sanitize_text_field( wp_unslash( $_GET['s'] ) ) : '';
		$cpt         = isset( $_GET['post_type'] ) ? sanitize_text_field( wp_unslash( $_GET['post_type'] ) ) : 'page';
		?>

		<h5><?php esc_html_e( 'Showing Results for', 'skel' ); ?> "<span><?php esc_html( $s ); ?></span>"</h5>

		<?php
		// Pages.
		$custom_query = new WP_Query(
			array(
				's'              => $search_term, /* search query */
				'post_type'      => $cpt,
				'posts_per_page' => -1,
				'field'          => 'ID',
			)
		);
		$post_count   = $custom_query->post_count;
		?>


		<?php if ( ! empty( $custom_query->posts ) ) { ?>
			<h6 class="cpt-heading"><?php esc_html_e( 'Pages', 'skel' ); ?> (<?php echo esc_html( $post_count ); ?>)</h6>

			<ul class="list-pages list-unstyled">
				<?php
				foreach ( $custom_query->posts as $post_item ) :
					setup_postdata( $post_item );
					?>
					<?php
					$post_title = get_the_title( $post_item );
					$permalink  = get_permalink( $post_item );
					?>
					<li>
						<a href="<?php echo esc_url( $permalink ); ?>" class="h6 title"><?php echo esc_html( $post_title ); ?></a>
					</li>
					<?php
				endforeach;
				wp_reset_postdata();
				?>
			</ul>
		<?php } ?>

		<!-- News -->
		<?php
		$custom_query = new WP_Query(
			array(
				's'              => $s, // search query.
				'post_type'      => 'news',
				'posts_per_page' => -1,
				'field'          => 'ID',
			)
		);
		$post_count   = $custom_query->post_count;
		?>

		<?php if ( ! empty( $custom_query->posts ) ) { ?>
			<h6 class="cpt-heading"><?php esc_html_e( 'News', 'skel' ); ?> (<?php echo esc_html( $post_count ); ?>)</h6>

			<ul class="list-news list-unstyled">
				<?php
				foreach ( $custom_query->posts as $post_item ) :
					setup_postdata( $post_item );
					?>
					<?php
					$excerpt    = get_the_excerpt( $post_item );
					$post_title = get_the_title( $post_item );
					$date       = get_the_date( 'F d Y', $post_item );
					$post_link  = get_permalink( $post_item );
					?>
					<li class="card">
						<div class="img-cover-block">
							<?php
							$image_id   = get_post_thumbnail_id( $post_item );
							$image_data = wp_get_attachment_image_src( $image_id, 'w768' );
							$image_alt  = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
							?>
							<img src="<?php echo esc_url( wp_get_attachment_image_url( $image_id, 'w768' ) ); ?>"
								srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( $image_id ) ); ?>"
								sizes="45rem"
								alt="<?php echo esc_attr( $image_alt ); ?>"
								width="<?php echo esc_attr( $image_data[1] ); ?>"
								height="<?php echo esc_attr( $image_data[2] ); ?>"
								class="img-cover"
								loading="lazy" />
						</div>

						<p class="date"><?php echo esc_html( $date ); ?></p>
						<div class="title-wrapper">
							<a href="<?php echo esc_url( $post_link ); ?>" class="h6 title"><?php echo esc_html( $post_title ); ?></a>
						</div>
						<p class="excerpt"><?php echo esc_html( $excerpt ); ?></p>
					</li>
					<?php
				endforeach;
				wp_reset_postdata();
				?>
			</ul>
		<?php } ?>

		<?php if ( empty( $custom_query->posts ) ) { ?>
			<h5 class="h5"><?php esc_html_e( 'No records matching your search criteria, please check again later!', 'skel' ); ?></h5>
		<?php } ?>

	</div> <!-- .container -->

</section>

<?php
	// Set preview
	if ( isset( $block['data']['preview_image'] ) ) {
		echo '<img src="' . $block['data']['preview_image'] . '" style="width:100%; height:auto;">';

		return; // required
	}
?>

<?php
	// Developer options
	$spacing               = get_field('spacing');
	$spacing_top           = $spacing['top']['spacing_top'];
	$spacing_bottom        = $spacing['bottom']['spacing_bottom'];
	$spacing_top_custom    = '';
	$spacing_bottom_custom = '';
	$custom_classes        = get_field( 'custom_classes' );
	$custom_css            = get_field( 'custom_css' );
	$unique_id             = get_field( 'unique_id' );
	// Custom Spacing
	if ( $spacing_top == 'custom' ) {
		$spacing_top = 'spacing-top-custom';
		$spacing_top_custom = '--spacing-top-custom:' . $spacing['top']['custom_value'] . ';';
	}
	if ( $spacing_bottom == 'custom' ) {
		$spacing_bottom = 'spacing-bottom-custom';
		$spacing_bottom_custom = '--spacing-bottom-custom:' . $spacing['bottom']['custom_value'] . ';';
	}
?>

<section class="search-results-section section <?php echo $spacing_top . ' ' . $spacing_bottom . ' ' . $custom_classes; ?>" style="<?php echo $spacing_top_custom; ?> <?php echo $spacing_bottom_custom; ?> <?php echo $custom_css; ?>" id="<?php echo $unique_id; ?>">

	<div class="container">

		<?php $s = $_GET['s']; ?>

		<h5><?php _e('Showing Results for', 'skel'); ?> "<span><?php echo $s ?></span>"</h5>

		<!-- Pages -->
		<?php
			$swp_query = new SWP_Query(
				[
					's'              => $s, // search query
					'post_type'      => 'page',
					'posts_per_page' => -1,
					'field'          => 'ID'
				]
			);
			$post_count = $swp_query->post_count;
			// print_r($swp_query);
		?>

		<?php if ( !  empty( $swp_query->posts ) ) { ?>
			<h6 class="cpt-heading"><?php _e('Pages', 'skel'); ?> (<?php echo $post_count; ?>)</h6>

			<ul class="list-pages list-unstyled">
				<?php foreach ( $swp_query->posts as $post ): setup_postdata( $post ); ?>
					<?php
						$title       = get_the_title($post);
						$permalink   = get_permalink($post);
					?>
					<li>
						<a href="<?php echo $permalink ?>" class="h6 title"><?php echo $title ?></a>
					</li>
				<?php endforeach; wp_reset_postdata(); ?>
			</ul>
		<?php } ?>

		<!-- News -->
		<?php
			$swp_query = new SWP_Query(
				[
					's'              => $s, // search query
					'post_type'      => 'news',
					'posts_per_page' => -1,
					'field'          => 'ID'
				]
			);
			$post_count = $swp_query->post_count;
			// print_r($swp_query);
		?>

		<?php if ( !  empty( $swp_query->posts ) ) { ?>
			<h6 class="cpt-heading"><?php _e('News', 'skel') ?> (<?php echo $post_count; ?>)</h6>

			<ul class="list-news list-unstyled">
				<?php foreach ( $swp_query->posts as $post ): setup_postdata( $post ); ?>
					<?php
						$excerpt     = get_the_excerpt($post);
						$title       = get_the_title($post);
						$date        = get_the_date('F d Y', $post);
						$post_link   = get_permalink($post);
					?>
					<li class="card">
						<div class="img-cover-block">
							<?php
								$image_ID = get_post_thumbnail_id( $post );
								$image_data = wp_get_attachment_image_src( $image_ID, 'w768' );
								$image_alt = get_post_meta( $image_ID, '_wp_attachment_image_alt', true );
								$image_alt = esc_attr( trim( strip_tags( $image_alt ) ) );
							?>
							<img
								src="<?php echo wp_get_attachment_image_url( $image_ID, 'w768' ) ?>"
								srcset="<?php echo wp_get_attachment_image_srcset( $image_ID ) ?>"
								sizes="45rem"
								alt="<?php echo $image_alt; ?>"
								width="<?php echo $image_data[1]; ?>"
								height="<?php echo $image_data[2]; ?>"
								class="img-cover"
								loading="lazy"
							/>
						</div>

						<p class="date"><?php echo $date ?></p>
						<div class="title-wrapper">
							<a href="<?php echo $post_link ?>" class="h6 title"><?php echo $title ?></a>
						</div>
						<p class="excerpt"><?php echo $excerpt ?></p>
					</li>
				<?php endforeach; wp_reset_postdata(); ?>
			</ul>
		<?php } ?>

		<?php if ( empty($swp_query->posts)){?>
			<h5 class="h5"><?php _e('No records matching your search criteria, please check again later!','skel') ?></h5>
		<?php } ?>

	</div> <!-- .container -->

</section>

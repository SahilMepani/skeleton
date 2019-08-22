<?php if ( get_row_layout() == 'post_cards' ) : ?>

<?php
	/* Section Options */
	$posts = get_sub_field('posts');
	/* Developer Options */
	$section_bg_color       = get_sub_field('section_bg_color');
	$section_css            = get_sub_field('section_css');
	$section_classes        = get_sub_field('section_classes');
	$section_padding_top    = get_sub_field('section_padding_top');
	$section_padding_bottom = get_sub_field('section_padding_bottom');
?>

<section class="post-cards-section position-relative <?php echo $section_padding_top . ' ' . $section_padding_bottom ?> <?php echo $section_classes . ' ' . $section_bg_color; ?>" style="<?php echo $section_css ?>">
	<div class="container">

		<?php if ( $posts ) : ?>

			<div class="list-post-cards post-cards-grid">
				<?php foreach( $posts as $post): ?>
					<?php setup_postdata($post); ?>
					<div class="card">
						<a href="<?php the_permalink(); ?>" class="inner-card">
							<?php
								if ( has_post_thumbnail() ) {
									$image_id        = get_post_thumbnail_id();
									$image_url_array = wp_get_attachment_image_src($image_id, 'medium_crop', true);
									$image_url       = $image_url_array[0];
									$image_css       = 'background-image: url(' . $image_url . ');';
								} else {
									$image_css = 'background-image: url(' . get_template_directory_uri() . '/images/placeholder.png)';
								}
							?>
							<div class="img-block" style="<?php echo $image_css; ?>"></div>
							<div class="content-block">
								<h5 class="heading"><?php the_title(); ?></h5>
								<p><?php echo tse_get_the_excerpt(20); ?></p>
							</div> <!-- .content-block -->
						</a> <!-- .card -->
					</div>
				<?php endforeach; ?>
			</div>
			<?php wp_reset_postdata(); ?>

		<?php endif; ?>

	</div> <!-- .container -->
</section>

<?php endif; ?>
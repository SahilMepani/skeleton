<?php if ( get_row_layout() == 'fullscreen_slider' ) : ?>

<?php
	global $flexi_counter;
	/* Section Options */
	$slides       = get_sub_field('slides');
	$slides_count = count($slides);
	$counter      = 0;
	/* Developer Options */
	$section_css     = get_sub_field('section_css');
	$section_classes = get_sub_field('section_classes');
?>

<section class="fullscreen-slider-section position-relative <?php echo $section_classes; ?>" style="<?php echo $section_css; ?>">

	<?php echo ($slides_count > 1) ? '<div class="fullscreen-slider fullscreen-slider-' . $flexi_counter . '">' : '' ?>

		<?php foreach( $slides as $slide ) : $counter++ ?>

			<?php
				$media_type = $slide['media_type'];
				$image = $slide['image'];
				$heading    = $slide['heading'];
				if ( $media_type == 'video' ) {
					$video_mp4  = $slide['video_mp4'];
					$video_webm = $slide['video_webm'];
				}
			?>

			<div class="slick-slide slick-slide-<?php echo $counter; ?>">

				<style>
					@media only screen and (min-width: 768px) {
						.fullscreen-slider-<?php echo $flexi_counter; ?> .slick-slide-<?php echo $counter; ?> {
						  background-image: url('<?php echo $image['sizes']['w2500']; ?>');
						}
					}
					@media only screen and (max-width: 767px) {
						.fullscreen-slider-<?php echo $flexi_counter; ?> .slick-slide-<?php echo $counter; ?> {
							background-image: url('<?php echo $image['sizes']['w800']; ?>');
						}
					}
				</style>

				<div class="container container--small">
					<h4 class="heading"><?php echo $heading; ?></h4> <!-- .heading -->
				</div> <!-- .container -->

				<?php if ( $media_type == 'video' ) { ?>
					<video class="bg-video bg-video--fullscreen" autoplay loop muted preload>
				    <source src="<?php echo $video_mp4; ?>" type="video/mp4">
				    <source src="<?php echo $video_webm; ?>" type="video/webm">
				    Your browser does not support the video tag.
				  </video>
				<?php } ?>

			</div> <!-- .slide -->

		<?php endforeach; ?>

	</div> <!-- .slider -->

	<div class="slick-slider-dots"></div>

</section>

<?php endif; ?>
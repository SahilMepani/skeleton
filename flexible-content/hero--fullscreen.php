<?php if ( get_row_layout() == 'hero_fullscreen' ) : ?>

<?php
	/* Section Options */
	$hero_background_type = get_sub_field('hero_background_type');
	$hero_image = get_sub_field('hero_image');
	$hero_image = $hero_image['sizes']['w1600h900'];
	$hero_video_mp4 = get_sub_field('hero_video_mp4');
	$hero_video_webm = get_sub_field('hero_video_webm');
	$hero_title = get_sub_field('hero_title');
	/* Developer Options */
	$section_css     = get_sub_field('section_css');
	$section_classes = get_sub_field('section_classes');
?>

<section class="hero--fullscreen-section <?php echo $section_classes; ?>" style="background-image: url(<?php echo $hero_image; ?>); <?php echo $section_css; ?>">

	<div class="container">
		<div class="content-block">
			<h1 class="section-heading"><?php echo $hero_title; ?></h1>
		</div> <!-- .content-block -->
	</div> <!-- .container -->

	<?php if ( $hero_background_type == 'video' ) { ?>
		<video class="bg-video bg-video--fullscreen" poster="<?php echo $hero_image; ?>" autoplay loop muted preload>
	    <source src="<?php echo $hero_video_mp4; ?>" type="video/mp4">
	    <source src="<?php echo $hero_video_webm; ?>" type="video/webm">
	    Your browser does not support the video tag.
	  </video>
	<?php } ?>

</section>

<?php endif; ?>
<?php
	$background_type = get_sub_field('background_type');
	$background_image = '';
	if ( $background_type == 'image' ) {
		$background_image = get_sub_field('background_image');
		$background_image = $background_image['sizes']['w1600h900'];
	}
	if ( $background_type == 'video' ) {
		$video_image = get_sub_field('video_image');
		$video_mp4 = get_sub_field('video_mp4');
		$video_webm = get_sub_field('video_webm');
	}
?>

<section class="hero-fullscreen-section <?php echo $section_padding_top . ' ' . $section_padding_bottom ?> <?php echo $section_classes . ' ' . $section_bg_color; ?>" style="<?php echo $section_css; ?> <?php if ( $background_image != '' ) { ?>background-image: url(<?php echo $background_image; ?>); <?php } ?>">

<?php if ( $background_type == 'video' ) { ?>
	<video class="bg-video bg-video--fullscreen" autoplay loop muted preload>
    <source src="<?php echo $video_mp4; ?>" type="video/mp4">
    <source src="<?php echo $video_webm; ?>" type="video/webm">
    Your browser does not support the video tag.
  </video>
<?php } ?>
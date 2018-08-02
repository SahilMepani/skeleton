<?php if ( get_row_layout() == 'full_width_cta_section' ) : ?>

<?php
	/* Section Options */
	$section_bg_image = '';
	$section_title    = '';
	$section_content  = '';
	$section_button   = '';

	$section_bg_image = get_sub_field('background_image');
	$section_title    = get_sub_field('title');
	$section_content  = get_sub_field('content');
	$section_button   = get_sub_field('button');

  //Developer Options
	$section_padding_top    = '';
	$section_padding_bottom = '';

	$section_padding_top    = get_sub_field('section_padding_top');
	$section_padding_bottom = get_sub_field('section_padding_bottom');

?>

<section id="cta-<?php echo @$flexible_counter; ?>" class="full-width-cta-section bg-cover bg-overlay text-center <?php echo $section_padding_top . ' ' . $section_padding_bottom ?>">
	<div class="container-fluid px-5vw">

		<?php if($section_title): ?>
			<h2 class="m-0 color-white wow fadeInUp"><?php echo @$section_title; ?></h2>
		<?php endif; ?>

		<?php if($section_content): ?>
			<div class="content-block color-white wysiwyg-editor pt-2 wow fadeInUp">
				<?php echo @$section_content; ?>
			</div> <!-- .content-block -->
		<?php endif; ?>

		<?php if(is_array($section_button) && $section_button['title'] && $section_button['url']): ?>
			<div class="button-block pt-2 wow fadeInUp">
				<a href="<?php echo @$section_button['url'] ?>" class="btn btn-primary" title="<?php echo @$section_button['title']; ?>" <?php echo ($section_button['target'] == '_blank')?'target="_blank"':''; ?>><?php echo @$section_button['title']; ?></a>
			</div> <!-- .button-block -->
		<?php endif; ?>

	</div> <!-- .container-fluid -->
</section> <!-- .full-width-cta-section -->

<style>
 @media only screen and (min-width: 768px) {
	#cta-<?php echo @$flexible_counter; ?> {
	  background-image: url('<?php echo @$section_bg_image['sizes']['large']; ?>');
	 }
}
 @media only screen and (max-width: 767px) {
	 #cta-<?php echo @$flexible_counter; ?> {
	  	background-image: url('<?php echo @$section_bg_image['sizes']['medium']; ?>');
	 }
 }
</style>

<?php endif; ?>
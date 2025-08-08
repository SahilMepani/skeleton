<?php

get_header();
the_content();
?>

<div class="swiper hero-slider">
	<!-- Additional required wrapper -->
	<div class="swiper-wrapper">
		<!-- Slides -->
		<div class="swiper-slide slide">
			<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/placeholder/1.jpg" alt="">
		</div> <!-- .swiper-slide -->
		<div class="swiper-slide slide">
			<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/placeholder/2.jpg" alt="">
		</div> <!-- .swiper-slide -->
		<div class="swiper-slide slide">
			<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/placeholder/3.jpg" alt="">
		</div> <!-- .swiper-slide -->
		<div class="swiper-slide slide">
			<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/placeholder/4.jpg" alt="">
		</div> <!-- .swiper-slide -->
	</div> <!-- .swiper-wrapper -->
	<!-- If we need pagination -->
	<div class="swiper-pagination"></div>
	<!-- If we need navigation buttons -->
	<div class="swiper-navigation">
		<div class="swiper-button-prev">
			<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
				<path fill="#000" d="m10.308 17.308.707-.72L6.927 12.5H19v-1H6.927l4.088-4.088-.707-.72L5 12l5.308 5.308Z" />
			</svg>
		</div>
		<div class="swiper-button-next">
			<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
				<path fill="#000" d="m13.692 17.308-.707-.72 4.088-4.088H5v-1h12.073l-4.088-4.088.707-.72L19 12l-5.308 5.308Z" />
			</svg>
		</div>
	</div>
	<!-- If we need scrollbar -->
	<div class="swiper-scrollbar"></div>
</div> <!-- .swiper -->


<?php
get_footer();

(() => {
	$('.logo-slider').each(function (i, el) {
		let swiperClass = 'logo-slider-' + i;
		$(this).addClass(swiperClass);

		new Swiper('.' + swiperClass, {
			speed: 3000,
			loop: true,
			autoplay: {
				delay: 0
			},
			slidesPerView: 'auto',
			spaceBetween: 40,
			centerInsufficientSlides: true,
			allowTouchMove: false,
			disableOnInteraction: false,
			watchOverflow: true,
			freeMode: {
				enabled: true
			},
			breakpoints: {
				992: {
					spaceBetween: 80
				}
			}
		});
	});
})();

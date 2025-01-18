(() => {
	$('.hero-slider').each(function (i, el) {
		let swiperClass = 'hero-slider-' + i;
		$(this).addClass(swiperClass);

		if ($(this).find('.swiper-slide').length > 1) {
			// navigation
			let prevClass = 'hero-button-prev-' + i;
			let nextClass = 'hero-button-next-' + i;
			$(this).parent().find('.swiper-button-prev').addClass(prevClass);
			$(this).parent().find('.swiper-button-next').addClass(nextClass);

			// pagination
			let pagination = 'hero-pagination-' + i;
			$(this).parent().find('.swiper-pagination').addClass(pagination);

			new Swiper('.' + swiperClass, {
				slidesPerView: 1,
				loop: true,
				speed: 300,
				watchOverflow: true,
				// effect: 'fade',
				navigation: {
					prevEl: '.' + prevClass,
					nextEl: '.' + nextClass
				},
				pagination: {
					el: '.' + pagination,
					clickable: true
				},
				autoplay: {
					delay: 5000,
					disableOnInteraction: false
				}
			});
		} else {
			// when there is only one slide
			$('.' + swiperClass)
				.find('.swiper-slide')
				.addClass('swiper-slide-active');
		}
	});
})();

(() => {
	const sliders = document.querySelectorAll('.logo-slider');

	sliders.forEach((el, i) => {
		const swiperClass = `logo-slider-${i}`;
		el.classList.add(swiperClass);

		new Swiper(`.${swiperClass}`, {
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

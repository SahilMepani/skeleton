(() => {
	const sliders = document.querySelectorAll('.hero-slider');

	sliders.forEach((el, i) => {
		const swiperClass = `hero-slider-${i}`;
		el.classList.add(swiperClass);

		const slides = el.querySelectorAll('.swiper-slide');

		if (slides.length <= 0) return;

		if (slides.length === 1) {
			slides.forEach(slide => slide.classList.add('swiper-slide-active'));
			return;
		}

		if (slides.length > 1) {
			const parent = el.parentElement;
			const prevClass = `hero-button-prev-${i}`;
			const nextClass = `hero-button-next-${i}`;

			const prevBtn = parent.querySelector('.swiper-button-prev');
			const nextBtn = parent.querySelector('.swiper-button-next');

			if (prevBtn) prevBtn.classList.add(prevClass);
			if (nextBtn) nextBtn.classList.add(nextClass);

			const paginationClass = `hero-pagination-${i}`;
			const paginationEl = parent.querySelector('.swiper-pagination');
			if (paginationEl) paginationEl.classList.add(paginationClass);

			new Swiper(`.${swiperClass}`, {
				slidesPerView: 1,
				loop: true,
				speed: 300,
				// effect: 'fade',
				// fadeEffect: {
				//   crossFade: true
				// },
				navigation: {
					prevEl: `.${prevClass}`,
					nextEl: `.${nextClass}`
				},
				pagination: {
					el: `.${paginationClass}`,
					clickable: true
				},
				autoplay: {
					delay: 5000,
					disableOnInteraction: false
				}
			});
		}
	});
})();

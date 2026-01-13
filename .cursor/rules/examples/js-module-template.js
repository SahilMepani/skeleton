/**
 * [Block Name] JavaScript Module
 *
 * Template for creating new ACF block JS files.
 * Copy this file to src/js/custom/acf-blocks/{slug}.js
 *
 * Remember to add block name to $blocks_with_js array in
 * functions/register-acf-blocks.php
 *
 * @package Skeleton
 */

(() => {
	// ============================================
	// ELEMENT SELECTION
	// ============================================
	const sections = document.querySelectorAll('.block-name-section');

	// Early return if no elements
	if (!sections.length) return;

	// ============================================
	// MAIN LOGIC
	// ============================================
	sections.forEach((section, index) => {
		// Add unique identifier for multiple instances
		const uniqueClass = `block-name-${index}`;
		section.classList.add(uniqueClass);

		// Get child elements
		const items = section.querySelectorAll('.item');
		const buttons = section.querySelectorAll('.js-action-btn');

		// Early return if required elements missing
		if (!items.length) return;

		// ============================================
		// EVENT HANDLERS
		// ============================================
		const handleClick = (event) => {
			event.preventDefault();
			const target = event.currentTarget;
			target.classList.toggle('js-active');
		};

		const handleKeydown = (event) => {
			if (event.key === 'Enter' || event.key === ' ') {
				event.preventDefault();
				handleClick(event);
			}
		};

		// ============================================
		// BIND EVENTS
		// ============================================
		buttons.forEach((button) => {
			button.addEventListener('click', handleClick);
			button.addEventListener('keydown', handleKeydown);
		});

		// ============================================
		// OPTIONAL: Intersection Observer
		// ============================================
		// const observer = new IntersectionObserver(
		// 	(entries) => {
		// 		entries.forEach((entry) => {
		// 			if (entry.isIntersecting) {
		// 				entry.target.classList.add('js-visible');
		// 				observer.unobserve(entry.target);
		// 			}
		// 		});
		// 	},
		// 	{ threshold: 0.1 }
		// );
		//
		// items.forEach((item) => observer.observe(item));
	});
})();

// ============================================
// SWIPER VARIANT (for slider blocks)
// ============================================
/*
(() => {
	const sliders = document.querySelectorAll('.block-slider');

	sliders.forEach((el, i) => {
		const swiperClass = `block-slider-${i}`;
		el.classList.add(swiperClass);

		const slides = el.querySelectorAll('.swiper-slide');

		// Handle single slide
		if (slides.length <= 1) {
			slides.forEach((slide) => slide.classList.add('swiper-slide-active'));
			return;
		}

		// Setup navigation classes
		const parent = el.closest('.block-section');
		const prevClass = `block-prev-${i}`;
		const nextClass = `block-next-${i}`;
		const paginationClass = `block-pagination-${i}`;

		const prevBtn = parent?.querySelector('.swiper-button-prev');
		const nextBtn = parent?.querySelector('.swiper-button-next');
		const pagination = parent?.querySelector('.swiper-pagination');

		if (prevBtn) prevBtn.classList.add(prevClass);
		if (nextBtn) nextBtn.classList.add(nextClass);
		if (pagination) pagination.classList.add(paginationClass);

		// Initialize Swiper
		new Swiper(`.${swiperClass}`, {
			slidesPerView: 1,
			spaceBetween: 16,
			loop: true,
			speed: 300,
			navigation: {
				prevEl: `.${prevClass}`,
				nextEl: `.${nextClass}`
			},
			pagination: {
				el: `.${paginationClass}`,
				clickable: true
			},
			breakpoints: {
				768: {
					slidesPerView: 2,
					spaceBetween: 24
				},
				992: {
					slidesPerView: 3,
					spaceBetween: 32
				}
			},
			autoplay: {
				delay: 5000,
				disableOnInteraction: false
			}
		});
	});
})();
*/

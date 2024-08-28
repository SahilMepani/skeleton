(() => {
	const verticalAccordion = function verticalAccordion(section) {
		const accordions = section.querySelectorAll('.accordion');
		const accHeadings = section.querySelectorAll('.accordion-heading');
		const accContents = section.querySelectorAll('.accordion-content');

		// Adjust the height of the active accordion content after resize
		const activeAccordions = section.querySelectorAll(
			'.accordion.js-active'
		);
		activeAccordions.forEach(el => {
			const accContent = el.querySelector('.accordion-content');
			accContent.style.maxHeight = accContent.scrollHeight + 'px';
		});

		const activateAccordion = index => {
			accordions.forEach((accordion, i) => {
				const accContent =
					accordion.querySelector('.accordion-content');
				if (i === index) {
					if (accordion.classList.contains('js-active')) {
						accordion.classList.remove('js-active');
						accContent.style.maxHeight = null;
					} else {
						accordion.classList.add('js-active');
						accContent.style.maxHeight =
							accContent.scrollHeight + 'px';
					}
				} else {
					accordion.classList.remove('js-active');
					accContent.style.maxHeight = null;
				}
			});
		};

		// Loop over headings and add a click event listener
		accHeadings.forEach((accHeading, index) => {
			accHeading.addEventListener('click', () => {
				activateAccordion(index);
			});
		});

		// Set the first accordion and image to active by default
		if (accordions.length > 0) {
			activateAccordion(0);
		}
	};

	const initVerticalAccordions = () => {
		const sections = document.querySelectorAll('.faqs-section');
		sections.forEach(section => verticalAccordion(section));
	};

	initVerticalAccordions();
	window.addEventListener('resize', debounce(initVerticalAccordions, 200));
	window.addEventListener(
		'orientationchange',
		debounce(initVerticalAccordions, 200)
	);
})();

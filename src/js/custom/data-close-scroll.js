(() => {
	// Add scroll event listener to the window
	window.addEventListener('scroll', function () {
		// Check if the user has scrolled more than 10px
		if (window.scrollY > 10) {
			// Select all elements with the 'data-close-scroll' attribute
			const elements = document.querySelectorAll('[data-close-scroll]');

			// Loop through each element and remove the 'js-active' class
			elements.forEach(function (element) {
				element.classList.remove('js-active');
			});
		}
	});
})();

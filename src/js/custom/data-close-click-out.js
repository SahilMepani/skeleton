function clickOutsideHandler() {
	const elements = document.querySelectorAll('[data-close-click-out]');

	// Add event listener to the document for detecting clicks out
	document.addEventListener('click', function (event) {
		// Log the clicked element to the console
		// console.log('Clicked element:', event.target);

		// Check if the clicked element itself or its immediate parent has the 'data-toggle-click' attribute
		if (
			event.target.hasAttribute('data-toggle-click') ||
			event.target.closest('[data-toggle-click]')
		) {
			return;
		}

		elements.forEach(function (element) {
			// Check if the clicked element is outside the target element
			if (!element.contains(event.target)) {
				element.classList.remove('js-active');
			}
		});
	});
}

// Call the function to initiate the listener
clickOutsideHandler();

(() => {
	const elements = document.querySelectorAll(
		'[data-inview], [data-inview-repeat]'
	);

	// Function to convert the offset to pixels if it's a percentage
	function convertOffsetToPixels(offset) {
		if (typeof offset === 'string' && offset.endsWith('%')) {
			const percentage = parseFloat(offset) / 100;
			return window.innerHeight * percentage;
		}
		return parseFloat(offset); // If it's already in pixels, just parse it as a float
	}

	// IntersectionObserver callback
	function handleIntersect(entries, observer) {
		entries.forEach(entry => {
			const inviewRepeat =
				entry.target.hasAttribute('data-inview-repeat');
			if (entry.isIntersecting) {
				entry.target.dataset.inview = 'true';
			} else if (inviewRepeat) {
				entry.target.removeAttribute('data-inview');
			}
		});
	}

	elements.forEach(element => {
		const offset = element.getAttribute('data-inview-offset') || '0px';
		const offsetPixels = convertOffsetToPixels(offset);

		// Get the threshold from the element's data attribute, default to 0
		const thresholdAttr = element.getAttribute('data-inview-threshold');
		const threshold =
			thresholdAttr !== null ? parseFloat(thresholdAttr) : 0.05;

		// IntersectionObserver options
		const options = {
			root: null, // Use the viewport as the root
			rootMargin: `${offsetPixels}px 0px ${-offsetPixels}px 0px`, // Adjust when element is considered in view
			threshold: threshold // Use the custom threshold value
		};

		const observer = new IntersectionObserver(handleIntersect, options);
		observer.observe(element);
	});
})();

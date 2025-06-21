function observeInviewElements(context = document) {
	const elements = context.querySelectorAll(
		'[data-inview]:not([data-inview-initialized]), [data-inview-repeat]:not([data-inview-initialized])'
	);

	elements.forEach(element => {
		const offset = element.getAttribute('data-inview-offset') || '12svh';
		const thresholdAttr = element.getAttribute('data-inview-threshold');
		const threshold = thresholdAttr ? parseFloat(thresholdAttr) : 0.05;

		const offsetPixels = convertOffsetToPixels(offset);

		const observer = new IntersectionObserver(
			(entries, observer) => {
				entries.forEach(entry => {
					const repeat =
						entry.target.hasAttribute('data-inview-repeat');
					if (entry.isIntersecting) {
						entry.target.dataset.inview = 'true';
					} else if (repeat) {
						entry.target.removeAttribute('data-inview');
					}
				});
			},
			{
				root: null,
				rootMargin: `${offsetPixels}px 0px ${-offsetPixels}px 0px`,
				threshold: threshold
			}
		);

		observer.observe(element);
		element.setAttribute('data-inview-initialized', 'true');
	});
}

function convertOffsetToPixels(offset) {
	if (typeof offset === 'string') {
		if (offset.endsWith('%')) {
			return (window.innerHeight * parseFloat(offset)) / 100;
		}
		if (offset.endsWith('svh')) {
			return (
				(((window.visualViewport && window.visualViewport.height) ||
					window.innerHeight) *
					parseFloat(offset)) /
				100
			);
		}
	}
	return parseFloat(offset);
}

// Initial run
observeInviewElements();

// Expose it globally so you can call it after AJAX
window.observeInviewElements = observeInviewElements;

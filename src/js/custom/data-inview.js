(function () {
	// Shared map of observers keyed by unique options (margin + threshold)
	const observers = new Map();

	function observeInviewElements(context = document) {
		// Skip if reduced motion is enabled
		if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
			console.info(
				'[InView] Reduced motion preference detected, skipping observers.'
			);
			return;
		}

		const elements = context.querySelectorAll(
			'[data-inview]:not([data-inview-initialized]), [data-inview-repeat]:not([data-inview-initialized])'
		);

		elements.forEach(el => {
			const offset = el.getAttribute('data-inview-offset') || '15svh';
			const thresholdAttr = el.getAttribute('data-inview-threshold');
			const threshold = thresholdAttr ? parseFloat(thresholdAttr) : 0.05;
			const offsetPixels = convertOffsetToPixels(offset);

			const key = `${offsetPixels}-${threshold}`;
			let observer = observers.get(key);

			// Create observer only once per unique config
			if (!observer) {
				observer = new IntersectionObserver(handleIntersect, {
					root: null,
					rootMargin: `${offsetPixels}px 0px ${-offsetPixels}px 0px`,
					threshold: threshold
				});
				observers.set(key, observer);
			}

			el.setAttribute('data-inview-initialized', 'true');
			observer.observe(el);
		});
	}

	function handleIntersect(entries, observer) {
		for (const entry of entries) {
			const target = entry.target;
			const repeat = target.hasAttribute('data-inview-repeat');

			if (entry.isIntersecting) {
				target.dataset.inview = 'true';
			} else if (repeat) {
				target.removeAttribute('data-inview');
			}
		}
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

	// Initialize immediately
	if ('IntersectionObserver' in window) {
		observeInviewElements();
		window.observeInviewElements = observeInviewElements;
	} else {
		console.warn(
			'[InView] IntersectionObserver not supported by this browser.'
		);
	}
})();

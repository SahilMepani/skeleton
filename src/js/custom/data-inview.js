(function () {
	if (!('IntersectionObserver' in window)) {
		console.warn(
			'[InView] IntersectionObserver not supported by this browser.'
		);
		return;
	}

	const prefersReducedMotion = window.matchMedia(
		'(prefers-reduced-motion: reduce)'
	);
	// One observer per unique (root + margin + thresholds) key.
	const observers = new Map();
	const initialized = new WeakSet();

	function observeInviewElements(context = document) {
		if (prefersReducedMotion.matches) return;

		const elements = context.querySelectorAll(
			'[data-inview], [data-inview-repeat]'
		);

		elements.forEach(el => {
			if (initialized.has(el)) return;
			initialized.add(el);

			const offsetRaw = el.getAttribute('data-inview-offset') || '7%';
			const thresholdAttr = el.getAttribute('data-inview-threshold');

			// Safari sometimes misses bare 0; give it a tiny ladder of thresholds.
			const thresholds = thresholdAttr
				? thresholdAttr.split(',').map(v => parseFloat(v.trim()))
				: [0, 0.001, 0.01];

			const rootSel = el.getAttribute('data-inview-root');
			const rootEl = rootSel ? document.querySelector(rootSel) : null;

			const margin = normalizeRootMargin(offsetRaw);

			const key = `${rootSel || 'viewport'}|${margin}|${thresholds.join('/')}`;
			let observer = observers.get(key);

			if (!observer) {
				observer = new IntersectionObserver(handleIntersect, {
					root: rootEl || null,
					rootMargin: margin,
					threshold: thresholds
				});
				observers.set(key, observer);
			}

			observer.observe(el);
		});
	}

	function handleIntersect(entries, observer) {
		for (const entry of entries) {
			const target = entry.target;
			const repeat = target.hasAttribute('data-inview-repeat');

			if (entry.isIntersecting) {
				target.dataset.inview = 'true';
				// Fire-once: stop tracking after first hit unless the element opts into repeat.
				if (!repeat) observer.unobserve(target);
			} else if (repeat) {
				target.removeAttribute('data-inview');
			}
		}
	}

	// Accepts "7%", "7vh"/"7svh", "56", or "56px". 'vh'/'svh' are treated as percent of root height.
	function normalizeRootMargin(offset) {
		const s = String(offset);
		const n = parseFloat(s.replace(/[^\d.\-]/g, '')) || 0;
		const unit = s.endsWith('vh') || s.endsWith('%') ? '%' : 'px';
		return `${n}${unit} 0px -${n}${unit} 0px`;
	}

	observeInviewElements();
	window.observeInviewElements = observeInviewElements;
})();

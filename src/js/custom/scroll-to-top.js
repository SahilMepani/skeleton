(() => {
	const button = document.querySelector('.scroll-to-top');
	if (!button) return;

	const threshold = 0.25;
	let ticking = false;
	let visible = false;

	function update() {
		const doc = document.documentElement;
		const scrollable = doc.scrollHeight - window.innerHeight;
		const shouldShow =
			scrollable > 0 && window.scrollY / scrollable >= threshold;

		if (shouldShow !== visible) {
			visible = shouldShow;
			button.classList.toggle('js-visible', visible);
		}

		ticking = false;
	}

	function onScroll() {
		if (!ticking) {
			requestAnimationFrame(update);
			ticking = true;
		}
	}

	window.addEventListener('scroll', onScroll, { passive: true });
	window.addEventListener('resize', onScroll, { passive: true });
	update();
})();

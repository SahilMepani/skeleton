(() => {
	// Get the modal backdrop element
	const backdrop = document.querySelector('.modal-backdrop');
	if (!backdrop) return;

	// Add click event to all elements with data-modal attribute
	document.querySelectorAll('[data-modal]').forEach(trigger => {
		trigger.addEventListener('click', () => {
			backdrop.classList.toggle('js-active');
		});
	});
})();

(() => {
	function handleClickToggle(element) {
		const toggleClick = element.getAttribute('data-toggle-click');
		const toggleGroup = element.getAttribute('data-toggle-group');

		if (!toggleClick) return;

		// First, remove js-active from all elements with same data-toggle-click value
		document
			.querySelectorAll(`[data-toggle-click="${toggleClick}"]`)
			.forEach(function (el) {
				if (el !== element) {
					el.classList.remove('js-active');
				}
			});

		// Then toggle js-active on the clicked element
		element.classList.toggle('js-active');

		// If toggleGroup is used, also remove js-active from others in the same group
		if (toggleGroup) {
			document
				.querySelectorAll(`[data-toggle-group="${toggleGroup}"]`)
				.forEach(function (groupElement) {
					if (groupElement !== element) {
						groupElement.classList.remove('js-active');

						const otherToggleClick =
							groupElement.getAttribute('data-toggle-click');
						if (otherToggleClick) {
							document
								.querySelectorAll(
									`[data-toggle-link="${otherToggleClick}"]`
								)
								.forEach(function (linkedEl) {
									linkedEl.classList.remove('js-active');
								});
						}
					}
				});
		}

		// Then toggle the linked element
		document
			.querySelectorAll(`[data-toggle-link="${toggleClick}"]`)
			.forEach(function (linkedElement) {
				linkedElement.classList.toggle('js-active');
			});
	}

	// Attach click event
	document
		.querySelectorAll('[data-toggle-click]')
		.forEach(function (element) {
			element.addEventListener('click', function () {
				handleClickToggle(element);
			});
		});
})();

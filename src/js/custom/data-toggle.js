(() => {
	let leaveTimeout;

	// ==========================
	// CLICK HANDLER
	// ==========================
	function handleClickToggle(element) {
		const toggleClick = element.getAttribute('data-toggle-click');
		const toggleGroup = element.getAttribute('data-toggle-group');

		// If already active and has a data-tab attribute, do nothing
		if (
			element.classList.contains('js-active') &&
			element.hasAttribute('data-tab')
		) {
			return;
		}

		// 1. Deactivate other items in the same group
		if (toggleGroup) {
			document
				.querySelectorAll(`[data-toggle-group="${toggleGroup}"]`)
				.forEach(groupElement => {
					if (groupElement !== element) {
						groupElement.classList.remove('js-active');
					}
				});
		}

		// 2. Toggle js-active on clicked element
		element.classList.toggle('js-active');

		// 3. Toggle corresponding data-toggle-link elements
		if (toggleClick) {
			document
				.querySelectorAll(`[data-toggle-link="${toggleClick}"]`)
				.forEach(linkedElement => {
					const linkedGroup =
						linkedElement.getAttribute('data-toggle-group');

					// Deactivate others in the same linked group
					if (linkedGroup) {
						document
							.querySelectorAll(
								`[data-toggle-group="${linkedGroup}"]`
							)
							.forEach(sibling => {
								if (sibling !== linkedElement) {
									sibling.classList.remove('js-active');
								}
							});
					}

					// Activate linked element
					linkedElement.classList.toggle('js-active');
				});
		}
	}

	document.querySelectorAll('[data-toggle-click]').forEach(element => {
		element.addEventListener('click', event => {
			handleClickToggle(event.currentTarget);
		});
	});

	// ==========================
	// HOVER HANDLER
	// ==========================
	function handleMouseEnter(element) {
		const toggleHover = element.getAttribute('data-toggle-hover');
		element.classList.add('js-active');

		if (toggleHover) {
			document
				.querySelectorAll(`[data-toggle-link="${toggleHover}"]`)
				.forEach(linkedElement => {
					linkedElement.classList.add('js-active');
				});
		}

		if (leaveTimeout) {
			clearTimeout(leaveTimeout);
		}
	}

	function handleMouseLeave(element) {
		const toggleHover = element.getAttribute('data-toggle-hover');

		leaveTimeout = setTimeout(() => {
			let isMouseOverLinked = false;

			if (element.matches(':hover')) {
				isMouseOverLinked = true;
			} else if (toggleHover) {
				document
					.querySelectorAll(`[data-toggle-link="${toggleHover}"]`)
					.forEach(linkedElement => {
						if (linkedElement.matches(':hover')) {
							isMouseOverLinked = true;
						}
					});
			}

			if (!isMouseOverLinked) {
				element.classList.remove('js-active');

				if (toggleHover) {
					document
						.querySelectorAll(`[data-toggle-link="${toggleHover}"]`)
						.forEach(linkedElement => {
							linkedElement.classList.remove('js-active');
						});
				}
			}
		}, 50);
	}

	document.querySelectorAll('[data-toggle-hover]').forEach(element => {
		element.addEventListener('mouseenter', event =>
			handleMouseEnter(event.currentTarget)
		);
		element.addEventListener('mouseleave', event =>
			handleMouseLeave(event.currentTarget)
		);

		// Touch support
		element.addEventListener('touchstart', event => {
			event.preventDefault();
			handleMouseEnter(event.currentTarget);
		});
		element.addEventListener('touchend', event => {
			event.preventDefault();
			handleMouseLeave(event.currentTarget);
		});
	});

	// ==========================
	// HOVER: LINKED ELEMENT SUPPORT
	// ==========================
	document.querySelectorAll('[data-toggle-link]').forEach(element => {
		element.addEventListener('mouseenter', () => {
			if (leaveTimeout) clearTimeout(leaveTimeout);
		});

		element.addEventListener('mouseleave', () => {
			// Try to find its associated hover origin (if exists)
			document
				.querySelectorAll('[data-toggle-hover]')
				.forEach(hoverElement => {
					const hoverTarget =
						hoverElement.getAttribute('data-toggle-hover');
					const linkedTarget =
						element.getAttribute('data-toggle-link');
					if (hoverTarget === linkedTarget) {
						handleMouseLeave(hoverElement);
					}
				});
		});
	});
})();

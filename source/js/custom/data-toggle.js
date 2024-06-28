(() => {
	// Helper function to toggle js-active class on click
	function handleClickToggle(element) {
		const toggleClick = element.getAttribute('data-toggle-click');
		const toggleGroup = element.getAttribute('data-toggle-group');

		// Toggle the js-active class on the clicked element
		element.classList.toggle('js-active');

		// Handle the data-toggle-group logic
		if (toggleGroup) {
			// Remove js-active class from all elements in the same group
			document
				.querySelectorAll(`[data-toggle-group="${toggleGroup}"]`)
				.forEach(function (groupElement) {
					if (groupElement !== element) {
						groupElement.classList.remove('js-active');
					}
				});
		}

		// Find and toggle the corresponding data-toggle-link elements
		if (toggleClick) {
			document
				.querySelectorAll(`[data-toggle-link="${toggleClick}"]`)
				.forEach(function (linkedElement) {
					linkedElement.classList.toggle('js-active');
				});
		}
	}

	// Handle click events for elements with data-toggle-click attribute
	document
		.querySelectorAll('[data-toggle-click]')
		.forEach(function (element) {
			element.addEventListener('click', function (event) {
				handleClickToggle(event.currentTarget);
			});
		});

	// Handle hover events for elements with data-toggle-hover attribute
	document
		.querySelectorAll('[data-toggle-hover]')
		.forEach(function (element) {
			const toggleHover = element.getAttribute('data-toggle-hover');
			let leaveTimeout;

			function handleMouseEnter(event) {
				const currentElement = event.currentTarget;
				// Add js-active class on hover
				currentElement.classList.add('js-active');

				// Add js-active class to corresponding data-toggle-link elements
				if (toggleHover) {
					document
						.querySelectorAll(`[data-toggle-link="${toggleHover}"]`)
						.forEach(function (linkedElement) {
							linkedElement.classList.add('js-active');
						});
				}

				// Clear any pending leave timeout
				if (leaveTimeout) {
					clearTimeout(leaveTimeout);
				}
			}

			function handleMouseLeave(event) {
				const currentElement = event.currentTarget;
				// Set a delay before removing the js-active class
				leaveTimeout = setTimeout(function () {
					// Check if mouse is over the current element or any linked elements
					let isMouseOverLinked = false;

					if (currentElement.matches(':hover')) {
						isMouseOverLinked = true;
					} else if (toggleHover) {
						document
							.querySelectorAll(
								`[data-toggle-link="${toggleHover}"]`
							)
							.forEach(function (linkedElement) {
								if (linkedElement.matches(':hover')) {
									isMouseOverLinked = true;
								}
							});
					}

					if (!isMouseOverLinked) {
						// Remove js-active class if the mouse is not over the element or linked elements
						currentElement.classList.remove('js-active');

						if (toggleHover) {
							document
								.querySelectorAll(
									`[data-toggle-link="${toggleHover}"]`
								)
								.forEach(function (linkedElement) {
									linkedElement.classList.remove('js-active');
								});
						}
					}
				}, 50); // Adjust the delay as needed
			}

			element.addEventListener('mouseenter', handleMouseEnter);
			element.addEventListener('mouseleave', handleMouseLeave);

			// Touch events for touch devices
			element.addEventListener('touchstart', function (event) {
				// Prevent touchstart from triggering click event
				event.preventDefault();
				handleMouseEnter(event);
			});
			element.addEventListener('touchend', function (event) {
				event.preventDefault();
				handleMouseLeave(event);
			});
		});

	// Handle mouse enter and leave events for elements with data-toggle-link attribute
	// document.querySelectorAll('[data-toggle-link]').forEach(function (element) {
	// 	element.addEventListener('mouseenter', function (event) {
	// 		// Clear any pending leave timeout when mouse enters the linked element
	// 		if (leaveTimeout) {
	// 			clearTimeout(leaveTimeout);
	// 		}
	// 	});

	// 	element.addEventListener('mouseleave', function (event) {
	// 		// Invoke mouse leave function when mouse leaves the linked element
	// 		handleMouseLeave(event);
	// 	});
	// });
})();

(() => {
	// ------------------------------------
	// 1. Cache elements using const
	// ------------------------------------
	const headerNavToggle = document.querySelector('.header-nav-toggle');
	const headerNav = document.querySelector('.header-nav');
	const body = document.body;
	const headerNavClose = document.querySelector('.header-nav-close');
	const parentMenuItems = document.querySelectorAll(
		'.header-nav-parent-menu li.menu-item-has-children > a'
	);

	// CSS classes for visual toggling
	const activeClass = 'js-active';
	const popupActiveClass = 'js-popup-active';

	// ------------------------------------
	// 2. Helper functions for navigation state
	// ------------------------------------

	/**
	 * Opens the main navigation menu, updating visual and ARIA states.
	 */
	const openNavigation = () => {
		// Add classes for visual styling (e.g., show menu, disable body scroll)
		headerNavToggle.classList.add(activeClass);
		headerNav.classList.add(activeClass);
		body.classList.add(popupActiveClass);

		// Update ARIA attributes for accessibility
		headerNavToggle.setAttribute('aria-expanded', 'true'); // Button now expands
		headerNav.setAttribute('aria-hidden', 'false'); // Menu is now visible to screen readers
		headerNavClose.setAttribute('aria-expanded', 'true'); // Close button's state reflects menu is open
	};

	/**
	 * Closes the main navigation menu, updating visual and ARIA states.
	 */
	const closeNavigation = () => {
		// Remove classes for visual styling
		headerNavToggle.classList.remove(activeClass);
		headerNav.classList.remove(activeClass);
		body.classList.remove(popupActiveClass);

		// Update ARIA attributes for accessibility
		headerNavToggle.setAttribute('aria-expanded', 'false'); // Button now collapses
		headerNav.setAttribute('aria-hidden', 'true'); // Menu is now hidden from screen readers
		headerNavClose.setAttribute('aria-expanded', 'false'); // Close button's state reflects menu is closed
	};

	// ------------------------------------
	// 3. Event Listeners for main navigation toggle
	// ------------------------------------

	// Header navigation toggle button
	if (headerNavToggle) {
		// Ensure the element exists before adding listener
		headerNavToggle.addEventListener('click', e => {
			e.preventDefault(); // Stop default button behavior

			// Check if the menu is currently open to decide action
			const isMenuOpen = headerNav.classList.contains(activeClass);
			if (isMenuOpen) {
				closeNavigation();
			} else {
				openNavigation();
			}
		});
	}

	// Header navigation close button
	if (headerNavClose) {
		// Ensure the element exists before adding listener
		headerNavClose.addEventListener('click', e => {
			e.preventDefault(); // Stop default button behavior
			closeNavigation(); // Always close when this button is clicked
		});
	}

	// ------------------------------------
	// 4. Mobile parent menu dropdown functionality
	// ------------------------------------

	if (parentMenuItems) {
		// Ensure parent menu items exist
		parentMenuItems.forEach(anchorElement => {
			// Create the <span> element
			const span = document.createElement('span');
			// Append the <span> to the <a>
			anchorElement.appendChild(span);

			// Add click listener to the newly created <span>
			span.addEventListener('click', function (e) {
				e.preventDefault(); // Prevent the main link from navigating

				// Toggle 'js-active' class on the parent <li>
				// The 'this' context refers to the <span>, so its parentElement is the <a>,
				// and the parentElement of the <a> is the <li>.
				this.parentElement.parentElement.classList.toggle(activeClass);

				// IMPORTANT: Manage ARIA for the dropdown
				// Find the direct child <ul> (submenu) of the <li>
				const subMenu =
					this.parentElement.parentElement.querySelector(
						'ul.sub-menu'
					);
				if (subMenu) {
					const isExpanded =
						this.parentElement.parentElement.classList.contains(
							activeClass
						);
					// Set aria-expanded on the <a> (or the span, or the <li> if that's what controls the dropdown)
					// For a better experience, aria-expanded should be on the interactive element (the <a> or the span acting as a button).
					// And aria-hidden on the dropdown content (the <ul>).
					this.setAttribute('aria-expanded', isExpanded);
					subMenu.setAttribute('aria-hidden', !isExpanded);
				}
			});
		});
	}
})();

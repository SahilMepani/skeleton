(() => {
	// Select all dialog open buttons
	const allDialogOpeners = document.querySelectorAll('.js-dialog-open');

	// Helper function to stop Lenis scroll
	const handleLenisStop = () => {
		if (typeof lenis !== 'undefined' && lenis.stop) {
			lenis.stop();
		}
	};

	// Helper function to start Lenis scroll
	const handleLenisStart = () => {
		if (typeof lenis !== 'undefined' && lenis.start) {
			lenis.start();
		}
	};

	// Helper function to reset media (video and iframe)
	const resetMedia = dialog => {
		const video = dialog.querySelector('.js-video');
		if (video) {
			video.pause();
			video.currentTime = 0;
		}
		const iframe = dialog.querySelector('.js-iframe');
		if (iframe) {
			const newIframe = iframe.cloneNode(true);
			iframe.parentNode.replaceChild(newIframe, iframe);
		}
	};

	allDialogOpeners.forEach(dialogOpenButton => {
		// Get the unique identifier from the data-dialog attribute of the open button
		const dialogId = dialogOpenButton.getAttribute('data-dialog');

		// Find the corresponding dialog element using the data-dialog ID
		const targetDialog = document.querySelector(
			`.js-dialog[data-dialog="${dialogId}"]`
		);

		// If no target dialog found, skip this opener
		if (!targetDialog) {
			console.warn(`No dialog found for data-dialog="${dialogId}"`);
			return;
		}

		// Find elements specific to this dialog instance
		const video = targetDialog.querySelector('.js-video');
		const iframe = targetDialog.querySelector('.js-iframe');
		const dialogCloseButton =
			targetDialog.querySelector('.js-dialog-close');

		dialogOpenButton.addEventListener('click', () => {
			handleLenisStop();
			document.body.setAttribute('inert', ''); // Makes background content unclickable/unscrollable

			// Video/Iframe auto-play logic
			if (video) {
				video.play();
			}
			if (iframe) {
				const baseVideoURL = iframe.getAttribute('data-video-url');
				const youtubeOptions =
					'?autoplay=1&rel=0&showinfo=0&iv_load_policy=3&modestbranding=1&disablekb=1';
				const vimeoOptions = '?autoplay=1&title=0&byline=0&portrait=0';
				const embedOptions =
					baseVideoURL && baseVideoURL.includes('youtube')
						? youtubeOptions
						: baseVideoURL && baseVideoURL.includes('vimeo')
							? vimeoOptions
							: '';
				const autoplayVideoURL = baseVideoURL
					? `${baseVideoURL}${embedOptions}`
					: ''; // Ensure baseVideoURL exists
				iframe.src = autoplayVideoURL;
			}

			// Show dialog
			targetDialog.showModal();

			// Attach close event to the specific close button within this dialog
			// We attach it here because the dialog might be dynamically added or its close button might change.
			// Using { once: true } ensures the listener is automatically removed after first click.
			if (dialogCloseButton) {
				dialogCloseButton.addEventListener(
					'click',
					function closeDialogHandler() {
						// Named function for clarity
						handleLenisStart();
						document.body.removeAttribute('inert');
						resetMedia(targetDialog);
						targetDialog.close();
					},
					{ once: true }
				);
			}
		});

		// Close when clicking outside the dialog content (on the dialog backdrop)
		targetDialog.addEventListener('click', event => {
			if (event.target === targetDialog) {
				// Checks if the click was directly on the <dialog> element itself (the backdrop)
				handleLenisStart();
				document.body.removeAttribute('inert');
				resetMedia(targetDialog);
				targetDialog.close();
			}
		});

		// Handle dialog's native 'close' event (e.g., when pressing ESC key)
		targetDialog.addEventListener('close', () => {
			handleLenisStart();
			document.body.removeAttribute('inert');
			resetMedia(targetDialog);
		});
	});
})();

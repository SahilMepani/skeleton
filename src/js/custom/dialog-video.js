(() => {
	const allDialog = document.querySelectorAll('.js-dialog');

	const resetIframe = dialog => {
		const iframe = dialog.querySelector('.js-iframe');
		if (iframe) {
			const newIframe = iframe.cloneNode(true);
			iframe.parentNode.replaceChild(newIframe, iframe);
		}
	};

	allDialog.forEach(dialog => {
		const dialogParent = dialog.parentElement;
		const dialogOpen = dialogParent.querySelector('.js-dialog-open');

		dialogOpen.addEventListener('click', () => {
			lenis.stop();
			document.body.setAttribute('inert', '');

			const video = dialog.querySelector('.js-video');
			const iframe = dialog.querySelector('.js-iframe');

			if (video) {
				video.play();
			}
			if (iframe) {
				const baseVideoURL = iframe.getAttribute('data-video-url');
				const youtubeOptions =
					'?autoplay=1&rel=0&showinfo=0&iv_load_policy=3&modestbranding=1&disablekb=1';
				const vimeoOptions = '?autoplay=1&title=0&byline=0&portrait=0';
				const embedOptions = baseVideoURL.includes('youtube')
					? youtubeOptions
					: baseVideoURL.includes('vimeo')
						? vimeoOptions
						: '';
				const autoplayVideoURL = `${baseVideoURL}${embedOptions}`;
				iframe.src = autoplayVideoURL;
			}

			// Show dialog
			dialog.showModal();

			// Re-attach close event each time in case DOM changed
			const dialogClose = dialog.querySelector('.js-dialog-close');
			if (dialogClose) {
				dialogClose.addEventListener(
					'click',
					() => {
						document.body.removeAttribute('inert');
						if (video) {
							video.pause();
							video.currentTime = 0;
						}
						resetIframe(dialog);
						dialog.close();
					},
					{ once: true }
				); // Ensures it's not added multiple times
			}
		});

		// Close when clicking outside the dialog content
		dialog.addEventListener('click', event => {
			if (event.target === dialog) {
				document.body.removeAttribute('inert');
				resetIframe(dialog);
				dialog.close();
			}
		});

		dialog.addEventListener('close', () => {
			lenis.start();
			document.body.removeAttribute('inert');

			const video = dialog.querySelector('.js-video');
			if (video) {
				video.pause();
				video.currentTime = 0;
			}
			resetIframe(dialog);
		});
	});
})();

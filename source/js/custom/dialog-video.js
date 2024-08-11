(() => {
	const allDialog = document.querySelectorAll('.js-dialog');

	allDialog.forEach(dialog => {
		const dialogParent = dialog.parentElement;
		const dialogOpen = dialogParent.querySelector('.js-dialog-open');
		const dialogClose = dialog.querySelector('.js-dialog-close');
		const video = dialog.querySelector('.js-video');
		const iframe = dialog.querySelector('.js-iframe');

		dialogOpen.addEventListener('click', () => {
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
			dialog.showModal();
		});

		dialogClose.addEventListener('click', () => {
			if (video) {
				video.pause();
				video.currentTime = 0; // Reset video to start
			}
			if (iframe) {
				iframe.src = '';
			}
			dialog.close();
		});

		dialog.addEventListener('close', () => {
			if (video) {
				video.pause();
				video.currentTime = 0; // Reset video to start
			}
			if (iframe) {
				iframe.src = '';
			}
		});
	});
})();

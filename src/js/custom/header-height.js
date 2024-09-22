/**
 * Find the header height and set to
 * scroll-padding-top css property
 */
(() => {
	const siteHeader = document.querySelector('.site-header');
	const headerHeight = siteHeader.offsetHeight;
	const resizeHeaderHeight = () => {
		document.documentElement.style.setProperty(
			'--header-height',
			headerHeight + 'px'
		);
	};
	resizeHeaderHeight();
	window.addEventListener('resize', resizeHeaderHeight);
})();

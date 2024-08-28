/**
 * Find the header height and set to
 * scroll-padding-top css property
 */
const headerHeight = document.querySelector('.site-header').offsetHeight;
const resizeHeaderHeight = () => {
	document.documentElement.style.setProperty(
		'--header-height',
		headerHeight + 'px'
	);
};
resizeHeaderHeight();
window.addEventListener('resize', resizeHeaderHeight);

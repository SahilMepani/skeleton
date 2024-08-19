/**
 * Check if the user's screen primary input device is touch or not
 * https://stackoverflow.com/questions/4817029/whats-the-best-way-to-detect-a-touch-screen-device-using-javascript
 */
if (!window.matchMedia('(pointer: coarse)').matches) {
	document.documentElement.classList.add('js-no-touchevents');
}

/**
 * Find the header height and set to
 * scroll-padding-top css property
 */
const resizeHeaderHeight = () => {
	const headerHeight = document.querySelector('.site-header').offsetHeight;
	document.documentElement.style.setProperty(
		'--header-height',
		headerHeight + 'px'
	);
};
resizeHeaderHeight();
window.addEventListener('resize', resizeHeaderHeight);

/**
 * Check if user scrolled
 */
let pageScroll = function () {
	let scroll = window.scrollY;
	const siteHeader = document.querySelector('.site-header');
	if (siteHeader) {
		if (scroll > 0) {
			siteHeader.classList.add('js-fixed');
		} else {
			siteHeader.classList.remove('js-fixed');
		}
	}
};
// need to run once, as sometimes the page is already scrolled down on load
pageScroll();
// run on scroll
window.addEventListener('scroll', pageScroll);

/**
 * Scroll to a specific section from #ID at the end of Window URL
 */
const current_url = window.location.href;
if (current_url.indexOf('#') != -1) {
	let hash_index = current_url.indexOf('#');
	element_id = current_url.substring(hash_index + 1);
	let element = document.getElementById(element_id);
	if (element) {
		setTimeout(function () {
			element.scrollIntoView({
				behavior: 'smooth',
				block: 'center'
			});
		}, 100);
	}
}

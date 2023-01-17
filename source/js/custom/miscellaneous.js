// Check if user scrolled
////////////////////////////////////////////////
let pageScroll = function () {
	let scroll = window.scrollY;
	const siteHeader = document.querySelector(".site-header");
	if (siteHeader) {
		if (scroll > 0) {
			siteHeader.classList.add("js-fixed");
		} else {
			siteHeader.classList.remove("js-fixed");
		}
	}
};
// need to run once, as sometimes the page is already scrolled down on load
pageScroll();
// run on scroll
window.addEventListener("scroll", pageScroll);

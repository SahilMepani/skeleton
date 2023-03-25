// Check if the user's screen primary input device is touch or not
// https://stackoverflow.com/questions/4817029/whats-the-best-way-to-detect-a-touch-screen-device-using-javascript
////////////////////////////////////////////////
if (!window.matchMedia("(pointer: coarse)").matches) {
	document.documentElement.classList.add("js-no-touchevents")
}


// Find the header height and set to scroll-padding-top css property
////////////////////////////////////////////////
const resizeHeaderHeight = () => {
    const headerHeight = document.querySelector(".site-header").offsetHeight
    document.documentElement.style.setProperty("--scroll-padding-top", headerHeight + "px")
}
resizeHeaderHeight()
window.addEventListener("resize", resizeHeaderHeight)


// Check if user scrolled
////////////////////////////////////////////////
let pageScroll = function () {
	let scroll = window.scrollY
	const siteHeader = document.querySelector(".site-header")
	if (siteHeader) {
		if (scroll > 0) {
			siteHeader.classList.add("js-fixed")
		} else {
			siteHeader.classList.remove("js-fixed")
		}
	}
}
// need to run once, as sometimes the page is already scrolled down on load
pageScroll()
// run on scroll
window.addEventListener("scroll", pageScroll)

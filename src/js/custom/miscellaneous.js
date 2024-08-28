/**
 * Check if the user's screen primary input device is touch or not
 * https://stackoverflow.com/questions/4817029/whats-the-best-way-to-detect-a-touch-screen-device-using-javascript
 */
if (!window.matchMedia('(pointer: coarse)').matches) {
	document.documentElement.classList.add('js-no-touchevents');
}

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

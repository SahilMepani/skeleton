/**
 * Scroll to a specific section from #ID at the end of Window URL
 */
(() => {
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
})();

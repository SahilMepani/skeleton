import buildMakeNotices from "./core-notices"
const makeNotices = buildMakeNotices()

// Initialize the main components.
window.addEventListener("DOMContentLoaded", () => {
	const { themeCore } = window

	// These should only work on the Backend.
	if (themeCore.isAdmin) {
		const notices = makeNotices()
		notices.init()
	}
})

export default function buildMakeNotices() {
	return function makeNotices() {
		const Cookies = require("js-cookie")
		const { themeNotices } = window

		return Object.freeze({ init })

		/**
		 * Initializes this component.
		 *
		 * @since 1.0.0
		 */
		function init() {
			if (
				typeof themeNotices !== "undefined" &&
				new URLSearchParams(window.location.search).get(
					"core-notices"
				) != 0
			) {
				showCoreAdminNotices(themeNotices)
			}
		}

		/**
		 * Closes and removes the specified notice.
		 *
		 * @param {Object} notice
		 */
		function closeNotice(notice) {
			notice.classList.add("core-notice--hide")
			setTimeout(() => notice.remove(), 500)
		}

		/**
		 * Dismisses the specified notice forever.
		 *
		 * The cookie expires in 7 days.
		 *
		 * @param {Object} notice
		 * @param {Number|boolean} by Defines when, in days, the cookie will be removed.
		 */
		function dismissNotice(noticeId, by = false) {
			const options = {}
			if (!isNaN(by)) options.expires = parseInt(by)
			console.log({ options })

			Cookies.set(`core-notice-dismiss-${noticeId}`, "", options)
		}

		/**
		 * showCoreAdminNotices
		 *
		 * Prepares and displays core admin notices.
		 *
		 * @param array notices=[]
		 */
		function showCoreAdminNotices(notices = []) {
			const noticesWrapper = document.createElement("div")
			noticesWrapper.id = "core-notices"
			noticesWrapper.classList.add("core-notices")

			document.body.append(noticesWrapper)

			for (let type in notices) {
				for (let notice of notices[type]) {
					showCoreAdminNotice(type, notice, noticesWrapper)
				}
			}

			setTimeout(() => {
				noticesWrapper.classList.add("core-notices--show")
			}, 500)

			/** Bind click event to close notices. */
			noticesWrapper.addEventListener("click", ({ target }) => {
				const closeButton = target.closest(".core-notice__close")
				if (!closeButton) return

				closeNotice(closeButton.parentNode)
			})

			/** Bind click even to dismiss notices. */
			noticesWrapper.addEventListener("click", ({ target }) => {
				const dismissButton = target.closest(
					".core-notice__dismiss-button"
				)
				if (!dismissButton) return

				dismissNotice(
					dismissButton.parentNode.parentNode.dataset.id,
					dismissButton.dataset.by
				)
				closeNotice(dismissButton.parentNode.parentNode)
			})

			/** Bind click event to the backtrace toggler. */
			noticesWrapper.addEventListener("click", ({ target }) => {
				const toggler = target.closest(
					".core-notice__backtrace-toggler"
				)
				if (!toggler) return

				const backtraceContent = toggler.parentNode.querySelector(
					".core-notice__backtrace-content"
				)
				const a = backtraceContent.classList.contains(
					"core-notice__backtrace-content--open"
				)
					? "remove"
					: "add"

				backtraceContent.classList[a](
					"core-notice__backtrace-content--open"
				)
			})
		}

		/**
		 * showCoreAdminNotice
		 *
		 * Displays a core admin notice.
		 *
		 * @param string type
		 * @param object data
		 * @param Node wrapper
		 */
		function showCoreAdminNotice(type, data, wrapper) {
			const notice = document.createElement("div")
			notice.classList.add("core-notice", `core-notice--${type}`)
			notice.setAttribute("data-id", data.id)

			notice.innerHTML = `
				<button type="button" title="Dismiss" class="core-notice__close">
					<span class="dashicons dashicons-no"></span>
				</button>

				<div class="core-notice__message">
					<span class="core-notice__message--main">${data.message}</span>
				</div>
			`

			/** Include additional info. */
			if (data.info) {
				notice.querySelector(".core-notice__message").innerHTML += `
						<span class="core-notice__message--info">${data.info}</span>
					`
			}

			/** Include the dismiss button. */
			if (data.dismissible) {
				const dismiss = document.createElement("div")
				dismiss.className = "core-notice__dismiss"

				dismiss.innerHTML = `
					<button
						type="button"
						title="Dismiss this notice forever"
						aria-label="Dismiss this notice forever"
						class="core-notice__dismiss-button"
						data-by="${data.dismissible}">
						Dismiss
					</button>
				`

				notice.append(dismiss)
			}

			/** Include the backtrace. */
			if (data.backtrace) {
				const backtrace = document.createElement("div")
				backtrace.className = "core-notice__backtrace"

				backtrace.innerHTML += `
					<div class="core-notice__backtrace-preview">${data.backtrace[1].file}:${data.backtrace[1].line}</div>

					<button type="button" title="Toggle backtrace" class="core-notice__backtrace-toggler">
						Full backtrace <span class="dashicons dashicons-arrow-down-alt2"></span>
					</button>

					<div class="core-notice__backtrace-content"></div>
				`

				const backtraceContent = backtrace.querySelector(
					".core-notice__backtrace-content"
				)

				for (let entry of data.backtrace) {
					backtraceContent.innerHTML += `
						<div class="core-notice__file">${entry.file}:${entry.line}</div>
					`
				}

				notice.append(backtrace)
			}

			wrapper.append(notice)
		}
	}
}

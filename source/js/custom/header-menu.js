$(".header-nav-toggle").click(function (e) {
	$(this).toggleClass("js-active")
	$(".header-nav").toggleClass("js-active")
	$("body").toggleClass("js-popup-active")
	e.preventDefault()
})

$(".header-nav-close").click(function (e) {
	$(".header-nav-toggle").toggleClass("js-active")
	$(".header-nav").toggleClass("js-active")
	$("body").removeClass("js-popup-active")
	e.preventDefault()
})

/* Add dropdown arrow for mobile parent menu */
$(".header-nav-parent-menu li.menu-item-has-children > a").append(
	"<span></span>"
)
$(".header-nav-parent-menu li.menu-item-has-children > a span").on(
	"click",
	function (e) {
		e.preventDefault()
		$(this).toggleClass("js-active")
		$(this).parent("a").siblings(".sub-menu").toggleClass("js-active")
		$(this)
			.parent("a")
			.siblings(".sub-menu")
			.find("span.js-active")
			.removeClass("js-active")
		$(this)
			.parent("a")
			.siblings(".sub-menu")
			.find(".sub-menu.js-active")
			.removeClass("js-active")
	}
)

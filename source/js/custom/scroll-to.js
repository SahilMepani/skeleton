/*=============================================
=            General scroll to any            =
=============================================*/
$(".scroll-to").click(function (e) {
	e.preventDefault()
	$("html,body").animate(
		{
			scrollTop: $(this.hash).offset().top
		},
		500
	)
})

/*=====================================
=            Scroll to top            =
=====================================*/
var scrollToTop = debounce(function () {
	// if width is greater
	if ($(this).width() > 767) {
		// if scrollTop offset is greater
		if ($(this).scrollTop() > 200) {
			$(".scroll-to-top").fadeIn(200)
		} else {
			$(".scroll-to-top").fadeOut(200)
		}
	}
}, 200)

// run on page load
scrollToTop()

// run on scroll
window.addEventListener("scroll", scrollToTop)

jQuery( document ).ready( function( $ ) {

	/*=======================================
	=            Js Social Share            =
	=======================================*/
	$(".js-socials-share").jsSocials({
		shares: ["email", "twitter", "facebook", "googleplus", "linkedin", "pinterest"],
		showLabel: true,
		showCount: false,
		shareIn: "popup"
	});


	/*=======================================
	=            Carousel Slider            =
	=======================================*/
	new Swiper( '.carousel-slider', {
		slidesPerView: 3,
		slidesPerGroup: 3,
		spaceBetween: 30,
		// loop: true,
		centeredSlides: false,
		breakpoints: {
			// when window width is less than equal to
			480: {
				slidesPerView: 1,
				slidesPerGroup: 1,
				spaceBetween: 0
			},
			767: {
				slidesPerView: 2,
				slidesPerGroup: 2,
				spaceBetween: 20,
			},
		},
		nextButton: '.btn-next',
		prevButton: '.btn-prev',
	} );


	/*=====================================
	=            Images Slider            =
	=====================================*/
	new Swiper( '.images-slider', {
		//keyboardControl: true,
		autoplay: 5000,
		speed: 500,
		pagination: '.swiper-pagination',
		paginationClickable: true,
		nextButton: '.btn-next',
		prevButton: '.btn-prev',
		//loop: true, //content transition breaks
	} );


	/*=======================================
	=            Centered Slider            =
	=======================================*/
	new Swiper( '.centered-slider', {
		autoplay: 5000,
		speed: 500,
		pagination: '.swiper-pagination',
		paginationClickable: true,
		nextButton: '.btn-next',
		prevButton: '.btn-prev',
		loop: true,
		slidesPerView: 'auto',
		centeredSlides: true,
		spaceBetween: 0,
		// initialSlide: 1,
	} );


	/*===================================
	=            Tabs Slider            =
	===================================*/
	$( function() {
		// swiper
		tabsSlider = new Swiper( '.tabs-slider', {
			nextButton: '.btn-next',
			prevButton: '.btn-prev',
			speed: 500,
			onSlideChangeStart: function() {
				$( '.tabs-slider-pagination > li' ).removeClass( 'is-active' );
				$( '.tabs-slider-pagination > li' ).eq( tabsSlider.activeIndex ).addClass( 'is-active' );
			}
		} );
		// pagination
		$( '.tabs-slider-pagination > li' ).eq( 0 ).addClass( 'is-active' );
		$( '.tabs-slider-pagination > li' ).click( function() {
			tabsSlider.slideTo( $( this ).index() );
			$( '.tabs-slider-pagination > li' ).removeClass( 'is-active' );
			$( this ).addClass( 'is-active' )
		} )
	} );


	/*==========================================
	=            Nested Tabs Slider            =
	==========================================*/
	// swiper
	nestedTabSlider = new Swiper( '.nested-tabs-slider', {
		nextButton: '.btn-next',
		prevButton: '.btn-prev',
		speed: 500,
		onSlideChangeStart: function() {
			$activeSlide = $( '.nested-tabs-slider .swiper-slide-active' );
			$tabActiveClass = $activeSlide.data( 'tab-heading' );
			$( '.nested-tabs-slider-pagination > li' ).removeClass( 'is-active' );
			$( '.' + $tabActiveClass ).addClass( 'is-active' );
		}
	} );
	// navigation
	$( '.nested-tabs-slider-pagination > li' ).eq( 0 ).addClass( 'is-active' );
	$( '.nested-tabs-slider-pagination > li' ).click( function() {
		nestedTabSlider.slideTo( $( this ).data( 'slide-index' ) );
		$( '.nested-tabs-slider-pagination > li' ).removeClass( 'is-active' );
		$( this ).addClass( 'is-active' )
	} );


	/*===================================
	=            Header Menu            =
	===================================*/
	$( '.header-menu-toggle' ).click( function( e ) {
		$( this ).toggleClass( 'is-active' );
		$( '#header-menu' ).toggleClass( 'is-active' );
		e.preventDefault();
	} );

	$( '.header-menu-close' ).click( function( e ) {
		$( '.header-menu-toggle' ).toggleClass( 'is-active' );
		$( '#header-menu' ).toggleClass( 'is-active' );
		e.preventDefault();
	} );

	/* Add dropdown arrow for mobile parent menu */
	$( '.parent-menu > li.menu-item-has-children > a' ).append( '<span></span>' );
	$( '.parent-menu > li.menu-item-has-children > a span' ).on( 'click', function( e ) {
		e.preventDefault();
		$( this ).parent( 'a' ).siblings( '.sub-menu' ).toggleClass( 'is-active' );
	} );


	/*=====================================
	=            Scroll to top            =
	=====================================*/
	$( '#scroll-top' ).click( function( e ) {
		e.preventDefault();
		$( 'html, body' ).animate( {
			scrollTop: 0
		}, 300 );
	} );

	var scrollToTop = debounce( function() {
		if ( $( this ).width() > 767 ) {
			if ( $( this ).scrollTop() > 200 ) {
				$( '#scroll-top' ).fadeIn( 200 );
			} else {
				$( '#scroll-top' ).fadeOut( 200 );
			}
		}
	}, 200 );

	window.addEventListener( 'scroll', scrollToTop );


	/*=================================================
	=            Responsive Tabs - Sitemap            =
	=================================================*/
	/* Remove this if not using on sitemaps */
	$( '#sitemap-tabs' ).responsiveTabs( {
		startCollapsed: 'accordion'
	} );


	/*=====================================
	=            WOW Init                 =
	=====================================*/
	Visibility.onVisible( function() {
		var wow = new WOW().init();
	} );


	/*=======================================
	=            Spam Protection            =
	=======================================*/
	$( 'body' ).emailSpamProtection( 'email' );

} ); // Document Ready


/*=================================
=            Buggyfill            =
=================================*/
/* Polyfill for vh,vw units on iphone4,5 */
window.viewportUnitsBuggyfill.init( {
	refreshDebounceWait: 50,
	hacks: window.viewportUnitsBuggyfillHacks
} );
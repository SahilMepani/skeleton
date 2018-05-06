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
				$( '.tabs-slider-pagination > li' ).removeClass( 'js-active' );
				$( '.tabs-slider-pagination > li' ).eq( tabsSlider.activeIndex ).addClass( 'js-active' );
			}
		} );
		// pagination
		$( '.tabs-slider-pagination > li' ).eq( 0 ).addClass( 'js-active' );
		$( '.tabs-slider-pagination > li' ).click( function() {
			tabsSlider.slideTo( $( this ).index() );
			$( '.tabs-slider-pagination > li' ).removeClass( 'js-active' );
			$( this ).addClass( 'js-active' )
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
			$( '.nested-tabs-slider-pagination > li' ).removeClass( 'js-active' );
			$( '.' + $tabActiveClass ).addClass( 'js-active' );
		}
	} );
	// navigation
	$( '.nested-tabs-slider-pagination > li' ).eq( 0 ).addClass( 'js-active' );
	$( '.nested-tabs-slider-pagination > li' ).click( function() {
		nestedTabSlider.slideTo( $( this ).data( 'slide-index' ) );
		$( '.nested-tabs-slider-pagination > li' ).removeClass( 'js-active' );
		$( this ).addClass( 'js-active' )
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




	/*=======================================
	=            Spam Protection            =
	=======================================*/
	$( 'body' ).emailSpamProtection( 'email' );

} ); // Document Ready


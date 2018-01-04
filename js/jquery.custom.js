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


	/*=================================================
	=            Set ajax load more height            =
	=================================================*/
	/* Prevents below content jumping on btn click due to hidden */
	// $( '.btn-load-more-block' ).css( {
	// 	height: $( '.btn-load-more-block' ).outerHeight()
	// } );


	/*===============================================
	=            Ajax filter post by cat            =
	===============================================*/
	$( '#ajax-list-post-categories a' ).on( 'click', function( e ) {
		e.preventDefault();
		$( '#ajax-list-post-categories li' ).removeClass( 'js-active' );
		$( this ).parent( 'li' ).addClass( 'js-active' );
		filter_post_by_cat_trigger( $( this ) );
	} );

	$( '#ajax-select-post-categories' ).on( 'change', function( e ) {
		e.preventDefault();
		filter_post_by_cat_trigger( $( 'option:selected', this ) );
	} );

	function filter_post_by_cat_trigger( filterCategory ) {
		var loadMoreBtn = $( '#ajax-load-more-post' );

		loadMoreBtn.fadeOut( 400 );

		$( '#ajax-list-post' ).fadeOut( '400', function() {
			$( '.spinner' ).addClass( 'js-active' );
		} );

		var cpt = filterCategory.attr( 'data-cpt' );
		var cptTax = filterCategory.attr( 'data-cpt-tax' );
		var catID = filterCategory.attr( 'data-cat-id' );

		$( '#filter-cat-id' ).val( catID );
		$( '#filter-pagenum' ).val( 1 );

		filter_post_by_cat( catID, cpt, cptTax, loadMoreBtn );
	}

	function filter_post_by_cat( catID, cpt, cptTax, loadMoreBtn ) {
		$.ajax( {
			type: 'POST',
			dataType: 'html',
			url: localize_var.adminUrl,
			data: {
				action: 'filter_post_by_cat_ajax',
				catID: catID,
				cpt: cpt,
				cptTax: cptTax,
			},
			success: function( data ) {
				var $data = $( data );
				if ( $.trim( data ) != '' && $.trim( data ) != 0 ) {

					$( '#ajax-list-post > li' ).remove();

					setTimeout( function() {
						$( '#ajax-list-post' ).append( $data );
						$( '.spinner' ).removeClass( 'js-active' );
						$( '#ajax-list-post' ).fadeIn( 400 );
						loadMoreBtn.fadeIn( 400 );
					}, 300 );

					if ( $data.length < 6 ) {
						loadMoreBtn.removeClass( 'js-active js-disabled' ).addClass( 'js-disabled' );
					} else {
						loadMoreBtn.removeClass( 'js-active js-disabled' ).addClass( 'js-active' );
					}

				}
			},
			error: function( request, status, error ) {
				alert( request.responseText );
			}
		} );
		return false;
	}

	/*===========================================
	=            Ajax load more post            =
	===========================================*/
	$( '#ajax-load-more-post' ).on( 'click', function( e ) {
		e.preventDefault();
		$( this ).removeClass( 'js-active' ).addClass( 'js-disabled' );
		$( '.spinner' ).addClass( 'js-active' );
		load_more_post( $( this ) );
	} );

	function load_more_post( $this ) {

		var cpt = $this.attr( 'data-cpt' );
		var cptTax = $this.attr( 'data-cpt-tax' );
		var catID = $( '#filter-cat-id' ).val();
		var pageNumber = $( '#filter-pagenum' ).val();

		$.ajax( {
			type: 'POST',
			dataType: 'html',
			url: localize_var.adminUrl,
			data: {
				action: 'load_more_post_ajax',
				cpt: cpt,
				cptTax: cptTax,
				catID: catID,
				pageNumber: pageNumber,
			},
			success: function( data ) {

					var $data = $( data );

					if ( $.trim( data ) != '' && $.trim( data ) != 0 ) {

						$( '#filter-pagenum' ).val( parseInt( pageNumber ) + 1 );

						$( '#ajax-list-post' ).append( $data );

						$( '.spinner' ).removeClass( 'js-active' );

						if ( $data.length < 6 ) {
							$this.addClass( 'js-disabled' );
						} else {
							$this.removeClass( 'js-disabled' ).addClass( 'js-active' );
						}

					} else {
						$( '.spinner' ).removeClass( 'js-active' );
						$this.removeClass( 'js-active' ).addClass( 'js-disabled' );
					}

				} //success

		} ); //ajax
		return false;
	}


	/*====================================================
	=            Ajax filter post by dual cat            =
	====================================================*/
	$( '#ajax-first-list-post-categories a, #ajax-second-list-post-categories a' ).on( 'click', function( e ) {
		e.preventDefault();
		$( this ).parents( 'ul' ).find( 'li' ).removeClass( 'js-active' );
		$( this ).parent( 'li' ).addClass( 'js-active' );
		filter_post_by_dual_cat_trigger();
	} );

	$( '#ajax-first-select-post-categories, #ajax-second-select-post-categories' ).on( 'change', function( e ) {
		e.preventDefault();
		filter_post_by_dual_cat_trigger( true );
	} );

	function filter_post_by_dual_cat_trigger( select ) {

		if ( select === undefined ) {
	    select = false;
	  }

		var loadMoreBtn = $( '#ajax-load-more-post-dual' );

		loadMoreBtn.fadeOut( 400 );

		$( '#ajax-list-post' ).fadeOut( '400', function() {
			$( '.spinner' ).addClass( 'js-active' );
		} );

		if ( select == true ) {
			var firstSelectFilterCategory = $( '#ajax-first-select-post-categories' );
			var secondSelectFilterCategory = $( '#ajax-second-select-post-categories' );

			var cpt = firstSelectFilterCategory.find( ':selected' ).data( 'cpt' );
			var firstCptTax = firstSelectFilterCategory.find( ':selected' ).data( 'first-cpt-tax' );
			var firstCatID = firstSelectFilterCategory.find( ':selected' ).data( 'first-cat-id' );
			var secondCptTax = secondSelectFilterCategory.find( ':selected' ).data( 'second-cpt-tax' );
			var secondCatID = secondSelectFilterCategory.find( ':selected' ).data( 'second-cat-id' );
		}

		if ( select == false ) {
			var firstFilterCategory = $( '#ajax-first-list-post-categories' ).find( 'li.js-active a' );
			var secondFilterCategory = $( '#ajax-second-list-post-categories' ).find( 'li.js-active a' );

			var cpt = firstFilterCategory.attr( 'data-cpt' );
			var firstCptTax = firstFilterCategory.attr( 'data-first-cpt-tax' );
			var firstCatID = firstFilterCategory.attr( 'data-first-cat-id' );
			var secondCptTax = secondFilterCategory.attr( 'data-second-cpt-tax' );
			var secondCatID = secondFilterCategory.attr( 'data-second-cat-id' );
		}

		$( '#filter-first-cat-id' ).val( firstCatID );
		$( '#filter-second-cat-id' ).val( secondCatID );
		$( '#filter-pagenum' ).val( 1 );

		filter_post_by_dual_cat( cpt, firstCptTax, firstCatID, secondCptTax, secondCatID, loadMoreBtn );
	}

	function filter_post_by_dual_cat( cpt, firstCptTax, firstCatID, secondCptTax, secondCatID, loadMoreBtn ) {
		$.ajax( {
			type: 'POST',
			dataType: 'html',
			url: localize_var.adminUrl,
			data: {
				action: 'filter_post_by_dual_cat_ajax',
				cpt: cpt,
				firstCptTax: firstCptTax,
				firstCatID: firstCatID,
				secondCptTax: secondCptTax,
				secondCatID: secondCatID
			},
			success: function( data ) {
				var $data = $( data );
				if ( $.trim( data ) != '' && $.trim( data ) != 0 ) {

					$( '#ajax-list-post > li' ).remove();

					setTimeout( function() {
						$( '#ajax-list-post' ).append( $data );
						$( '.spinner' ).removeClass( 'js-active' );
						$( '#ajax-list-post' ).fadeIn( 400 );
						loadMoreBtn.fadeIn( 400 );
					}, 300 );

					if ( $data.length < 6 ) {
						loadMoreBtn.removeClass( 'js-active' ).addClass( 'js-disabled' );
					} else {
						loadMoreBtn.removeClass( 'js-disabled' ).addClass( 'js-active' );
					}

				}
			},
			error: function( request, status, error ) {
				alert( request.responseText );
			}
		} );
		return false;
	}


	/*===============================================
	=            Ajax load more Dual CPT            =
	===============================================*/
	$( '#ajax-load-more-post-dual' ).on( 'click', function( e ) {
		e.preventDefault();
		$( this ).removeClass( 'js-active' ).addClass( 'js-disabled' );
		$( '.spinner' ).addClass( 'js-active' );
		load_more_dual_cpt( $( this ) );
	} );

	function load_more_dual_cpt( $this ) {

		var cpt = $this.attr( 'data-cpt' );
		var firstCptTax = $this.attr( 'data-first-cpt-tax' );
		var firstCatID = $( '#filter-first-cat-id' ).val();
		var secondCptTax = $this.attr( 'data-second-cpt-tax' );
		var secondCatID = $( '#filter-second-cat-id' ).val();
		var pageNumber = $( '#filter-pagenum' ).val();

		$.ajax( {
			type: 'POST',
			dataType: 'html',
			url: localize_var.adminUrl,
			data: {
				action: 'load_more_dual_cpt_ajax',
				cpt: cpt,
				firstCptTax: firstCptTax,
				firstCatID: firstCatID,
				secondCptTax: secondCptTax,
				secondCatID: secondCatID,
				pageNumber: pageNumber,
			},
			success: function( data ) {

					var $data = $( data );

					if ( $.trim( data ) != '' && $.trim( data ) != 0 ) {

						$( '#filter-pagenum' ).val( parseInt( pageNumber ) + 1 );

						$( '#ajax-list-post' ).append( $data );

						$( '.spinner' ).removeClass( 'js-active' );

						if ( $data.length < 6 ) {
							$this.addClass( 'js-disabled' );
						} else {
							$this.removeClass( 'js-disabled' ).addClass( 'js-active' );
						}

					} else {
						$( '.spinner' ).removeClass( 'js-active' );
						$this.removeClass( 'js-active' ).addClass( 'js-disabled' );
					}

				} //success

		} ); //ajax
		return false;
	}


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
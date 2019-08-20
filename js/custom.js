jQuery( document ).ready( function( $ ) {;
/*=============================
=            Basic            =
=============================*/
// $( '.list-accordions .content-block' ).css( {
// 	'display': 'none'
// } ); // if loaded via ajax. Set this in css or toggleClass with css to hide it

// /* Works with Ajax loaded content */
$( '.list-accordions .content-block' ).css( {
	'display': 'none'
} );
$( 'body' ).on( 'click', '.list-accordions .heading', function( e ) {
	$( '.list-accordions li' ).removeClass( 'js-active' );
	$( '.list-accordions .content-block' ).slideUp( 'fast' );
	if ( $( this ).next().is( ':hidden' ) == true ) {
		$( this ).parent().addClass( 'js-active' );
		$( this ).next().slideDown( 'fast' );
	}
} );


/*=======================================
=            Invidual Toggle            =
=======================================*/
// $( '.list-accordions .content-block' ).css( {
// 	'display': 'none'
// } );

// $( '.list-accordions .heading' ).click( function() {
// 	if ( $( this ).next().is( ':hidden' ) == true ) {
// 		$( this ).addClass( 'js-active' );
// 		$( this ).next().slideDown( 100 );
// 	} else {
// 		$( this ).removeClass( 'js-active' );
// 		$( this ).next().slideUp( 100 );
// 	}
// } );

/*==================================================
=            Expand and Collapse button            =
==================================================*/
// $( ".accordion-toggle" ).click( function() {
// 	var txt = $( ".toggle-top" ).text();
// 	if ( txt == 'Expand All' ) {

// 		txt = 'Collapse All';
// 		$( '.list-accordions .heading' ).addClass( 'js-active' );
// 		$( '.list-accordions .content' ).slideDown( 100 );

// 	} else if ( txt == 'Collapse All' ) {

// 		txt = 'Expand All';
// 		$( '.list-accordions .heading' ).removeClass( 'js-active' );
// 		$( '.list-accordions .content' ).slideUp( 100 );

// 	}
// 	$( ".accordion-toggle" ).text( txt );
// } );


/*============================================
=            Open first accordion            =
============================================*/
// $( '.list-offices li:not(:first-child) .content-block' ).css( {
// 	'display': 'none'
// } );

// $( '.list-offices li:first-child .heading' ).addClass( 'js-active' );

// $( '.list-offices .heading' ).click( function() {
// 	$( '.list-offices .heading' ).removeClass( 'js-active' );
// 	$( '.list-offices .content-block' ).slideUp( 'fast' );
// 	if ( $( this ).next().is( ':hidden' ) == true ) {
// 		$( this ).addClass( 'js-active' );
// 		$( this ).next().slideDown( 'fast' )
// 	}
// } );;
var btnMorePost = $( '#ajax-more-post' );
var formSearchPost = $( '#ajax-search-post' );

/*======================================
=            Ajax More Post            =
======================================*/
btnMorePost.on( 'click', function( e ) {
	e.preventDefault();

	$( this ).addClass( 'btn-disabled' );
	$( '.loading-dots' ).addClass( 'js-active' );

	filter_post( $( this ), 'filter_more' );
} );


/*========================================
=            Ajax Search Post            =
========================================*/
formSearchPost.submit( function( e ) {
	e.preventDefault();

	$( '#ajax-submit-block' ).addClass( 'hidden' );
	$( '#alert-no-data').addClass('hide');
	$( '#ajax-search-clear' ).removeClass( 'js-active' );
	$( this ).find( '.loading-spinner' ).addClass( 'js-active' );

	$( '#ajax-list-post > li' ).remove();
	$( '.loading-dots' ).addClass( 'js-active' );
	btnMorePost.hide();

	var searchValue = formSearchPost.find( '.input-search' ).val();
	$( '#filter-search' ).val( searchValue );

	filter_post( $( this ), 'filter_search' );
} );


/*=========================================
=            Ajax Search Clear            =
=========================================*/
$( '#ajax-search-clear' ).click( function( e ) {
	e.preventDefault();

	$( '#alert-no-data').addClass('hide');

	formSearchPost.find( '.input-search' ).val( '' );
	$( '#filter-search' ).val( '' );

	formSearchPost.trigger( 'submit' );
} );


/*=======================================
=            Ajax Filter Cat            =
=======================================*/
$( '#ajax-filter-cat' ).on( 'change', function( e ) {
	e.preventDefault();

	$( '#alert-no-data').addClass('hide');
	$( '#ajax-list-post > li' ).remove();
	$( '.loading-dots' ).addClass( 'js-active' );
	btnMorePost.hide();

	var selectedCat = $( 'option:selected' ).data('term-id');
	$( '#filter-cat-id' ).val( selectedCat );

	filter_post( $( 'option:selected', this ), 'filter_cat' );
} );


/*========================================
=            Ajax Filter Post            =
========================================*/
function filter_post( $this, trigger ) {

	var cpt = $this.attr( 'data-cpt' );
	var cptTax = $this.attr( 'data-cpt-tax' );
	var catID = $( '#filter-cat-id' ).val();
	var authorID = $( '#filter-author-id' ).val();
	var tagID = $( '#filter-tag-id' ).val();
	var search = $( '#filter-search' ).val();

	if ( trigger == 'filter_search' || trigger == 'filter_cat' ) {

		// when user clicks load more, pagenum get sets to +1, so we need to reset it back to 1 to load first set of posts.
		$( '#filter-pagenum' ).val( 1 );
		// set page number variable empty
		var pageNumber = '';

	} else if ( trigger == 'filter_more' ) {

		var pageNumber = $( '#filter-pagenum' ).val();

	}

	$.ajax( {
		type: 'POST',
		dataType: 'html',
		url: localize_var.adminUrl,
		data: {
			action: 'filter_post_ajax',
			cpt: cpt,
			cptTax: cptTax,
			catID: catID,
			authorID: authorID,
			tagID: tagID,
			search: search,
			pageNumber: pageNumber,
		},
		success: function( data ) {

			var $data = $( data );

			if ( $.trim( data ) != '' && $.trim( data ) != 0 ) {

				$( '.loading-dots' ).removeClass( 'js-active' );

				/*----------- Filter More -----------*/
				if ( trigger == 'filter_more' ) {

					$( '#filter-pagenum' ).val( parseInt( pageNumber ) + 1 );

					$( '#ajax-list-post' ).append( $data );

					$( '.loading-dots' ).removeClass( 'js-active' );

				}

				/*----------  Filter Search  ----------*/
				if ( trigger == 'filter_search' ) {

					setTimeout( function() {
						if ( search != '' ) {
							$( '#ajax-search-clear' ).addClass( 'js-active' );
						} else {
							$( '#ajax-submit-block' ).removeClass( 'hidden' );
						}
						$( '.loading-spinner' ).removeClass( 'js-active' );
						$( '#ajax-list-post' ).append( $data );
						$( '#ajax-list-post' ).fadeIn( 400 );
						btnMorePost.fadeIn( 400 );
					}, 300 );

				}

				/*----------  Filter Cat  ----------*/
				if ( trigger == 'filter_cat' ) {

					$( '#ajax-list-post > li' ).remove();

					setTimeout( function() {
						$( '#ajax-list-post' ).append( $data );
						$( '#ajax-list-post' ).fadeIn( 400 );
						btnMorePost.fadeIn( 400 );
					}, 300 );

				}

				// console.log( $data.length );

				if ( $data.length < 6 ) {
					btnMorePost.addClass( 'btn-disabled' );
				} else {
					btnMorePost.removeClass( 'btn-disabled' );
				}

			}  else {

				if ( $( '.loading-spinner' ).hasClass('js-active') ) {
					$( '#ajax-search-clear' ).addClass( 'js-active' );
				}
				$( '.loading-spinner' ).removeClass( 'js-active' );
				$( '#alert-no-data').removeClass('hide');
				$( '.loading-dots' ).removeClass( 'js-active' );
				btnMorePost.hide();

			} // trim

		} //success

	} ); //ajax
	return false;
};
if ( Modernizr.cssanimations && Modernizr.mutationobserver ) {
  Visibility.onVisible(function () {
    AOS.init( {
			duration: 1000,
			useClassNames: true,
			initClassName: false,
			animatedClassName: 'animated',
			once: true,
		} );
  });
}

// You can also pass an optional settings object
// below listed default settings
// AOS.init({
//   // Global settings:
//   disable: false, // accepts following values: 'phone', 'tablet', 'mobile', boolean, expression or function
//   startEvent: 'DOMContentLoaded', // name of the event dispatched on the document, that AOS should initialize on
//   initClassName: 'aos-init', // class applied after initialization
//   animatedClassName: 'aos-animate', // class applied on animation
//   useClassNames: false, // if true, will add content of `data-aos` as classes on scroll
//   disableMutationObserver: false, // disables automatic mutations' detections (advanced)
//   debounceDelay: 50, // the delay on debounce used while resizing window (advanced)
//   throttleDelay: 99, // the delay on throttle used while scrolling the page (advanced)


//   // Settings that can be overridden on per-element basis, by `data-aos-*` attributes:
//   offset: 120, // offset (in px) from the original trigger point
//   delay: 0, // values from 0 to 3000, with step 50ms
//   duration: 400, // values from 0 to 3000, with step 50ms
//   easing: 'ease', // default easing for AOS animations
//   once: false, // whether animation should happen only once - while scrolling down
//   mirror: false, // whether elements should animate out while scrolling past them
//   anchorPlacement: 'top-bottom', // defines which position of the element regarding to window should trigger the animation

// });;
// if (Cookies.get('2016') != '1') {
//   Cookies.set('2016', '1', { expires: 1 });
// };
$( '.header__nav-toggle' ).click( function( e ) {
	$( this ).toggleClass( 'js-active' );
	$( '.header__nav' ).toggleClass( 'js-active' );
	e.preventDefault();
} );

$( '.header__nav-close' ).click( function( e ) {
	$( '.header__nav-toggle' ).toggleClass( 'js-active' );
	$( '.header__nav' ).toggleClass( 'js-active' );
	e.preventDefault();
} );

/* Add dropdown arrow for mobile parent menu */
$( '.header__nav__parent-menu > li.menu-item-has-children > a' ).append( '<span></span>' );
$( '.header__nav__parent-menu > li.menu-item-has-children > a span' ).on( 'click', function( e ) {
	e.preventDefault();
	$( this ).parent( 'a' ).siblings( '.sub-menu' ).toggleClass( 'js-active' );
} );;
$(".js-socials-share").jsSocials({
	shares: ["email", "twitter", "facebook", "googleplus", "linkedin", "pinterest"],
	showLabel: true,
	showCount: false,
	shareIn: "popup"
});

;
/*==============================================
=            Magnific Popup - Basic            =
==============================================*/
// $( '.popup-link' ).magnificPopup( {
// 	mainClass: 'mfp-fade'
// } );


/*====================================================
=            Manually Open Magnific Popup            =
====================================================*/
// $( '.trigger-form' ).on( 'click', function() {
// 	$.magnificPopup.open({
//     items: {
//       src: '.popup-block'
//     },
//     type: 'inline',
//     mainClass: 'mfp-zoom-in', // add class for animation
//     removalDelay: 500, // delay removal by X to allow out-animation
//   });
// } );



/*=======================================================
=            Open gallery from external link            =
=======================================================*/
// $( '.view-gallery' ).on( 'click', function() {
// 	$( '.gallery' ).magnificPopup( 'open' );
// 	// $(this).next().magnificPopup('open');
// } );


/*================================================
=            Magnific Popup - Gallery            =
================================================*/
// $( '.gallery-grid' ).magnificPopup( {
// 	delegate: 'a', // child items selector, by clicking on it popup will open
// 	type: 'image',
// 	gallery: {
// 		enabled: true,
// 		preload: [ 0, 1 ]
// 	},
// 	mainClass: 'mfp-zoom-in mfp-fade', // add class for animation
// 	removalDelay: 300, // delay removal by X to allow out-animation
// 	titleSrc: 'title', // custom function will nest inside image: {}
// 	callbacks: {
// 		imageLoadComplete: function() {
// 			var self = this;
// 			setTimeout( function() {
// 				self.wrap.addClass( 'mfp-image-loaded' );
// 			}, 16 );
// 		},
// 		close: function() {
// 			this.wrap.removeClass( 'mfp-image-loaded' );
// 		}
// 	}
// } );


/*==============================================
=            Magnific Popup - Video            =
==============================================*/
// $( '.popup-video' ).magnificPopup( {
// 	type: 'iframe',
// 	removalDelay: 300,
// 	mainClass: 'mfp-fade',
// 	fixedContentPos: false, // disable scrollbar
// iframe: {
//   patterns: {
//     youtube: {
//       index: 'youtube.com/', // String that detects type of video (in this case YouTube). Simply via url.indexOf(index).
//       id: 'v=', // String that splits URL in a two parts, second part should be %id%
//       // Or null - full URL will be returned
//       // Or a function that should return %id%, for example:
//       // id: function(url) { return 'parsed id'; }
//       src: '//www.youtube.com/embed/%id%?autoplay=1&rel=0' // URL that will be set as a source for iframe.
//     }
//     ,
//     vimeo: {
//       index: 'vimeo.com/',
//       id: '/',
//       src: '//player.vimeo.com/video/%id%?autoplay=1'
//     }
//   }
// }
// } );


/*====================================================
=            Magnific Popup - Members Bio            =
====================================================*/
// all the popup should have a same class
/*$( '.list-members' ).magnificPopup( {
	delegate: 'a',
	mainClass: 'mfp-move-from-top',
	removalDelay: 500, // delay removal by X to allow out-animation
	midClick: true,
	gallery: {
		enabled: true
	}
} );*/


/*====================================================
=            Open a popup after 2 seconds            =
====================================================*/
// setTimeout( function() {
// 	$.magnificPopup.open( {
// 		items: {
// 			src: '#subscribe-modal'
// 		},
// 		removalDelay: 300,
// 		mainClass: 'mfp-fade',
// 	} );
// }, 2000 );


/*====================================
=            Custom Title            =
====================================*/
// $( '.list-members' ).magnificPopup( {
// 	image: {
// 		titleSrc: function( item ) {
// 			return item.el.attr( 'title' ) + ' - <a href="' + item.el.parents( 'li' ).find( '.download-link' ).attr( 'href' ) + '">Download</a>';
// 		}
// 	}
// } );


/*=======================================================================
=            Next/Previous Arrows for gallery inside content            =
=======================================================================*/
// $( '.element' ).magnificPopup( {
// 	callbacks: {
// 		buildControls: function() {
// 			// re-appends controls inside the main container
// 			this.content.append( this.arrowLeft.add( this.arrowRight ) ); //content is predefined property. Check API
// 		}
// 	}
// } )


/*==============================================================================================
=            Open on load and custom close with cookie set - REQUIRES cookie plugin            =
==============================================================================================*/
// if ( $( 'body' ).hasClass( 'page-template-literature' ) ) {
// 	if ( Cookies.get( '2022' ) != '1' ) {
// 		$.magnificPopup.open( {
// 			items: {
// 				src: '#terms-modal'
// 			},
// 			removalDelay: 300,
// 			mainClass: 'mfp-fade terms-modal',
// 			closeOnBgClick: false,
// 			showCloseBtn: false,
// 			enableEscapeKey: false
// 		} );

// 		$( '.terms-modal .btn-accept' ).click( function( e ) {
// 			$.magnificPopup.close();
// 			Cookies.set( '2022', '1', {
// 				expires: 1
// 			} );
// 		} );
// 	}
// };



/*===================================
=            Simple Tabs            =
===================================*/
// $( '.list-tabs-trigger > li' ).click( function( e ) {
// 	$( '.list-tabs-trigger > li' ).removeClass( 'js-active' );
// 	$( this ).addClass( 'js-active' );
// 	var index = $( this ).index();
// 	$( '.list-tabs-content > li' ).removeClass( 'js-active' );
// 	$( '.list-tabs-content > li' ).eq( index ).addClass( 'js-active' );
// } );


/*===================================================
=            Simple Equal Height Columns            =
===================================================*/
// var equalHeight = debounce( function() {
// 	if ( $( this ).width() > 991 ) {

// 		var arColHeight = [];
// 		// store each height in array
// 		$( '.list-purchase-books li' ).each( function() {
// 			arColHeight.push( $( this ).find( '.desc-block' ).outerHeight() );
// 		} );
// 		// set height
// 		$( '.list-purchase-books .desc-block' ).height( Math.max.apply( Math, arColHeight ) );

// 	} else {

// 		$( '.list-purchase-books .desc-block' ).css('height','auto');

// 	}
// }, 200 );

// // run on page load
// equalHeight();
// // run on resize
// window.addEventListener( 'resize', equalHeight );
;
// ScrollReveal.debug = true; // can be used only with unminified code
// by default sreveal class has the fadeIn effect.

/* Set init options */
window.sr = ScrollReveal( {
	duration: 1000,
} );

/* Define custom animations */
var fadeInUp = { // it means fadeIn from Up
	origin: 'top',
	distance: '30px'
}

var fadeInDown = {
	origin: 'bottom',
	distance: '30px'
}

var fadeInRight = {
	origin: 'right',
	distance: '30px'
}

var fadeInLeft = {
	origin: 'left',
	distance: '30px'
}

var slideInUp = {
	origin: 'top',
	distance: '30px',
	opacity: null
}

var slideInDown = {
	origin: 'bottom',
	distance: '30px',
	opacity: null
}

var slideInRight = {
	origin: 'right',
	distance: '30px',
	opacity: null
}

var slideInLeft = {
	origin: 'left',
	distance: '30px',
	opacity: null
}

var zoomOut = {
	scale: '2',
}

/* Invoke stagger animation */
// sr.reveal( 'html.js.mutationobserver.cssanimations:not(.is-mobile) .list-partners > li', {
// 	origin: 'bottom',
// 	distance: '30px',
// 	interval: 100,
// } );

/* Invoke custom animations */
sr.reveal( '[data-sreveal="fadeIn"]' );
sr.reveal( '[data-sreveal="fadeInUp"]', fadeInUp );
sr.reveal( '[data-sreveal="fadeInDown"]', fadeInDown );
sr.reveal( '[data-sreveal="fadeInRight"]', fadeInRight );
sr.reveal( '[data-sreveal="fadeInLeft"]', fadeInLeft );
sr.reveal( '[data-sreveal="slideInUp"]', slideInUp );
sr.reveal( '[data-sreveal="slideInDown"]', slideInDown );
sr.reveal( '[data-sreveal="slideInRight"]', slideInRight );
sr.reveal( '[data-sreveal="slideInLeft"]', slideInLeft );
sr.reveal( '[data-sreveal="zoomOut"]', zoomOut );


/* Enable data-attributes */
$( '[data-sreveal]' ).each( function() {

	var el = $( this );

	// options can be used as postfix. For eg. data-sreveal-option.
	// option with two words should be separated using '-'. For eg. viewFactor can be written as data-sreveal-view-factor.
	var options = [ 'delay', 'distance', 'duration', 'easing', 'interval', 'opacity', 'origin', 'rotate', 'scale', 'desktop', 'mobile', 'reset', 'useDelay', 'viewFactor', 'viewOffset' ];

	var settings = {};
	var interval = 0;

	$( options ).each( function( index, element ) {

		if ( el.data( 'animation-' + options[ index ] ) ) {
			var option = options[ index ];
			settings[ option ] = el.data( 'animation-' + option );
		}

	} );

	sr.reveal( el, settings );
} );

/* Disable animation, if not mobile */
$( 'html.js.mutationobserver.cssanimations:not(.is-mobile) .sreveal' ).css( 'animation-name', 'none' );

sr.reveal( 'html.js.mutationobserver.cssanimations:not(.is-mobile) .sreveal', {
	opacity: null,
	duration: 0,
	beforeReveal: function( el ) {
		el.style.animationName = '';
		el.classList.add( 'animated' );
	},
	afterReveal: function( el ) {
		// el.classList.remove( 'animated' );
	}
} );



/* Default Values */
/*{
delay: 0,
distance: '0px', // %, px, em
duration: 600,
easing: 'cubic-bezier(0.5, 0, 0, 1)',
interval: 0, // is the time between each reveal.
opacity: 0,
origin: 'bottom',
rotate: {
		x: 0,
		y: 0,
		z: 0,
},
scale: 1,
cleanup: true,
container: document.documentElement,
desktop: true,
mobile: true, // we are using custom js to check the device and accordingly adding .is-mobile class and enable/disable the animation. No need to use this option. Edit css instead.
reset: false, //enables/disables elements returning to their initialized position when they leave the viewport. When true elements reveal each time they enter the viewport instead of once.
useDelay: 'always', // always, once, onload
viewFactor: 0.0, // specifies what portion of an element must be within the viewport for it to be considered visible.  range between 0.0 and 1.0
viewOffset: { // expands/contracts the active boundaries of the viewport when calculating element visibility. Accepts only number as pixels
		top: 0,
		right: 0,
		bottom: 0,
		left: 0,
},
afterReset: function (el) {},
afterReveal: function (el) {},
beforeReset: function (el) {},
beforeReveal: function (el) {},
}*/;
/*=============================================
=            General scroll to any            =
=============================================*/
$('.scroll-to').click(function(e) {
  e.preventDefault();
  $('html,body').animate({
    scrollTop: $(this.hash).offset().top
  }, 500 );
});

/*=====================================
=            Scroll to top            =
=====================================*/
var scrollToTop = debounce( function() {
	// if width is greater
	if ( $( this ).width() > 767 ) {
		// if scrollTop offset is greater
		if ( $( this ).scrollTop() > 200 ) {
			$( '.scroll-to-top' ).fadeIn( 200 );
		} else {
			$( '.scroll-to-top' ).fadeOut( 200 );
		}
	}
}, 200 );

// run on page load
scrollToTop();

// run on scroll
window.addEventListener( 'scroll', scrollToTop );;
/*----------  Fullscreen Slider  ----------*/
function fullscreenSlider() {
	$( '.fullscreen-slider' ).each( function() {

		$( this ).slick( {
			touchThreshold: 30,
			mobileFirst: true,
			speed: 500,
			dots: true,
			appendDots: $( this ).parent().find( '.slick-slider-dots' ),
		} );

		$( this ).on( 'beforeChange', function( event, slick, currentSlide, nextSlide ) {
			if ( $( this ).find( '.slick-slide:not(.slick-cloned)' ).eq( currentSlide ).find( 'video' ).length ) {
				$( this ).find( '.slick-slide:not(.slick-cloned)' ).eq( currentSlide ).find( 'video' )[ 0 ].currentTime = 0;
			}
			if ( $( this ).find( '.slick-slide:not(.slick-cloned)' ).eq( nextSlide ).find( 'video' ).length ) {
				$( this ).find( '.slick-slide:not(.slick-cloned)' ).eq( nextSlide ).find( 'video' )[ 0 ].currentTime = 0;
			}
		} );

		$( this ).on( 'afterChange', function( event, slick, currentSlide ) {
			if ( $( this ).find( '.slick-slide:not(.slick-cloned)' ).eq( currentSlide ).find( 'video' ).length ) {
				$( this ).find( '.slick-slide:not(.slick-cloned)' ).eq( currentSlide ).find( 'video' )[ 0 ].play();
			}
		} );

		// play the first video when the first slide comes inview.
		$( this ).one( 'inview', function( event, isInView ) {
			if ( isInView ) {
				if ( $( this ).find( '.slick-slide' ).eq( 0 ).find( 'video' ).length ) {
					$( this ).find( '.slick-slide' ).eq( 0 ).find( 'video' )[ 0 ].play();
				}
			}
		} );

	} );
}
fullscreenSlider();


/*----------  Post Cards Carousel  ----------*/
function postCardsCarousel() {
  $( '.post-cards-carousel' ).each( function() {
    $( this ).slick( {
      touchThreshold: 30,
      mobileFirst: true,
      speed: 500,
      slidesToShow: 1,
      slidesToScroll: 1,
      dots: true,
      appendDots: $( this ).parent('.container').siblings( '.slick-slider-dots' ),
      arrows: false,
      responsive: [ {
        breakpoint: 768,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
        }
      },
      {
        breakpoint: 992,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
        }
      },
        {
          breakpoint: 1500,
          settings: {
            slidesToShow: 4,
            slidesToScroll: 4,
          }
      } ]
    } );
  } );
}
postCardsCarousel();;
//
// SmoothScroll for websites v1.4.9 (Balazs Galambosi)
// https://github.com/gblazex/smoothscroll-for-websites
//
// Licensed under the terms of the MIT license.
//
// You may use it in your theme if you credit me.
// It is also free to use on any individual website.
//
// Exception:
// The only restriction is to not publish any
// extension for browsers or native application
// without getting a written permission first.
//

(function () {

// Scroll Variables (tweakable)
var defaultOptions = {

    // Scrolling Core
    frameRate        : 150, // [Hz]
    animationTime    : 400, // [ms]
    stepSize         : 100, // [px]

    // Pulse (less tweakable)
    // ratio of "tail" to "acceleration"
    pulseAlgorithm   : true,
    pulseScale       : 4,
    pulseNormalize   : 1,

    // Acceleration
    accelerationDelta : 50,  // 50
    accelerationMax   : 3,   // 3

    // Keyboard Settings
    keyboardSupport   : true,  // option
    arrowScroll       : 50,    // [px]

    // Other
    fixedBackground   : true,
    excluded          : ''
};

var options = defaultOptions;


// Other Variables
var isExcluded = false;
var isFrame = false;
var direction = { x: 0, y: 0 };
var initDone  = false;
var root = document.documentElement;
var activeElement;
var observer;
var refreshSize;
var deltaBuffer = [];
var deltaBufferTimer;
var isMac = /^Mac/.test(navigator.platform);

var key = { left: 37, up: 38, right: 39, down: 40, spacebar: 32,
            pageup: 33, pagedown: 34, end: 35, home: 36 };
var arrowKeys = { 37: 1, 38: 1, 39: 1, 40: 1 };

/***********************************************
 * INITIALIZE
 ***********************************************/

/**
 * Tests if smooth scrolling is allowed. Shuts down everything if not.
 */
function initTest() {
    if (options.keyboardSupport) {
        addEvent('keydown', keydown);
    }
}

/**
 * Sets up scrolls array, determines if frames are involved.
 */
function init() {

    if (initDone || !document.body) return;

    initDone = true;

    var body = document.body;
    var html = document.documentElement;
    var windowHeight = window.innerHeight;
    var scrollHeight = body.scrollHeight;

    // check compat mode for root element
    root = (document.compatMode.indexOf('CSS') >= 0) ? html : body;
    activeElement = body;

    initTest();

    // Checks if this script is running in a frame
    if (top != self) {
        isFrame = true;
    }

    /**
     * Safari 10 fixed it, Chrome fixed it in v45:
     * This fixes a bug where the areas left and right to
     * the content does not trigger the onmousewheel event
     * on some pages. e.g.: html, body { height: 100% }
     */
    else if (isOldSafari &&
             scrollHeight > windowHeight &&
            (body.offsetHeight <= windowHeight ||
             html.offsetHeight <= windowHeight)) {

        var fullPageElem = document.createElement('div');
        fullPageElem.style.cssText = 'position:absolute; z-index:-10000; ' +
                                     'top:0; left:0; right:0; height:' +
                                      root.scrollHeight + 'px';
        document.body.appendChild(fullPageElem);

        // DOM changed (throttled) to fix height
        var pendingRefresh;
        refreshSize = function () {
            if (pendingRefresh) return; // could also be: clearTimeout(pendingRefresh);
            pendingRefresh = setTimeout(function () {
                if (isExcluded) return; // could be running after cleanup
                fullPageElem.style.height = '0';
                fullPageElem.style.height = root.scrollHeight + 'px';
                pendingRefresh = null;
            }, 500); // act rarely to stay fast
        };

        setTimeout(refreshSize, 10);

        addEvent('resize', refreshSize);

        // TODO: attributeFilter?
        var config = {
            attributes: true,
            childList: true,
            characterData: false
            // subtree: true
        };

        observer = new MutationObserver(refreshSize);
        observer.observe(body, config);

        if (root.offsetHeight <= windowHeight) {
            var clearfix = document.createElement('div');
            clearfix.style.clear = 'both';
            body.appendChild(clearfix);
        }
    }

    // disable fixed background
    if (!options.fixedBackground && !isExcluded) {
        body.style.backgroundAttachment = 'scroll';
        html.style.backgroundAttachment = 'scroll';
    }
}

/**
 * Removes event listeners and other traces left on the page.
 */
function cleanup() {
    observer && observer.disconnect();
    removeEvent(wheelEvent, wheel);
    removeEvent('mousedown', mousedown);
    removeEvent('keydown', keydown);
    removeEvent('resize', refreshSize);
    removeEvent('load', init);
}


/************************************************
 * SCROLLING
 ************************************************/

var que = [];
var pending = false;
var lastScroll = Date.now();

/**
 * Pushes scroll actions to the scrolling queue.
 */
function scrollArray(elem, left, top) {

    directionCheck(left, top);

    if (options.accelerationMax != 1) {
        var now = Date.now();
        var elapsed = now - lastScroll;
        if (elapsed < options.accelerationDelta) {
            var factor = (1 + (50 / elapsed)) / 2;
            if (factor > 1) {
                factor = Math.min(factor, options.accelerationMax);
                left *= factor;
                top  *= factor;
            }
        }
        lastScroll = Date.now();
    }

    // push a scroll command
    que.push({
        x: left,
        y: top,
        lastX: (left < 0) ? 0.99 : -0.99,
        lastY: (top  < 0) ? 0.99 : -0.99,
        start: Date.now()
    });

    // don't act if there's a pending queue
    if (pending) {
        return;
    }

    var scrollRoot = getScrollRoot();
    var isWindowScroll = (elem === scrollRoot || elem === document.body);

    // if we haven't already fixed the behavior,
    // and it needs fixing for this sesh
    if (elem.$scrollBehavior == null && isScrollBehaviorSmooth(elem)) {
        elem.$scrollBehavior = elem.style.scrollBehavior;
        elem.style.scrollBehavior = 'auto';
    }

    var step = function (time) {

        var now = Date.now();
        var scrollX = 0;
        var scrollY = 0;

        for (var i = 0; i < que.length; i++) {

            var item = que[i];
            var elapsed  = now - item.start;
            var finished = (elapsed >= options.animationTime);

            // scroll position: [0, 1]
            var position = (finished) ? 1 : elapsed / options.animationTime;

            // easing [optional]
            if (options.pulseAlgorithm) {
                position = pulse(position);
            }

            // only need the difference
            var x = (item.x * position - item.lastX) >> 0;
            var y = (item.y * position - item.lastY) >> 0;

            // add this to the total scrolling
            scrollX += x;
            scrollY += y;

            // update last values
            item.lastX += x;
            item.lastY += y;

            // delete and step back if it's over
            if (finished) {
                que.splice(i, 1); i--;
            }
        }

        // scroll left and top
        if (isWindowScroll) {
            window.scrollBy(scrollX, scrollY);
        }
        else {
            if (scrollX) elem.scrollLeft += scrollX;
            if (scrollY) elem.scrollTop  += scrollY;
        }

        // clean up if there's nothing left to do
        if (!left && !top) {
            que = [];
        }

        if (que.length) {
            requestFrame(step, elem, (1000 / options.frameRate + 1));
        } else {
            pending = false;
            // restore default behavior at the end of scrolling sesh
            if (elem.$scrollBehavior != null) {
                elem.style.scrollBehavior = elem.$scrollBehavior;
                elem.$scrollBehavior = null;
            }
        }
    };

    // start a new queue of actions
    requestFrame(step, elem, 0);
    pending = true;
}


/***********************************************
 * EVENTS
 ***********************************************/

/**
 * Mouse wheel handler.
 * @param {Object} event
 */
function wheel(event) {

    if (!initDone) {
        init();
    }

    var target = event.target;

    // leave early if default action is prevented
    // or it's a zooming event with CTRL
    if (event.defaultPrevented || event.ctrlKey) {
        return true;
    }

    // leave embedded content alone (flash & pdf)
    if (isNodeName(activeElement, 'embed') ||
       (isNodeName(target, 'embed') && /\.pdf/i.test(target.src)) ||
        isNodeName(activeElement, 'object') ||
        target.shadowRoot) {
        return true;
    }

    var deltaX = -event.wheelDeltaX || event.deltaX || 0;
    var deltaY = -event.wheelDeltaY || event.deltaY || 0;

    if (isMac) {
        if (event.wheelDeltaX && isDivisible(event.wheelDeltaX, 120)) {
            deltaX = -120 * (event.wheelDeltaX / Math.abs(event.wheelDeltaX));
        }
        if (event.wheelDeltaY && isDivisible(event.wheelDeltaY, 120)) {
            deltaY = -120 * (event.wheelDeltaY / Math.abs(event.wheelDeltaY));
        }
    }

    // use wheelDelta if deltaX/Y is not available
    if (!deltaX && !deltaY) {
        deltaY = -event.wheelDelta || 0;
    }

    // line based scrolling (Firefox mostly)
    if (event.deltaMode === 1) {
        deltaX *= 40;
        deltaY *= 40;
    }

    var overflowing = overflowingAncestor(target);

    // nothing to do if there's no element that's scrollable
    if (!overflowing) {
        // except Chrome iframes seem to eat wheel events, which we need to
        // propagate up, if the iframe has nothing overflowing to scroll
        if (isFrame && isChrome)  {
            // change target to iframe element itself for the parent frame
            Object.defineProperty(event, "target", {value: window.frameElement});
            return parent.wheel(event);
        }
        return true;
    }

    // check if it's a touchpad scroll that should be ignored
    if (isTouchpad(deltaY)) {
        return true;
    }

    // scale by step size
    // delta is 120 most of the time
    // synaptics seems to send 1 sometimes
    if (Math.abs(deltaX) > 1.2) {
        deltaX *= options.stepSize / 120;
    }
    if (Math.abs(deltaY) > 1.2) {
        deltaY *= options.stepSize / 120;
    }

    scrollArray(overflowing, deltaX, deltaY);
    event.preventDefault();
    scheduleClearCache();
}

/**
 * Keydown event handler.
 * @param {Object} event
 */
function keydown(event) {

    var target   = event.target;
    var modifier = event.ctrlKey || event.altKey || event.metaKey ||
                  (event.shiftKey && event.keyCode !== key.spacebar);

    // our own tracked active element could've been removed from the DOM
    if (!document.body.contains(activeElement)) {
        activeElement = document.activeElement;
    }

    // do nothing if user is editing text
    // or using a modifier key (except shift)
    // or in a dropdown
    // or inside interactive elements
    var inputNodeNames = /^(textarea|select|embed|object)$/i;
    var buttonTypes = /^(button|submit|radio|checkbox|file|color|image)$/i;
    if ( event.defaultPrevented ||
         inputNodeNames.test(target.nodeName) ||
         isNodeName(target, 'input') && !buttonTypes.test(target.type) ||
         isNodeName(activeElement, 'video') ||
         isInsideYoutubeVideo(event) ||
         target.isContentEditable ||
         modifier ) {
      return true;
    }

    // [spacebar] should trigger button press, leave it alone
    if ((isNodeName(target, 'button') ||
         isNodeName(target, 'input') && buttonTypes.test(target.type)) &&
        event.keyCode === key.spacebar) {
      return true;
    }

    // [arrwow keys] on radio buttons should be left alone
    if (isNodeName(target, 'input') && target.type == 'radio' &&
        arrowKeys[event.keyCode])  {
      return true;
    }

    var shift, x = 0, y = 0;
    var overflowing = overflowingAncestor(activeElement);

    if (!overflowing) {
        // Chrome iframes seem to eat key events, which we need to
        // propagate up, if the iframe has nothing overflowing to scroll
        return (isFrame && isChrome) ? parent.keydown(event) : true;
    }

    var clientHeight = overflowing.clientHeight;

    if (overflowing == document.body) {
        clientHeight = window.innerHeight;
    }

    switch (event.keyCode) {
        case key.up:
            y = -options.arrowScroll;
            break;
        case key.down:
            y = options.arrowScroll;
            break;
        case key.spacebar: // (+ shift)
            shift = event.shiftKey ? 1 : -1;
            y = -shift * clientHeight * 0.9;
            break;
        case key.pageup:
            y = -clientHeight * 0.9;
            break;
        case key.pagedown:
            y = clientHeight * 0.9;
            break;
        case key.home:
            if (overflowing == document.body && document.scrollingElement)
                overflowing = document.scrollingElement;
            y = -overflowing.scrollTop;
            break;
        case key.end:
            var scroll = overflowing.scrollHeight - overflowing.scrollTop;
            var scrollRemaining = scroll - clientHeight;
            y = (scrollRemaining > 0) ? scrollRemaining + 10 : 0;
            break;
        case key.left:
            x = -options.arrowScroll;
            break;
        case key.right:
            x = options.arrowScroll;
            break;
        default:
            return true; // a key we don't care about
    }

    scrollArray(overflowing, x, y);
    event.preventDefault();
    scheduleClearCache();
}

/**
 * Mousedown event only for updating activeElement
 */
function mousedown(event) {
    activeElement = event.target;
}


/***********************************************
 * OVERFLOW
 ***********************************************/

var uniqueID = (function () {
    var i = 0;
    return function (el) {
        return el.uniqueID || (el.uniqueID = i++);
    };
})();

var cacheX = {}; // cleared out after a scrolling session
var cacheY = {}; // cleared out after a scrolling session
var clearCacheTimer;
var smoothBehaviorForElement = {};

//setInterval(function () { cache = {}; }, 10 * 1000);

function scheduleClearCache() {
    clearTimeout(clearCacheTimer);
    clearCacheTimer = setInterval(function () {
        cacheX = cacheY = smoothBehaviorForElement = {};
    }, 1*1000);
}

function setCache(elems, overflowing, x) {
    var cache = x ? cacheX : cacheY;
    for (var i = elems.length; i--;)
        cache[uniqueID(elems[i])] = overflowing;
    return overflowing;
}

function getCache(el, x) {
    return (x ? cacheX : cacheY)[uniqueID(el)];
}

//  (body)                (root)
//         | hidden | visible | scroll |  auto  |
// hidden  |   no   |    no   |   YES  |   YES  |
// visible |   no   |   YES   |   YES  |   YES  |
// scroll  |   no   |   YES   |   YES  |   YES  |
// auto    |   no   |   YES   |   YES  |   YES  |

function overflowingAncestor(el) {
    var elems = [];
    var body = document.body;
    var rootScrollHeight = root.scrollHeight;
    do {
        var cached = getCache(el, false);
        if (cached) {
            return setCache(elems, cached);
        }
        elems.push(el);
        if (rootScrollHeight === el.scrollHeight) {
            var topOverflowsNotHidden = overflowNotHidden(root) && overflowNotHidden(body);
            var isOverflowCSS = topOverflowsNotHidden || overflowAutoOrScroll(root);
            if (isFrame && isContentOverflowing(root) ||
               !isFrame && isOverflowCSS) {
                return setCache(elems, getScrollRoot());
            }
        } else if (isContentOverflowing(el) && overflowAutoOrScroll(el)) {
            return setCache(elems, el);
        }
    } while ((el = el.parentElement));
}

function isContentOverflowing(el) {
    return (el.clientHeight + 10 < el.scrollHeight);
}

// typically for <body> and <html>
function overflowNotHidden(el) {
    var overflow = getComputedStyle(el, '').getPropertyValue('overflow-y');
    return (overflow !== 'hidden');
}

// for all other elements
function overflowAutoOrScroll(el) {
    var overflow = getComputedStyle(el, '').getPropertyValue('overflow-y');
    return (overflow === 'scroll' || overflow === 'auto');
}

// for all other elements
function isScrollBehaviorSmooth(el) {
    var id = uniqueID(el);
    if (smoothBehaviorForElement[id] == null) {
        var scrollBehavior = getComputedStyle(el, '')['scroll-behavior'];
        smoothBehaviorForElement[id] = ('smooth' == scrollBehavior);
    }
    return smoothBehaviorForElement[id];
}


/***********************************************
 * HELPERS
 ***********************************************/

function addEvent(type, fn, arg) {
    window.addEventListener(type, fn, arg || false);
}

function removeEvent(type, fn, arg) {
    window.removeEventListener(type, fn, arg || false);
}

function isNodeName(el, tag) {
    return el && (el.nodeName||'').toLowerCase() === tag.toLowerCase();
}

function directionCheck(x, y) {
    x = (x > 0) ? 1 : -1;
    y = (y > 0) ? 1 : -1;
    if (direction.x !== x || direction.y !== y) {
        direction.x = x;
        direction.y = y;
        que = [];
        lastScroll = 0;
    }
}

if (window.localStorage && localStorage.SS_deltaBuffer) {
    try { // #46 Safari throws in private browsing for localStorage
        deltaBuffer = localStorage.SS_deltaBuffer.split(',');
    } catch (e) { }
}

function isTouchpad(deltaY) {
    if (!deltaY) return;
    if (!deltaBuffer.length) {
        deltaBuffer = [deltaY, deltaY, deltaY];
    }
    deltaY = Math.abs(deltaY);
    deltaBuffer.push(deltaY);
    deltaBuffer.shift();
    clearTimeout(deltaBufferTimer);
    deltaBufferTimer = setTimeout(function () {
        try { // #46 Safari throws in private browsing for localStorage
            localStorage.SS_deltaBuffer = deltaBuffer.join(',');
        } catch (e) { }
    }, 1000);
    var dpiScaledWheelDelta = deltaY > 120 && allDeltasDivisableBy(deltaY); // win64
    return !allDeltasDivisableBy(120) && !allDeltasDivisableBy(100) && !dpiScaledWheelDelta;
}

function isDivisible(n, divisor) {
    return (Math.floor(n / divisor) == n / divisor);
}

function allDeltasDivisableBy(divisor) {
    return (isDivisible(deltaBuffer[0], divisor) &&
            isDivisible(deltaBuffer[1], divisor) &&
            isDivisible(deltaBuffer[2], divisor));
}

function isInsideYoutubeVideo(event) {
    var elem = event.target;
    var isControl = false;
    if (document.URL.indexOf ('www.youtube.com/watch') != -1) {
        do {
            isControl = (elem.classList &&
                         elem.classList.contains('html5-video-controls'));
            if (isControl) break;
        } while ((elem = elem.parentNode));
    }
    return isControl;
}

var requestFrame = (function () {
      return (window.requestAnimationFrame       ||
              window.webkitRequestAnimationFrame ||
              window.mozRequestAnimationFrame    ||
              function (callback, element, delay) {
                 window.setTimeout(callback, delay || (1000/60));
             });
})();

var MutationObserver = (window.MutationObserver ||
                        window.WebKitMutationObserver ||
                        window.MozMutationObserver);

var getScrollRoot = (function() {
  var SCROLL_ROOT = document.scrollingElement;
  return function() {
    if (!SCROLL_ROOT) {
      var dummy = document.createElement('div');
      dummy.style.cssText = 'height:10000px;width:1px;';
      document.body.appendChild(dummy);
      var bodyScrollTop  = document.body.scrollTop;
      var docElScrollTop = document.documentElement.scrollTop;
      window.scrollBy(0, 3);
      if (document.body.scrollTop != bodyScrollTop)
        (SCROLL_ROOT = document.body);
      else
        (SCROLL_ROOT = document.documentElement);
      window.scrollBy(0, -3);
      document.body.removeChild(dummy);
    }
    return SCROLL_ROOT;
  };
})();


/***********************************************
 * PULSE (by Michael Herf)
 ***********************************************/

/**
 * Viscous fluid with a pulse for part and decay for the rest.
 * - Applies a fixed force over an interval (a damped acceleration), and
 * - Lets the exponential bleed away the velocity over a longer interval
 * - Michael Herf, http://stereopsis.com/stopping/
 */
function pulse_(x) {
    var val, start, expx;
    // test
    x = x * options.pulseScale;
    if (x < 1) { // acceleartion
        val = x - (1 - Math.exp(-x));
    } else {     // tail
        // the previous animation ended here:
        start = Math.exp(-1);
        // simple viscous drag
        x -= 1;
        expx = 1 - Math.exp(-x);
        val = start + (expx * (1 - start));
    }
    return val * options.pulseNormalize;
}

function pulse(x) {
    if (x >= 1) return 1;
    if (x <= 0) return 0;

    if (options.pulseNormalize == 1) {
        options.pulseNormalize /= pulse_(1);
    }
    return pulse_(x);
}


/***********************************************
 * FIRST RUN
 ***********************************************/

var userAgent = window.navigator.userAgent;
var isEdge    = /Edge/.test(userAgent); // thank you MS
var isChrome  = /chrome/i.test(userAgent) && !isEdge;
var isSafari  = /safari/i.test(userAgent) && !isEdge;
var isMobile  = /mobile/i.test(userAgent);
var isIEWin7  = /Windows NT 6.1/i.test(userAgent) && /rv:11/i.test(userAgent);
var isOldSafari = isSafari && (/Version\/8/i.test(userAgent) || /Version\/9/i.test(userAgent));
var isEnabledForBrowser = (isChrome || isSafari || isIEWin7) && !isMobile;

var supportsPassive = false;
try {
  window.addEventListener("test", null, Object.defineProperty({}, 'passive', {
    get: function () {
            supportsPassive = true;
        }
    }));
} catch(e) {}

var wheelOpt = supportsPassive ? { passive: false } : false;
var wheelEvent = 'onwheel' in document.createElement('div') ? 'wheel' : 'mousewheel';

if (wheelEvent && isEnabledForBrowser) {
    addEvent(wheelEvent, wheel, wheelOpt);
    addEvent('mousedown', mousedown);
    addEvent('load', init);
}


/***********************************************
 * PUBLIC INTERFACE
 ***********************************************/

function SmoothScroll(optionsToSet) {
    for (var key in optionsToSet)
        if (defaultOptions.hasOwnProperty(key))
            options[key] = optionsToSet[key];
}
SmoothScroll.destroy = cleanup;

if (window.SmoothScrollOptions) // async API
    SmoothScroll(window.SmoothScrollOptions);

if (typeof define === 'function' && define.amd)
    define(function() {
        return SmoothScroll;
    });
else if ('object' == typeof exports)
    module.exports = SmoothScroll;
else
    window.SmoothScroll = SmoothScroll;

})();;
// function stickyEl() {
//   if ( window.innerWidth > 767 ) {
//     $( "#sticky-nav-bar" ).sticky({
//     	topSpacing: 0
//     });
//   } else {
//     $("#sticky-nav-bar").unstick();
//   }
// }
// stickyEl();
// window.addEventListener( 'resize', stickyEl() );;
// $('.sticky-sidebar').stick_in_parent({
// 	offset_top: topSpacing + 30,
// 	spacer: false // disable disappearing sticky element when reach bottom
// });


// /*============================
// =            SMHS            =
// ============================*/
// /* Sticky Sidebar */
// var stickyEl = function stickyEl() {
//   var $topSpacing = '';
//   if ( window.innerWidth < 1051 ) {
//     $topSpacing = $('.mobile-header').outerHeight();
//   } else if ( window.innerWidth > 1050 ) {
//     $topSpacing = $('.header-primary-menu-section').outerHeight() + $('.header-secondary-menu-section').outerHeight();
//   }
//   if ( window.innerWidth > 767 ) {
//     $(".sticky-sidebar").trigger("sticky_kit:detach");
//     $('.sticky-sidebar').stick_in_parent({
//       offset_top: $topSpacing + 30,
//       spacer: false
//     });
//   }
// }
// stickyEl();
// window.addEventListener( 'resize', debounce(stickyEl, 200) );



// ============================
// =            LDVA            =
// ============================
// var stickyEl = function stickyEl() {
//   var topSpacing = headerHeight + $('#sections-menu-bar').outerHeight(); //margin
//   if ( window.innerWidth > 767 ) {
//     $("#img-stick-right").stick_in_parent({
//       offset_top: topSpacing
//     });

//     $("#img-stick-right").stick_in_parent()
//       .on("sticky_kit:stick", function(e) {
//         $(this).addClass('is-sticky');
//       })
//       .on("sticky_kit:unstick", function(e) {
//         $(this).removeClass('is-sticky');
//       })
//       .on("sticky_kit:bottom", function(e) {
//         $(this).removeClass('unbottom-out is-sticky').addClass('bottom-out');
//       })
//       .on("sticky_kit:unbottom", function(e) {
//         $(this).removeClass('bottom-out').addClass('unbottom-out is-sticky');
//       });

//     $('.sticky-sidebar').stick_in_parent({
//       offset_top: topSpacing + 30
//     });
//   }
// }
// stickyEl();
// window.addEventListener( 'resize', debounce(stickyEl, 200) );
;
} ); // Document Ready


/*=================================
=            Buggyfill            =
=================================*/
/* Polyfill for vh,vw units on iphone4,5 */
window.viewportUnitsBuggyfill.init( {
	refreshDebounceWait: 50,
	hacks: window.viewportUnitsBuggyfillHacks
} );
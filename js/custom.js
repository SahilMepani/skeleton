// Media queries constant
const smMQ = window.matchMedia( '(min-width: 575px)' );
const mdMQ = window.matchMedia( '(min-width: 768px)' );
const lgMQ = window.matchMedia( '(min-width: 992px)' );
const xlMQ = window.matchMedia( '(min-width: 1200px)' );
const xxlMQ = window.matchMedia( '(min-width: 1400px)' );
const xxxlMQ = window.matchMedia( '(min-width: 1600px)' );


/*=================================
=            UA Parser            =
=================================*/
// https://github.com/faisalman/ua-parser-js
var parser = new UAParser();
var result = parser.getResult();
console.log( result.browser.name );
console.log( parseInt( result.browser.version.split( '.' )[ 0 ], 10 ) );
console.log( result.device.type );
console.log( result.os.name );
console.log( result.os.version );


jQuery( document ).ready( function( $ ) {;
var btnMorePost = $( '#ajax-more-post' );
var formSearchPost = $( '#ajax-search-post' );

// Load More Post
////////////////////////////////////////////////
btnMorePost.on( 'click', function( e ) {
  e.preventDefault();

  // disable load more button
  btnMorePost.addClass( 'btn-disabled' );

  update_post( $( this ), 'filter_more' );
} );


// Filter Search Post
////////////////////////////////////////////////
formSearchPost.submit( function( e ) {
  e.preventDefault();

  // remove search icon
  $( '#ajax-submit-block' ).addClass( 'd-none' );
  // remove close icon
  $( '#ajax-search-clear' ).removeClass( 'js-active' );
  // show spinner inside input
  $( this ).find( '.loading-spinner' ).addClass( 'js-active' );

  // save the search value in hidden input
  var searchValue = formSearchPost.find( '.input-search' ).val();
  $( '#filter-search' ).val( searchValue );

  update_post( $( this ), 'filter_search' );
} );


// Clear Search Post
////////////////////////////////////////////////
$( '#ajax-search-clear' ).click( function( e ) {
  e.preventDefault();

  // clear input value
  formSearchPost.find( '.input-search' ).val( '' );
  // remove value from hidden input
  $( '#filter-search' ).val( '' );
  // submit the form
  formSearchPost.trigger( 'submit' );
} );


// Filter Categories Post
////////////////////////////////////////////////
$( '#ajax-filter-cat' ).on( 'change', function( e ) {
  e.preventDefault();

  // save the value in hidden input
  var selectedCat = $( 'option:selected' ).data( 'term' );
  $( '#filter-term' ).val( selectedCat );

  update_post( $( 'option:selected', this ), 'filter_term' );
} );


// Update Post
////////////////////////////////////////////////
function update_post( $this, trigger ) {

  // remove no data heading
  $( '#alert-no-data' ).addClass( 'd-none' );
  // show loading dots
  $( '.loading-dots' ).addClass( 'js-active' );

  if ( trigger == 'filter_search' || trigger == 'filter_term' ) {

    // hide the load more button
    btnMorePost.hide();
    // remove the list items
    $( '#ajax-list-post > li' ).fadeOut( 400, function () {
      $( '#ajax-list-post > li' ).remove();
    } );

    $( '#filter-pagenum' ).val( 1 ); // when user clicks load more, pagenum get sets to +1, so we need to reset it back to 1 to load first set of posts.

    var pageNumber = '';

  }

  if ( trigger == 'filter_more' ) {
    var pageNumber = $( '#filter-pagenum' ).val();
  }

  var cpt             = $this.data( 'cpt' );
  var tax             = $this.data( 'tax' );
  var term            = $( '#filter-term' ).val();
  var authorID        = $( '#filter-author-id' ).val();
  var tagID           = $( '#filter-tag-id' ).val();
  var search          = $( '#filter-search' ).val();
  var pageNumber      = $( '#filter-pagenum' ).val();
  var totalPostCount  = $( '#filter-total-post-count' ).val();
  var postsPerPage    = $( '#filter-posts-per-page' ).val();
  var unseenPostCount = $( '#filter-unseen-post-count' ).val();

  $.ajax( {
    type: 'POST',
    dataType: 'html',
    url: localize_var.ajax_url,
    data: {
      action       : 'update_post_ajax',
      cpt          : cpt,
      tax          : tax,
      term         : term,
      authorID     : authorID,
      tagID        : tagID,
      search       : search,
      pageNumber   : pageNumber,
      postsPerPage : postsPerPage,
    },
    success: function( data ) {

      var $data = $( data );

      if ( $.trim( data ) != '' && $.trim( data ) != 0 ) {

        $( '.loading-dots' ).removeClass( 'js-active' );

        /*----------- Filter More -----------*/
        if ( trigger == 'filter_more' ) {

          unseenPostCount = unseenPostCount - $data.length;

          $( '#filter-pagenum' ).val( parseInt( pageNumber ) + 1 );
          $( '#filter-unseen-post-count' ).val( unseenPostCount );

          $( '#ajax-list-post' ).append( $data );

          // scroll to newly appended data object
          $( 'html,body' ).animate( {
            scrollTop: $( $data ).offset().top
          }, 100 );

        }

        /*----------  Filter Search  ----------*/
        if ( trigger == 'filter_search' ) {

          setTimeout( function() {
            if ( search != '' ) {
              $( '#ajax-search-clear' ).addClass( 'js-active' );
            } else {
              $( '#ajax-submit-block' ).removeClass( 'd-none' );
            }
            $( '.loading-spinner' ).removeClass( 'js-active' );
            $( '#ajax-list-post' ).append( $data );
            $( '#ajax-list-post' ).fadeIn( 400 );
            btnMorePost.fadeIn( 400 );
          }, 300 );

        }

        /*----------  Filter Cat  ----------*/
        if ( trigger == 'filter_term' ) {

          $( '#ajax-list-post > li' ).remove();

          setTimeout( function() {
            $( '#ajax-list-post' ).append( $data );
            $( '#ajax-list-post' ).fadeIn( 400 );
            btnMorePost.fadeIn( 400 );
          }, 300 );

        }

        // console.log( $data.length );

        if ( unseenPostCount ) {
          btnMorePost.removeClass( 'btn-disabled' );
        }

      } else {

        if ( $( '.loading-spinner' ).hasClass( 'js-active' ) ) {
          $( '#ajax-search-clear' ).addClass( 'js-active' );
        }
        $( '.loading-spinner' ).removeClass( 'js-active' );
        $( '#alert-no-data' ).removeClass( 'd-none' );
        $( '.loading-dots' ).removeClass( 'js-active' );
        btnMorePost.hide();

      } // trim

    } //success

  } ); //ajax
  return false;
};
if ( Modernizr.cssanimations && Modernizr.mutationobserver ) {
  Visibility.onVisible( function() {
    AOS.init( {
      offset: 120,
      duration: 1000,
      useClassNames: true,
      initClassName: false,
      animatedClassName: 'animated',
      once: true,
    } );
  } );
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
$( '.mobile-header-nav-toggle' ).click( function ( e ) {
  $( this ).toggleClass( 'js-active' );
  $( '.mobile-header-nav' ).toggleClass( 'js-active' );
  $( 'body' ).toggleClass( 'js-popup-active' );
  e.preventDefault();
} );

$( '.header-nav-close' ).click( function( e ) {
  $( '.header-nav-toggle' ).toggleClass( 'js-active' );
  $( '.header-nav' ).toggleClass( 'js-active' );
  $( 'body' ).removeClass( 'js-popup-active' );
  e.preventDefault();
} );

/* Add dropdown arrow for mobile parent menu */
$( '.header-nav-parent-menu > li.menu-item-has-children > a' ).append( '<span></span>' );
$( '.header-nav-parent-menu > li.menu-item-has-children > a span' ).on( 'click', function( e ) {
  e.preventDefault();
  $( this ).parent( 'a' ).siblings( '.sub-menu' ).toggleClass( 'js-active' );
} );;
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
      // Or null - full URL will be returned
      // Or a function that should return %id%, for example:
      // id: function(url) { return 'parsed id'; }
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
// window.addEventListener( 'resize', equalHeight );;
/*=============================================
=            General scroll to any            =
=============================================*/
$( '.scroll-to' ).click( function( e ) {
  e.preventDefault();
  $( 'html,body' ).animate( {
    scrollTop: $( this.hash ).offset().top
  }, 500 );
} );

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
      appendDots: $( this ).parent( '.container' ).siblings( '.slick-slider-dots' ),
      arrows: false,
      responsive: [ {
          breakpoint: 767,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
          }
      },
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
          }
      },
        {
          breakpoint: 1499,
          settings: {
            slidesToShow: 4,
            slidesToScroll: 4,
          }
      } ]
    } );
  } );
}
postCardsCarousel();

// Initialize dynamic block preview (backend editor).
// if ( window.acf ) {
//   window.acf.addAction( 'render_block_preview', fullscreenSlider );
//   window.acf.addAction( 'render_block_preview', postCardsCarousel );
// };
} ); // Document Ready


/*=================================
=            Buggyfill            =
=================================*/
/* Polyfill for vh,vw units on iphone4,5 */
window.viewportUnitsBuggyfill.init( {
  refreshDebounceWait: 50,
  hacks: window.viewportUnitsBuggyfillHacks
} );
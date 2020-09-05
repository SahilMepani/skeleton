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
  $( '#alert-no-data' ).addClass( 'hide' );
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

  $( '#alert-no-data' ).addClass( 'hide' );

  formSearchPost.find( '.input-search' ).val( '' );
  $( '#filter-search' ).val( '' );

  formSearchPost.trigger( 'submit' );
} );


/*=======================================
=            Ajax Filter Cat            =
=======================================*/
$( '#ajax-filter-cat' ).on( 'change', function( e ) {
  e.preventDefault();

  $( '#alert-no-data' ).addClass( 'hide' );
  $( '#ajax-list-post > li' ).remove();
  $( '.loading-dots' ).addClass( 'js-active' );
  btnMorePost.hide();

  var selectedCat = $( 'option:selected' ).data( 'term-id' );
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

      } else {

        if ( $( '.loading-spinner' ).hasClass( 'js-active' ) ) {
          $( '#ajax-search-clear' ).addClass( 'js-active' );
        }
        $( '.loading-spinner' ).removeClass( 'js-active' );
        $( '#alert-no-data' ).removeClass( 'hide' );
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
$( '.header-nav-toggle' ).click( function( e ) {
  $( this ).toggleClass( 'js-active' );
  $( '.header-nav' ).toggleClass( 'js-active' );
  e.preventDefault();
} );

$( '.header-nav-close' ).click( function( e ) {
  $( '.header-nav-toggle' ).toggleClass( 'js-active' );
  $( '.header-nav' ).toggleClass( 'js-active' );
  e.preventDefault();
} );

/* Add dropdown arrow for mobile parent menu */
$( '.header-nav-parent-menu > li.menu-item-has-children > a' ).append( '<span></span>' );
$( '.header-nav-parent-menu > li.menu-item-has-children > a span' ).on( 'click', function( e ) {
  e.preventDefault();
  $( this ).parent( 'a' ).siblings( '.sub-menu' ).toggleClass( 'js-active' );
} );;
// https://www.jacklmoore.com/notes/naturalwidth-and-naturalheight-in-ie/
// adds .naturalWidth() and .naturalHeight() methods to jQuery
// for retreaving a normalized naturalWidth and naturalHeight.
( function ( $ ) {
  var
    props = [ 'Width', 'Height' ],
    prop;

  while ( prop = props.pop() ) {
    ( function ( natural, prop ) {
      $.fn[ natural ] = ( natural in new Image() ) ?
        function () {
          return this[ 0 ][ natural ];
        } :
        function () {
          var
            node = this[ 0 ],
            img,
            value;

          if ( node.tagName.toLowerCase() === 'img' ) {
            img = new Image();
            img.src = node.src,
              value = img[ prop ];
          }
          return value;
        };
    }( 'natural' + prop, prop.toLowerCase() ) );
  }
}( jQuery ) );


// Custom
var imgCover = debounce( function () {
  $( '.img-cover' ).each( function () {

    var img = $( this );
    var imgParent = $( this ).parents( '.img-cover-parent' );
    var imgAspectRatio       = img.naturalWidth() / img.naturalHeight();
    var imgParentAspectRatio = imgParent.outerWidth() / imgParent.outerHeight();

    if ( imgAspectRatio >= imgParentAspectRatio ) {
      img.removeClass( 'img-cover-w' ).addClass( 'img-cover-h' );
    } else {
      img.removeClass( 'img-cover-h' ).addClass( 'img-cover-w' );
    }

  } )
}, 200 );
window.addEventListener( 'resize', imgCover );
imgCover();;
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
postCardsCarousel();;
} ); // Document Ready


/*=================================
=            Buggyfill            =
=================================*/
/* Polyfill for vh,vw units on iphone4,5 */
window.viewportUnitsBuggyfill.init( {
  refreshDebounceWait: 50,
  hacks: window.viewportUnitsBuggyfillHacks
} );
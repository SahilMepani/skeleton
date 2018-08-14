jQuery( document ).ready( function( $ ) {;
/*=============================
=            Basic            =
=============================*/
// $( '.list-accordions .content-block' ).css( {
// 	'display': 'none'
// } ); // if loaded via ajax. Set this in css or toggleClass with css to hide it

// /* Works with Ajax loaded content */
// $( '.list-accordions .content-block' ).css( {
// 	'display': 'none'
// } );
// $( 'body' ).on( 'click', '.list-accordions .heading', function( e ) {
// 	$( '.list-accordions li' ).removeClass( 'js-active' );
// 	$( '.list-accordions .content-block' ).slideUp( 'fast' );
// 	if ( $( this ).next().is( ':hidden' ) == true ) {
// 		$( this ).parent().addClass( 'js-active' );
// 		$( this ).next().slideDown( 'fast' );
// 	}
// } );


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
// if (Cookies.get('2016') != '1') {
//   Cookies.set('2016', '1', { expires: 1 });
// };
$( '.header__menu-toggle' ).click( function( e ) {
	$( this ).toggleClass( 'js-active' );
	$( '.header__menu' ).toggleClass( 'js-active' );
	e.preventDefault();
} );

$( '.header__menu-close' ).click( function( e ) {
	$( '.header__menu-toggle' ).toggleClass( 'js-active' );
	$( '.header__menu' ).toggleClass( 'js-active' );
	e.preventDefault();
} );

/* Add dropdown arrow for mobile parent menu */
$( '.header__menu__parent-menu > li.menu-item-has-children > a' ).append( '<span></span>' );
$( '.header__menu__parent-menu > li.menu-item-has-children > a span' ).on( 'click', function( e ) {
	e.preventDefault();
	$( this ).parent( 'a' ).siblings( '.sub-menu' ).toggleClass( 'js-active' );
} );;
$(".js-socials-share").jsSocials({
	shares: ["email", "twitter", "facebook", "googleplus", "linkedin", "pinterest"],
	showLabel: true,
	showCount: false,
	shareIn: "popup"
});;
/*==============================================
=            Magnific Popup - Basic            =
==============================================*/
// $( '.popup-link' ).magnificPopup( {
// 	mainClass: 'mfp-fade'
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
// 	fixedContentPos: false // disable scrollbar
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
;
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
Visibility.onVisible( function() {
	var wow = new WOW().init();
} );;
} ); // Document Ready


/*=================================
=            Buggyfill            =
=================================*/
/* Polyfill for vh,vw units on iphone4,5 */
window.viewportUnitsBuggyfill.init( {
	refreshDebounceWait: 50,
	hacks: window.viewportUnitsBuggyfillHacks
} );
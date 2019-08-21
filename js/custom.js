jQuery( document ).ready( function( $ ) {;
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
} ); // Document Ready


/*=================================
=            Buggyfill            =
=================================*/
/* Polyfill for vh,vw units on iphone4,5 */
window.viewportUnitsBuggyfill.init( {
	refreshDebounceWait: 50,
	hacks: window.viewportUnitsBuggyfillHacks
} );
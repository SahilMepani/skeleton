/*=================================
=            UA Parser            =
=================================*/
// https://github.com/faisalman/ua-parser-js
var parser = new UAParser();
var result = parser.getResult();
console.log(result.browser.name);
console.log(parseInt(result.browser.version.split('.')[0], 10));
console.log(result.device.type);
console.log(result.os.name);
console.log(result.os.version);


jQuery( document ).ready( function( $ ) {;
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
} ); // Document Ready


/*=================================
=            Buggyfill            =
=================================*/
/* Polyfill for vh,vw units on iphone4,5 */
window.viewportUnitsBuggyfill.init( {
	refreshDebounceWait: 50,
	hacks: window.viewportUnitsBuggyfillHacks
} );
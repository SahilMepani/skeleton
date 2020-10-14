// Media queries constant
const smMQ   = window.matchMedia( '(min-width: 575px)' );
const mdMQ   = window.matchMedia( '(min-width: 768px)' );
const lgMQ   = window.matchMedia( '(min-width: 992px)' );
const xlMQ   = window.matchMedia( '(min-width: 1200px)' );
const xxlMQ  = window.matchMedia( '(min-width: 1400px)' );
const xxxlMQ = window.matchMedia( '(min-width: 1600px)' );

jQuery( document ).ready( function( $ ) {;
} ); // Document Ready


/*=================================
=            Buggyfill            =
=================================*/
/* Polyfill for vh,vw units on iphone4,5 */
window.viewportUnitsBuggyfill.init( {
  refreshDebounceWait: 50,
  hacks: window.viewportUnitsBuggyfillHacks
} );
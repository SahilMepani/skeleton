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


jQuery( document ).ready( function( $ ) {
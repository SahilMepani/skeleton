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


jQuery( document ).ready( function( $ ) {
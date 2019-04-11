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
}*/
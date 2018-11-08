jQuery( document ).ready( function( $ ) {

	// ScrollReveal.debug = true; // can be used only with unminified code
	// by default sreveal class has the fadeIn effect.

	var fadeInUp = {
		origin: 'bottom',
		distance: '30px'
	}

	var fadeInDown = {
		origin: 'top',
		distance: '30px'
	}

	var fadeInRight = {
		origin: 'left',
		distance: '30px'
	}

	var fadeInLeft = {
		origin: 'right',
		distance: '30px'
	}

	var slideInUp = {
		origin: 'bottom',
		distance: '30px',
		opacity: null
	}

	var slideInDown = {
		origin: 'top',
		distance: '30px',
		opacity: null
	}

	var slideInRight = {
		origin: 'left',
		distance: '30px',
		opacity: null
	}

	var slideInLeft = {
		origin: 'right',
		distance: '30px',
		opacity: null
	}

	var zoomOut = {
		scale: '2',
	}

	window.sr = ScrollReveal({
		duration: 1000,
		mobile: false,
	});

	// sr.reveal( '.list-partners > li', {
	// 	origin: 'bottom',
	// 	distance: '30px',
	// 	interval: 100,
	// } );

	sr.reveal( '[data-animation="fadeIn"]' );
	sr.reveal( '[data-animation="fadeInUp"]', fadeInUp );
	sr.reveal( '[data-animation="fadeInDown"]', fadeInDown );
	sr.reveal( '[data-animation="fadeInRight"]', fadeInRight );
	sr.reveal( '[data-animation="fadeInLeft"]', fadeInLeft );
	sr.reveal( '[data-animation="slideInUp"]', slideInUp );
	sr.reveal( '[data-animation="slideInDown"]', slideInDown );
	sr.reveal( '[data-animation="slideInRight"]', slideInRight );
	sr.reveal( '[data-animation="slideInLeft"]', slideInLeft );
	sr.reveal( '[data-animation="zoomOut"]', zoomOut );


	$( '[data-animation]' ).each( function() {

		var el = $(this);

		var options = ['delay', 'distance', 'duration', 'easing', 'interval', 'opacity', 'origin', 'rotate', 'scale', 'desktop', 'mobile', 'reset', 'useDelay', 'viewFactor', 'viewOffset'];

		var settings = {};
		var interval = 0;

		$( options ).each( function(index, element) {

			if ( el.data( 'animation-' + options[index] ) ) {
				var option = options[index];
				settings[option] = el.data( 'animation-' + option );
			}

		});

		sr.reveal( el, settings );
	} );

	$('.sreveal').css('animation-name', 'none');

	sr.reveal( '.sreveal', {
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

} ); // Document Ready



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
	mobile: true,
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
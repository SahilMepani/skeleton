// ScrollReveal.debug = true; // can be used only with unminified code
// by default sreveal class has the fade effect.

/* Set init options */
window.sr = ScrollReveal({
	// set defaults
	duration: 1000,
	easing: 'ease',
	distance: '50px',
	delay: 200,
	beforeReveal: function (el) {
		el.style.animationName = '';
		el.classList.add('sreveal-in-view');
	}
});

/* Define custom animations */
var fade = {
	distance: 0
};

var fadeUp = {
	// it means fade from Up
	origin: 'bottom'
};

var fadeDown = {
	origin: 'top'
};

var fadeRight = {
	origin: 'left'
};

var fadeLeft = {
	origin: 'right'
};

var slideUp = {
	origin: 'bottom',
	opacity: null
};

var slideUpFull = {
	origin: 'bottom',
	distance: '100%',
	opacity: null
};

var slideDown = {
	origin: 'top',
	opacity: null
};

var slideDownFull = {
	origin: 'top',
	distance: '100%',
	opacity: null
};

var slideRight = {
	origin: 'left',
	opacity: null
};

var slideRightFull = {
	origin: 'left',
	distance: '100%',
	opacity: null
};

var slideLeft = {
	origin: 'right',
	opacity: null
};

var slideLeftFull = {
	origin: 'right',
	distance: '100%',
	opacity: null
};

var zoomOut = {
	scale: '1.2',
	distance: 0,
	opacity: null
};

var zoomFadeOut = {
	scale: '1.2',
	distance: 0
};

// Project Specific
var slideDownMarkers = {
	opacity: null,
	distance: '-30rem',
	origin: 'bottom'
};

// do nothing, useful for adding just class
var trigger = {
	// overwrite defaults
	duration: 0,
	easing: 'ease',
	distance: 0,
	delay: 0,
	opacity: null
};

/* Invoke stagger animation */
let srevealStagger100 = document.querySelectorAll(
	'body:not(.wp-admin) .sreveal-stagger-100'
);
for (const item of srevealStagger100) {
	let srevealStaggerItem = item.querySelectorAll(
		'body:not(.wp-admin) .sreveal-stagger-item'
	);
	sr.reveal(srevealStaggerItem, {
		interval: 100
	});
}

let srevealStagger200 = document.querySelectorAll(
	'body:not(.wp-admin) .sreveal-stagger-200'
);
for (const item of srevealStagger200) {
	let srevealStaggerItem = item.querySelectorAll(
		'body:not(.wp-admin) .sreveal-stagger-item'
	);
	sr.reveal(srevealStaggerItem, {
		interval: 200
	});
}

/* Invoke custom animations */
/* eslint-disable */
sr.reveal("body:not(.wp-admin) [data-sreveal='trigger']", trigger);
sr.reveal("body:not(.wp-admin) [data-sreveal='fade']", fade);
sr.reveal("body:not(.wp-admin) [data-sreveal='fade-up']", fadeUp);
sr.reveal("body:not(.wp-admin) [data-sreveal='fade-down']", fadeDown);
sr.reveal("body:not(.wp-admin) [data-sreveal='fade-right']", fadeRight);
sr.reveal("body:not(.wp-admin) [data-sreveal='fade-left']", fadeLeft);
sr.reveal("body:not(.wp-admin) [data-sreveal='slide-up']", slideUp);
sr.reveal("body:not(.wp-admin) [data-sreveal='slide-up']", slideUp);
sr.reveal("body:not(.wp-admin) [data-sreveal='slide-up-full']", slideUpFull);
sr.reveal("body:not(.wp-admin) [data-sreveal='slide-down']", slideDown);
sr.reveal(
	"body:not(.wp-admin) [data-sreveal='slide-down-full']",
	slideDownFull
);
sr.reveal("body:not(.wp-admin) [data-sreveal='slide-right']", slideRight);
sr.reveal(
	"body:not(.wp-admin) [data-sreveal='slide-right-full']",
	slideRightFull
);
sr.reveal("body:not(.wp-admin) [data-sreveal='slide-left']", slideLeft);
sr.reveal(
	"body:not(.wp-admin) [data-sreveal='slide-left-full']",
	slideLeftFull
);
sr.reveal("body:not(.wp-admin) [data-sreveal='zoom-out']", zoomOut);
sr.reveal("body:not(.wp-admin) [data-sreveal='zoom-fade-out']", zoomFadeOut);
sr.reveal(
	"body:not(.wp-admin) [data-sreveal='slide-down-markers']",
	slideDownMarkers
);
/* eslint-enable */
/* Enable data-attributes */
$('body:not(.wp-admin) [data-sreveal]').each(function () {
	var el = $(this);

	// options can be used as postfix. For eg. data-sreveal-option.
	// option with two words should be separated using '-'. For eg. viewFactor can be written as data-sreveal-view-factor.
	var options = [
		'delay',
		'distance',
		'duration',
		'easing',
		'interval',
		'opacity',
		'origin',
		'rotate',
		'scale',
		'desktop',
		'mobile',
		'reset',
		'useDelay',
		'viewFactor',
		'viewOffset'
	];

	var settings = {};
	var interval = 0;

	$(options).each(function (index, element) {
		if (el.data('sreveal-' + options[index])) {
			var option = options[index];
			settings[option] = el.data('sreveal-' + option);
		}
	});

	sr.reveal(el, settings);
});

/* Disable animation, if not mobile */
// $( 'html.js:not(.is-mobile) .sreveal' ).css( 'animation-name', 'none' );

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

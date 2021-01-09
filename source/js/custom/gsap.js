gsap.registerPlugin( ScrollTrigger );

const locoScroll = new LocomotiveScroll( {
  el: document.querySelector( '.scroll-container' ),
  smooth: true
} );

// each time Locomotive Scroll updates, tell ScrollTrigger to update too (sync positioning)
locoScroll.on( "scroll", ScrollTrigger.update );

// tell ScrollTrigger to use these proxy methods for the ".scroll-container" element since Locomotive Scroll is hijacking things
ScrollTrigger.scrollerProxy( ".scroll-container", {
  scrollTop( value ) {
    return arguments.length ? locoScroll.scrollTo( value, 0, 0 ) : locoScroll.scroll.instance.scroll.y;
  }, // we don't have to define a scrollLeft because we're only scrolling vertically.
  getBoundingClientRect() {
    return {top: 0, left: 0, width: window.innerWidth, height: window.innerHeight};
  },
  // LocomotiveScroll handles things completely differently on mobile devices - it doesn't even transform the container at all! So to get the correct behavior and avoid jitters, we should pin things with position: fixed on mobile. We sense it by checking to see if there's a transform applied to the container (the LocomotiveScroll-controlled element).
  pinType: document.querySelector( ".scroll-container" ).style.transform ? "transform" : "fixed"
} );


gsap.to( '.box-1', {
  scrollTrigger: {
    trigger: '.box',
    scroller: '.scroll-container',
    scrub: true,
  },
  y: '-200',
  duration: 3,
} );

gsap.to( '.box-2', {
  scrollTrigger: {
    trigger: '.box',
    scroller: '.scroll-container',
    scrub: true,
  },
  y: '-400',

  duration: 3,
} );

gsap.to( '.box-3', {
  scrollTrigger: {
    trigger: '.box',
    scroller: '.scroll-container',
    scrub: true,
  },
  y: '-600',
  duration: 3,
} );


// each time the window updates, we should refresh ScrollTrigger and then update LocomotiveScroll.
ScrollTrigger.addEventListener( "refresh", () => locoScroll.update() );

// after everything is set up, refresh() ScrollTrigger and update LocomotiveScroll because padding may have been added for pinning, etc.
ScrollTrigger.refresh();

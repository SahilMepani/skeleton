/*----------  Fullscreen Slider  ----------*/
function fullscreenSlider() {
	$( '.fullscreen-slider' ).each( function() {

		$( this ).slick( {
			touchThreshold: 30,
			mobileFirst: true,
			speed: 500,
			dots: true,
			appendDots: $( this ).parent().find( '.slick-slider-dots' ),
		} );

		$( this ).on( 'beforeChange', function( event, slick, currentSlide, nextSlide ) {
			if ( $( this ).find( '.slick-slide:not(.slick-cloned)' ).eq( currentSlide ).find( 'video' ).length ) {
				$( this ).find( '.slick-slide:not(.slick-cloned)' ).eq( currentSlide ).find( 'video' )[ 0 ].currentTime = 0;
			}
			if ( $( this ).find( '.slick-slide:not(.slick-cloned)' ).eq( nextSlide ).find( 'video' ).length ) {
				$( this ).find( '.slick-slide:not(.slick-cloned)' ).eq( nextSlide ).find( 'video' )[ 0 ].currentTime = 0;
			}
		} );

		$( this ).on( 'afterChange', function( event, slick, currentSlide ) {
			if ( $( this ).find( '.slick-slide:not(.slick-cloned)' ).eq( currentSlide ).find( 'video' ).length ) {
				$( this ).find( '.slick-slide:not(.slick-cloned)' ).eq( currentSlide ).find( 'video' )[ 0 ].play();
			}
		} );

		// play the first video when the first slide comes inview.
		$( this ).one( 'inview', function( event, isInView ) {
			if ( isInView ) {
				if ( $( this ).find( '.slick-slide' ).eq( 0 ).find( 'video' ).length ) {
					$( this ).find( '.slick-slide' ).eq( 0 ).find( 'video' )[ 0 ].play();
				}
			}
		} );

	} );
}
fullscreenSlider();


/*----------  Post Cards Carousel  ----------*/
function postCardsCarousel() {
	$( '.post-cards-carousel' ).each( function() {
		$( this ).slick( {
			touchThreshold: 30,
			mobileFirst: true,
			speed: 500,
			slidesToShow: 1,
			slidesToScroll: 1,
			dots: true,
			appendDots: $( this ).parent( '.container' ).siblings( '.slick-slider-dots' ),
			arrows: false,
			responsive: [ {
					breakpoint: 767,
					settings: {
						slidesToShow: 2,
						slidesToScroll: 2,
					}
      },
				{
					breakpoint: 991,
					settings: {
						slidesToShow: 3,
						slidesToScroll: 3,
					}
      },
				{
					breakpoint: 1499,
					settings: {
						slidesToShow: 4,
						slidesToScroll: 4,
					}
      } ]
		} );
	} );
}
postCardsCarousel();
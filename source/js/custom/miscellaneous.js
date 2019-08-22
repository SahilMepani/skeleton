/*===================================
=            Simple Tabs            =
===================================*/
// $( '.list-tabs-trigger > li' ).click( function( e ) {
// 	$( '.list-tabs-trigger > li' ).removeClass( 'js-active' );
// 	$( this ).addClass( 'js-active' );
// 	var index = $( this ).index();
// 	$( '.list-tabs-content > li' ).removeClass( 'js-active' );
// 	$( '.list-tabs-content > li' ).eq( index ).addClass( 'js-active' );
// } );


/*===================================================
=            Simple Equal Height Columns            =
===================================================*/
// var equalHeight = debounce( function() {
// 	if ( $( this ).width() > 991 ) {

// 		var arColHeight = [];
// 		// store each height in array
// 		$( '.list-purchase-books li' ).each( function() {
// 			arColHeight.push( $( this ).find( '.desc-block' ).outerHeight() );
// 		} );
// 		// set height
// 		$( '.list-purchase-books .desc-block' ).height( Math.max.apply( Math, arColHeight ) );

// 	} else {

// 		$( '.list-purchase-books .desc-block' ).css('height','auto');

// 	}
// }, 200 );

// // run on page load
// equalHeight();
// // run on resize
// window.addEventListener( 'resize', equalHeight );
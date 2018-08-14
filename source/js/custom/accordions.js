/*=============================
=            Basic            =
=============================*/
// $( '.list-accordions .content-block' ).css( {
// 	'display': 'none'
// } ); // if loaded via ajax. Set this in css or toggleClass with css to hide it

// /* Works with Ajax loaded content */
// $( '.list-accordions .content-block' ).css( {
// 	'display': 'none'
// } );
// $( 'body' ).on( 'click', '.list-accordions .heading', function( e ) {
// 	$( '.list-accordions li' ).removeClass( 'js-active' );
// 	$( '.list-accordions .content-block' ).slideUp( 'fast' );
// 	if ( $( this ).next().is( ':hidden' ) == true ) {
// 		$( this ).parent().addClass( 'js-active' );
// 		$( this ).next().slideDown( 'fast' );
// 	}
// } );


/*=======================================
=            Invidual Toggle            =
=======================================*/
// $( '.list-accordions .content-block' ).css( {
// 	'display': 'none'
// } );

// $( '.list-accordions .heading' ).click( function() {
// 	if ( $( this ).next().is( ':hidden' ) == true ) {
// 		$( this ).addClass( 'js-active' );
// 		$( this ).next().slideDown( 100 );
// 	} else {
// 		$( this ).removeClass( 'js-active' );
// 		$( this ).next().slideUp( 100 );
// 	}
// } );

/*==================================================
=            Expand and Collapse button            =
==================================================*/
// $( ".accordion-toggle" ).click( function() {
// 	var txt = $( ".toggle-top" ).text();
// 	if ( txt == 'Expand All' ) {

// 		txt = 'Collapse All';
// 		$( '.list-accordions .heading' ).addClass( 'js-active' );
// 		$( '.list-accordions .content' ).slideDown( 100 );

// 	} else if ( txt == 'Collapse All' ) {

// 		txt = 'Expand All';
// 		$( '.list-accordions .heading' ).removeClass( 'js-active' );
// 		$( '.list-accordions .content' ).slideUp( 100 );

// 	}
// 	$( ".accordion-toggle" ).text( txt );
// } );


/*============================================
=            Open first accordion            =
============================================*/
// $( '.list-offices li:not(:first-child) .content-block' ).css( {
// 	'display': 'none'
// } );

// $( '.list-offices li:first-child .heading' ).addClass( 'js-active' );

// $( '.list-offices .heading' ).click( function() {
// 	$( '.list-offices .heading' ).removeClass( 'js-active' );
// 	$( '.list-offices .content-block' ).slideUp( 'fast' );
// 	if ( $( this ).next().is( ':hidden' ) == true ) {
// 		$( this ).addClass( 'js-active' );
// 		$( this ).next().slideDown( 'fast' )
// 	}
// } );
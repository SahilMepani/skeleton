$( '.header-nav-toggle' ).click( function( e ) {
	$( this ).toggleClass( 'js-active' );
	$( '.header-nav' ).toggleClass( 'js-active' );
	e.preventDefault();
} );

$( '.header-nav-close' ).click( function( e ) {
	$( '.header-nav-toggle' ).toggleClass( 'js-active' );
	$( '.header-nav' ).toggleClass( 'js-active' );
	e.preventDefault();
} );

/* Add dropdown arrow for mobile parent menu */
$( '.header-nav-parent-menu > li.menu-item-has-children > a' ).append( '<span></span>' );
$( '.header-nav-parent-menu > li.menu-item-has-children > a span' ).on( 'click', function( e ) {
	e.preventDefault();
	$( this ).parent( 'a' ).siblings( '.sub-menu' ).toggleClass( 'js-active' );
} );
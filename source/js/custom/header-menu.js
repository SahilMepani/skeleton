$( '.header__menu-toggle' ).click( function( e ) {
	$( this ).toggleClass( 'js-active' );
	$( '.header__menu' ).toggleClass( 'js-active' );
	e.preventDefault();
} );

$( '.header__menu-close' ).click( function( e ) {
	$( '.header__menu-toggle' ).toggleClass( 'js-active' );
	$( '.header__menu' ).toggleClass( 'js-active' );
	e.preventDefault();
} );

/* Add dropdown arrow for mobile parent menu */
$( '.header__menu__parent-menu > li.menu-item-has-children > a' ).append( '<span></span>' );
$( '.header__menu__parent-menu > li.menu-item-has-children > a span' ).on( 'click', function( e ) {
	e.preventDefault();
	$( this ).parent( 'a' ).siblings( '.sub-menu' ).toggleClass( 'js-active' );
} );
// https://www.jacklmoore.com/notes/naturalwidth-and-naturalheight-in-ie/
// adds .naturalWidth() and .naturalHeight() methods to jQuery
// for retreaving a normalized naturalWidth and naturalHeight.
( function ( $ ) {
  var
    props = [ 'Width', 'Height' ],
    prop;

  while ( prop = props.pop() ) {
    ( function ( natural, prop ) {
      $.fn[ natural ] = ( natural in new Image() ) ?
        function () {
          return this[ 0 ][ natural ];
        } :
        function () {
          var
            node = this[ 0 ],
            img,
            value;

          if ( node.tagName.toLowerCase() === 'img' ) {
            img = new Image();
            img.src = node.src,
              value = img[ prop ];
          }
          return value;
        };
    }( 'natural' + prop, prop.toLowerCase() ) );
  }
}( jQuery ) );


// Custom
var imgCover = debounce( function () {
  $( '.img-cover' ).each( function () {

    var img = $( this );
    var imgParent = $( this ).parents( '.img-cover-parent' );
    var imgAspectRatio       = img.naturalWidth() / img.naturalHeight();
    var imgParentAspectRatio = imgParent.outerWidth() / imgParent.outerHeight();

    if ( imgAspectRatio >= imgParentAspectRatio ) {
      img.removeClass( 'img-cover-w' ).addClass( 'img-cover-h' );
    } else {
      img.removeClass( 'img-cover-h' ).addClass( 'img-cover-w' );
    }

  } )
}, 200 );
window.addEventListener( 'resize', imgCover );
imgCover();
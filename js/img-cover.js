// ImgCover on image load
////////////////////////////////////////////////
function imgCover( img ) {
  const imgParent = img.parentElement;
  const imgAspectRatio = img.naturalWidth / img.naturalHeight;
  const imgParentAspectRatio = imgParent.offsetWidth / imgParent.offsetHeight;

  if ( imgAspectRatio >= imgParentAspectRatio ) {
    img.classList.remove( 'js-img-cover-w' );
    img.classList.add( 'js-img-cover-h' );
  } else {
    img.classList.remove( 'js-img-cover-h' );
    img.classList.add( 'js-img-cover-w' );
  }
}

// ImgCover on resize
////////////////////////////////////////////////
function imgCoverOnResize() {
  const images = document.querySelectorAll( '.js-img-cover' );
  images.forEach( img => imgCover( img ) );
}
window.addEventListener( 'resize', imgCoverOnResize );
window.addEventListener( 'orientationchange', imgCoverOnResize );
// imgCover on resize
////////////////////////////////////////////////
const debounceImgCover = debounce(
  function () {
    const images = document.querySelectorAll( '.img-cover' );
    images.forEach( img => imgCover( img ) );
  }, 200
);
window.addEventListener( 'resize', debounceImgCover );
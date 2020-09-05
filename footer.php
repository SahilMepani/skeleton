</main> <!-- #site-content -->

<footer class="site-footer clearfix">
<div class="container">

  <?php //wp_nav_menu( array( 'theme_location' => 'footer-menu', 'container' => '', 'menu_class' => 'footer-menu' ) ); ?>
  <!-- <p class="copyright">&copy; <?php //echo date( 'Y' ); ?>. All Rights Reserved.</p> -->

</div> <!-- .container -->
</footer> <!-- #footer -->

<a href="#" class="scroll-to-top scroll-to" aria-label="<?php _e( 'Scroll to Top', 'tse' ); ?>"></a>

<script>
  // imgCover on image load
  function imgCover( img ) {
    const imgParent = img.parentElement;
    const imgAspectRatio = img.naturalWidth / img.naturalHeight;
    const imgParentAspectRatio = imgParent.offsetWidth / imgParent.offsetHeight;

    // console.log( img );
    console.log( 'imgWidth :' + img.naturalWidth );
    // console.log( 'imgHeight :' + img.naturalHeight );
    // console.log( 'imgAspectRatio :' + imgAspectRatio );
    // console.log( 'imgParentAspectRatio :' + imgParentAspectRatio );

    if ( imgAspectRatio >= imgParentAspectRatio ) {
      img.classList.remove('js-img-cover-w')
      img.classList.add('js-img-cover-h');
    } else {
      img.classList.remove('js-img-cover-h')
      img.classList.add('js-img-cover-w');
    }
  }
</script>

<?php wp_footer(); ?>
</body>
</html>
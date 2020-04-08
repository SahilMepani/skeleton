<aside class="sidebar">
  <ul>
    <?php
      if ( is_home() || is_single() || is_archive() ) {
        if ( dynamic_sidebar( 'Blog' ) ) : else : endif;
      } else {
        if ( dynamic_sidebar( 'Pages' ) ) : else : endif;
      }
    ?>
  </ul>
</aside> <!-- .sidebar -->
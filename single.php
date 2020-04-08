<?php get_header(); ?>

<div class="content-section">
  <div class="container">

    <div class="row">

      <div class="col-sm-9">
        <section class="main-content clearfix">

          <?php if ( have_posts() ) : the_post(); ?>

          <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

            <?php if ( has_post_thumbnail() ) { ?>
              <aside class="featured-img-block">
                <?php the_post_thumbnail( 'post_featured_thumb' ); ?>
              </aside> <!-- .featured-thumb-block -->
            <?php } ?>

            <header>
              <h1 class="post-title"><?php the_title(); ?></h1>
              <div class="post-meta">
                Published by <?php the_author_posts_link(); ?> on
                <time pubdate><?php the_time('F j, Y'); ?></time> under <?php the_category(' / '); ?>
              </div> <!-- .post-meta -->
            </header>

            <?php the_content(); ?>

            <?php tse_wp_link_pages(); ?>

            <?php if ( has_tag() ) { ?>
              <p class="tags"> <?php the_tags( '<b>Tags:</b> ', ', ', '' ); ?> </p>
            <?php } ?>

            <div class="js-socials-share margin-top-3"></div>

          </article> <!-- .type-post -->

          <div class="author-box">
            <div class="avatar-block">
              <?php if (function_exists('get_avatar')) { echo get_avatar( get_the_author_meta('email'), '100' ); } ?>
            </div> <!-- .avatar-block -->
            <div class="author-info">
              <h5><?php the_author_posts_link(); ?></h5>
              <p><?php the_author_meta('description'); ?></p>
              <ul class="list-author-meta list-connections list-unstyled">
                <?php
                  $url = get_the_author_meta( 'user_url' );
                  if ( $url ) {
                ?>
                    <li class="i-info"><a href="<?php echo $url; ?>" title="Visit my website">Website</a></li>
                <?php } ?>
                <?php
                  $twitter = get_the_author_meta( 'twitter' );
                  if ( $twitter ) {
                ?>
                    <li class="i-twitter"><a href="https://twitter.com/<?php echo $twitter; ?>" title="Follow me on twitter">Twitter</a></li>
                <?php } ?>
                <?php
                  $facebook = get_the_author_meta( 'facebook' );
                  if ( $facebook ) {
                ?>
                    <li class="i-facebook"><a href="<?php echo $facebook; ?>" title="View my facebook profile">Facebook</a></li>
                <?php } ?>
                <?php
                  $google = get_the_author_meta( 'googleplus' );
                  if ( $google ) {
                ?>
                    <li class="i-gplus"><a href="https://googleplus.com/<?php echo $google; ?>" title="View my google+ profile">Google+</a></li>
                <?php } ?>
              </ul>
            </div> <!-- .author-info -->
          </div> <!-- .author-box -->

          <div class="post-nav clearfix">
            <?php
              $prev_post = get_previous_post();
              if ( !empty( $prev_post ) ) {
            ?>
              <div class="old-post">
                <a href="<?php echo $prev_post->guid ?>" title="<?php echo $prev_post->post_title; ?>"><?php echo $prev_post->post_title ?></a>
              </div>
            <?php } ?>

            <div class="text-center"><a href="<?php echo get_permalink( get_option('page_for_posts') ) ?>">Blog Home</a></div>

            <?php
              $next_post = get_next_post();
              if ( !empty( $next_post ) ) {
            ?>
              <div class="new-post">
                <a href="<?php echo $next_post->guid ?>" title="<?php echo $next_post->post_title; ?>"><?php echo $next_post->post_title ?></a>
              </div>
            <?php } ?>

          </div> <!-- .post-nav End -->

          <?php
            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || '0' != get_comments_number() )
              comments_template( '', true );
          ?>

          <?php else : ?>

            <h2>Not Found</h2>
            <p>Sorry, but you are looking for something that isn&#8217;t here.</p>

          <?php endif; ?>

        </section> <!-- .main-content -->
      </div> <!-- .col -->

      <div class="col-sm-3">
        <?php get_sidebar(); ?>
      </div> <!-- .col -->

    </div> <!-- .row -->

  </div> <!-- .container -->
</div> <!-- .content-section -->

<?php get_footer(); ?>
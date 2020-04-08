<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural = tribe_get_event_label_plural();

$event_id = get_the_ID();

?>

<div class="post-nav margin-bottom-sm clearfix">
  <a href="<?php echo esc_url( tribe_get_events_link() ); ?>" class="link-arrow-left link-more">Back to All Lectures</a>
</div> <!-- .post-nav -->

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

<!-- Notices -->
<?php tribe_the_notices() ?>

<?php while ( have_posts() ) : the_post(); ?>

  <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

    <?php if ( has_post_thumbnail() ) { ?>
      <aside class="single-event-featured-thumb-block">
        <a href="<?php the_permalink(); ?>" class="" title="Read more about <?php the_title_attribute(); ?>">
          <?php the_post_thumbnail( 'medium_crop' ); ?>
        </a>
      </aside> <!-- .event-featured-thumb-block -->
    <?php } ?>

    <header class="single-event-header">
      <h1 class="single-event-title h2"><?php the_title(); ?></h1>

      <p class="single-lecture-title"><?php echo tribe_get_organizer( $organizer ) ?></p>

      <div class="single-event-meta">
        <p class="single-event-datetime"><?php echo tribe_events_event_schedule_details( $event_id ); ?></p>
        <!-- <p class="single-event-time">NOON-1:00PM</p> -->
        <p class="single-event-location italic"><?php echo tribe_get_venue() ?></p>
      </div> <!-- .single-event-meta -->

      <?php do_action( 'tribe_events_single_event_after_the_content' ) ?>
    </header> <!-- .single-event-header -->

    <div class="clear margin-bottom-sm">
      <?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
      <?php the_content(); ?>
    </div> <!-- .clear -->

  </article>

<?php endwhile; ?>


<?php while ( have_posts() ) :  the_post(); ?>
  <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <!-- Event meta -->
    <?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
    <?php tribe_get_template_part( 'modules/meta' ); ?>
    <?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>
  </div> <!-- #post-x -->
  <?php if ( get_post_type() == Tribe__Events__Main::POSTTYPE && tribe_get_option( 'showComments', false ) ) comments_template() ?>
<?php endwhile; ?>


<article>

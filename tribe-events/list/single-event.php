<?php
/**
 * List View Single Event
 * This file contains one event in the list view
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/list/single-event.php
 *
 * @package TribeEventsCalendar
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// Setup an array of venue details for use later in the template
$venue_details = tribe_get_venue_details();

// Venue
$has_venue_address = ( ! empty( $venue_details['address'] ) ) ? ' location' : '';

// Organizer
$organizer = tribe_get_organizer();

?>

<?php if ( has_post_thumbnail() ) { ?>
  <aside class="event-featured-thumb-block">
    <div class="event-date">
      <span class="month"><?php echo tribe_event_format_date( '', false, 'M' ); ?></span>
      <span class="day"><?php echo tribe_event_format_date( '', false, 'd' ); ?></span>
    </div> <!-- .event-date -->
    <a href="<?php the_permalink(); ?>" title="Read more about <?php the_title_attribute(); ?>">
      <?php the_post_thumbnail( 'medium_crop' ); ?>
    </a>
  </aside> <!-- .event-featured-thumb-block -->
<?php } ?>

<div class="event-content-block">
  <div class="event-categories"><?php the_terms( $post->ID, 'tribe_events_cat' ); ?></div>

  <h3 class="event-title h5"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

  <!-- <p class="organizer"><?php //echo tribe_get_organizer( $organizer ); ?></p> -->

  <p class="excerpt clear"><?php echo vt_excerpt(20); ?></p>

  <div class="event-meta">
    <span class="event-time"><?php echo tribe_events_event_schedule_details(); ?></span>
    <span class="divider"></span>
    <span class="event-location"><?php echo tribe_get_venue(); ?></span>
  </div> <!-- .event-meta -->

  <p class="text-right">
    <a href="<?php the_permalink(); ?>" class="link-arrow-right link-more">Event Info</a>
  </p>
</div> <!-- .event-content-block -->

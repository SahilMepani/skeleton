<?php
/**
 * Single Event Meta Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta.php
 *
 * @package TribeEventsCalendar
 */

do_action( 'tribe_events_single_meta_before' );

// Check for skeleton mode (no outer wrappers per section)
$not_skeleton = ! apply_filters( 'tribe_events_single_event_the_meta_skeleton', false, get_the_ID() );

// Do we want to group venue meta separately?
$set_venue_apart = apply_filters( 'tribe_events_single_event_the_meta_group_venue', false, get_the_ID() );
?>

<div class="single-event-details-block">
  <div class="row">
    <div class="col-sm-6">
     <?php tribe_get_template_part( 'modules/meta/details' ); ?>
    </div> <!-- .col-sm-6 -->
    <div class="col-sm-6">
     <?php tribe_get_template_part( 'modules/meta/organizer' ); ?>
    </div> <!-- .col-sm-6 -->
  </div> <!-- .row -->
</div> <!-- .single-event-details-block -->

<?php if ( tribe_get_venue_id() ) { ?>
  <div class="single-event-details-block">
    <div class="inner-block">
      <div class="content-block">
        <?php tribe_get_template_part( 'modules/meta/venue' ); ?>
      </div> <!-- .content-block -->
      <div class="map-block">
        <?php tribe_get_template_part( 'modules/meta/map' ); ?>
      </div> <!-- .map-block -->
    </div> <!-- .row -->
  </div> <!-- .single-event-details-block -->
<?php } ?>

<?php do_action( 'tribe_events_single_meta_after' ); ?>

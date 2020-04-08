<?php
/**
 * Single Event Meta (Venue) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/venue.php
 *
 * @package TribeEventsCalendar
 */

if ( ! tribe_get_venue_id() ) {
  return;
}

$organizer_ids = tribe_get_organizer_ids();
$multiple = count( $organizer_ids ) > 1;
$phone   = tribe_get_phone();
$website = tribe_get_venue_website_link();
$email = tribe_get_organizer_email();
?>

<?php if ( tribe_address_exists() ) : ?>
  <h6 class="heading"><?php esc_html_e( tribe_get_venue_label_singular(), 'the-events-calendar' ) ?> </h6>
  <p><?php echo tribe_get_venue() ?></p>
  <p><?php echo tribe_get_full_address(); ?></p>
<?php endif; ?>

<?php if ( ! empty( $phone ) ): ?>
  <h6 class="heading"><?php esc_html_e( 'Phone:', 'the-events-calendar' ) ?></h6>
  <p><?php echo $phone ?></p>
<?php endif ?>

<?php if ( ! empty( $email ) ): ?>
  <div class="email-block">
    <h6 class="heading"><?php esc_html_e( 'Email:', 'the-events-calendar' ) ?></h6>
    <p><a href="mailto:<?php echo $email ?>"><?php echo $email ?></a></p>
  </div> <!-- .email-block -->
<?php endif ?>

<?php if ( ! empty( $website ) ): ?>
  <div class="event-url-block">
    <h6 class="heading"><?php esc_html_e( 'Website:', 'the-events-calendar' ) ?></h6>
    <p><?php echo $website ?></p>
  </div> <!-- .event-url-block -->
<?php endif ?>

<?php if ( tribe_show_google_map_link() ) : ?>
  <div class="map-link-block">
    <a href="<?php echo tribe_get_map_link(); ?>" target="_blank" class="purple">+ Google Map</a>
  </div> <!-- .map-link-block -->
<?php endif; ?>

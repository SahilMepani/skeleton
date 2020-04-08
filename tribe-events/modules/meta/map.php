<?php
/**
 * Single Event Meta (Map) Template
 *
 * Override this template in your own theme by creating a file at:z
 * [your-theme]/tribe-events/modules/meta/details.php
 *
 * @package TribeEventsCalendar
 */

$map = tribe_get_embedded_map();

if ( empty( $map ) ) {
  return;
}

echo $map;
?>

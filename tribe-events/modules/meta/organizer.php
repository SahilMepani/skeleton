<?php
/**
 * Single Event Meta (Organizer) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/details.php
 *
 * @package TribeEventsCalendar
 */

$organizer_ids = tribe_get_organizer_ids();
$multiple = count( $organizer_ids ) > 1;

$phone = tribe_get_organizer_phone();
$email = tribe_get_organizer_email();
$website = tribe_get_organizer_website_link();
?>

<div class="tribe-events-meta-group tribe-events-meta-group-organizer">

		<?php
		do_action( 'tribe_events_single_meta_organizer_section_start' );

		foreach ( $organizer_ids as $organizer ) {
			if ( ! $organizer ) {
				continue;
			}

			?>
			<h6 class="heading"><?php echo tribe_get_organizer_label( ! $multiple ); ?></h6>
			<p class="tribe-organizer">
				<?php echo tribe_get_organizer( $organizer ) ?>
			</p>
			<?php
		}

		if ( ! $multiple ) { // only show organizer details if there is one
			if ( ! empty( $phone ) ) {
				?>
				<h6 class="heading">
					<?php esc_html_e( 'Phone:', 'the-events-calendar' ) ?>
				</h6>
				<p class="tribe-organizer-tel">
					<?php echo esc_html( $phone ); ?>
				</p>
				<?php
			}//end if

			if ( ! empty( $email ) ) {
				?>
				<h6 class="heading">
					<?php esc_html_e( 'Email:', 'the-events-calendar' ) ?>
				</h6>
				<p class="tribe-organizer-email">
					<a href="mailto:<?php echo esc_html( $email ); ?>"><?php echo esc_html( $email ); ?></a>
				</p>
				<?php
			}//end if

			if ( ! empty( $website ) ) {
				?>
				<h6 class="heading">
					<?php esc_html_e( 'Website:', 'the-events-calendar' ) ?>
				</h6>
				<p class="tribe-organizer-url">
					<?php echo $website; ?>
				</p>
				<?php
			}//end if
		}//end if

		do_action( 'tribe_events_single_meta_organizer_section_end' );
		?>

</div>

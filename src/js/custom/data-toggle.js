<?php
/**
 *
 * @package WordPress
 * @subpackage Skeleton
 * @since 1.0.0
 */

get_header();

$course_id      = get_the_id();
$course_obj     = learn_press_get_course( $course_id );
$course_title   = get_the_title( $course_id );
$excerpt        = skel_get_the_excerpt( 20, $course_id );
$featured_image = get_post_thumbnail_id( $course_id );
$permalink      = get_the_permalink( $course_id );
$regular_price  = $course_obj->get_regular_price();
$sale_price     = $course_obj->get_sale_price();
$price          = $course_obj->get_price();
$offline_course = get_post_meta( $course_id, '_lp_offline_course', true ) ?? '';
$is_offline     = ( 'yes' === $offline_course ) ? true : false;
if ( $is_offline ) {
	$offline_lesson_count = get_post_meta( $course_id, '_lp_offline_lesson_count', true ) ?? '';
} else {
	$curriculum_items     = $course_obj->get_curriculum_items();
	$online_sections      = $course_obj->get_sections();
	$online_section_count = count( $online_sections );
	$online_lesson_count  = 0;
	foreach ( $curriculum_items as $item_id ) {
		$item_type = get_post_type( $item_id );
		if ( 'lp_lesson' === $item_type ) {
			++$online_lesson_count;
		}
	}
}
$excerpt       = skel_get_the_excerpt( $course_id, 30 );
$author_id     = get_post_field( 'post_author', $course_id );
$author_name   = get_the_author_meta( 'display_name', $author_id );
$delivery      = array(
	'in_person_class' => 'In Person',
	'private_1_1'     => 'Private 1-1',
	'live_class'      => 'Live Class',
);
$delivery_type = get_post_meta( $course_id, '_lp_deliver_type', true ) ?? '';
$data          = maybe_unserialize( get_post_meta( $course_id, '_lp_requirements', true ) );
$all_meta      = get_post_meta( $course_id );


// print_r( $curriculum_items );

// echo '<pre>';
// print_r( $all_meta );
// echo '</pre>';
?>

<div class="page-header">
	<div class="container">
		<div class="grid">
			<div class="content-col">
				<h4 class="page-heading h2">Dispute Resolution in the UAE</h4>

				<div class="text-block">
					<p>Navigate the complexities of arbitration and dispute resolution with this comprehensive course
						tailored for
						legal professionals, business executives, and aspiring arbitrators. Covering UAE-specific
						frameworks,
						international arbitration principles, and practical case studies, this course equips you with
						the
						skills to
						manage disputes efficiently while maintaining compliance with local and international legal
						standards.</p>
				</div> <!-- .text-block -->

				<div class="meta-block">
					<div class="author">
						<div class="svg-block">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 21 20">
								<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
									stroke-width="1.5"
									d="M18.666 8.333v5m-.484-4.231a.834.834 0 0 0-.015-1.532l-7.143-3.253a1.666 1.666 0 0 0-1.383 0l-7.142 3.25a.833.833 0 0 0 0 1.526l7.142 3.257a1.667 1.667 0 0 0 1.383 0l7.158-3.248Z" />
								<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
									stroke-width="1.5"
									d="M5.332 10.416v2.917c0 .663.527 1.3 1.465 1.768.937.469 2.209.732 3.535.732s2.598-.263 3.536-.732c.937-.469 1.464-1.105 1.464-1.768v-2.917" />
							</svg>
						</div>
						<?php echo esc_html( $author_name ); ?>
					</div> <!-- .author -->
				</div> <!-- .meta-block -->
			</div> <!-- .content-col -->

			<div class="img-col img-cover-block">
				<?php
					$image_id   = get_post_thumbnail_id( get_the_id() );
					$image_data = wp_get_attachment_image_src( $image_id, 'w768' );
					$image_alt  = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
					$image_alt  = trim( wp_strip_all_tags( $image_alt ) );
				?>
				<img src="<?php echo esc_url( wp_get_attachment_image_url( $image_id, 'w768' ) ); ?>"
					srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( $image_id ) ); ?>" sizes="40rem"
					alt="<?php echo esc_attr( $image_alt ); ?>" width="<?php echo esc_attr( $image_data[1] ); ?>"
					height="<?php echo esc_attr( $image_data[2] ); ?>" class="img-cover" />
			</div> <!-- .img-col -->
		</div> <!-- .grid -->
	</div> <!-- .container -->
</div> <!-- .page-header -->

<div class="content-section">
	<div class="container">
		<div class="grid">
			<div class="content-col">
				<ul class="list-tabs">
					<li><button class="tab btn-reset js-active" data-toggle-click="tab-about" data-toggle-group="tab"
							data-tab><span>About</span></button></li>
					<li><button class="tab btn-reset" data-toggle-click="tab-curriculum" data-toggle-group="tab"
							data-tab><span>Curriculum</span></button></li>
				</ul> <!-- .list-tabs -->

				<div class="tabs-content">
					<div class="tab-content js-active" data-toggle-link="tab-about" data-toggle-group="tab-content">
						<?php the_content(); ?>
						Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quia explicabo sapiente omnis nam
						excepturi,
						expedita autem repudiandae maiores debitis perspiciatis illum ullam iure laboriosam sint
						aspernatur
						cumque quas. Tempore voluptates harum repellendus mollitia deserunt ipsum veniam ea facere
						voluptatum
						aliquid, sequi, tempora id tenetur neque. Molestiae, tempore temporibus saepe sit at nisi
						facilis odit,
						sunt necessitatibus veniam earum ratione? Et, delectus blanditiis dolores excepturi, enim
						quisquam
						facilis sit, sapiente eos reprehenderit ipsam ut! Eos dicta a ex quisquam quis ab ducimus
						dignissimos
						ipsum suscipit dolores. Quia dolorum, asperiores nesciunt exercitationem, officiis architecto,
						quae et
						dolore ducimus veniam reprehenderit! Sit sint quisquam corrupti suscipit odit accusamus
						voluptatibus
						assumenda eaque ut illo incidunt corporis quidem ducimus nulla, error enim perspiciatis minus,
						nam
						voluptatem similique ullam sed totam. Numquam ex iusto, aliquid rerum officiis minus tempore
						dolores
					</div>
					<div class="tab-content" data-toggle-link="tab-curriculum" data-toggle-group="tab-content" b>
						<h4>Curriculum</h4>
					</div>
				</div> <!-- .list-tabs-content -->
			</div> <!-- .content-col -->

			<div class="sidebar-col">
				<div class="sticky-block">

				</div> <!-- .sticky-block -->
			</div> <!-- .sidebar-col -->
		</div> <!-- .grid -->
	</div> <!-- .container -->
</div> <!-- .content-section -->

<?php
get_footer();

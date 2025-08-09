<?php
/**
 * Template Name: Sitemap
 *
 * @package WordPress
 * @subpackage Skeleton
 * @since 1.0.0
 */

get_header();
?>

<div class="container-fluid padding-4">
	<div id="sitemap-tabs">
		<ul class="list-tabs">
			<li><a href="#tab-1"><?php esc_html_e( 'Posts', 'skel' ); ?></a></li>
			<li><a href="#tab-2"><?php esc_html_e( 'Pages', 'skel' ); ?></a></li>
			<li><a href="#tab-3"><?php esc_html_e( 'Events', 'skel' ); ?></a></li>
		</ul>

		<div id="tab-1" class="tab-content">
			<?php
			$args       = array(
				'numberposts' => -1,
			);
			$list_posts = wp_get_recent_posts( $args );
			?>
			<h4><?php esc_html_e( 'Posts', 'skel' ); ?></h4>
			<ul class="list-sitemap">
				<?php
				foreach ( $list_posts as $item ) {
					echo '<li><a href="' . esc_url( get_permalink( $item['ID'] ) ) . '">' . esc_html( $item['post_title'] ) . '</a> </li>';
				}
				?>
			</ul>
		</div>

		<div id="tab-2" class="tab-content">
			<h4><?php esc_html_e( 'Pages', 'skel' ); ?></h4>
			<ul class="list-sitemap">
				<?php
				$args = array(
					'title_li' => '',
					'orderby'  => 'menu_order',
					'order'    => 'ASC',
					'exclude'  => 'sitemap_id, page_id',
				);
				wp_list_pages( $args );
				?>
			</ul>
		</div>

		<div id="tab-3" class="tab-content">
			<?php
			$args       = array(
				'post_type'   => 'event',
				'numberposts' => -1,
			);
			$list_posts = wp_get_recent_posts( $args );
			?>
			<h4><?php esc_html_e( 'Audio Albums', 'skel' ); ?></h4>
			<ul class="list-sitemap">
				<?php
				foreach ( $list_posts as $item ) {
					echo '<li><a href="' . esc_url( get_permalink( $item['ID'] ) ) . '">' . esc_html( $item['post_title'] ) . '</a> </li>';
				}
				?>
			</ul>
		</div>
	</div>
</div>

<?php get_footer(); ?>


<?php
$desktop_image = get_field( 'desktop_image' ) ?: DEFAULT_THUMBNAIL_ID;
$mobile_image  = get_field( 'mobile_image' ) ?: '';
$mobile_class  = $mobile_image ? 'has-mobile' : '';

$images = array(
	array(
		'id'    => $desktop_image,
		'sizes' => '100vw',
		'size'  => 'w1920',
		'class' => 'img-desktop ' . $mobile_class,
	),
	$mobile_image ? array(
		'id'    => $mobile_image,
		'sizes' => '100vw',
		'size'  => 'w992',
		'class' => 'img-mobile',
	) : null,
);

?>
<div class="img-cover-block">
	<?php
	foreach ( array_filter( $images ) as $img ) :
		$image_data   = wp_get_attachment_image_src( $img['id'], $img['size'] );
		$image_url    = wp_get_attachment_image_url( $img['id'], $img['size'] );
		$image_srcset = wp_get_attachment_image_srcset( $img['id'] );
		$image_alt    = trim( wp_strip_all_tags( get_post_meta( $img['id'], '_wp_attachment_image_alt', true ) ) );

		$image_width  = $image_data[1] ?? '';
		$image_height = $image_data[2] ?? '';
		?>
		<img
			src="<?php echo esc_url( $image_url ); ?>"
			srcset="<?php echo esc_attr( $image_srcset ); ?>"
			sizes="<?php echo esc_attr( $sizes ); ?>"
			alt="<?php echo esc_attr( $image_alt ); ?>"
			width="<?php echo esc_attr( $image_width ); ?>"
			height="<?php echo esc_attr( $image_height ); ?>"
			class="img-cover <?php echo esc_attr( $img['class'] ); ?>"
			loading="lazy"
		/>
	<?php endforeach; ?>
</div>

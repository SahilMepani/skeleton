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

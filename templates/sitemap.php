<?php /* Template Name: Sitemap */?>

<?php get_header();?>

<div class="container-fluid padding-4">
	<div id="sitemap-tabs">

		<ul class="list-tabs">
			<li><a href="#tab-1">Posts</a></li>
			<li><a href="#tab-2">Pages</a></li>
			<li><a href="#tab-3">Events</a></li>
		</ul> <!-- .list-tabs -->

		<div id="tab-1" class="tab-content">
			<?php
				$args = [
					'numberposts' => -1
				];
				$list_posts = wp_get_recent_posts( $args );
				if ( $list_posts ):
			?>
			<h4>Posts</h4>
			<ul class="list-sitemap">
				<?php
					foreach ( $list_posts as $item ) {
						echo '<li><a href="' . get_permalink( $item["ID"] ) . '">' . $item["post_title"] . '</a> </li>';
					}
				?>
			</ul>
			<?php endif;?>
		</div> <!-- .tab-content -->

		<div id="tab-2" class="tab-content">
			<h4>Pages</h4>
			<ul class="list-sitemap">
				<?php
					$args = [
						'title_li' => '',
						'orderby'  => 'menu_order',
						'order'    => 'ASC'
						//'exclude' => 'sitemap_id, page_id',
					];
					wp_list_pages( $args );
				?>
			</ul>
		</div> <!-- .tab-content -->

		<div id="tab-3" class="tab-content">
			<?php
				$args = [
					'post_type'   => 'event',
					'numberposts' => -1
				];
				$list_posts = wp_get_recent_posts( $args );
				if ( $list_posts ):
			?>
			<h4>Audio Albums</h4>
			<ul class="list-sitemap">
				<?php
					foreach ( $list_posts as $item ) {
						echo '<li><a href="' . get_permalink( $item["ID"] ) . '">' . $item["post_title"] . '</a> </li>';
					}
				?>
			</ul>
			<?php endif;?>
		</div> <!-- .tab-content -->


	</div> <!-- #sitemap-tabs -->
</div> <!-- .container-fluid -->

<?php get_footer();?>

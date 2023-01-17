<?php /* Template Name: Custom Select */?>

<?php get_header();?>

<div class="container-fluid padding-4">

	<h4>Mobile Select</h4>

	<div class="chosen-select-block hidden-sm hidden-md hidden-lg">
		<label for="mobile-select-category" class="sr-only">Select Category</label>
		<select class="redirect-chosen-select" id="mobile-select-category">
			<option value="<?php echo home_url(); ?>/news-and-events">All</option>
			<?php
				$cats_args = [
					'taxonomy'   => 'category',
					'hide_empty' => true
				];
				$cats = get_categories( $cats_args );
				foreach ( $cats as $cat ):
			?>
			<option value="<?php echo home_url(); ?>/category/<?php echo $cat->slug; ?>"
				<?php if ( is_category( $cat->slug ) ) {echo ' selected="selected"';}?>>
				<?php echo $cat->name; ?>
			</option>
			<?php endforeach;?>
		</select>
	</div> <!-- .redirect-select-block -->

</div> <!-- .container-fluid padding-4 -->

<?php get_footer();?>

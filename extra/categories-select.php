<?php //phpcs:ignore file comment ?>

<!-- Chosen Select Ajax -->
<select id="ajax-select-post-categories" class="chosen-select">
	<option data-cpt="post" data-tax="category" data-term="">
		<?php esc_html_e( 'All Categories', 'skel' ); ?>
	</option>
	<?php
		$cats_args = array(
			'taxonomy' => 'category',
		);
		$cats      = get_categories( $cats_args );
		foreach ( $cats as $cat_item ) :
			?>
	<option data-cpt="post" data-tax="category" data-term="<?php echo esc_attr( $cat_item->slug ); ?>" data-start-date="-1"
		data-end-date="-1">
			<?php echo esc_html( $cat_item->name ); ?>
	</option>
	<?php endforeach; ?>
</select>

<!-- Chosen/Custom -->
$( '#ajax-filter-cat' ).on( 'change', function( e ) {
e.preventDefault();
var selectedCat = $( 'option:selected' ).data('term-id');
$( '#filter-cat-id' ).val( selectedCat );
filter_post( $( 'option:selected', this ), 'filter_by_term' );
} );


<!--  Default Redirect to Cat Page -->
<form id="ajax-filter-cat" class="custom-select-block" action="<?php esc_url( home_url( '/' ) ); ?>" method="get">
	<?php
		$select = wp_dropdown_categories( 'show_option_none=All&show_count=1&orderby=name&echo=0&hide_empty=1' );
		$select = preg_replace( '#<select([^>]*)>#', "<select$1 onchange='return this.form.submit()'>", $select );
		echo $select; //phpcs:ignore
	?>
</form>

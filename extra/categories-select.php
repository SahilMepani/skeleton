<!-- Chosen Select Ajax -->
<select id="ajax-select-post-categories" class="chosen-select">
  <option data-cpt="post" data-tax="category" data-term=""><?php _e('All Categories','tse'); ?></option>
  <?php
    $cats_args = array(
      'taxonomy' => 'category',
    );
    $cats = get_categories( $cats_args );
    foreach ( $cats as $cat ) :
  ?>
    <option data-cpt="post" data-tax="category" data-term="<?php echo $cat->slug; ?>" data-start-date="-1" data-end-date="-1">
      <?php echo $cat->name; ?>
    </option>
  <?php endforeach; ?>
</select>

<!-- Custom Select Ajax -->
<div class="custom-select-block">
  <select id="ajax-filter-cat">
    <option data-cpt="post" data-tax="category" data-term=""><?php _e('All Categories','tse'); ?></option>
    <?php
      $cats_args = array(
        'taxonomy' => 'category',
      );
      $cats = get_categories( $cats_args );
      foreach ( $cats as $cat ) :
    ?>
      <option data-cpt="post" data-tax="category" data-term="<?php echo $cat->slug; ?>" data-start-date="-1" data-end-date="-1">
        <?php echo $cat->name . '(' . $cat->count . ')'; ?>
      </option>
    <?php endforeach; ?>
  </select>
</div> <!-- .custom-select-block -->

<!-- Chosen/Custom -->
$( '#ajax-filter-cat' ).on( 'change', function( e ) {
  e.preventDefault();
  var selectedCat = $( 'option:selected' ).data('term-id');
  $( '#filter-cat-id' ).val( selectedCat );
  filter_post( $( 'option:selected', this ), 'filter_by_term' );
} );


<!--  Default Redirect to Cat Page -->
<form id="ajax-filter-cat" class="custom-select-block" action="<?php bloginfo('url'); ?>/" method="get">
  <?php
    $select = wp_dropdown_categories('show_option_none=All&show_count=1&orderby=name&echo=0&hide_empty=1');
    $select = preg_replace("#<select([^>]*)>#", "<select$1 onchange='return this.form.submit()'>", $select);
    echo $select;
  ?>
</form>
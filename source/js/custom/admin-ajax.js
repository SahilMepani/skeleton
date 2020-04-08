var btnMorePost = $( '#ajax-more-post' );
var formSearchPost = $( '#ajax-search-post' );

/*======================================
=            Ajax More Post            =
======================================*/
btnMorePost.on( 'click', function( e ) {
  e.preventDefault();

  $( this ).addClass( 'btn-disabled' );
  $( '.loading-dots' ).addClass( 'js-active' );

  filter_post( $( this ), 'filter_more' );
} );


/*========================================
=            Ajax Search Post            =
========================================*/
formSearchPost.submit( function( e ) {
  e.preventDefault();

  $( '#ajax-submit-block' ).addClass( 'hidden' );
  $( '#alert-no-data' ).addClass( 'hide' );
  $( '#ajax-search-clear' ).removeClass( 'js-active' );
  $( this ).find( '.loading-spinner' ).addClass( 'js-active' );

  $( '#ajax-list-post > li' ).remove();
  $( '.loading-dots' ).addClass( 'js-active' );
  btnMorePost.hide();

  var searchValue = formSearchPost.find( '.input-search' ).val();
  $( '#filter-search' ).val( searchValue );

  filter_post( $( this ), 'filter_search' );
} );


/*=========================================
=            Ajax Search Clear            =
=========================================*/
$( '#ajax-search-clear' ).click( function( e ) {
  e.preventDefault();

  $( '#alert-no-data' ).addClass( 'hide' );

  formSearchPost.find( '.input-search' ).val( '' );
  $( '#filter-search' ).val( '' );

  formSearchPost.trigger( 'submit' );
} );


/*=======================================
=            Ajax Filter Cat            =
=======================================*/
$( '#ajax-filter-cat' ).on( 'change', function( e ) {
  e.preventDefault();

  $( '#alert-no-data' ).addClass( 'hide' );
  $( '#ajax-list-post > li' ).remove();
  $( '.loading-dots' ).addClass( 'js-active' );
  btnMorePost.hide();

  var selectedCat = $( 'option:selected' ).data( 'term-id' );
  $( '#filter-cat-id' ).val( selectedCat );

  filter_post( $( 'option:selected', this ), 'filter_cat' );
} );


/*========================================
=            Ajax Filter Post            =
========================================*/
function filter_post( $this, trigger ) {

  var cpt = $this.attr( 'data-cpt' );
  var cptTax = $this.attr( 'data-cpt-tax' );
  var catID = $( '#filter-cat-id' ).val();
  var authorID = $( '#filter-author-id' ).val();
  var tagID = $( '#filter-tag-id' ).val();
  var search = $( '#filter-search' ).val();

  if ( trigger == 'filter_search' || trigger == 'filter_cat' ) {

    // when user clicks load more, pagenum get sets to +1, so we need to reset it back to 1 to load first set of posts.
    $( '#filter-pagenum' ).val( 1 );
    // set page number variable empty
    var pageNumber = '';

  } else if ( trigger == 'filter_more' ) {

    var pageNumber = $( '#filter-pagenum' ).val();

  }

  $.ajax( {
    type: 'POST',
    dataType: 'html',
    url: localize_var.adminUrl,
    data: {
      action: 'filter_post_ajax',
      cpt: cpt,
      cptTax: cptTax,
      catID: catID,
      authorID: authorID,
      tagID: tagID,
      search: search,
      pageNumber: pageNumber,
    },
    success: function( data ) {

      var $data = $( data );

      if ( $.trim( data ) != '' && $.trim( data ) != 0 ) {

        $( '.loading-dots' ).removeClass( 'js-active' );

        /*----------- Filter More -----------*/
        if ( trigger == 'filter_more' ) {

          $( '#filter-pagenum' ).val( parseInt( pageNumber ) + 1 );

          $( '#ajax-list-post' ).append( $data );

          $( '.loading-dots' ).removeClass( 'js-active' );

        }

        /*----------  Filter Search  ----------*/
        if ( trigger == 'filter_search' ) {

          setTimeout( function() {
            if ( search != '' ) {
              $( '#ajax-search-clear' ).addClass( 'js-active' );
            } else {
              $( '#ajax-submit-block' ).removeClass( 'hidden' );
            }
            $( '.loading-spinner' ).removeClass( 'js-active' );
            $( '#ajax-list-post' ).append( $data );
            $( '#ajax-list-post' ).fadeIn( 400 );
            btnMorePost.fadeIn( 400 );
          }, 300 );

        }

        /*----------  Filter Cat  ----------*/
        if ( trigger == 'filter_cat' ) {

          $( '#ajax-list-post > li' ).remove();

          setTimeout( function() {
            $( '#ajax-list-post' ).append( $data );
            $( '#ajax-list-post' ).fadeIn( 400 );
            btnMorePost.fadeIn( 400 );
          }, 300 );

        }

        // console.log( $data.length );

        if ( $data.length < 6 ) {
          btnMorePost.addClass( 'btn-disabled' );
        } else {
          btnMorePost.removeClass( 'btn-disabled' );
        }

      } else {

        if ( $( '.loading-spinner' ).hasClass( 'js-active' ) ) {
          $( '#ajax-search-clear' ).addClass( 'js-active' );
        }
        $( '.loading-spinner' ).removeClass( 'js-active' );
        $( '#alert-no-data' ).removeClass( 'hide' );
        $( '.loading-dots' ).removeClass( 'js-active' );
        btnMorePost.hide();

      } // trim

    } //success

  } ); //ajax
  return false;
}
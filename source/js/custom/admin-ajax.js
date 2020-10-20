var btnMorePost = $( '#ajax-more-post' );
var formSearchPost = $( '#ajax-search-post' );

// Load More Post
////////////////////////////////////////////////
btnMorePost.on( 'click', function( e ) {
  e.preventDefault();

  // disable load more button
  btnMorePost.addClass( 'btn-disabled' );

  update_post( $( this ), 'filter_more' );
} );


// Filter Search Post
////////////////////////////////////////////////
formSearchPost.submit( function( e ) {
  e.preventDefault();

  // remove search icon
  $( '#ajax-submit-block' ).addClass( 'd-none' );
  // remove close icon
  $( '#ajax-search-clear' ).removeClass( 'js-active' );
  // show spinner inside input
  $( this ).find( '.loading-spinner' ).addClass( 'js-active' );

  // save the search value in hidden input
  var searchValue = formSearchPost.find( '.input-search' ).val();
  $( '#filter-search' ).val( searchValue );

  update_post( $( this ), 'filter_search' );
} );


// Clear Search Post
////////////////////////////////////////////////
$( '#ajax-search-clear' ).click( function( e ) {
  e.preventDefault();

  // clear input value
  formSearchPost.find( '.input-search' ).val( '' );
  // remove value from hidden input
  $( '#filter-search' ).val( '' );
  // submit the form
  formSearchPost.trigger( 'submit' );
} );


// Filter Categories Post
////////////////////////////////////////////////
$( '#ajax-filter-cat' ).on( 'change', function( e ) {
  e.preventDefault();

  // save the value in hidden input
  var selectedCat = $( 'option:selected' ).data( 'term' );
  $( '#filter-term' ).val( selectedCat );

  update_post( $( 'option:selected', this ), 'filter_term' );
} );


// Update Post
////////////////////////////////////////////////
function update_post( $this, trigger ) {

  // remove no data heading
  $( '#alert-no-data' ).addClass( 'd-none' );
  // show loading dots
  $( '.loading-dots' ).addClass( 'js-active' );

  if ( trigger == 'filter_search' || trigger == 'filter_term' ) {

    // hide the load more button
    btnMorePost.hide();
    // remove the list items
    $( '#ajax-list-post > li' ).fadeOut( 400, function () {
      $( '#ajax-list-post > li' ).remove();
    } );

    $( '#filter-pagenum' ).val( 1 ); // when user clicks load more, pagenum get sets to +1, so we need to reset it back to 1 to load first set of posts.

    var pageNumber = '';

  }

  if ( trigger == 'filter_more' ) {
    var pageNumber = $( '#filter-pagenum' ).val();
  }

  var cpt             = $this.data( 'cpt' );
  var tax             = $this.data( 'tax' );
  var term            = $( '#filter-term' ).val();
  var authorID        = $( '#filter-author-id' ).val();
  var tagID           = $( '#filter-tag-id' ).val();
  var search          = $( '#filter-search' ).val();
  var pageNumber      = $( '#filter-pagenum' ).val();
  var postsPerPage    = $( '#filter-posts-per-page' ).val();
  var unseenPostCount = $( '#filter-unseen-post-count' ).val();

  $.ajax( {
    type: 'POST',
    dataType: 'html',
    url: localize_var.ajax_url,
    data: {
      action       : 'update_post_ajax',
      cpt          : cpt,
      tax          : tax,
      term         : term,
      authorID     : authorID,
      tagID        : tagID,
      search       : search,
      pageNumber   : pageNumber,
      postsPerPage : postsPerPage,
    },
    success: function( data ) {

      var $data = $( data );

      if ( $.trim( data ) != '' && $.trim( data ) != 0 ) {

        $( '.loading-dots' ).removeClass( 'js-active' );

        /*----------- Filter More -----------*/
        if ( trigger == 'filter_more' ) {

          unseenPostCount = unseenPostCount - $data.length;

          $( '#filter-pagenum' ).val( parseInt( pageNumber ) + 1 );
          $( '#filter-unseen-post-count' ).val( unseenPostCount );

          $( '#ajax-list-post' ).append( $data );

          // scroll to newly appended data object
          $( 'html,body' ).animate( {
            scrollTop: $( $data ).offset().top
          }, 100 );

        }

        /*----------  Filter Search  ----------*/
        if ( trigger == 'filter_search' ) {

          setTimeout( function() {
            if ( search != '' ) {
              $( '#ajax-search-clear' ).addClass( 'js-active' );
            } else {
              $( '#ajax-submit-block' ).removeClass( 'd-none' );
            }
            $( '.loading-spinner' ).removeClass( 'js-active' );
            $( '#ajax-list-post' ).append( $data );
            $( '#ajax-list-post' ).fadeIn( 400 );
            btnMorePost.fadeIn( 400 );
          }, 300 );

        }

        /*----------  Filter Cat  ----------*/
        if ( trigger == 'filter_term' ) {

          $( '#ajax-list-post > li' ).remove();

          setTimeout( function() {
            $( '#ajax-list-post' ).append( $data );
            $( '#ajax-list-post' ).fadeIn( 400 );
            btnMorePost.fadeIn( 400 );
          }, 300 );

        }

        if ( unseenPostCount ) {
          btnMorePost.removeClass( 'btn-disabled' );
        }

      } else {

        if ( $( '.loading-spinner' ).hasClass( 'js-active' ) ) {
          $( '#ajax-search-clear' ).addClass( 'js-active' );
        }
        $( '.loading-spinner' ).removeClass( 'js-active' );
        $( '#alert-no-data' ).removeClass( 'd-none' );
        $( '.loading-dots' ).removeClass( 'js-active' );
        btnMorePost.hide();

      } // trim

    } //success

  } ); //ajax
  return false;
}
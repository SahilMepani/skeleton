jQuery( document ).ready( function( $ ) {

  /*=================================================
  =            Set ajax load more height            =
  =================================================*/
  /* Prevents below content jumping on btn click due to hidden */
  // $( '.btn-load-more-block' ).css( {
  // 	height: $( '.btn-load-more-block' ).outerHeight()
  // } );


  /*===============================================
  =            Ajax filter post by cat            =
  ===============================================*/
  $( '#ajax-list-post-categories a' ).on( 'click', function( e ) {
    e.preventDefault();
    $( '#ajax-list-post-categories li' ).removeClass( 'js-active' );
    $( this ).parent( 'li' ).addClass( 'js-active' );
    filter_post_by_cat_trigger( $( this ) );
  } );

  $( '#ajax-select-post-categories' ).on( 'change', function( e ) {
    e.preventDefault();
    filter_post_by_cat_trigger( $( 'option:selected', this ) );
  } );

  function filter_post_by_cat_trigger( filterCategory ) {
    var loadMoreBtn = $( '#ajax-load-more-post' );

    loadMoreBtn.fadeOut( 400 );

    $( '#ajax-list-post' ).fadeOut( '400', function() {
      $( '.spinner' ).addClass( 'js-active' );
    } );

    var cpt = filterCategory.attr( 'data-cpt' );
    var cptTax = filterCategory.attr( 'data-tax' );
    var catID = filterCategory.attr( 'data-cat-id' );

    $( '#filter-cat-id' ).val( catID );
    $( '#filter-pagenum' ).val( 1 );

    filter_post_by_cat( catID, cpt, cptTax, loadMoreBtn );
  }

  function filter_post_by_cat( catID, cpt, cptTax, loadMoreBtn ) {
    $.ajax( {
      type: 'POST',
      dataType: 'html',
      url: localize_var.adminUrl,
      data: {
        action: 'filter_post_by_cat_ajax',
        catID: catID,
        cpt: cpt,
        cptTax: cptTax,
      },
      success: function( data ) {
        var $data = $( data );
        if ( $.trim( data ) != '' && $.trim( data ) != 0 ) {

          $( '#ajax-list-post > li' ).remove();

          setTimeout( function() {
            $( '#ajax-list-post' ).append( $data );
            $( '.spinner' ).removeClass( 'js-active' );
            $( '#ajax-list-post' ).fadeIn( 400 );
            loadMoreBtn.fadeIn( 400 );
          }, 300 );

          if ( $data.length < 6 ) {
            loadMoreBtn.removeClass( 'js-active disabled' ).addClass( 'disabled' );
          } else {
            loadMoreBtn.removeClass( 'js-active disabled' ).addClass( 'js-active' );
          }

        }
      },
      error: function( request, status, error ) {
        alert( request.responseText );
      }
    } );
    return false;
  }

  /*===========================================
  =            Ajax load more post            =
  ===========================================*/
  $( '#ajax-load-more-post' ).on( 'click', function( e ) {
    e.preventDefault();
    $( this ).removeClass( 'js-active' ).addClass( 'disabled' );
    $( '.spinner' ).addClass( 'js-active' );
    load_more_post( $( this ) );
  } );

  function load_more_post( $this ) {

    var cpt        = $this.attr( 'data-cpt' );
    var cptTax     = $this.attr( 'data-tax' );
    var catID      = $( '#filter-cat-id' ).val();
    var pageNumber = $( '#filter-pagenum' ).val();

    $.ajax( {
      type: 'POST',
      dataType: 'html',
      url: localize_var.ajax_url,
      data: {
        action: 'load_more_post_ajax',
        _ajax_nonce: localize_var.nonce,
        cpt: cpt,
        cptTax: cptTax,
        catID: catID,
        pageNumber: pageNumber,
      },
      success: function( data ) {

          var $data = $( data );

          if ( $.trim( $data ) != '' && $.trim( $data ) != 0 ) {

            $( '#filter-pagenum' ).val( parseInt( pageNumber ) + 1 );

            $( '#ajax-list-post' ).append( $data );

            $( '.spinner' ).removeClass( 'js-active' );

            if ( $data.length < 6 ) {
              $this.addClass( 'disabled' );
            } else {
              $this.removeClass( 'disabled' ).addClass( 'js-active' );
            }

          } else {
            $( '.spinner' ).removeClass( 'js-active' );
            $this.removeClass( 'js-active' ).addClass( 'disabled' );
          }

        } //success

    } ); //ajax
    return false;
  }


  /*====================================================
  =            Ajax filter post by dual cat            =
  ====================================================*/
  $( '#ajax-first-list-post-categories a, #ajax-second-list-post-categories a' ).on( 'click', function( e ) {
    e.preventDefault();
    $( this ).parents( 'ul' ).find( 'li' ).removeClass( 'js-active' );
    $( this ).parent( 'li' ).addClass( 'js-active' );
    filter_post_by_dual_cat_trigger();
  } );

  $( '#ajax-first-select-post-categories, #ajax-second-select-post-categories' ).on( 'change', function( e ) {
    e.preventDefault();
    filter_post_by_dual_cat_trigger( true );
  } );

  function filter_post_by_dual_cat_trigger( select ) {

    if ( select === undefined ) {
      select = false;
    }

    var loadMoreBtn = $( '#ajax-load-more-post-dual' );

    loadMoreBtn.fadeOut( 400 );

    $( '#ajax-list-post' ).fadeOut( '400', function() {
      $( '.spinner' ).addClass( 'js-active' );
    } );

    if ( select == true ) {
      var firsskellectFilterCategory = $( '#ajax-first-select-post-categories' );
      var secondSelectFilterCategory = $( '#ajax-second-select-post-categories' );

      var cpt = firsskellectFilterCategory.find( ':selected' ).data( 'cpt' );
      var firstCptTax = firsskellectFilterCategory.find( ':selected' ).data( 'first-tax' );
      var firstCatID = firsskellectFilterCategory.find( ':selected' ).data( 'first-cat-id' );
      var secondCptTax = secondSelectFilterCategory.find( ':selected' ).data( 'second-tax' );
      var secondCatID = secondSelectFilterCategory.find( ':selected' ).data( 'second-cat-id' );
    }

    if ( select == false ) {
      var firstFilterCategory = $( '#ajax-first-list-post-categories' ).find( 'li.js-active a' );
      var secondFilterCategory = $( '#ajax-second-list-post-categories' ).find( 'li.js-active a' );

      var cpt = firstFilterCategory.attr( 'data-cpt' );
      var firstCptTax = firstFilterCategory.attr( 'data-first-tax' );
      var firstCatID = firstFilterCategory.attr( 'data-first-cat-id' );
      var secondCptTax = secondFilterCategory.attr( 'data-second-tax' );
      var secondCatID = secondFilterCategory.attr( 'data-second-cat-id' );
    }

    $( '#filter-first-cat-id' ).val( firstCatID );
    $( '#filter-second-cat-id' ).val( secondCatID );
    $( '#filter-pagenum' ).val( 1 );

    filter_post_by_dual_cat( cpt, firstCptTax, firstCatID, secondCptTax, secondCatID, loadMoreBtn );
  }

  function filter_post_by_dual_cat( cpt, firstCptTax, firstCatID, secondCptTax, secondCatID, loadMoreBtn ) {
    $.ajax( {
      type: 'POST',
      dataType: 'html',
      url: localize_var.adminUrl,
      data: {
        action: 'filter_post_by_dual_cat_ajax',
        cpt: cpt,
        firstCptTax: firstCptTax,
        firstCatID: firstCatID,
        secondCptTax: secondCptTax,
        secondCatID: secondCatID
      },
      success: function( data ) {
        var $data = $( data );
        if ( $.trim( data ) != '' && $.trim( data ) != 0 ) {

          $( '#ajax-list-post > li' ).remove();

          setTimeout( function() {
            $( '#ajax-list-post' ).append( $data );
            $( '.spinner' ).removeClass( 'js-active' );
            $( '#ajax-list-post' ).fadeIn( 400 );
            loadMoreBtn.fadeIn( 400 );
          }, 300 );

          if ( $data.length < 6 ) {
            loadMoreBtn.removeClass( 'js-active' ).addClass( 'disabled' );
          } else {
            loadMoreBtn.removeClass( 'disabled' ).addClass( 'js-active' );
          }

        }
      },
      error: function( request, status, error ) {
        alert( request.responseText );
      }
    } );
    return false;
  }


  /*===============================================
  =            Ajax load more Dual CPT            =
  ===============================================*/
  $( '#ajax-load-more-post-dual' ).on( 'click', function( e ) {
    e.preventDefault();
    $( this ).removeClass( 'js-active' ).addClass( 'disabled' );
    $( '.spinner' ).addClass( 'js-active' );
    load_more_dual_cpt( $( this ) );
  } );

  function load_more_dual_cpt( $this ) {

    var cpt = $this.attr( 'data-cpt' );
    var firstCptTax = $this.attr( 'data-first-tax' );
    var firstCatID = $( '#filter-first-cat-id' ).val();
    var secondCptTax = $this.attr( 'data-second-tax' );
    var secondCatID = $( '#filter-second-cat-id' ).val();
    var pageNumber = $( '#filter-pagenum' ).val();

    $.ajax( {
      type: 'POST',
      dataType: 'html',
      url: localize_var.adminUrl,
      data: {
        action: 'load_more_dual_cpt_ajax',
        cpt: cpt,
        firstCptTax: firstCptTax,
        firstCatID: firstCatID,
        secondCptTax: secondCptTax,
        secondCatID: secondCatID,
        pageNumber: pageNumber,
      },
      success: function( data ) {

          var $data = $( data );

          if ( $.trim( data ) != '' && $.trim( data ) != 0 ) {

            $( '#filter-pagenum' ).val( parseInt( pageNumber ) + 1 );

            $( '#ajax-list-post' ).append( $data );

            $( '.spinner' ).removeClass( 'js-active' );

            if ( $data.length < 6 ) {
              $this.addClass( 'disabled' );
            } else {
              $this.removeClass( 'disabled' ).addClass( 'js-active' );
            }

          } else {
            $( '.spinner' ).removeClass( 'js-active' );
            $this.removeClass( 'js-active' ).addClass( 'disabled' );
          }

        } //success

    } ); //ajax
    return false;
  }

} ); // Document Ready
// $('.sticky-sidebar').stick_in_parent({
// 	offset_top: topSpacing + 30,
// 	spacer: false // disable disappearing sticky element when reach bottom
// });


// /*============================
// =            SMHS            =
// ============================*/
// /* Sticky Sidebar */
// var stickyEl = function stickyEl() {
//   var $topSpacing = '';
//   if ( window.innerWidth < 1051 ) {
//     $topSpacing = $('.mobile-header').outerHeight();
//   } else if ( window.innerWidth > 1050 ) {
//     $topSpacing = $('.header-primary-menu-section').outerHeight() + $('.header-secondary-menu-section').outerHeight();
//   }
//   if ( window.innerWidth > 767 ) {
//     $(".sticky-sidebar").trigger("sticky_kit:detach");
//     $('.sticky-sidebar').stick_in_parent({
//       offset_top: $topSpacing + 30,
//       spacer: false
//     });
//   }
// }
// stickyEl();
// window.addEventListener( 'resize', debounce(stickyEl, 200) );



// ============================
// =            LDVA            =
// ============================
// var stickyEl = function stickyEl() {
//   var topSpacing = headerHeight + $('#sections-menu-bar').outerHeight(); //margin
//   if ( window.innerWidth > 767 ) {
//     $("#img-stick-right").stick_in_parent({
//       offset_top: topSpacing
//     });

//     $("#img-stick-right").stick_in_parent()
//       .on("sticky_kit:stick", function(e) {
//         $(this).addClass('is-sticky');
//       })
//       .on("sticky_kit:unstick", function(e) {
//         $(this).removeClass('is-sticky');
//       })
//       .on("sticky_kit:bottom", function(e) {
//         $(this).removeClass('unbottom-out is-sticky').addClass('bottom-out');
//       })
//       .on("sticky_kit:unbottom", function(e) {
//         $(this).removeClass('bottom-out').addClass('unbottom-out is-sticky');
//       });

//     $('.sticky-sidebar').stick_in_parent({
//       offset_top: topSpacing + 30
//     });
//   }
// }
// stickyEl();
// window.addEventListener( 'resize', debounce(stickyEl, 200) );
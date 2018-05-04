jQuery(document).ready(function(n){n(".header__menu-toggle").click(function(e){n(this).toggleClass("js-active"),n(".header__menu").toggleClass("js-active"),e.preventDefault()}),n(".header__menu-close").click(function(e){n(".header__menu-toggle").toggleClass("js-active"),n(".header__menu").toggleClass("js-active"),e.preventDefault()}),
/* Add dropdown arrow for mobile parent menu */
n(".header__menu__parent-menu > li.menu-item-has-children > a").append("<span></span>"),n(".header__menu__parent-menu > li.menu-item-has-children > a span").on("click",function(e){e.preventDefault(),n(this).parent("a").siblings(".sub-menu").toggleClass("js-active")})}),// Document Ready
/*=================================
=            Buggyfill            =
=================================*/
/* Polyfill for vh,vw units on iphone4,5 */
window.viewportUnitsBuggyfill.init({refreshDebounceWait:50,hacks:window.viewportUnitsBuggyfillHacks});
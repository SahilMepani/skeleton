/*!
 * viewport-units-buggyfill v0.6.2
 * @web: https://github.com/rodneyrehm/viewport-units-buggyfill/
 * @author: Rodney Rehm - http://rodneyrehm.de/en/
 */

!function(){!function(e,t){"use strict";"function"==typeof define&&define.amd?define([],t):"object"==typeof exports?module.exports=t():e.viewportUnitsBuggyfill=t()}(this,function(){"use strict";function e(e,t){var n;return function(){var i=this,r=arguments,o=function(){e.apply(i,r)};clearTimeout(n),n=setTimeout(o,t)}}function t(){try{return window.self!==window.top}catch(e){return!0}}function n(n){if(!b){if(n===!0&&(n={force:!0}),w=n||{},w.isMobileSafari=S,w.isBadStockAndroid=A,!w.ignoreVmax||w.force||C||(R=!1),C||!w.force&&!S&&!R&&!A&&!M&&(!w.hacks||!w.hacks.required(w)))return window.console&&C&&console.info("viewport-units-buggyfill requires a proper CSSOM and basic viewport unit support, which are not available in IE8 and below"),{init:function(){}};window.dispatchEvent(new I("viewport-units-buggyfill-init")),w.hacks&&w.hacks.initialize(w),b=!0,y=document.createElement("style"),y.id="patched-viewport",document[w.appendToBody?"body":"head"].appendChild(y),f(function(){var n=e(r,w.refreshDebounceWait||100);window.addEventListener("orientationchange",n,!0),window.addEventListener("pageshow",n,!0),(w.force||R||t())&&(window.addEventListener("resize",n,!0),w._listeningToResize=!0),w.hacks&&w.hacks.initializeEvents(w,r,n),r()})}}function i(){y.textContent=u(),y.parentNode.appendChild(y),window.dispatchEvent(new I("viewport-units-buggyfill-style"))}function r(){b&&(a(),setTimeout(function(){i()},1))}function o(e){try{if(!e.cssRules)return}catch(t){if("SecurityError"!==t.name)throw t;return}for(var n=[],i=0;i<e.cssRules.length;i++){var r=e.cssRules[i];n.push(r)}return n}function a(){return g=[],k.call(document.styleSheets,function(e){var t=o(e);t&&"patched-viewport"!==e.ownerNode.id&&"ignore"!==e.ownerNode.getAttribute("data-viewport-units-buggyfill")&&(e.media&&e.media.mediaText&&window.matchMedia&&!window.matchMedia(e.media.mediaText).matches||k.call(t,s))}),g}function s(e){if(7===e.type){var t;try{t=e.cssText}catch(n){return}return E.lastIndex=0,void(E.test(t)&&!T.test(t)&&(g.push([e,null,t]),w.hacks&&w.hacks.findDeclarations(g,e,null,t)))}if(!e.style){if(!e.cssRules)return;return void k.call(e.cssRules,function(e){s(e)})}k.call(e.style,function(t){var n=e.style.getPropertyValue(t);e.style.getPropertyPriority(t)&&(n+=" !important"),E.lastIndex=0,E.test(n)&&(g.push([e,t,n]),w.hacks&&w.hacks.findDeclarations(g,e,t,n))})}function u(){m=l();var e,t,n=[],i=[];return g.forEach(function(r){var o=c.apply(null,r),a=o.selector.length?o.selector.join(" {\n")+" {\n":"",s=new Array(o.selector.length+1).join("\n}");return a&&a===e?(a&&!e&&(e=a,t=s),void i.push(o.content)):(i.length&&(n.push(e+i.join("\n")+t),i.length=0),void(a?(e=a,t=s,i.push(o.content)):(n.push(o.content),e=null,t=null)))}),i.length&&n.push(e+i.join("\n")+t),M&&n.push("* { content: normal !important; }"),n.join("\n\n")}function c(e,t,n){var i,r=[];i=n.replace(E,d),w.hacks&&(i=w.hacks.overwriteDeclaration(e,t,i)),t&&(r.push(e.selectorText),i=t+": "+i+";");for(var o=e.parentRule;o;)o.media?r.unshift("@media "+o.media.mediaText):o.conditionText&&r.unshift("@supports "+o.conditionText),o=o.parentRule;return{selector:r,content:i}}function d(e,t,n){var i=m[n],r=parseFloat(t)/100;return r*i+"px"}function l(){var e=window.innerHeight,t=window.innerWidth;return{vh:e,vw:t,vmax:Math.max(t,e),vmin:Math.min(t,e)}}function f(e){var t=0,n=function(){t--,t||e()};k.call(document.styleSheets,function(e){e.href&&h(e.href)!==h(location.href)&&"ignore"!==e.ownerNode.getAttribute("data-viewport-units-buggyfill")&&(t++,p(e.ownerNode,n))}),t||e()}function h(e){return e.slice(0,e.indexOf("/",e.indexOf("://")+3))}function p(e,t){v(e.href,function(){var n=document.createElement("style");n.media=e.media,n.setAttribute("data-href",e.href),n.textContent=this.responseText,e.parentNode.replaceChild(n,e),t()},t)}function v(e,t,n){var i=new XMLHttpRequest;if("withCredentials"in i)i.open("GET",e,!0);else{if("undefined"==typeof XDomainRequest)throw new Error("cross-domain XHR not supported");i=new XDomainRequest,i.open("GET",e)}return i.onload=t,i.onerror=n,i.send(),i}var w,m,g,y,b=!1,x=window.navigator.userAgent,E=/([+-]?[0-9.]+)(vh|vw|vmin|vmax)/g,T=/(https?:)?\/\//,k=[].forEach,R=/MSIE [0-9]\./i.test(x),C=/MSIE [0-8]\./i.test(x),M=x.indexOf("Opera Mini")>-1,S=/(iPhone|iPod|iPad).+AppleWebKit/i.test(x)&&function(){var e=x.match(/OS (\d+)/);return e&&e.length>1&&parseInt(e[1])<10}(),A=function(){var e=x.indexOf(" Android ")>-1;if(!e)return!1;var t=x.indexOf("Version/")>-1;if(!t)return!1;var n=parseFloat((x.match("Android ([0-9.]+)")||[])[1]);return 4.4>=n}();R||(R=!!navigator.userAgent.match(/MSIE 10\.|Trident.*rv[ :]*1[01]\.| Edge\/1\d\./));try{new I("test")}catch(O){var I=function(e,t){var n;return t=t||{bubbles:!1,cancelable:!1,detail:void 0},n=document.createEvent("CustomEvent"),n.initCustomEvent(e,t.bubbles,t.cancelable,t.detail),n};I.prototype=window.Event.prototype,window.CustomEvent=I}return{version:"0.6.1",findProperties:a,getCss:u,init:n,refresh:r}})}();
/*! For license information please see admin.js.LICENSE.txt */
!function(){"use strict";function e(e){for(var t=1;t<arguments.length;t++){var r=arguments[t];for(var n in r)e[n]=r[n]}return e}var t=function t(r,n){function i(t,i,o){if("undefined"!=typeof document){"number"==typeof(o=e({},n,o)).expires&&(o.expires=new Date(Date.now()+864e5*o.expires)),o.expires&&(o.expires=o.expires.toUTCString()),t=encodeURIComponent(t).replace(/%(2[346B]|5E|60|7C)/g,decodeURIComponent).replace(/[()]/g,escape);var a="";for(var c in o)o[c]&&(a+="; "+c,!0!==o[c]&&(a+="="+o[c].split(";")[0]));return document.cookie=t+"="+r.write(i,t)+a}}return Object.create({set:i,get:function(e){if("undefined"!=typeof document&&(!arguments.length||e)){for(var t=document.cookie?document.cookie.split("; "):[],n={},i=0;i<t.length;i++){var o=t[i].split("="),a=o.slice(1).join("=");try{var c=decodeURIComponent(o[0]);if(n[c]=r.read(a,c),e===c)break}catch(e){}}return e?n[e]:n}},remove:function(t,r){i(t,"",e({},r,{expires:-1}))},withAttributes:function(r){return t(this.converter,e({},this.attributes,r))},withConverter:function(r){return t(e({},this.converter,r),this.attributes)}},{attributes:{value:Object.freeze(n)},converter:{value:Object.freeze(r)}})}({read:function(e){return'"'===e[0]&&(e=e.slice(1,-1)),e.replace(/(%[\dA-F]{2})+/gi,decodeURIComponent)},write:function(e){return encodeURIComponent(e).replace(/%(2[346BF]|3[AC-F]|40|5[BDE]|60|7[BCD])/g,decodeURIComponent)}},{path:"/"});Object.assign(window,{Cookies:t}),jQuery((function(e){function r(t){var r=e(t),n=((e=21)=>{let t="",r=crypto.getRandomValues(new Uint8Array(e));for(;e--;)t+="useandom-26T198340PX75pxJACKVERYMINDBUSHWOLF_GQZbfghjklqvwyzrict"[63&r[e]];return t})(9);r.addClass(n);var i=r.attr("id");return i||(i=n,r.attr("id",i)),i}if("undefined"!=typeof codemirror_settings){var n=e(".codemirror_css");_.each(n,(function(t,n){r(t);var i=codemirror_settings.codemirror_css?_.clone(codemirror_settings.codemirror_css):{};i.codemirror=_.extend({},i.codemirror,{indentUnit:3,tabSize:3,autoRefresh:!0}),wp.codeEditor.initialize(e(t),i)}));var i=e(".codemirror_html");_.each(i,(function(t,n){r(t);var i=codemirror_settings.codemirror_html?_.clone(codemirror_settings.codemirror_html):{};i.codemirror=_.extend({},i.codemirror,{indentUnit:3,tabSize:3,autoRefresh:!0}),wp.codeEditor.initialize(e(t),i)}))}e.fn.fadeOutAndRemove=function(t){return this.fadeOut(t,(function(){e(this).remove()}))},e.fn.serializeObject=function(){var t={},r=this.serializeArray();return e.each(r,(function(){var e=this.name,r=this.value||"";e.indexOf("[]")>-1?(e=e.replace("[]",""),t[e]||(t[e]=[]),t[e].push(r)):void 0!==t[e]?(Array.isArray(t[e])||(t[e]=[t[e]]),t[e].push(r)):t[e]=r})),t},e(document).ajaxStart((function(){Pace.restart()})),e(document).on("click",".notice-dismiss",(function(t){e(this).closest(".notice.is-dismissible").fadeOut()})),e(".filter-tabs").each((function(n,i){var o=e(i),a=r(i),c=o.find(".tabs-nav"),s=o.find(".tabs-content"),d="cookie_".concat(a,"_").concat(n),u=t.get(d);u||(u=c.find("a:first").attr("href"),t.set(d,u,{expires:7,path:""})),c.find('a[href="'.concat(u,'"]')).addClass("current"),c.find("a").on("click",(function(r){r.preventDefault();var n=e(this),i=n.attr("href");t.set(d,i,{expires:7,path:""}),c.find("a.current").removeClass("current"),s.find(".tabs-panel:visible").removeClass("show").hide(),e(n.attr("href")).addClass("show").show(),n.addClass("current")})).filter(".current").trigger("click")})),e("#createuser").find("#send_user_notification").removeAttr("checked").attr("disabled",!0),e(document).on("submit","#hd_form",(function(t){t.preventDefault();var r=e(this),n=r.find('button[name="hd_submit_settings"]'),i=n.html();n.prop("disabled",!0).html('<i class="fa-solid fa-spinner fa-spin-pulse"></i>'),e.ajax({type:"POST",url:ajaxurl,data:{action:"submit_settings",_data:r.serializeObject(),_ajax_nonce:r.find('input[name="_wpnonce"]').val(),_wp_http_referer:r.find('input[name="_wp_http_referer"]').val()}}).done((function(e){n.prop("disabled",!1).html(i),r.find("#hd_content").prepend(e),setTimeout((function(){var e;null===(e=r.find("#hd_content").find(".dismissible-auto"))||void 0===e||e.fadeOutAndRemove(400)}),4e3)})).fail((function(e,t,r){n.prop("disabled",!1).html(i),console.log(r)}))}))}))}();
"use strict";function copyClipboardForm(a){var b=jQuery(a).prev(),c=jQuery(a).next();b.select(),document.execCommand("copy"),c.length&&c.show().fadeOut(2e3)}document.addEventListener("DOMContentLoaded",function(){var a=jQuery(".copy-form__button:not(.is-without-event)");a.length&&a.each(function(a,b){b.addEventListener("click",function(a){a.preventDefault(),copyClipboardForm(a.target)})})});
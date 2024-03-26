import './bootstrap';

import jQuery from "jquery";
Object.assign(window, { $: jQuery, jQuery })
//or
window.jQuery = window.$ = $

import Alpine from 'alpinejs';
window.Alpine = Alpine;

Alpine.start();
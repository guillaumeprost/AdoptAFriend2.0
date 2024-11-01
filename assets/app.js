import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

import './styles/app.scss';
import 'bootstrap';

import bsCustomFileInput from 'bs-custom-file-input';

import './bootstrap';

bsCustomFileInput.init();


const $ = require('jquery');
global.$ = global.jQuery = $;

require('bootstrap');
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');

// or you can include specific pieces
 require('bootstrap/js/dist/tooltip');
 require('bootstrap/js/dist/popover');

console.log('app.js loaded');

$(document).ready(function() {

    var bootstrap_enabled = (typeof $().modal == 'function');

    $('[data-toggle="popover"]').popover();
});


//Click animal card
/*$(document).ready(function() {
    $(".animal-card").on('click', function(event){
        // var card = event.elem;
        window.location.href = $(this).children('.card').data('link');
    });
});

//Click organisation card
$(document).ready(function() {
    $(".organisation-card").on('click', function(event){
        // var card = event.elem;
        window.location.href = $(this).children('.card').data('link');
    });
});
*/

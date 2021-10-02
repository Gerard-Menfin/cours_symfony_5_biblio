/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss'; /* ________________________________________________________________ */
                            /* COURS : il faut importer les fichiers (S)CSS que l'on veut créer */
                            /* ________________________________________________________________ */

// start the Stimulus application
const $ = require('jquery');
global.$ = global.jquery = $;
// import './bootstrap';
require("bootstrap");


$(function(){
    console.log("%c chargement js 0.1", 'background: #222; color: #bada55');
    if( $("html").prop("clientHeight") < $("body > .container").prop("clientHeight") ) {
        $("html").css("height", $("body>.container").prop("clientHeight"));
    }
});


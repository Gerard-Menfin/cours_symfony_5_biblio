import './styles/gestion.scss';

$(function(){
    console.log("%c chargement gestion.js 0.2", 'background: #222; color: #bada55');
    if( $("html").prop("clientHeight") < $("main").prop("clientHeight") ) {
        $("html").css("height", $("main").prop("clientHeight"));
    }
});

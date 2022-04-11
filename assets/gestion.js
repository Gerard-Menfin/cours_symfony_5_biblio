import './styles/gestion.scss';

$(function(){
    console.log("%c chargement gestion.js 1.0", 'background: #222; color: #bada55');
    if( $("html").prop("clientHeight") < $("main").prop("clientHeight") ) {
        $("html").css("height", $("main").prop("clientHeight"));
    }

    $("main.right-aside > div").css("margin-top", $("#menu").height());
});

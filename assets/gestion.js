import './styles/gestion.scss';

$(function(){
    console.log("%c chargement gestion.js 1.0", 'background: #222; color: #bada55');
    if( $("html").prop("clientHeight") < $("main").prop("clientHeight") ) {
        $("html").css("height", $("main").prop("clientHeight"));
    }

    $("main.right-aside > div").css("margin-top", $("#menu").height());
});


$(function(){
    console.log("%c chargement js 0.3", 'background: #222; color: #bada55');
    $("a.nav-link.ajax").on("click", function(evtClick){
        evtClick.preventDefault();
        $.ajax({
            url: $(this).prop("href"),
            dataType: "html",
            success: function(donnees) {
                $("#gestion-contenu").html(donnees);            
            },
            error: function(jqXHR, status, error){
                console.log(jqXHR);
                $("#gestion-contenu").html("<div class='alert alert-danger'>" + status + " : " + error + "</div>");
            }
        });
    });

    let main = document.querySelector("main");
    let hauteurAvant = main.clientHeight;
    main.style.height = "calc(100vh - 60px)";
    if(hauteurAvant > main.clientHeight) {
        main.style.height = hauteurAvant + "px";
    }

});
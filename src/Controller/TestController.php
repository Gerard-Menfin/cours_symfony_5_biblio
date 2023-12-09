<?php

namespace App\Controller;

use stdClass;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class TestController extends AbstractController
{
    /*
     ? @Route("/test1", name="app_test")
     ! NPM : ne pas mettre les 2 types de déclaration de route (l'annotation prend le dessus.)
     */
    // ? On peut changer le chemin mais il faut éviter de changer le nom de la route.

    #[Route('/test', name: 'app_test')]
    /**
     * La "fonction" Route :
     *  1er argument : le chemin relatif. TOUJOURS commencer par /
     * 
     *  Ensuite les arguments sont notés avec leur nom. Par 
     *  exemple, name, qui sera le nom utilisé pour utiliser
     *  cette route (pour un lien ou pour une redirection)
     * 
     * La méthode index du controleur TestController
     * @ Route("/test", name="app_test")
     * @return Response objet de la classe Response

     * @Route("/test", name="app_test")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TestController.php',
        ]);
    }

    #[Route("/test/salut8", name: 'app_test_salut')]
    public function salut8()
    {
        return $this->render("test/salut.html.twig");
    }
    /**
     * @Route("/test/salut")
     */
    public function salut()
    {
        return $this->json([ "salut" => "hello" ]);
    }

    // TODO EXO : créez une route /test/aujourdhui qui affiche la date du jour
    // date("d/m/Y")
    /**
     * @Route("/test/aujourdhui")
     */
    public function aujj()
    {   
        return $this->json([ "auj" => date("d/m/Y") ]);
    }

    /*
     * EXO : faire une route pour le chemin "/test/aujourdhui" qui affiche la date du jour.
     *       Utiliser un nouveau fichier twig pour l'affichage
            En PHP : date("d/m/Y")
    */
    #[Route('/test/auj', name: 'app_test_aujax')]
    public function auj()
    {
        return $this->render("test/auj.html.twig", [ "auj" => date("d/m/Y")]);
    }

    
    /**
     * @Route("/test/message")
     */
    public function message()
    {
        /* 
            ? Voici un exemple de messages flashes en mémoire. C'est un array associatif d'array
            ?    [                                                                              
            ?        "danger" => [                                                              
            ?                        "la requête a échoué",                                     
            ?                        "la bdd n'a pas été modifié",                              
            ?                        "erreur d'identifiants"                                    
            ?                    ],                                                             
            ??                                                                                  
            ?        "success" => [                                                             
            ?                        "requête réalisée avec succès",                            
            ?                        "nouveau livre enregistré avec succès",                    
            ?                        "identifiants corrects"                                    
            ?                    ],                                                             
            ??                                                                                  
            ?        "info"   => [                                                              
            ?                        "une nouvelle version est disponible",                     
            ?                        "il reste 2 jours pour profiter de l'offre",               
            ?                        "Vous êtes maintenant connecté"                            
            ?                    ],                                                             
            ?    ]                                                                              
            ?? 

            ? Les messages flash sont des messages enregistrés dans la session utilisateur. Permettent de passer un message d'une page à une autre.
            ? Une fois qu'ils ont été affiché, ils seront supprimés de la session.   
        */
        $this->addFlash("danger", "la requête a échoué");
        $this->addFlash("danger", "la bdd n'a pas été modifié");
        $this->addFlash("danger", "erreur d'identifiants");
        $this->addFlash("success", "requête réalisée avec succès");
        $this->addFlash("success", "nouveau livre enregistré avec succès");
        $this->addFlash("success", "identifiants corrects");
        $this->addFlash("success", "une nouvelle version est disponible");
        $this->addFlash("success", "il reste 2 jours pour profiter de l'offre");
        $this->addFlash("success", "Vous êtes maintenant connecté");

        return $this->render("test/message.html.twig", [
            "message" => "Voici le message à afficher"
        ]);

        return $this->render("test/message.html.twig", [
            "message" => "Voici le message à afficher"
        ]);
    }

    /**
     * Pour générer l'affichage, on utilise la méthode render
     *    1e argument : le fichier vue que l'on veut afficher
     *                  le nom du fichier est donné à partir du dossier "templates"
     *    2e argument : un array qui contient les variables nécéssaires à la vue
     *                  Les indices de cet array correspondent aux noms des variables
     *                  dans le fichier twig
     * 
     * Pour retourner une page 404 : Controller::createNotFoundException($message)
     * Pour retourner une page 403 : Controller::createAccessDeniedException($message)
     * 
     * 
     * @Route("/affiche-titre", name="app_test_titre")
     */
    public function titre()
    {
        throw $this->createNotFoundException('Page 404');
        throw $this->createAccessDeniedException("Page 403");
        return $this->render("test/titre.html.twig");
    }

    /**
     * @Route("/test/boucle", name="app_test_boucle")
     */
    public function boucle()
    {
        return $this->render("/test/boucle.html.twig", [ "taille" => 75 ]);
    }

    /**
     * @Route("/test/boucle/{taille}", name="app_test_param", requirements={"taille"="[0-9]+"})
     * 
     * Dans l'URL, la partie entre {} est dynamique. La valeur peut être différente à chaque 
     * appel.
     * Pour récupérer la valeur passée dans l'url, il faut définir un paramètre dans la méthode
     * (le paramètre a le même nom que ce qui est entre {})
     * 
     * REGEX : la chaîne de caractères doit correspondre au modèle défini dans la regex (expression réguilère)
     *  [0-9] : le caractère doit être compris entre le 0 et le 9
     *  \d    : le caractère doit être un chiffre (d pour digit, chiffre en anglais)
     *    +   : le caractère précédent le + doit être présent au moins 1 fois
     *    *   : le caractère précédent le * peut être présent 0 fois ou autant que l'on veut
     *    ?   : le caractère précédent le ? ne peut être présent qu'1 fois
     */
    public function routeAvecParametre($taille)
    {
        return $this->render("/test/boucle.html.twig", [ "taille" => $taille ]);
    }

    /**
     * @Route("/test/tableau", name="app_test_tableau")
     */
    public function tableau()
    {
        $variable = [ "nom" => "Faim", "prenom" => "Roger", "age" => 32 ];

        return $this->render("test/variable.html.twig", [ "variable" => $variable]);
    }

    #[Route("/test/salut/{nom}/{prenom}", name:"app_test_salut")]
    public function salutation($nom, $prenom)
    {
        $personne["nom"] = $nom;
        $personne["prenom"] = $prenom;
        $p2 = new \stdClass;
        
        return $this->render("test/personne.html.twig", [ "personne" => $personne ]);
    }



    /**
     * @Route("/test/objet", name="app_test_objet")
     */
    public function objet()
    {
        $objet = new stdClass;
        $objet->prenom = "Gérard";
        $objet->nom = "Menfaim";

        return $this->render("test/variable.html.twig", [ "variable" => $objet ]);
    }
    
    /**
    * @Route("/test/erreur", name="app_test_erreur")
    */
    public function erreur() {
        throw new \Exception("Error Processing Request", 1);
        
    }

    /*
        ? $this->getUser() permet de récupérer un objet de la classe Abonne contenant
        ? les informations de l'utilisateur connecté. 
        ? Vaut NULL si l'utilisateur n'est pas connecté.
    */


    /*
        ?  L'objet de la classe Request a des propriétés publiques de type objet qui contiennent toutes 
        ?  les valeurs des variables superglobales de PHP.
        ?       $request->query         contient        $_GET
        ?       $request->request       contient        $_POST
        ?       $request->files         contient        $_FILES
        ?       $request->server        contient        $_SERVER
        ?       $request->cookies       contient        $_COOKIES
        ?       $request->session       contient        $_SESSION
        ?   Ces différents objets ont des méthodes communes : get, has,...    
        ?   La méthode get() permet de récupérer la valeur voulue.
        ?   𝒆̲̅𝒙̲̅ : $motRecherche = $request->query->get("search");  
        ?        $motRecherche = $_GET["search"]
    */

    /*
        ? COURS : 
        ? Pour générer l'affichage, on utilise la méthode render
        ?     1er argument   : le fichier vue que l'on veut afficher
        ?         le nom du fichier est donné à partir du dossier "templates"
        ?     2ième argument : un array qui contient les variables nécéssaires à la vue
        ?         Les indices de cet array correspondent aux noms des variables
        ?         dans le fichier twig
            
        ? La fonction paginate va filter les produits à afficher selon le numéro de page demandé
        ?     1e argument : la liste totale des produits à afficher
        ?     2e argument : le numéro de la page actuelle
        ?     3e argument : le nombre de produits affichés par page
        ? 
    */

    /* 
        ? Voici un exemple de messages flashes en mémoire. C'est un array associatif d'array
        ?    [
        ?        "danger" => [
        ?                        "la requête a échoué",
        ?                        "la bdd n'a pas été modifié",
        ?                        "erreur d'identifiants"
        ?                    ],
        ?        "success" => [
        ?                        "requête réalisée avec succès",
        ?                        "nouveau livre enregistré avec succès",
        ?                        "identifiants corrects"
        ?                    ],
        ?        "info"   => [
        ?                        "une nouvelle version est disponible",
        ?                        "il reste 2 jours pour profiter de l'offre",
        ?                        "Vous êtes maintenant connecté"
        ?                    ],
        ?    ]        
    
    */

    /*
     * @Route("/calculatrice/{a}/{b}", requirements={"a"="\d+", "b"="\d+"})
      
        ? Une route paramétrée est définie par un chemin dont une partie est un paramètre
        ? Cette partie du chemin, indiqué entre {} est le nom du paramètre. 
        ? Pour récupérer sa valeur, il faut ajouter un argument à la méthode de la route. 
        ? L'argument doit avoir le même nom.
        
        ? requirements est une option qui permet de préciser à quoi doit ressembler un paramètre
        ?      requirements utilise les expressions régulières (REGEX)
            
        ? PHP : Quand on précise le type des arguments dans une fonction, si il y a un ?
        ? avant le type cela signifie que l'argument peut être de type null
        ?      ex: ?string         soit c'est un string, soit c'est null
        ?      RAPPEL : en PHP, null est un type de données (comme int, array, object, boolean, ...)
            
        ? SYMFONY : pour qu'un paramètre d'une route soit optionnel il faut ajouter un ?
        ?           après le paramètre en question dans les {}
     */
    #[Route('/calculatrice/{a}/{b?}', requirements:['a' => '\d+', 'b' => '\d+'])]
    public function calculatrice(int $a, ?int $b)
    {
        // dd($b);
        return $this->render("test/calculatrice.html.twig", [ "a" => $a, "b" => $b ]);
    }
    /* 
        TODO     AFFICHEZ sous forme de table HTML (<table>), les indices et les valeurs du 
        TODO     tableau
        TODO 
        TODO     | indices  | valeurs  |
        TODO     |----------|----------|
        TODO     | nom      |  Mentor  |
        TODO     | prenom   |  Gérard  |
    */

    /*
     ? Pour ajouter une route, il suffit d'ajouter une méthode à un contrôleur sans oublier l'annotation.
     ? Le mieux est de faire un copier-coller. Ne pas oublier de changer le nom de la fonction.

     ? Il ne faut surtout pas oublier de changer le 'name' de la route. Avoir 2 routes avec le même nom risque de rendre
     ? les 2 routes indisponibles.

     ? On essaiera de respecter la convention de nommage des routes de symfony : 
        app_nomDuControleur_nomFonction
     ? Pareil pour les vues : dans le dossier templates , 1 dossier ayant le nom du contrôleur. Souvent la vue aura le 
     ? nom de la fonction.

     ? Les variables sont passés comme valeur d'un tableau. L'indice sera le nom de la variable dans le fichier twig.
     */
    #[Route('/test/autre_route', name: 'app_test_autreroute')]
    public function autreRoute(): Response
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }

     /*
     ? Une route peut retourner du json (pour une connexion AJAX ou dans un projet API)
     ? l'argument passé à la méthode 'json' sera transformé en objet json 
     */
    #[Route('/test/ajax', name: 'app_test_aujax')]
    public function ajax()
    {
        $tableau = [ "nom" => "Onyme", "prenom" => "Anne" ];
        return $this->json($tableau);
    }

    #[Route('/test/entite', name: 'app_test_entite')]
    public function entite()
    {
        $tableau = [ "nom" => "Onyme", "prenom" => "Anne" ];
        return $this->json($tableau);
    }

//--------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------
    /**
     * @Route("/test/heritage")
     */
    public function heritage()
    {
        return $this->render("test/heritage.html.twig");
    }


    /**
     * @Route("/test/transitif")
     */
    public function transitif()
    {
        return $this->render("test/transitif.html.twig");
    }

    /**
     * @Route("/test/tableau")
     */
    public function tableau2()
    {
        $tab = [ "jour" => "07", "mois" => "mai", "annee" => 2021 ];

        return $this->render("test/variables.html.twig", [
            "tableau" => $tab,
            "tableau2" => [ 45, "test", true ],
            "nombre" => 0,
            "chaine" => ""
        ]);
    }


    /**
     * @Route("/test/salutation/{prenom?}")
     */
    // #[Route('/test/salutation/{prenom?}')]
    public function salutation2($prenom )
    {
        $prenom = $prenom ?? "inconnu";
        return $this->render("test/salutation.html.twig", [ 
            "prenom" => $prenom
            // "nombre" => 456    
        ]);
        // EXO : créez la vue et affichez dans la balise h1
            // Bonjour prenom
    }


    /**
     * @Route("/test/calcul/{nb1}-{nb2}", name="test_calcul", requirements={"nb1"="[0-9]+", "nb2"="[0-9]+"})
     */
    public function calcul($nb1, $nb2)
    {
        return $this->render("test/calcul.html.twig", [ "nb1" => $nb1, "nb2" => $nb2 ]);
    }



}

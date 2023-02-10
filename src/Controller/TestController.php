<?php

namespace App\Controller;

use stdClass;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class TestController extends AbstractController
{
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
    public function auj()
    {   
        return $this->json([ "auj" => date("d/m/Y") ]);
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
        */
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
     *    ?   : le caractère précédent le + ne peut être présent qu'1 fois
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

}

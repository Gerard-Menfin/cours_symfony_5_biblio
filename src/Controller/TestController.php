<?php

namespace App\Controller;

use stdClass;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TestController.php',
        ]);
    }

    /**
     * @Route("/test/salut")
     */
    public function salut()
    {
        return $this->json([ "salut" => "hello" ]);
    }

    // EXO : créez une route /test/aujourdhui qui affiche la date du jour
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
        /* Voici un exemple de messages flashes en mémoire. C'est un array associatif d'array
                [
                    "danger" => [
                                    "la requête a échoué",
                                    "la bdd n'a pas été modifié",
                                    "erreur d'identifiants"
                                ],

                    "success" => [
                                    "requête réalisée avec succès",
                                    "nouveau livre enregistré avec succès",
                                    "identifiants corrects"
                                ],

                    "info"   => [
                                    "une nouvelle version est disponible",
                                    "il reste 2 jours pour profiter de l'offre",
                                    "Vous êtes maintenant connecté"
                                ],
                ]        
        
        */
        return $this->render("test/message.html.twig", [
            "message" => "Voici le message à afficher"
        ]);
    }

    /**
     * @Route("/affiche-titre", name="test_titre")
     */
    public function titre()
    {
        throw $this->createNotFoundException('The product does not exist');
        return $this->render("test/titre.html.twig");
    }

    /**
     * @Route("/test/boucle", name="test_boucle")
     */
    public function boucle()
    {
        return $this->render("/test/boucle.html.twig", [ "taille" => 75 ]);
    }

    /**
     * @Route("/test/boucle/{taille}", name="test_param", requirements={"taille"="[0-9]+"})
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
     * @Route("/test/tableau", name="test_tableau")
     */
    public function tableau()
    {
        $variable = [ "nom" => "Faim", "prenom" => "Roger", "age" => 32 ];

        return $this->render("test/variable.html.twig", [ "variable" => $variable]);
    }

    /**
     * @Route("/test/objet", name="test_objet")
     */
    public function objet()
    {
        $objet = new stdClass;
        $objet->prenom = "Gérard";
        $objet->nom = "Menfaim";

        return $this->render("test/variable.html.twig", [ "variable" => $objet ]);
    }
    
    /**
    * @Route("/test/erreur", name="test_erreur")
    */
    public function erreur() {
        throw new \Exception("Error Processing Request", 1);
        
    }


}

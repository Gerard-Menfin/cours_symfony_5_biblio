<?php

namespace App\Controller;

use App\Form\RechercheType;
use App\Repository\LivreRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RechercheController extends AbstractController
{
    /**
     * @Route("/recherche", name="app_recherche")
     */
    public function index(Request $request, LivreRepository $lr): Response
    {
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

        // version avec RechercheType
        // $form = $this->createForm(RechercheType::class);
        // $form->handleRequest($request);
        // if($request->isMethod("POST")) dd($form, $form->get("search")->getData());
        // if( $form->isSubmitted() && $form->isValid() ){
            // $motRecherche = $form->get("search")->getData();
            $motRecherche = $request->query->get("search");
            return $this->render('recherche/index.html.twig', [
                'livres'            => $lr->recherche($motRecherche),
                "mot"               => $motRecherche,
                // 'livresParGenres'   => $lr->rechercheGenres($motRecherche)
            ]);
        // } else {
        //     $this->addFlash("danger", "Veuillez saisir le mot à rechercher");
        //     return $this->redirectToRoute("app_accueil");
        // }

    }

    /*
     ? Cette méthode ne sert qu'à l'affichage du formulaire de recherche. 
     ? Elle n'est pas liée à une route.
     */
    public function formulaire()
    {
        $form = $this->createForm(RechercheType::class);

        return $this->renderForm("recherche/_form.html.twig", [ "form" => $form ]);
    }
}

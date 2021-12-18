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
     * @Route("/recherche", name="recherche")
     */
    public function index(Request $request, LivreRepository $lr): Response
    {
        /* L'objet Request a des propriétés qui contiennent les valeurs de toutes les variables superglobales de PHP.
            $_GET   : $request->query
            $_POST  : $request->request
            $_FILES : $request->files
        
          ces propriétés sont des objets qui ont les mêmes méthodes : get, has,...     */
        // $motRecherche = $request->query->get("search");  // $motRecherche = $_GET["search"]

        // version avec RechercheType
        $form = $this->createForm(RechercheType::class);
        $form->handleRequest($request);
        if( $form->isSubmitted() && $form->isValid() ){
            $motRecherche = $form->get("search")->getData();
            return $this->render('recherche/index.html.twig', [
                'livres' => $lr->findBySearch($motRecherche),
                "mot" => $motRecherche
            ]);
        } else {
            $this->addFlash("danger", "Veuillez saisir le mot à rechercher");
            return $this->redirectToRoute("home");
        }

    }

    /**
     * Cette méthode ne sert qu'à l'affichage du formulaire de recherche. Il n'est pas lié à une route
     */
    public function formulaire()
    {
        $form = $this->createForm(RechercheType::class);

        return $this->renderForm("recherche/_form.html.twig", [ "form" => $form ]);
    }
}

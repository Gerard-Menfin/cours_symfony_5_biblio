<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Entity\Livre;
use App\Form\RechercheType;
use App\Repository\LivreRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RechercheController extends AbstractController
{
    private $managerRegistry;
    public function __construct(ManagerRegistry $managerRegistry) {
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @Route("/recherche", name="app_recherche")
     */
    public function index(Request $request, LivreRepository $lr): Response
    {
            $motRecherche = $request->query->get("search");
            return $this->render('recherche/index.html.twig', [
                'livres'            => $lr->recherche($motRecherche),
                "mot"               => $motRecherche,
                // 'livresParGenres'   => $lr->rechercheGenres($motRecherche)
            ]);

    }

    /**
     * @Route("/admin/recherche", name="app_admin_recherche")
     */
    public function admin(Request $request): Response
    {
        /**
         * @var \App\Repository\GenreRepository $gr
         */
        $gr = $this->managerRegistry->getRepository(Genre::class);
        /**
         * @var \App\Repository\LivreRepository $lr
         */
        $lr = $this->managerRegistry->getRepository(Livre::class);
        $motRecherche = $request->query->get("search");
        return $this->render('admin/recherche/index.html.twig', [
            'livres'    => $lr->recherche($motRecherche),
            'genres'    => $gr->recherche($motRecherche),
            "mot"       => $motRecherche,
            // 'livresParGenres'   => $lr->rechercheGenres($motRecherche)
        ]);

    }

    /**
    * @Route("/recherche-form", name="app")
    */
    public function rechercheForm(Request $request, LivreRepository $lr) {
        // version avec RechercheType
        $form = $this->createForm(RechercheType::class);
        $form->handleRequest($request);
        // if($request->isMethod("POST")) dd($form, $form->get("search")->getData());
        if( $form->isSubmitted() && $form->isValid() ){
            $motRecherche = $form->get("search")->getData();
        } else {
            $this->addFlash("danger", "Veuillez saisir le mot à rechercher");
            return $this->redirectToRoute("app_accueil");
        }
    }

    /*
     💬 Cette méthode ne sert qu'à l'affichage du formulaire de recherche. 
     💬 Elle n'est pas liée à une route.
     */
    public function formulaire()
    {
        $form = $this->createForm(RechercheType::class);

        return $this->renderForm("recherche/_form.html.twig", [ "form" => $form ]);
    }
}

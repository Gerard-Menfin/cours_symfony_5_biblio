<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Entity\Livre;
use App\Entity\Auteur;
use App\Repository\GenreRepository;
use App\Repository\AuteurRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VisiteurController extends AbstractController
{
    #[Route('/auteur/{id}', name: 'app_visiteur_auteur')]
    public function index(Auteur $auteur): Response
    {
        return $this->render('auteur/fiche.html.twig', compact("auteur"));
    }

    /**
     * @Route("/fiche-livre-{id}", name="app_visiteur_livre_fiche", requirements={"id"="\d+"})
     */
    public function livre(Livre $livre)
    {
        return $this->render("livre/fiche.html.twig", [ "livre" => $livre ]);
    }

    /* =================================== GENRES =================================== */
    /**
    * @Route("/genres", name="app_visiteur_genre")
    */
    public function genres(GenreRepository $gr) {
        return $this->render("genre/index.html.twig", [ "genres" => $gr->findBy([], ["libelle" => "ASC"]) ]);
        
    }

    /**
    * @Route("/genres/{libelle}", name="app_visiteur_genre_fiche")
    */
    public function genre(Genre $genre) {
        return $this->render("genre/fiche.html.twig", compact("genre"));
    }

    /* =================================== AUTEURS =================================== */
    /**
    * @Route("/auteurs", name="app_visiteur_auteur")
    */
    public function auteurs(AuteurRepository $ar) {
        return $this->render("auteur/index.html.twig", [ "auteurs" => $ar->findBy([], ["nom" => "ASC", "prenom" => "ASC"]) ]);
        
    }

    /**
    * @Route("/auteurs/{id}", name="app_visiteur_auteur_fiche")
    */
    public function auteur(Auteur $auteur) {
        return $this->render("auteur/fiche.html.twig", compact("auteur"));
    }
}

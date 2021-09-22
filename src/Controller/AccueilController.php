<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LivreRepository;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(LivreRepository $lr): Response
    {
        /* COURS : Pour générer l'affichage, on utilise la méthode render
            1er argument   : le fichier vue que l'on veut afficher
                le nom du fichier est donné à partir du dossier "templates"
            2ième argument : un array qui contient les variables nécéssaires à la vue
                Les indices de cet array correspondent aux noms des variables
                dans le fichier twig
        */

        return $this->render('accueil/index.html.twig', [
            'liste_livres' => $lr->findAll()
        ]);
    }

    /**
     * @Route("/base")
     */
    public function base()
    {
        return $this->render("base.html.twig");
    }
}

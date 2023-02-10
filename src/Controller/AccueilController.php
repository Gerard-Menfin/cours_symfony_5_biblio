<?php

namespace App\Controller;

use App\Repository\LivreRepository;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface as Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="app_accueil")
     */
    public function index(LivreRepository $lr, Paginator $paginator, Request $rq): Response
    {
        // $this->redirectToRoute("app_test");
        /**
            COURS : 
            Pour générer l'affichage, on utilise la méthode render
                1er argument   : le fichier vue que l'on veut afficher
                    le nom du fichier est donné à partir du dossier "templates"
                2ième argument : un array qui contient les variables nécéssaires à la vue
                    Les indices de cet array correspondent aux noms des variables
                    dans le fichier twig

            La fonction paginate va filter les produits à afficher selon le numéro de page demandé
                1e argument : la liste totale des produits à afficher
                2e argument : le numéro de la page actuelle
                3e argument : le nombre de produits affichés par page
        */

        $livres = $lr->findAll();
        $page = $rq->query->get("page", 1);
        $nombreParPage = 6;
        $listeLivres = $paginator->paginate($livres, $page , $nombreParPage);

        return $this->render('accueil/index.html.twig', [
            'liste_livres' => $listeLivres
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
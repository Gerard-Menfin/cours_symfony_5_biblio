<?php

namespace App\Controller\Admin;

use App\Repository\LivreRepository;
use App\Repository\AbonneRepository;
use App\Repository\AuteurRepository;
use App\Repository\EmpruntRepository;
use App\Repository\GenreRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GestionController extends AbstractController
{
    /**
     * @Route("/admin/gestion", name="app_admin_gestion")
     */
    public function index(LivreRepository $lr, EmpruntRepository $er, AbonneRepository $ar, AuteurRepository $aR, GenreRepository $gr){
        $emprunts = $er->findAll(["dateRetour" => "ASC", "dateEmprunt" => "ASC"]);
        $empruntsEnCours = $er->findByNonRendus();
        
        $emprunts["liste"] = $emprunts;
        $emprunts["nb"] = $er->nb();
        $emprunts["en cours"] = $empruntsEnCours;
        
        $livres["liste"] = $lr->findAll();
        $livres["nb"] = $lr->nb();
        $livres["nbSortis"] = $lr->nbLivresEmpruntes();
        $livres["nbDisponibles"] = $lr->nbLivresDisponibles();
        $livres["plusAncienEmprunt"] = count($empruntsEnCours) ? $empruntsEnCours[0] : null;
        $livres_empruntes = $lr->lesPlusEmpruntes();
        // $livres_empruntes = array_splice($livres_empruntes, 0, 5);
        $livres["plusEmprunte"] = $livres_empruntes ? $livres_empruntes[0] : null;
        $livres["moinsEmprunte"] = $livres_empruntes ? end($livres_empruntes) : null;
        
        $abs = $ar->findOrderedByNbEmprunts();
        $abonnes["liste"]       = $ar->findAll();
        $abonnes["nb"]          = $ar->nb();
        $abonnes["emprunteurs"] = $ar->findByLivresNonRendus();
        $abonnes["assidu"]      = empty($abs) ? null : $abs[0];
        $bibliophiles           = $ar->findOrderedByNbLivresEmpruntes();
        $abonnes["bibliophile"] = $bibliophiles ?  $bibliophiles[0] : null;

        $auteurs["liste"]       = $aR->findAll();
        $auteurs["prolifique"]  = $aR->findProlifique();
        $auteurs["faineant"]    = $aR->findProlifique(false);
        $auteurs["nb"]          = $ar->nb();
        // $auteurs["plebiscite"] = $aR->findPlebiscite();
        // $auteurs["deteste"] = $aR->findDeteste();

        $genres["liste"]            = $gr->findAll();
        $genres["nb"]               = $gr->nb();
        $plusPresent                = $gr->findByNbLivres(true);
        $moinsPresent               = $gr->findByNbLivres(false);
        $genres["nbPlusPresent"]    = $plusPresent ? $plusPresent[0][0]->getLivres()->count() : 0;
        $genres["nbMoinsPresent"]   = $moinsPresent ? $moinsPresent[0][0]->getLivres()->count() : 0;
        $genres["plusPresent"]      = "";
        $genres["moinsPresent"]     = "";
        foreach ($plusPresent as $genre) {
            $genre = $genre[0];
            $genres["plusPresent"] .= ($genres["plusPresent"] ? ", " : "") . $genre->getLibelle();
        }
        foreach ($moinsPresent as $genre) {
            $genre = $genre[0];
            $genres["moinsPresent"] .= ($genres["moinsPresent"] ? ", " : "") . $genre->getLibelle();
        }
        $nombdd = $lr->nomBDD();

        return $this->render("admin/gestion.html.twig", compact("livres", "abonnes", "emprunts", "nombdd", "auteurs", "genres"));
    }

}

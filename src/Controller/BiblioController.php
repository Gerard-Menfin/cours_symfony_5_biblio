<?php

namespace App\Controller;

use DateTime;
use App\Repository\LivreRepository;
use App\Repository\EmpruntRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BiblioController extends AbstractController
{
    /** 
     *  
     * @Route("/biblio", name="app_biblio")
     */
    public function index(EmpruntRepository $er): Response
    {
        $tousLesEmprunts = $er->findAll();
        return $this->render('biblio/index.html.twig', [
            'tousLesEmprunts' => $tousLesEmprunts
        ]);
    }

    /**
     * @Route("/biblio/retour-emprunt-{id}", name="app_biblio_retour", requirements={"id"="[0-9]+"})
     */
    public function retour(EntityManagerInterface $em, EmpruntRepository $er, $id)
    {
        $empruntAmodifier = $er->find($id);
        $dateRetour = new DateTime();
        $empruntAmodifier->setDateRetour( $dateRetour );
        $em->flush();  //
        return $this->redirectToRoute("app_biblio");
    }

    /**
    * @Route("/biblio/livres", name="app_biblio_livres")
    */
    public function livres(LivreRepository $lr) {
        $livres_disponibles = $lr->livresDisponibles();
        $livres_indisponibles = $lr->livresIndisponibles();
        return $this->render("biblio/livres.html.twig", compact("livres_disponibles", "livres_indisponibles"));
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\EmpruntRepository;
use DateTime;

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
}

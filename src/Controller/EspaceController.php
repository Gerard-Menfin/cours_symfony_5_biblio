<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/espace")
 */
class EspaceController extends AbstractController
{
    
    /**
     * @Route("/", name="espace")
     */
    public function index(): Response
    {
        return $this->render('espace/index.html.twig');
    }

    /**
     * @Route("/profil", name="profil")
     */
    public function profil(): Response
    {
        return $this->render('espace/profil.html.twig', []);
    }

}

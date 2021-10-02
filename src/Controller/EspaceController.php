<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/espace-lecture")
 * @IsGranted("ROLE_LECTEUR")
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

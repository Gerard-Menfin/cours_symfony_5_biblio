<?php

namespace App\Controller\Dev;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoursController extends AbstractController
{
    /**
     * @Route("/cours", name="cours")
     */
    public function index(): Response
    {
        // TODO : entité exercices ?
        return $this->render('dev/cours/index.html.twig', [
            'controller_name' => 'CoursController',
        ]);
    }
}

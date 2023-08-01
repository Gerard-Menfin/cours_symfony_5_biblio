<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ex0', name: 'app_exercices')]
class ExercicesController extends AbstractController
{
    #[Route('/exercices', name: 'app_exercices')]
    public function index(): Response
    {
        return $this->render('exercices/index.html.twig', [
            'controller_name' => 'ExercicesController',
        ]);
    }

    #[Route('/calculatrice/{a}/{b?}', requirements:['a' => '[0-9]+', 'b' => '\d+'])]
    public function calculatrice(int $a, ?int $b)
    {
        return $this->render("exercices/calculatrice.html.twig", [ "a" => $a, "b" => $b ]);
    }

}

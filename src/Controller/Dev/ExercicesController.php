<?php

namespace App\Controller\Dev;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExercicesController extends AbstractController
{
    #[Route('/dev/exercices', name: 'app_dev_exercices')]
    public function index(): Response
    {
        return $this->render('dev/exercices/index.html.twig', [
            'controller_name' => 'ExercicesController',
        ]);
    }
}

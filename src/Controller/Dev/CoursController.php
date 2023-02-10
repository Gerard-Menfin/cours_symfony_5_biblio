<?php

namespace App\Controller\Dev;

use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoursController extends AbstractController
{
    /**
     * @Route("/cours", name="app_cours")
     */
    public function index(): Response
    {
        // TODO : entité exercices ?
        return $this->render('dev/cours/index.html.twig', [
            'cours' => ""//include("../_docs/textes_cours.php")
        ]);
    }

    #[Route("/dev/bdd", name: "app_dev_maj")]
    public function maj(LivreRepository $lr, EntityManagerInterface $em)
    {
        $data = [
            [1, '1984', 'Un monde dystopique où tout le monde est surveillé par Big Brother et où les enfants dénoncent leurs parents', '1984.jpg', 3],
            [2, 'Dune', "Une planète aride qui contient le bien le plus précieux de la galaxie : l\'épice", 'dune.jpg', 2],
            [4, 'Akira', 'Une bande de motards dans la ville de Neo-Tokyo en 2010', 'akira.jpg', 4],
            [5, 'Fondation et Empire', 'suite de Fondation', 'fondation_et_empire.jpg', 1],
            [6, 'Gunnm', 'Manga futuriste', 'gunnm.jpg', 5],
            [7, 'I, robot', 'Des robots se fondent dans la masse...', 'i_robot.jpg', 1],
            [8, 'Le Messie de Dune', 'Le héros de Dune prend un rôle plus mystique', NULL, 2]
        ];

        foreach ($data as $record) {
            $livre = $lr->find($record[0]);
            $livre->setTitre($record[1]);
            $livre->setResume($record[2]);
            $livre->setCouverture($record[3]);
            $lr->save($livre);
        }
        $lr->save($livre, true);
        return $this->redirectToRoute("app_admin_livre_index");

    }
}

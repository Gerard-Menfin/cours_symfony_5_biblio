<?php

namespace App\Controller;

use App\Entity\Emprunt;
use App\Entity\Livre;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="profil")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(): Response
    {
        /* Pour récupérer l'utilsateur connecté dans un contrôleur : $this->getUser() */
        $utilisaterConnecte = $this->getUser();
        return $this->render('profil/index.html.twig');
    }

    /**
     * @Route("/profil/emprunter-livre-{id}", name="profil_emprunter", requirements={"id"="\d+"})
     * @IsGranted("ROLE_LECTEUR")
     */
    public function emprunter(EntityManagerInterface $em, Livre $livre)
    {
        $emprunt = new Emprunt;
        $emprunt->setAbonne( $this->getUser() );
        $emprunt->setDateEmprunt( new DateTime() );
        $emprunt->setLivre( $livre );
        $em->persist($emprunt);
        $em->flush();
        $this->addFlash("success", "Votre emprunt du livre <strong>" . $livre->getTitre() . "</strong> a été enregistré");
        return $this->redirectToRoute("profil");
    }


}

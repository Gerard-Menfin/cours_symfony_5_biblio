<?php

namespace App\Controller;

use DateTime;
use App\Entity\Livre;
use App\Entity\Emprunt;
use App\Form\LivreType;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\AsciiSlugger;
/**
 * @Route("/livre", name="app_livre")
 */
class LivreController extends AbstractController
{





    /**
     * @Route("/emprunter/{id}", name="_emprunter", requirements={"id"="\d+"})
     */
    public function emprunter(EntityManagerInterface $em, Livre $livre)
    {
        $emprunt = new Emprunt;
        $emprunt->setAbonne( $this->getUser() );
        $emprunt->setDateEmprunt( new DateTime() );
        $emprunt->setLivre( $livre );
        $em->persist( $emprunt );
        $em->flush();
        $this->addFlash("success", "Votre emprunt du livre <strong>" . $livre->getTitre() . "</strong> a été enregistré");
        return $this->redirectToRoute("app_espace");
    }

    /**
     * @Route("/fiche/{id}", name="_fiche", requirements={"id"="\d+"})
     */
    public function fiche(LivreRepository $lr, $id)
    {
       /* 
          !EXO : Affichez les informations du livre puis la liste de toutes les fois où le
          !     livre a été emprunté
       */
        $livre = $lr->find($id);
        return $this->render("livre/fiche.html.twig", [ "livre" => $livre ]);
    }    

    /**
     * @Route("/fiche/{url}", name="_fiche2")
     */
    public function ficheLivre(Livre $livre) {
        return $this->render("livre/fiche.html.twig", compact("livre"));
    }


}

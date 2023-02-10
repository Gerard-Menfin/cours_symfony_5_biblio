<?php

namespace App\Controller\Admin;

use App\Entity\Abonne;
use App\Form\AbonneType;
use App\Repository\AbonneRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface as Hasher;

/**
 * COURS : si Route est avant la classe, il s'applique à toutes les routes de la classe
 *          ex : toutes les routes commenceront par '/admin/abonne'
 * je peux utiliser 
 * IsGranted("ROLE_ADMIN") pour limiter toutes les routes de ce controleur
 * 
 * @Route("/admin/abonne", name="app_admin_")
 */
class AbonneController extends AbstractController
{
    /**
     * @Route("/", name="abonne_index", methods={"GET"})
     */
    public function index(AbonneRepository $abonneRepository): Response
    {
        return $this->render('admin/abonne/index.html.twig', [
            'abonnes' => $abonneRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="abonne_new", methods={"GET","POST"})
     */
    public function new(Request $request, Hasher $hasher, AbonneRepository $ar): Response
    {
        $abonne = new Abonne();
        $form = $this->createForm(AbonneType::class, $abonne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On récupére le mot de passe tapé dans le formulaire
            $mdp = $form->get("password")->getData();
            // On encode le mot de passe récupéré
            $mdp = $hasher->hashPassword($abonne, $mdp);
            // On définit la propriété 'password' de l'entité Abonne à insérer en bdd
            $abonne->setPassword( $mdp );

            $ar->save($abonne, true);

            return $this->redirectToRoute('admin_abonne_index');
        }

        return $this->render('admin/abonne/new.html.twig', [
            'abonne' => $abonne,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="abonne_show", methods={"GET"})
     */
    public function show(Abonne $abonne): Response
    {
        return $this->render('admin/abonne/show.html.twig', [
            'abonne' => $abonne,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="abonne_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Hasher $hasher, Abonne $abonne, AbonneRepository $ar): Response
    {
        $form = $this->createForm(AbonneType::class, $abonne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if( $mdp = $form->get("password")->getData() ){
                $mdp = $hasher->hashPassword($abonne, $mdp);
                $abonne->setPassword( $mdp );
            }
            $ar->save($abonne, true);

            return $this->redirectToRoute('app_admin_abonne_index');
        }

        return $this->render('admin/abonne/edit.html.twig', [
            'abonne' => $abonne,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="abonne_delete", methods={"POST"})
     */
    public function delete(Request $request, Abonne $abonne, AbonneRepository $ar): Response
    {
        if ($this->isCsrfTokenValid('delete'.$abonne->getId(), $request->request->get('_token'))) {
            $ar->remove($abonne, true);
        }

        return $this->redirectToRoute('app_admin_abonne_index');
    }

    /**
     * @Route("/pseudo/{pseudo}")
     */
    public function pseudo(Abonne $abonne)
    {
        /* On peut récupérer une entité selon un paramètre passé dans le chemin.
          il faut que le paramètre ait le nom d'une propriété de l'entité */
        dd($abonne);
    }
}

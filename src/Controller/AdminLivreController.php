<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\Livre1Type;
use App\Entity\Categorie;
use App\Form\LivreCategoriesType;
use App\Repository\LivreRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/livre")
 */
class AdminLivreController extends AbstractController
{
    /**
     * @Route("/liste", name="admin_livre_index", methods={"GET"})
     */
    public function index(LivreRepository $livreRepository): Response
    {
        return $this->render('admin_livre/index.html.twig', [
            'livres' => $livreRepository->findAll(),
        ]);
    }

    /**
     * COURS : ⚠ si la route show est avant la route new, c'est la fonction show qui sera exécutée '/admin/livre/new'
     *          Pour éviter cette erreur, on ajoute une restriction sur la partie variable du chemin, avec le paramètre 'requirements'
     * @Route("/{id}", name="admin_livre_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show(Livre $livre): Response
    {
        return $this->render('admin_livre/show.html.twig', [
            'livre' => $livre,
        ]);
    }

    /* *************************************************************************  */
    // ROUTES new et edit avec le formulaire utilisant CollectionType
    
    /**
     * @Route("/ajouter", name="admin_livre_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $livre = new Livre();
        // $livre->addCategory(new Categorie);
        $form = $this->createForm(Livre1Type::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($livre);
            $entityManager->flush();

            return $this->redirectToRoute('admin_livre_index');
        }

        return $this->render('admin_livre/new.html.twig', [
            'livre' => $livre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/modifier/{id}", name="admin_livre_edit", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function edit(Request $request, Livre $livre): Response
    {
        $form = $this->createForm(Livre1Type::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_livre_index');
        }

        return $this->render('admin_livre/edit.html.twig', [
            'livre' => $livre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/supprimer/{id}", name="admin_livre_delete", methods={"POST"}, requirements={"id"="\d+"})
     */
    public function delete(Request $request, Livre $livre): Response
    {
        if ($this->isCsrfTokenValid('delete'.$livre->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($livre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_livre_index');
    }

    
    /* *************************************************************************  */
    // ROUTES new et edit avec le formulaire utilisant EntityType (ChoiceType) 

    /**
     * AJOUTER avec TOUTES LES CATEGORIES
     * @Route("/nouveau", name="admin_livre_new_cat", methods={"GET","POST"})
     */
    public function new_cat(Request $request): Response
    {
        $livre = new Livre();
        $form = $this->createForm(LivreCategoriesType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($livre);
            $entityManager->flush();

            return $this->redirectToRoute('admin_livre_index');
        }

        return $this->render('admin_livre/new.html.twig', [
            'livre' => $livre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="admin_livre_edit_cat", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function edit_cat(Request $request, Livre $livre): Response
    {
        $form = $this->createForm(LivreCategoriesType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_livre_index');
        }

        return $this->render('admin_livre/edit.html.twig', [
            'livre' => $livre,
            'form' => $form->createView(),
        ]);
    }
    
}

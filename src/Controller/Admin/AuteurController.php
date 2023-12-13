<?php

namespace App\Controller\Admin;

use App\Entity\Auteur;
use App\Form\AuteurType;
use Knp\Component\Pager\PaginatorInterface as Paginator;
use App\Repository\AuteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/auteur", name="app_")
 */
class AuteurController extends AbstractController
{
    /**
     * @Route("/", name="admin_auteur_index", methods={"GET"})
     */
    public function index(AuteurRepository $auteurRepository, Paginator $paginator, Request $rq): Response
    {
        return $this->render('admin/auteur/index.html.twig', [
            'auteurs' => $paginator->paginate($auteurRepository->findAll(), $rq->query->get("page", 1)),
        ]);
    }

    /**
     * @Route("/new", name="admin_auteur_new", methods={"GET", "POST"})
     */
    public function new(Request $request, AuteurRepository $ar): Response
    {
        $auteur = new Auteur();
        $form = $this->createForm(AuteurType::class, $auteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ar->save($auteur, true);

            return $this->redirectToRoute('app_admin_auteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/auteur/new.html.twig', [
            'auteur' => $auteur,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_auteur_show", methods={"GET"})
     */
    public function show(Auteur $auteur): Response
    {
        return $this->render('admin/auteur/show.html.twig', [
            'auteur' => $auteur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_auteur_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Auteur $auteur, AuteurRepository $ar): Response
    {
        $form = $this->createForm(AuteurType::class, $auteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ar->save($auteur, true);
            return $this->redirectToRoute('app_admin_auteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/auteur/edit.html.twig', [
            'auteur' => $auteur,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/delete", name="admin_auteur_delete", methods={"POST"})
     */
    public function delete(Request $request, Auteur $auteur, AuteurRepository $ar): Response
    {
        if ($this->isCsrfTokenValid('delete' . $auteur->getId(), $request->request->get('_token'))) {
            $ar->remove($auteur, true);
        }

        return $this->redirectToRoute('app_admin_auteur_index', [], Response::HTTP_SEE_OTHER);
    }

    public function form()
    {
        /**
         * 💬 createForm sera appelé sans 2ième argument. cf GenreType.php
         */

        $form = $this->createForm(AuteurType::class);
        return $this->renderForm("admin/auteur/_inline_form.html.twig", ["form" => $form]);
    }

    /**
     * @Route("/ajouter", name="admin_auteur_new_ajax", methods={"POST"})
     */
    public function ajaxNew(Request $request, AuteurRepository $ar): Response
    {
        $auteur = new Auteur();
        $form = $this->createForm(AuteurType::class, $auteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ar->save($auteur, true);

            return $this->json(["reponse" => true, "message" => "Nouvel auteur enregistré"]);
        }
        
        return $this->json(["reponse" => false, "message" => "Erreur formulaire",
            "submited" => $form->isSubmitted(),
            "valid" => $form->isValid()
        ]);
    }
}

<?php

namespace App\Controller\Admin;

use App\Entity\Genre;
use App\Form\GenreType;
use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/genre")
 */
class GenreController extends AbstractController
{
    /**
     * @Route("/", name="app_admin_genre_index", methods={"GET"})
     */
    public function index(GenreRepository $genreRepository): Response
    {
        return $this->render('admin/genre/index.html.twig', [
            'genres' => $genreRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_admin_genre_new", methods={"GET","POST"})
     */
    public function new(Request $request, GenreRepository $gr): Response
    {
        $genre = new Genre();
        $form = $this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $gr->save($genre, true);

            return $this->redirectToRoute('app_admin_genre_index');
        }

        return $this->render('admin/genre/new.html.twig', [
            "entite" => $genre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_genre_show", methods={"GET"})
     */
    public function show(Genre $genre): Response
    {
        return $this->render('admin/genre/show.html.twig', [
            "entite" => $genre,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_admin_genre_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Genre $genre, GenreRepository $gr): Response
    {
        $form = $this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $gr->save($genre, true);

            return $this->redirectToRoute('app_admin_genre_index');
        }

        return $this->render('admin/genre/edit.html.twig', [
            "entite" => $genre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_genre_delete", methods={"POST"})
     */
    public function delete(Request $request, Genre $genre, GenreRepository $gr): Response
    {
        if ($this->isCsrfTokenValid('delete'.$genre->getId(), $request->request->get('_token'))) {
            $gr->remove($genre, true);
        }

        return $this->redirectToRoute('app_admin_genre_index');
    }

    public function form()
    {
        /**
         * 💬 createForm sera appelé sans 2ième argument. cf GenreType.php
         */

        $form = $this->createForm(GenreType::class);
        return $this->renderForm("admin/genre/_inline_form.html.twig", [ "form" => $form ]);
    }
}

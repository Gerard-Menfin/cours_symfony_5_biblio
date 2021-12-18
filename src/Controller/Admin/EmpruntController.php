<?php

namespace App\Controller\Admin;

use App\Entity\Emprunt;
use App\Form\EmpruntType;
use App\Repository\EmpruntRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/emprunt", name="admin_")
 */
class EmpruntController extends AbstractController
{
    /**
     * @Route("/", name="emprunt_index", methods={"GET"})
     */
    public function index(EmpruntRepository $empruntRepository): Response
    {
        return $this->render('admin/emprunt/index.html.twig', [
            'emprunts' => $empruntRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="emprunt_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $emprunt = new Emprunt();
        $emprunt->setDateEmprunt(new DateTime());
        $form = $this->createForm(EmpruntType::class, $emprunt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($emprunt);
            $entityManager->flush();

            return $this->redirectToRoute('emprunt_index');
        }

        return $this->render('admin/emprunt/new.html.twig', [
            'emprunt' => $emprunt,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="emprunt_show", methods={"GET"})
     */
    public function show(Emprunt $emprunt): Response
    {
        return $this->render('admin/emprunt/show.html.twig', [
            'emprunt' => $emprunt,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="emprunt_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Emprunt $emprunt): Response
    {
        $form = $this->createForm(EmpruntType::class, $emprunt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_emprunt_index');
        }

        return $this->render('admin/emprunt/edit.html.twig', [
            'emprunt' => $emprunt,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="emprunt_delete", methods={"POST"})
     */
    public function delete(Request $request, Emprunt $emprunt): Response
    {
        if ($this->isCsrfTokenValid('delete'.$emprunt->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($emprunt);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_emprunt_index');
    }
}

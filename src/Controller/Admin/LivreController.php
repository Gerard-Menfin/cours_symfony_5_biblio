<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\Livre1Type;
// use App\Entity\Categorie;
use App\Form\LivreCategoriesType;
use App\Repository\LivreRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Cocur\Slugify\Slugify;

/**
 * @Route("/admin/livre")
 */
class LivreController extends AbstractController
{
    /**
     * @Route("/liste", name="admin_livre_index", methods={"GET"})
     */
    public function index(LivreRepository $livreRepository): Response
    {
        return $this->render('admin/livre/index.html.twig', [
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
        return $this->render('admin/livre/show.html.twig', [
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
            // si un fichier a été téléversé dans l'input 'couverture'...
            if( $fichier = $form->get("couverture")->getData() ){
                
                // on récupère le nom du fichier qui a été téléversé
                $nomFichier = pathinfo($fichier->getClientOriginalName(), PATHINFO_FILENAME);

                // on remplace les espaces par des _
                // $nouveauNomFichier = str_replace(" ", "_", $nomFichier);
                $nouveauNomFichier = (new Slugify)->slugify($nomFichier);

                // on ajoute un string unique au nom du fichier (pour éviter les doublons) et l'extension du fichier
                $nouveauNomFichier .= uniqid() . "." . $fichier->guessExtension(); 

                // on copie le fichier téléversé dans un dossier du dossier 'public' avec le nouveau nom de fichier
                $fichier->move($this->getParameter("dossier_couvertures"), $nouveauNomFichier);

                // on modifie la propriété 'couverture' de l'entité $livre
                $livre->setCouverture($nouveauNomFichier);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($livre);
            $entityManager->flush();
            /* COURS : l'id n'est donné à une nouvelle entité qu'après avoir lancé $em->flush(). 
                        Cet objet n'est pas détruit, on peut donc connaître l'id qui lui a été attribué */
            $livre->setUrl( $livre->getId() . "-" . (new Slugify)->slugify($livre->getTitre()) );
            return $this->redirectToRoute('admin_livre_index');
        }

        return $this->render('admin/livre/new.html.twig', [
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
            // si un fichier a été téléversé dans l'input 'couverture'...
            if( $fichier = $form->get("couverture")->getData() ){
                
                // on récupère le nom du fichier qui a été téléversé
                $nomFichier = pathinfo($fichier->getClientOriginalName(), PATHINFO_FILENAME);

                // on remplace les espaces par des _
                $nouveauNomFichier = str_replace(" ", "_", $nomFichier);

                // on ajoute un string unique au nom du fichier (pour éviter les doublons) et l'extension du fichier
                $nouveauNomFichier .= uniqid() . "." . $fichier->guessExtension(); 

                // on copie le fichier téléversé dans un dossier du dossier 'public' avec le nouveau nom de fichier
                $fichier->move($this->getParameter("dossier_couvertures"), $nouveauNomFichier);

                // on modifie la propriété 'couverture' de l'entité $livre
                $livre->setCouverture($nouveauNomFichier);
            } 
            $livre->setUrl( $livre->getId() . "-" . (new Slugify)->slugify($livre->getTitre()) );
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_livre_index');
        }

        return $this->render('admin/livre/edit.html.twig', [
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

        return $this->render('admin/livre/new.html.twig', [
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

        return $this->render('admin/livre/edit.html.twig', [
            'livre' => $livre,
            'form' => $form->createView(),
        ]);
    }
    
}

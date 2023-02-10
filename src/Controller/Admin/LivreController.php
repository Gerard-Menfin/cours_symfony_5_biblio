<?php

namespace App\Controller\Admin;

use App\Entity\Livre;
use App\Form\Livre1Type;
use Cocur\Slugify\Slugify;
use App\Form\LivreCategoriesType;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface as EM;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Knp\Component\Pager\PaginatorInterface as Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
 * @Route("/admin/livre")
 */
class LivreController extends AbstractController
{
    /**
     * @Route("/", name="app_admin_livre_index", methods={"GET"})
     */
    public function index(LivreRepository $lr, Paginator $paginator, Request $rq): Response
    {
        $nombreParPage = 10;
        return $this->render('admin/livre/index.html.twig', [
            'livres' => $paginator->paginate($lr->findAll(), $rq->query->get("page", 1 ), $nombreParPage),
        ]);
    }

    /**
     * COURS : ⚠ si la route show est avant la route new, c'est la fonction show qui sera exécutée '/admin/livre/new'
     *          Pour éviter cette erreur, on ajoute une restriction sur la partie variable du chemin, avec le paramètre 'requirements'
     * 
     * @Route("/{id}", name="app_admin_livre_show", methods={"GET"}, requirements={"id"="\d+"})
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
     * @Route("/ajouter", name="app_admin_livre_new", methods={"GET","POST"})
     */
    public function new(Request $request, LivreRepository $lr): Response
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

                // on utilise AsciiSlugger
                $slugger = new AsciiSlugger();
                $nouveauNomFichier = $slugger->slug( $nomFichier ); 

                // on ajoute un string au nom du fichier (pour éviter les doublons) puis l'extension du fichier
                $nouveauNomFichier .= "_" . uniqid() . "." . $fichier->guessExtension(); 

                // on copie le fichier dans un dossier défini dans services.yaml avec le nouveau nom de fichier
                $fichier->move($this->getParameter("dossier_couvertures"), $nouveauNomFichier);

                // on modifie la propriété 'couverture' de l'entité $livre
                $livre->setCouverture($nouveauNomFichier);
            }
            // le livre est enregistré en bdd
            $lr->save($livre, true);

            // message 
            $this->addFlash("success", "Le nouveau livre a bien été enregistré");
            
            // redirection vers la liste des livres
            return $this->redirectToRoute('app_admin_livre_index');
        }

        return $this->render('admin/livre/new.html.twig', [
            'livre' => $livre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/modifier/{id}", name="app_admin_livre_edit", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function edit(Request $request, Livre $livre, LivreRepository $lr): Response
    {
        $form = $this->createForm(Livre1Type::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slugger = new AsciiSlugger();
            // si un fichier a été téléversé dans l'input 'couverture'...
            if( $fichier = $form->get("couverture")->getData() ){
                
                // on récupère le nom du fichier qui a été téléversé
                $nomFichier = pathinfo($fichier->getClientOriginalName(), PATHINFO_FILENAME);

                // on utilise AsciiSlugger
                $nouveauNomFichier = $slugger->slug( $nomFichier ); 


                // on ajoute un string unique au nom du fichier (pour éviter les doublons) et l'extension du fichier
                $nouveauNomFichier .= uniqid() . "." . $fichier->guessExtension(); 

                // on copie le fichier téléversé dans un dossier du dossier 'public' avec le nouveau nom de fichier
                $fichier->move($this->getParameter("dossier_couvertures"), $nouveauNomFichier);

                // on modifie la propriété 'couverture' de l'entité $livre
                $livre->setCouverture($nouveauNomFichier);
            } 
            $livre->setUrl( $livre->getId() . "-" . $slugger->slug($livre->getTitre()) );
            $lr->save($livre, true); // $lr->record($livre);

            return $this->redirectToRoute('app_admin_livre_index');
        }

        return $this->render('admin/livre/edit.html.twig', [
            'livre' => $livre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/supprimer/{id}", name="app_admin_livre_delete", methods={"POST"}, requirements={"id"="\d+"})
     */
    public function delete(Request $request, Livre $livre, LivreRepository $lr): Response
    {
        if ($this->isCsrfTokenValid('delete'.$livre->getId(), $request->request->get('_token'))) {
            $lr->remove($livre, true);
        }

        return $this->redirectToRoute('app_admin_livre_index');
    }

    
    /* *************************************************************************  */
    // ROUTES new et edit avec le formulaire utilisant EntityType (ChoiceType) 

    /**
     * AJOUTER avec TOUTES LES CATEGORIES
     * @Route("/nouveau", name="app_admin_livre_new_cat", methods={"GET","POST"})
     */
    public function new_cat(Request $request, LivreRepository $lr): Response
    {
        $livre = new Livre();
        $form = $this->createForm(LivreCategoriesType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lr->save($livre, true);

            return $this->redirectToRoute('app_admin_livre_index');
        }

        return $this->render('admin/livre/new.html.twig', [
            'livre' => $livre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="app_admin_livre_edit_cat", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function edit_cat(Request $request, Livre $livre, LivreRepository $lr): Response
    {
        $form = $this->createForm(LivreCategoriesType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lr->save($livre, true);

            return $this->redirectToRoute('app_admin_livre_index');
        }

        return $this->render('admin/livre/edit.html.twig', [
            'livre' => $livre,
            'form' => $form->createView(),
        ]);
    }

    

    ////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////
    /**
     * @Route("/indisponibles", name="app_livre_indisponibles")
     * @IsGranted("ROLE_BIBLIO")
     */
    public function indispo(LivreRepository $livreRepository)
    {
        return $this->render("livre/index.html.twig", [ 
            "livres" => $livreRepository->findByLivresIndisponibles(),
            "titre" => "Livres indisponibles"
        ]);
    }

    /**
     * @Route("/supprimer-plusieurs-livres", name="app_livre_effacer", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function effacer(Request $request, EM $em, LivreRepository $lr): Response
    {
        $ids = (array)$request->request->get("supp");
        foreach ($ids as $id) {
            $em->remove($lr->find($id));
        }
        $em->flush();

        return $this->redirectToRoute('livre_index', [], Response::HTTP_SEE_OTHER);
    }

}

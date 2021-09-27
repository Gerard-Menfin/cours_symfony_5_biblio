<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\LivreType;
use App\Repository\LivreRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LivreController extends AbstractController
{

    /**
    * @Route("/fiche-livre/{url}", name="livre_fiche")
    */
    public function ficheLivre(Livre $livre) {
        return $this->render("livre/fiche.html.twig", compact("livre"));
    }


    /********************************************************************************************************** */
    /********************************************************************************************************** */
    /********************************************************************************************************** */
    /**
     * @Route("/livre", name="livre")
     * 
     * Pour pouvoir utiliser certaines classes qu'on ne peut pas instancier directement, on va utiliser
     * 'linjection de dépendance : l'objet est passé comme paramètre d'une méthode d'un contrôleur
     * Dans l'exemple, on veut utiliser un objet de la classe LivreRepository, on déclare un paramètre de cette classe
     * dans la méthode index
     */
    public function index(LivreRepository $livreRepository): Response
    {
        $listeLivres = $livreRepository->findAll();

        return $this->render('livre/index.html.twig', [
            'liste_livres' => $listeLivres,
        ]);
    }

    /**
     * @Route("/livre/ajouter", name="livre_ajouter")
     * 
     * La classe Request permet de gérer tout ce qui vient d'une requête HTTP
     * Comme pour la classe Repository, on doit l'utiliser en injection de dépendance.
     * L'objet $request a des propriétés qui contiennent toutes les valeurs des variables
     * super-globales de PHP. Par exemple : 
     *  la propriété query   contient $_GET
     *  la propriété request contient $_POST
     * 
     * Cet objet a aussi des méthodes, par exemple
     *  isMethod permet de savoir si on est en méthode GET ou POST
     * 
     */
    public function ajouter(Request $request, EntityManager $em)
    {
        /* dd = dump and die */
        // dd($request);

        if( $request->isMethod("POST") ){
            $titre = $request->request->get("titre"); // $titre = $_POST["titre"]
            $auteur = $request->request->get("auteur");

            if( !empty($titre) && !empty($auteur) ){
                $livre = new Livre;
                $livre->setTitre($titre);
                $livre->setAuteur($auteur);
                /* La méthode EntityManager::persist prépare et met en attente la requête INSERT INTO à partir
                    des valeurs de l'objet passé en paramètre */
                $em->persist($livre);
                /* La méthode EntityManager::flush exécute les requêtes en attente.
                    Après le 'flush' la base de données est modifiée  */
                $em->flush();
                return $this->redirectToRoute("livre");
            }
        }
        return $this->render("livre/formulaire.html.twig");
    }

    /**
     * @Route("/livre/modifier/{id}", name="livre_modifier", requirements={"id"="[0-9]+"})
     */
    public function modifier(Request $request, LivreRepository $lr, EntityManager $em, $id)
    {
       $livre = $lr->find($id);
       if( $livre ) {
           if ( $request->isMethod("POST") ){
               $titre = $request->request->get("titre");
               $auteur = $request->request->get("auteur");
               if( !empty($titre) && !empty($auteur) ){
                   $livre->setTitre($titre);
                   $livre->setAuteur($auteur);
                   /* Pas besoin d'utiliser persist pour un objet Entity dont l'id n'est pas null,
                      l'entityManager enregistre automatiquement les modifications en bdd
                   */
                   $em->flush();
                   return $this->redirectToRoute("livre");
               }
           }
           return $this->render("livre/formulaire.html.twig", [ "livre" => $livre ]);
       }
    }

    /**
     * @Route("/livre/supprimer/{id}", name="livre_supprimer", requirements={"id"="\d+"})
     */
    public function supprimer(LivreRepository $lr, EntityManager $em, $id)
    {
        $livre = $lr->find($id);
        if( $livre ){
            /* La méthode EntityManager::remove prépare et met en attente une requête DELETE */
            $em->remove($livre);
            $em->flush();

            /* La méthode addFlash permet d'ajouter un message flash (ce message sera affiché une fois et ensuite il
                sera supprimé de la session ) */
            $this->addFlash("success", "Le livre n°$id a bien supprimé");
        } else {
            $this->addFlash("danger", "Il n'y a pas de livre n°$id dans la base de données");
            // $this->addFlash("danger", "Autre message d'erreur");
            // $this->addFlash("info", "message d'info");
        }
        return $this->redirectToRoute("livre");
    }

    /**
     * @Route("/livre/nouveau", name="livre_nouveau")
     */
    public function nouveau(Request $request, EntityManager $em)
    {
        $livre = new Livre;
        /* Le 2ième paramètre de 'createForm' est un objet Entity. Le formulaire va être lié à cet objet */
        $form = $this->createForm(LivreType::class, $livre);

        /* La méthode 'handleRequest' permet à la variable $form de gérer les informations venant de la requête HTTP (en utilisant l'objet 
                de la classe Request) */
        $form->handleRequest($request);
        if( $form->isSubmitted() && $form->isValid() ){
            $em->persist($livre);
            $em->flush();
            $this->addFlash("success", "Le nouveau livre a été enregistré");
            return $this->redirectToRoute("livre");
        }
        return $this->render("livre/nouveau.html.twig", [ "formLivre" => $form->createView() ]);
    }

    /**
     * @Route("/livre/editer/{id}", name="livre_editer", requirements={"id"="\d+"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function editer(Request $request, EntityManager $em, LivreRepository $lr, $id)
    {
        $livre = $lr->find($id);
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);
        if( $form->isSubmitted() && $form->isValid() ){
            $em->flush();
            $this->addFlash("success", "Le livre n°$id a été modifié");
            return $this->redirectToRoute("livre");
        }
        return $this->render("livre/nouveau.html.twig", [ "formLivre" => $form->createView() ]);
    }

    /**
     * @Route("/livre/fiche/{id}", name="livre_fiche2", requirements={"id"="\d+"})
     */
    public function fiche(LivreRepository $lr, $id)
    {
       /* EXO : Affichez les informations du livre puis la liste de toutes les fois où le
            livre a été emprunté
       */
        $livre = $lr->find($id);
        return $this->render("livre/fiche.html.twig", [ "livre" => $livre ]);
    }

    /**
     * COURS : Comme les routes commençant par "/livre" ne sont autorisés que pour les admins, 
     * on peut écrire cette route dans le même contrôleur en la faisant commencer par 
     * autre chose
     * Rappel : si le paramètre récupéré dans l'URL correspond à une propriété d'une entité (id, titre, ...),
     *          on peut passer en paramètre de la fonction un objet entité qui sera récupéré selon
     *          la valeur de cette propriété (SELECT * FROM livre WHERE id = {id} )
     * 
     * @Route("/afficher/livre/{id}", name="livre_afficher", requirements={"id"="\d+"})
     */
     public function afficher(Livre $livre)
     {
        return $this->render("livre/detail.html.twig", [ "livre" => $livre ]);
     }
}

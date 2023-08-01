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

    /********************************************************************************************************** */
    /********************************************************************************************************** */
    /********************************************************************************************************** */
    /**
     * @Route("/cours", name="")
     * 
     * ? Pour pouvoir utiliser certaines classes qu'on ne peut pas instancier directement, on va utiliser
     * ? l'injection de dépendance : l'objet est passé comme paramètre d'une méthode d'un contrôleur
     * ? Dans l'exemple, on veut utiliser un objet de la classe LivreRepository, on déclare un paramètre de cette classe
     * ? dans la méthode index
     */
    public function index(LivreRepository $livreRepository): Response
    {
        $listeLivres = $livreRepository->findAll();

        return $this->render('livre/index.html.twig', [
            'liste_livres' => $listeLivres,
        ]);
    }

    /**
     * 
     * Pour instancier un objet de la classe Request, on va utiliser l'injection de dépendance.
     * On définit un paramètre dans une méthode d'un contrôleur de la classe Request et dans cette méthode,
     * on pourra utiliser l'objet, qui aura des propriétés avec toutes les valeurs des superglobales de PHP
     * ex:
     *      * $request->query      : cette propriété est l'objet qui a les valeurs de $_GET
     * $request->request    : propriété qui a les valeurs de $_POST
    
        La classe Request pert de gérer les informations de la requête HTTP.
        Dans un objet de cette classe, on va aussi retrouver toutes les valeurs des variables super-globales de PHP.
        à chaque variable superglobale correspond une propriété publique de l'objet Request : 
            query       correspond à        $_GET
            request     correspond à        $_POST
            files                           $_FILES
            session                         $_SESSION
            cookies                         $_COOKIES
            server                          $_SERVER

        Ces propriétés sont des objets qui ont des méthodes pour accéder aux valeurs :
            get(indice)   pour récupérer une valeur de l'indice 
                par exemple $_POST["nom"]  sera récupéré avec $request->request->get("nom")

            has(indice)   pour savoir si l'indice existe
        
        L'objet Request a aussi des méthodes, par exemple :
            isMethod("POST")  pour savoir si la méthode HTTP correspond à la méthode POST
        ?  L'objet de la classe Request a des propriétés publiques de type objet qui contiennent toutes 
        ?  les valeurs des variables superglobales de PHP.
        ?       $request->query         contient        $_GET
        ?       $request->request       contient        $_POST
        ?       $request->files         contient        $_FILES
        ?       $request->server        contient        $_SERVER
        ?       $request->cookies       contient        $_COOKIES
        ?       $request->session       contient        $_SESSION
        ?   Ces différents objets ont des méthodes communes : get, has,...    
        ?   La méthode get() permet de récupérer la valeur voulue.
        ?   𝒆̲̅𝒙̲̅ : $motRecherche = $request->query->get("search");  
        ?        $motRecherche = $_GET["search"]
     * 
     * @Route("/cours/ajouter", name="_ajouter")
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
                // $livre->setAuteur($auteur);
                /**
                    La méthode EntityManager::persist prépare et met en attente la requête INSERT INTO à partir
                    des valeurs de l'objet passé en paramètre 
                    
                quand on veut mettre à jour un enregistrement, on n'est pas obligé d'utiliser la méthode 'persist'. 
                Les modifications faites à l'objet Entity vont être enregistrées automatiquement.
            */
                $em->persist($livre);
                /* La méthode EntityManager::flush exécute les requêtes en attente.
                    Après le 'flush' la base de données est modifiée  */
                $em->flush();
                return $this->redirectToRoute("app_livre");
            }
        }
        return $this->render("livre/formulaire.html.twig");
    }

    /**
     * @Route("/cours/modifier/{id}", name="_modifier", requirements={"id"="[0-9]+"})
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
                //    $livre->setAuteur($auteur);
                   /* Pas besoin d'utiliser persist pour un objet Entity dont l'id n'est pas null,
                      l'entityManager enregistre automatiquement les modifications en bdd
                   */
                   $em->flush();
                   return $this->redirectToRoute("app_livre");
               }
           }
           return $this->render("livre/formulaire.html.twig", [ "livre" => $livre ]);
       }
    }

    /**
     * @Route("/cours/supprimer/{id}", name="_supprimer", requirements={"id"="\d+"})
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
        return $this->redirectToRoute("app_livre");
    }

    /**
     * @Route("/cours/nouveau", name="_nouveau")
     */
    public function nouveau(Request $request, EntityManager $em)
    {
        $livre = new Livre;
        /* La méthode 'createForm' va créer un objet qui va permettre de gérer un formulaire
            créé à partir de la classe Form\AbonneType. On lie ce formulaire à l'objet
            $abonne

            AbonneType::class = "App\Form\AbonneType", c'est-à-dire le nom complet de la classe
            (en string)
        */
        /* Le 2ième paramètre de 'createForm' est un objet Entity. Le formulaire va être lié à cet objet */
        $form = $this->createForm(LivreType::class, $livre);

        /* La méthode 'handleRequest' permet à la variable $form de gérer les informations venant de la requête HTTP (en utilisant l'objet 
                de la classe Request) */
        $form->handleRequest($request);

        /* On vérifie si le formulaire a été soumis et s'il est valide */
        if( $form->isSubmitted() && $form->isValid() ){
            $em->persist($livre);
            $em->flush();
            $this->addFlash("success", "Le nouveau livre a été enregistré");
            return $this->redirectToRoute("app_livre");
        }
        return $this->render("livre/nouveau.html.twig", [ "formLivre" => $form->createView() ]);
    }

    /**
     * @Route("/cours/editer/{id}", name="_editer", requirements={"id"="\d+"})
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
            return $this->redirectToRoute("app_livre");
        }
        return $this->render("livre/nouveau.html.twig", [ "formLivre" => $form->createView() ]);
    }

    /**
     * @Route("/cours/fiche/{id}", name="_fiche", requirements={"id"="\d+"})
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
     * ? Rappel : si le paramètre récupéré dans l'URL correspond à une propriété d'une entité (id, titre, ...),
     * ?          on peut passer en paramètre de la fonction un objet entité qui sera récupéré selon
     * ?          la valeur de cette propriété (SELECT * FROM livre WHERE id = {id} )
     * 
     * @Route("/afficher/{id}", name="_afficher", requirements={"id"="\d+"})
     */
    public function afficher(Livre $livre)
    {
       return $this->render("livre/detail.html.twig", [ "livre" => $livre ]);
    }

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
     * @Route("/fiche/{url}", name="_fiche2")
     */
    public function ficheLivre(Livre $livre) {
        return $this->render("livre/fiche.html.twig", compact("livre"));
    }



}

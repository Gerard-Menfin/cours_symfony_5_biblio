<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Repository\LivreRepository;
use App\Repository\EmpruntRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/espace-lecture", name="app_espace")
 * @IsGranted("ROLE_LECTEUR")
 */
class EspaceController extends AbstractController
{
    /*
     ? COURS : pour avoir accès à un objet dans toutes les fonctions de ce contrôleur, j'ajoute une propriété
     ?          et j'assigne l'objet à cette propriété dans le constructeur (puisque c'est une classe qui doit
     ?          être injecté);
     */
    private RequestStack $rs;

    public function __construct(RequestStack $rs) {
        $this->rs = $rs;
    }

    /**
     * @Route("/", name="")
     */
    /*
        La page "Lecteur" va afficher toutes les informations du l'utilisateur connecté,
        s'il a le ROLE_LECTEUR. On pourrait envoyer une variable contenant ces informations à 
        la vue avec la méthode 'getUser' du contrôleur (qui retourne un objet Abonne, l'abonné actuellement connecté)
            $abonneConnecte = $this->getUser();
        Mais on peut avoir cet objet contenant l'abonné connecté directement dans le fichier Twig en utilisant 
            app.user
    */

    public function index(): Response
    {
        $reservations = $this->rs->getSession()->get("reservations", []);
        return $this->render('espace/index.html.twig', compact("reservations"));
    }

    /**
     * @Route("/profil", name="app_profil")
     */
    public function profil(): Response
    {
        return $this->render('espace/profil.html.twig', []);
    }

    /**
     * @Route("/reservations", name="app_reservations")
     */
    public function reservations(): Response
    {
        return $this->render('reservation/index.html.twig', [
            'reservations' => $this->rs->getSession()->get("reservations", []),
        ]);
    }

    /**
    * @Route("/reservation/livre-{id}", name="_reserver", requirements={"id"="\d+"})
    */
    public function livre(Livre $livre, RequestStack $rs) {
        /**
         * @var stdCClass $livre
         * ! commentaire pour éviter l'affichage d'erreur pour la variable $livre
         */
        $livre->libelle = $livre->getTitre(); // ! uniquement pour éviter la concaténation dans le message 'success'

        $session = $rs->getSession();
        $panier = $session->get("reservations", []);
        $dejaReserve = false;
        foreach($panier as $indice => $ligne){
            if($livre == $ligne["livre"]){
                $panier[$indice] = [ "livre" => $livre, "date" => date("Y-m-d") ];
                $dejaReserve = true;
                $this->addFlash("success", "Le livre <b>$livre->libelle</b> a été modifié dans la liste de vos réservations");
            }
        }
        if(!$dejaReserve){
            $panier[] = [ "livre" => $livre, "date" => date("Y-m-d") ];
            $this->addFlash("success", "Le livre <b>$livre->libelle</b> a été ajouté dans la liste de vos réservations");
        }
        $session->set("reservations", $panier);
        return $this->redirectToRoute("app_espace");
    }

    #[Route("/supprimer-reservation-livre-{id}", name: "_supprimer_reservation", requirements: ["id" => "\d+"])]
    public function supprimerReservation(Livre $livre, RequestStack $rs)
    {
        /* EXERCICE : écrire le code de cette route puis ajouter un lien dans l'Espace Lecteur pour 
                        pouvoir enlever un livre de la liste des réservations  */

        /* On peut récupérer un enregistrement en bdd avec le paramètre d'une route :
            - le paramètre doit avoir le nom d'un champ de la table
            - dans les arguments de la méthode liée à la route, il faut mettre un objet entité, pas
                besoin de mettre le paramètre lui-même (et plus besoin du Repository non plus)
        */
        // $livre = $lr->find($id);
        
        $panier = $rs->getSession()->get("reservations", []);
        foreach($panier as $indice => $ligne) {
            if( $livre->getId() == $ligne["livre"]->getId() ) {
                unset($panier[$indice]);
                break;
            }
        }
        $rs->getSession()->set("reservations", $panier);
        // $this->addFlash("success", "Le livre <b>" . $livre->getTitre() . "</b> a été retiré de vos réservations");
        // return $this->redirectToRoute("app_app_espace_lecteur");

        $reponse = new \stdClass;
        $reponse->message = "Le livre <b>" . $livre->getTitre() . "</b> a été retiré de vos réservations";
        $reponse->reservations = $rs->getSession()->get("reservations", []);
        return $this->json($reponse);
    }


    /**
    * @Route("/aj-panier", name="app_panier")
    */
    public function panier() {
        $panier = $this->rs->getSession()->get("reservations", []);
        return $this->render("espace/panier.html.twig", compact("panier"));
    }


    /**
     * @Route("/livre/{id}/emprunter", name="livre_emprunter", requirements={"id"="[0-9]+"})
     * @IsGranted("ROLE_LECTEUR")
     */
    public function emprunter(EntityManager $entityManager, LivreRepository $livreRepository, int $id)
    {
        $abonne = $this->getUser(); // getUser() retourne l'objet Abonné de l'utilisateur connecté
        // Pour récupérer l'utilisateur connecté dans un controleur on utlise $this->get_current_user
        // cette méthode retourne un objet de la classe Entity/Abonne
        
        $auj = new \DateTime();
        $livre = $livreRepository->find($id); // SELECT * FROM livre WHERE id = $id

        if( in_array($livre, $livreRepository->findByNonRendu()) ){
            $this->addFlash("danger", "Le livre <strong>" . $livre->getTitre() . "</strong> n'est pas disponible");
            return $this->redirectToRoute("accueil");
        }


        /* EXO : ajouter les lignes de codes pour créer et enregistrer un nouvel emprunt dans la bdd */
        $toto = new \App\Entity\Emprunt;
        $toto->setDateEmprunt($auj);
        $toto->setAbonne($abonne);
        $toto->setLivre($livre);

        $entityManager->persist($toto);
        $entityManager->flush();

        $this->addFlash("info", "Votre emprunt du livre " . $livre->getTitre() . " à la date du " . $auj->format("d/m/y") . " a bien été enregistré");

        return $this->redirectToRoute("profil");
    }

    
    /* EXO : 1. ajouter une route qui permet de définir une date de retour à un emprunt (la date du jour). 
             Dans l'affichage de la liste des emprunts, dans la colonne "Date retour", lorsqu'il n'y a pas de date_retour, il y aura un lien "à rendre" 
             qui lancera cette route (après avoir enregistré la modification de l'emprunt en base de données, on redirige vers la liste des emprunts)
        /*       2. Ajouter un lien sur chaque vignette de livre pour pouvoir emprunter ce livre.
                    Attention ce lien ne doit être visible que si on est connecté avec le ROLE_USER

            Les routes qui commencent par "/lecteur" ne sont accessibles qu'aux utilisateurs qui ont le ROLE_LECTEUR
            quelque soit le controleur où est défini cette route
          */

    /**
     * @Route("/biblio/emprunt/retour/{id}", name="emprunt_retour" )
     */
    public function retour(EmpruntRepository $er, EntityManagerInterface $em, $id)
    {
        $empruntAmodifier = $er->find($id);
        $empruntAmodifier->setDateRetour(new \DateTime());
        $em->flush();
        $this->addFlash("info", "Le livre <strong>" . $empruntAmodifier->getLivre()->getTitre() . "</strong> emprunté par <i>" . $empruntAmodifier->getAbonne()->getPseudo() . "</i> a été rendu");
        return $this->redirectToRoute("emprunt");
    }


}

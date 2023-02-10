<?php

namespace App\Controller;

use App\Entity\Livre;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
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
        $livre->libelle = $livre->getTitre(); // ! uniquement pour éviter la concaténation dnas le message 'success'

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

}

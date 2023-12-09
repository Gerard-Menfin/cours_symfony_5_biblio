<?php

namespace App\Controller;

use App\Entity\Livre;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface as Session;

class ReservationController extends AbstractController
{
    /**
     * @Route("/reservation", name="app_reservation")
     */
    public function index(Request $rq, Session $session): Response
    {
       
        return $this->render('reservation/index.html.twig', [
            'reservations' => $session->get("reservations", []),
        ]);
    }

    /**
    * @Route("/reservation/livre/{id}", name="app_reservation_livre")
    */
    public function livre(Livre $livre, Session $session) {
        // $livre->libelle = $livre->getTitre();

        $panier = $session->get("reservations", []);
        $dejaReserve = false;
        foreach($panier as $indice => $ligne){
            if($livre == $ligne["livre"]){
                $panier[$indice] = [ "livre" => $livre, "date" => date("Y-m-d") ];
                $dejaReserve = true;
                $this->addFlash("success", "Le livre $livre->libelle a été modifié dans la liste de vos réservations");
            }
        }
        if(!$dejaReserve){
            $panier[] = [ "livre" => $livre, "date" => date("Y-m-d") ];
            $this->addFlash("success", "Le livre $livre->libelle a été ajouté dans la liste de vos réservations");
        }
        $session->set("panier", $panier);
        return $this->redirectToRoute("app_reservation");
    }

    /**
    * @Route("/reservation/test", name="app_reservation_test")
    */
    public function fonction(Session $session) {
        $session->set("reservation", ["valeur ajouté à la session"]);
        return $this->redirectToRoute("app_reservation");
    }
}

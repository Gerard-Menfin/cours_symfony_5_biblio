<?php

namespace App\EventListener;

use App\Entity\Livre;
use App\Repository\LivreRepository;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * COURS : 
 * Cette classe est un EntityListener (un EventListener spécial entité)
 * Elle permet de définir des méthodes qui vont s'exécuter lorsqu'un évènement défini aura lieu.
 * 
 * Le Listener doit être référencé dans le fichier 
 *      • config/services.yaml
 * L'EntityListener doit être référencé dans l'entité correspondante
 *      • @ORM\EntityListeners({LivreListener::class})
 * 
 * 
 * ! https://symfonycasts.com/screencast/api-platform-extending/post-load-listener
 */
class LivreListener {

    /**
     * L'évènement 'postLoad' a lieu après le chargement d'un objet Entité à partir de la bdd.
     * Ici, au chargement d'un objet Livre, sa propriété 'dispo' va être affecté
     * selon la présence de l'objet dans la liste des livres renvoyés par 'findLivresEmpruntes'.
     *  
     * @param $livre Livre le 1er argument est donc l'entité déclenchant l'évènement
     * @param $lifeCycle LifecycleEventArgs
     * 
     */
    public function postLoad($livre, LifecycleEventArgs $lifeCycle)
    {
        $livreRepository = $lifeCycle->getEntityManager()->getRepository(Livre::class);
        /** @var LivreRepository $livreRepository */
        // $livreRepository = (object)$livreRepository; // cette ligne ne sert qu'à eviter l'erreur signalée par VS Code
        $livre->setDispo( !in_array($livre, $livreRepository->findLivresEmpruntes()) );
    }
}
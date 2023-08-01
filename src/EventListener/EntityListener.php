<?php 
/* Cette classe est donc un écouteur d'évènement. On va définir dans
    cette classe des méthodes qui seront exécutées lorsqu'un évènement 
    particulier sera activé */

namespace App\EventListener;

use App\Entity\Livre;
use App\Repository\LivreRepository;
use Doctrine\ORM\Event\LifecycleEventArgs;

class EntityListener{
    /* Cette méthode est déclenchée pour chaque évènement liée à une entité */
    public function onEntityLifecycle(LifecycleEventArgs $lifeCycle)
    {
        $entite = $lifeCycle->getEntity();
        /* Si l'entité qui a déclenché l'évènement est une entité Livre... */
        if( $entite instanceof Livre ){
            $livreRepository = $lifeCycle->getEntityManager()->getRepository(Livre::class);
            // $livreRepository = (object)$livreRepository;
            $entite->setDispo( !in_array($entite, $livreRepository->findLivresEmpruntes()) );
        }
    }
}
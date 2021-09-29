<?php

namespace App\DataFixtures;

use DateTime;
use DateInterval;
use App\Entity\Emprunt;
use App\DataFixtures\LivreFixtures;
use App\DataFixtures\AbonneFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EmpruntFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // 9 lecteurs, 20 livres
        for ($i=0; $i < 31; $i++) { 
            $lecteur = "abonne_" . rand(0, 8);
            $livre = "livre_" . rand(0, 19);
            $debut = rand(2000, 2020) . "-" . rand(1, 12) . "-" . rand(1, 31);
            $sortie = new DateTime( $debut );
            $retour =clone $sortie;
            $retour = rand(0, 1) ? $retour->add(new DateInterval("P10D")) : null;
            $emprunt = new Emprunt;
            $emprunt->setDateEmprunt( $sortie );
            $emprunt->setDateRetour( $retour );
            $emprunt->setAbonne( $this->getReference( $lecteur ) );
            $emprunt->setLivre( $this->getReference( $livre ) );

            $manager->persist( $emprunt );
        }
        $manager->flush();
    }
    
    public function getDependencies()
    {
        return [ LivreFixtures::class, AbonneFixtures::class ];
    }
    
}

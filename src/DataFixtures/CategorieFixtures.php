<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * COURS : Il faut implémenter une interface lorsqu'une fixture a besoin que d'autres fixtures soit
 * exécutées avant. 
 */
class CategorieFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $cat01 = new Categorie();
        $cat01->setTitre("science-fiction")->setMots("futur, robot, androïde, avenir, espace");
        $cat01->addLivre( $this->getReference( "livre_Dune" ) )
              ->addLivre( $this->getReference( "livre_I, robot" ) )
              ->addLivre( $this->getReference( "livre_Fondation" ) )
              ->addLivre( $this->getReference( "livre_Fondation et Empire" ) )
              ->addLivre( $this->getReference( "livre_Fondation foudroyée" ) )
              ;
        $manager->persist($cat01);
        
        $cat02 = new Categorie;
        $cat02->setTitre("heroic-fantasy")->setMots("dragon, chevalier, moyen-âge, magie");
        $cat02->addLivre( $this->getReference( "livre_Le Seigneur des Anneaux" ) )
              ->addLivre( $this->getReference( "livre_Les Deux Tours" ) )
              ->addLivre( $this->getReference( "livre_Le trône de fer" ) )
        ;
        $manager->persist($cat02);
        
        $cat03 = new Categorie;
        $cat03->setTitre("policier")->setMots("enquête, détective, meutre");
        $cat03->addLivre( $this->getReference( "livre_A.B.C. contre Poirot" ) )
              ->addLivre( $this->getReference( "livre_Le retour d'Hercule Poirot" ) )
              ->addLivre( $this->getReference( "livre_Le crime de l'Orient-Express" ) )
        ;
        $manager->persist($cat03);
        
        $cat04 = new Categorie;
        $cat04->setTitre("théatre")->setMots("comédie, drame");
        $cat04->addLivre( $this->getReference( "livre_L'avare" ) );
        $manager->persist($cat04);
        
        $cat05 = new Categorie;
        $cat05->setTitre("littérature")->setMots("classique");
        $cat05->addLivre( $this->getReference( "livre_Les trois mousquetaires" ) )
              ->addLivre( $this->getReference( "livre_Discours de méthode" ) );
        $manager->persist($cat05);
        
        $cat06 = new Categorie;
        $cat06->setTitre("fantastique")->setMots("étrange, merveilleux, bizarre");
        $cat06->addLivre( $this->getReference( "livre_Dune" ) )
              ->addLivre( $this->getReference( "livre_1984" ) )
              ->addLivre( $this->getReference( "livre_Je suis une légende" ) )
              ->addLivre( $this->getReference( "livre_Les fourmis" ) )
              ->addLivre( $this->getReference( "livre_Le jour des fourmis" ) )
              ->addLivre( $this->getReference( "livre_Le trône de fer" ) )
        ;
        $manager->persist($cat06);
        
        $cat07 = new Categorie;
        $cat07->setTitre("philosophie")->setMots("scepticisme, stoïcisme, dialectique, métaphysique");
        $cat07->addLivre( $this->getReference( "livre_Discours de méthode" ) );
        $manager->persist($cat07);
        
        $cat08 = new Categorie;
        $cat08->setTitre("manga")->setMots("dessin, japon, épique, arts-martiaux");
        $cat08->addLivre( $this->getReference( "livre_Akira tome 1" ) );
        $manager->persist($cat08);
        
        $cat09 = new Categorie;
        $cat09->setTitre("mythologie")->setMots("dieu, déesse, titan, arts-martiaux");
        $cat09->addLivre( $this->getReference( "livre_Odyssée" ) );
        $manager->persist($cat09);
        

        $manager->flush();
    }

    /**
     * COURS : C'est dans cette méthode que l'on définie les fixtures qui doivent être exécutées avant
     */
    public function getDependencies()
    {
        return [ LivreFixtures::class ];
    }
}

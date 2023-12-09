<?php

namespace App\DataFixtures;

use App\Entity\Livre;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class LivreFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $livres = [
            [ "titre" => "Dune",                          "auteur" => "Herbert",    "couverture" => "dune.jpg" ],
            [ "titre" => "1984",                          "auteur" => "Orwell",     "couverture" => "1984.jpg" ],
            [ "titre" => "I, robot",                      "auteur" => "Asimov",     "couverture" => "i_robot.jpg" ],
            [ "titre" => "Le Seigneur des Anneaux",       "auteur" => "Tolkien",    "couverture" => "le_seigneur_des_anneaux.jpg" ],
            [ "titre" => "Les Deux Tours",                "auteur" => "Tolkien",    "couverture" => "les_deux_tours.jpg" ],
            [ "titre" => "A.B.C. contre Poirot",          "auteur" => "Christie",   "couverture" => "abc_contre_poirot.jpg" ],
            [ "titre" => "Fondation",                     "auteur" => "Asimov",     "couverture" => "fondation.jpg" ],
            [ "titre" => "Fondation et Empire",           "auteur" => "Asimov",     "couverture" => "fondation_et_empire.jpg" ],
            [ "titre" => "Je suis une légende",           "auteur" => "Matheson",   "couverture" => "je_suis_une_legende.jpg" ],
            [ "titre" => "Les fourmis",                   "auteur" => "Werber",     "couverture" => "les_fourmis.jpg" ],
            [ "titre" => "Fondation foudroyée",           "auteur" => "Asimov",     "couverture" => "fondation_foudroyee.jpg" ],
            [ "titre" => "Les trois mousquetaires",       "auteur" => "Dumas",      "couverture" => "les_trois_mousquetaires.jpg" ],
            [ "titre" => "Le jour des fourmis",           "auteur" => "Werber",     "couverture" => "le_jour_des_fourmis.jpg" ],
            [ "titre" => "Le retour d'Hercule Poirot",    "auteur" => "Christie",   "couverture" => "le_retour_d_hercule_poirot.jpg" ],
            [ "titre" => "L'avare",                       "auteur" => "Molière",    "couverture" => "l_avare.jpg" ],
            [ "titre" => "Discours de méthode",           "auteur" => "Descartes",  "couverture" => "discours_de_la_methode.jpg" ],
            [ "titre" => "Akira tome 1",                  "auteur" => "Otomo",      "couverture" => "akira_1.jpg" ],
            [ "titre" => "Odyssée",                       "auteur" => "Homère",     "couverture" => "l_univers_de_la_mythologie_grecque.jpg" ],
            [ "titre" => "Le trône de fer",               "auteur" => "Martin",     "couverture" => "le_trone_de_fer.jpg" ],
            [ "titre" => "Le crime de l'Orient-Express",  "auteur" => "Christie",   "couverture" => "le_crime_de_l_orient-express.jpg" ],
        ];
        
        $slugger = new AsciiSlugger();
        foreach ($livres as $cpt => $book) {
            $livre = new Livre;
            $livre->setTitre( $book["titre"] )->setAuteur( $this->getReference("auteur_" . $book["auteur"]) )->setCouverture( $book["couverture"] )->setUrl( $slugger->slug($book["titre"]) );
            $manager->persist( $livre );

            $this->setReference( "livre_" . $book["titre"], $livre );
            $this->setReference( "livre_$cpt", $livre );  // 20 livres
        }
        for ($i=1; $i <= 50; $i++) { 
            $livre = new Livre;
            $livre->setTitre( $book["titre"] )
                    ->setAuteur( $this->getReference("auteur_" . $book["auteur"]) )
                    ->setCouverture( $book["couverture"] )
                    ->setUrl( $slugger->slug($book["titre"]) );

        }
        $manager->flush();
    }
}

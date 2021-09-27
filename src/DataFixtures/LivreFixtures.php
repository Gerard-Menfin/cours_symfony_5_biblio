<?php

namespace App\DataFixtures;

use App\Entity\Livre;
use Cocur\Slugify\Slugify;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class LivreFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $livres = [
            [ "titre" => "Dune",                          "auteur" => "Frank Herbert",        "couverture" => "dune.jpg" ],
            [ "titre" => "1984",                          "auteur" => "George Orwell",        "couverture" => "1984.jpg" ],
            [ "titre" => "I, robot",                      "auteur" => "Isaac Asimov",         "couverture" => "i_robot.jpg" ],
            [ "titre" => "Le Seigneur des Anneaux",       "auteur" => "J.R.R. Tolkien",       "couverture" => "le_seigneur_des_anneaux.jpg" ],
            [ "titre" => "Les Deux Tours",                "auteur" => "J.R.R. Tolkien",       "couverture" => "les_deux_tours.jpg" ],
            [ "titre" => "A.B.C. contre Poirot",          "auteur" => "Agatha Christie",      "couverture" => "abc_contre_poirot.jpg" ],
            [ "titre" => "Fondation",                     "auteur" => "Isaac Asimov",         "couverture" => "fondation.jpg" ],
            [ "titre" => "Fondation et Empire",           "auteur" => "Isaac Asimov",         "couverture" => "fondation_et_empire.jpg" ],
            [ "titre" => "Je suis une légende",           "auteur" => "Richard Matheson",     "couverture" => "je_suis_une_legende.jpg" ],
            [ "titre" => "Les fourmis",                   "auteur" => "Bernard Werber",       "couverture" => "les_fourmis.jpg" ],
            [ "titre" => "Fondation foudroyée",           "auteur" => "Isaac Asimov",         "couverture" => "fondation_foudroyee.jpg" ],
            [ "titre" => "Les trois mousquetaires",       "auteur" => "Alexandre Dumas",      "couverture" => "les_trois_mousquetaires.jpg" ],
            [ "titre" => "Le jour des fourmis",           "auteur" => "Bernard Werber",       "couverture" => "le_jour_des_fourmis.jpg" ],
            [ "titre" => "Le retour d'Hercule Poirot",    "auteur" => "Agatha Christie",      "couverture" => "le_retour_d_hercule_poirot.jpg" ],
            [ "titre" => "L'avare",                       "auteur" => "Molière",              "couverture" => "l_avare.jpg" ],
            [ "titre" => "Discours de méthode",           "auteur" => "René Descartes",       "couverture" => "discours_de_la_methode.jpg" ],
            [ "titre" => "Akira tome 1",                  "auteur" => "Katsuhiro Otomo",      "couverture" => "akira_1.jpg" ],
            [ "titre" => "Odyssée",                       "auteur" => "Homère",               "couverture" => "l_univers_de_la_mythologie_grecque.jpg" ],
            [ "titre" => "Le trône de fer",               "auteur" => "George R.R. Martin",   "couverture" => "le_trone_de_fer.jpg" ],
            [ "titre" => "Le crime de l'Orient-Express",  "auteur" => "Agatha Christie",      "couverture" => "le_crime_de_l_orient-express.jpg" ],
        ];
        
        $slugify = new Slugify;
        foreach ($livres as $cpt => $book) {
            $livre = new Livre;
            $livre->setTitre( $book["titre"] )->setAuteur( $book["auteur"] )->setCouverture( $book["couverture"] )->setUrl( $slugify->slugify($book["titre"]) );
            $manager->persist( $livre );

            $this->setReference( "livre_" . $book["titre"], $livre );
            $this->setReference( "livre_$cpt", $livre );  // 20 livres
        }
        $manager->flush();
    }
}

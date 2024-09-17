<?php

namespace App\DataFixtures;

use App\Entity\Auteur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use DateTime;

class AuteurFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $auteurs = [
            [ "prenom" => "Frank",          "nom" => "Herbert",     "naissance" => "", "deces" => "", "biographie" => "Climatologue de formation" ],        
            [ "prenom" => "George",         "nom" => "Orwell",      "naissance" => "", "deces" => "", "biographie" => "" ],        
            [ "prenom" => "Isaac",          "nom" => "Asimov",      "naissance" => "", "deces" => "", "biographie" => "Écrivain américain d'origine russe" ],         
            [ "prenom" => "J.R.R.",         "nom" =>" Tolkien",     "naissance" => "", "deces" => "", "biographie" => "" ],       
            [ "prenom" => "Richard",        "nom" => "Matheson",    "naissance" => "", "deces" => "", "biographie" => "" ],     
            [ "prenom" => "Alexandre",      "nom" => "Dumas",       "naissance" => "", "deces" => "", "biographie" => "Écrivain français, fils d'un officier né à Haïti.Ses oeuvres ont été maintes fois traduites et adaptés à la télé et au cinéma." ],      
            [ "prenom" => "Bernard",        "nom" => "Werber",      "naissance" => "", "deces" => "", "biographie" => "Écrivain français" ],       
            [ "prenom" => "Agatha",         "nom" => "Christie",    "naissance" => "", "deces" => "", "biographie" => "Écrivaine anglaise, célèbre pour avoir créé le personnage de détective belge, Hercule Poirot" ],      
            [ "prenom" => "",               "nom" => "Molière",     "naissance" => "", "deces" => "", "biographie" => "Souvent considéré comme le plus grand auteur de théatre français." ],              
            [ "prenom" => "René",           "nom" => "Descartes",   "naissance" => "", "deces" => "", "biographie" => "Philosophe, mathématicien, ..." ],       
            [ "prenom" => "Katsuhiro",      "nom" => "Otomo",       "naissance" => "", "deces" => "", "biographie" => "Mangaka, célèbre pour sa série Akira, devenu une référence après l'adaption au cinéma" ],      
            [ "prenom" => "",               "nom" => "Homère",      "naissance" => "", "deces" => "", "biographie" => "Auteur antique, dont l'existence réelle est contesté." ],               
            [ "prenom" => "George R.R.",    "nom" => "Martin",      "naissance" => "", "deces" => "", "biographie" => "Écrivain américain célèbre pour sa sage Game of Thrones, insipiré des Rois Maudits et de l'oeuvre de Tolkien" ],
            [ "prenom" => "", "nom" => "", "biographie" => "" ],  
            [ "prenom" => "", "nom" => "", "biographie" => "" ],  
        ];
        foreach ($auteurs as $indice => $valeur) {
            $auteur = new Auteur;
            $auteur
                ->setPrenom($valeur["prenom"])
                ->setNom($valeur["nom"])
                ->setBiographie($valeur["biographie"])
                ->setNaissance( new DateTime($valeur["naissance"]) )
                ->setDeces( new DateTime($valeur["deces"]) )
            ;
            $manager->persist($auteur);
            $this->setReference( "auteur_" . $auteur->getNom(), $auteur);
        }
        $manager->flush();
    }
}

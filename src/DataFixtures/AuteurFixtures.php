<?php

namespace App\DataFixtures;

use App\Entity\Auteur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AuteurFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $auteurs = [
            [ "prenom" => "Frank",          "nom" => "Herbert",     "biographie" => "Climatologue de formation" ],        
            [ "prenom" => "George",         "nom" => "Orwell",      "biographie" => "" ],        
            [ "prenom" => "Isaac",          "nom" => "Asimov",      "biographie" => "Écrivain américain d'origine russe" ],         
            [ "prenom" => "J.R.R.",         "nom" =>" Tolkien",     "biographie" => "" ],       
            [ "prenom" => "Richard",        "nom" => "Matheson",    "biographie" => "" ],     
            [ "prenom" => "Alexandre",      "nom" => "Dumas",       "biographie" => "Écrivain français, fils d'un officier né à Haïti.Ses oeuvres ont été maintes fois traduites et adaptés à la télé et au cinéma." ],      
            [ "prenom" => "Bernard",        "nom" => "Werber",      "biographie" => "Écrivain français" ],       
            [ "prenom" => "Agatha",         "nom" => "Christie",    "biographie" => "Écrivaine anglaise, célèbre pour avoir créé le personnage de détective belge, Hercule Poirot" ],      
            [ "prenom" => "",               "nom" => "Molière",     "biographie" => "Souvent considéré comme le plus grand auteur de théatre français." ],              
            [ "prenom" => "René",           "nom" => "Descartes",   "biographie" => "Philosophe, mathématicien, ..." ],       
            [ "prenom" => "Katsuhiro",      "nom" => "Otomo",       "biographie" => "Mangaka, célèbre pour sa série Akira, devenu une référence après l'adaption au cinéma" ],      
            [ "prenom" => "",               "nom" => "Homère",      "biographie" => "Auteur antique, dont l'existence réelle est contesté." ],               
            [ "prenom" => "George R.R.",    "nom" => "Martin",      "biographie" => "Écrivain américain célèbre pour sa sage Game of Thrones, insipiré des Rois Maudits et de l'oeuvre de Tolkien" ],
            [ "prenom" => "", "nom" => "", "biographie" => "" ],  
            [ "prenom" => "", "nom" => "", "biographie" => "" ],  
        ];
        foreach ($auteurs as $indice => $valeur) {
            $auteur = new Auteur;
            $auteur->setPrenom($valeur["prenom"])->setNom($valeur["nom"])->setBiographie($valeur["biographie"]);
            $manager->persist($auteur);
            $this->setReference( "auteur_" . $auteur->getNom(), $auteur);
        }
        $manager->flush();
    }
}

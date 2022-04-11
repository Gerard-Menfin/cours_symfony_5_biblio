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
            [ "prenom" => "Frank",          "nom" => "Herbert",     "biographie" => "" ],        
            [ "prenom" => "George",         "nom" => "Orwell",      "biographie" => "" ],        
            [ "prenom" => "Isaac",          "nom" => "Asimov",      "biographie" => "" ],         
            [ "prenom" => "J.R.R.",         "nom" =>" Tolkien",     "biographie" => "" ],       
            [ "prenom" => "Richard",        "nom" => "Matheson",    "biographie" => "" ],     
            [ "prenom" => "Alexandre",      "nom" => "Dumas",       "biographie" => "" ],      
            [ "prenom" => "Bernard",        "nom" => "Werber",      "biographie" => "" ],       
            [ "prenom" => "Agatha",         "nom" => "Christie",    "biographie" => "" ],      
            [ "prenom" => "",               "nom" => "Molière",     "biographie" => "" ],              
            [ "prenom" => "René",           "nom" => "Descartes",   "biographie" => "" ],       
            [ "prenom" => "Katsuhiro",      "nom" => "Otomo",       "biographie" => "" ],      
            [ "prenom" => "",               "nom" => "Homère",      "biographie" => "" ],               
            [ "prenom" => "George R.R.",    "nom" => "Martin",      "biographie" => "" ],   
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

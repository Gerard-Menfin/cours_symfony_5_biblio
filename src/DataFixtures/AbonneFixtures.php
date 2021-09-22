<?php

namespace App\DataFixtures;

use App\Entity\Abonne;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AbonneFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $abonnes = [
            [ "pseudo"  => "admin",     "prenom" => "Nordine",   "nom" => "Ateur",      "role" => "admin"   ],
            [ "pseudo"  => "biblio",   "prenom" => "Hayet ",    "nom" => "Dementir",    "role" => "biblio"  ],
            [ "pseudo"  => "mentor",    "prenom" => "Gérard",    "nom" => "Mentor",     "role" => "biblio"  ],
            [ "pseudo"  => "alien",     "prenom" => "Ali ",      "nom" => "Aine",       "role" => "biblio"  ],
            [ "pseudo"  => "lecteur",   "prenom" => "Hannibal",  "nom" => "Lecteur",    "role" => "lecteur" ],
            [ "pseudo"  => "fanta",     "prenom" => "Fanta",     "nom" => "Stick",      "role" => "lecteur" ],
            [ "pseudo"  => "foot",      "prenom" => "Marc",      "nom" => "Ainbutte",   "role" => "lecteur" ],
            [ "pseudo"  => "polo",      "prenom" => "Paul",      "nom" => "Augnes",     "role" => "lecteur" ],
            [ "pseudo"  => "mama",      "prenom" => "Mamadou",   "nom" => "Otouché",    "role" => "lecteur" ],
            [ "pseudo"  => "froid",     "prenom" => "Gérard",    "nom" => "Menfroa",    "role" => "lecteur" ],
            [ "pseudo"  => "robe",      "prenom" => "Anissa ",   "nom" => "Plubelrob",  "role" => "lecteur" ],
            [ "pseudo"  => "comedie",   "prenom" => "Eddy",      "nom" => "Lacome",     "role" => "lecteur" ],
            [ "pseudo"  => "belle",     "prenom" => "Cybèle ",   "nom" => "Hélabèt",    "role" => "lecteur" ],
            [ "pseudo"  => "fanta",     "prenom" => "Fanta",     "nom" => "Stick",      "role" => "lecteur" ],
        ];

        foreach ($abonnes as $cpt => $abo ) {
            $abonne = new Abonne;
            $abonne->setPseudo( $abo["pseudo"] )
                   ->setPrenom( $abo["prenom"] )
                   ->setNom( $abo["nom"] )
                   ->setPassword( $this->encoder->encodePassword($abonne, $abo["pseudo"]) )
                   ->setRoles( ["ROLE_" . strtoupper($abo["role"]) ] );
            $manager->persist( $abonne );
            
            if( $abo["role"] == "lecteur" ) 
                $this->addReference( "abonne_" . $abo["pseudo"], $abonne );
        }

        $manager->flush();
    }
}

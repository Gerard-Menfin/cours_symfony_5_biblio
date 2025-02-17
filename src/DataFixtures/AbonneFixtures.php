<?php

namespace App\DataFixtures;

use App\Entity\Abonne;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
// use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AbonneFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $abonnes = [
            [ "pseudo"  => "admin",     "prenom" => "Amin",     "nom" => "Strateur",    "role" => "admin"   ],
            [ "pseudo"  => "dev",       "prenom" => "Nordine",  "nom" => "Ateur",       "role" => "admin"   ],

            [ "pseudo"  => "biblio1",    "prenom" => "Hayet ",   "nom" => "Dementir",   "role" => "biblio"  ],
            [ "pseudo"  => "biblio2",    "prenom" => "Gérard",   "nom" => "Mentor",     "role" => "biblio"  ],
            [ "pseudo"  => "biblio3",    "prenom" => "Ali ",     "nom" => "Hène",       "role" => "biblio"  ],
            
            [ "pseudo"  => "lecteur",   "prenom" => "Hannibal", "nom" => "Lecteur",     "role" => "lecteur" ],
            [ "pseudo"  => "fanta",     "prenom" => "Fanta",    "nom" => "Stick",       "role" => "lecteur" ],
            [ "pseudo"  => "foot",      "prenom" => "Marc",     "nom" => "Ainbutte",    "role" => "lecteur" ],
            [ "pseudo"  => "polo",      "prenom" => "Paul",     "nom" => "Augnes",      "role" => "lecteur" ],
            [ "pseudo"  => "mama",      "prenom" => "Mamadou",  "nom" => "Otouché",     "role" => "lecteur" ],
            [ "pseudo"  => "froid",     "prenom" => "Gérard",   "nom" => "Menfroa",     "role" => "lecteur" ],
            [ "pseudo"  => "robe",      "prenom" => "Anissa ",  "nom" => "Plubelrob",   "role" => "lecteur" ],
            [ "pseudo"  => "comedie",   "prenom" => "Eddy",     "nom" => "Lacome",      "role" => "lecteur" ],
            [ "pseudo"  => "belle",     "prenom" => "Cybèle ",  "nom" => "Hélabèt",     "role" => "lecteur" ],
        ];

        $cpt = 0;
        foreach ($abonnes as $abo ) {
            $abonne = new Abonne;
            $abonne->setPseudo( $abo["pseudo"] )
                   ->setPrenom( $abo["prenom"] )
                   ->setNom( $abo["nom"] )
                   ->setPassword( $this->encoder->encodePassword($abonne, $abo["pseudo"]) )
                   ->setRoles( ["ROLE_" . strtoupper($abo["role"]) ] );
            $manager->persist( $abonne );
            
            if( $abo["role"] == "lecteur" ) {
                $this->addReference( "abonne_" . $cpt, $abonne );  // 9 lecteurs
                $cpt++;
            }
        }

        $manager->flush();
    }
}

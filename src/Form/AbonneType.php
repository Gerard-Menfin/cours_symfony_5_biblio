<?php

namespace App\Form;

use App\Entity\Abonne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AbonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* Dans Symfony, le rôle utilisateur sont des string, tout en majuscules, et 
            doivent commencer par ROLE_
            ⚠ : la propriété roles DOIT être de type array 
        */

        $abonne = $options["data"]; // $options["data"] permet de récupérer l'objet utilisé comme données du formulaire 
                                    // c'est le 2ième argument de createForm(), utilisée dans le contrôleur

        $builder
            ->add("confirmation", CheckboxType::class, [
                "mapped" => false
            ])
            ->add('pseudo', TextType::class, [
                "attr" => [
                    "class" => "text-primary"
                ]
            ])
            ->add('roles', ChoiceType::class, [
                "choices"   => [
                    "Abonné"         => "ROLE_ABONNE",
                    // "Abonné"         => "ROLE_USER"
                    "Lecteur"        => "ROLE_LECTEUR",
                    "Bibliothécaire" => "ROLE_BIBLIOTHECAIRE",
                    "Directeur"      => "ROLE_ADMIN",
                    "Développeur"    => "ROLE_DEV",
                ],
                "multiple"  => true,
                "expanded"  => true,
                "label"     => "Niveau d'accès"
            ])
            ->add('password', TextType::class, [
                "mapped"    => false,   /**
                                            l'option "mapped" avec la valeur false, permet de préciser que
                                            le champ ne sera pas lié à une propriété de l'objet utilisé pour
                                            afficher le formulaire */
                "required"  => $abonne->getId() ? false : true,
                "label"  => "Mot de passe"
            ])
            ->add('prenom')
            ->add('nom')
            ->add("adresse")
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Abonne::class,
        ]);
    }
}
